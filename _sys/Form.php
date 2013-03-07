<?php

class Form {

	private $validator;
	private $validationRules;

	public function __construct() {
		$this->validator = new Validator();
	}

	/**
	 * HTTP post method.
	 * 
	 * @param String $name Name of key in $_POST.
	 * @param Boolean $xssClean Run it through xssClean() or not. True by default.
	 * @return String Value from $_POST.
	 */
	public function post($name, $validate = 'all', $xssClean = true) {

		if (!isset($_POST[$name])) {
			$_POST[$name] = '';
		}

		if (is_array($_POST[$name])) {

			$multiPost = array();
			foreach ($_POST[$name] as $one) {
				$postValue = $xssClean ? _xssClean($one) : $one;
				$this->validateField($name, $postValue, $validate);
				$multiPost[] = $postValue;
			}
			return $multiPost;
		}


		$postValue = $xssClean ? _xssClean($_POST[$name]) : $_POST[$name];

		$this->validateField($name, $postValue, $validate);

		return $postValue;
	}

	/**
	 * HTTP get method.
	 * 
	 * @param String $name Name of key in $_GET. Blank by default.
	 * @param Boolean $xssClean Run it through xssClean() or not. True by default.
	 * @return String Value from $_GET.
	 */
	public function get($name, $validate = 'all', $xssClean = true) {

		if (!isset($_GET[$name])) {
			$_GET[$name] = '';
		}

		if (is_array($_GET[$name])) {

			$multiGet = array();
			foreach ($_GET[$name] as $one) {
				$getValue = $xssClean ? _xssClean($one) : $one;
				$this->validateField($name, $getValue, $validate);
				$multiGet[] = $getValue;
			}
			return $multiGet;
		}

		$getValue = $xssClean ? _xssClean($_GET[$name]) : $_GET[$name];

		$this->validateField($name, $getValue, $validate);

		return $getValue;
	}

	/**
	 * HTTP post/get/request method.
	 * 
	 * @param String $name Name of key in $_REQUEST. Blank by default.
	 * @param Boolean $xssClean Run it through xssClean() or not. True by default.
	 * @return String Value from $_REQUEST.
	 */
	public function request($name, $validate = 'all', $xssClean = true) {

		if (!isset($_REQUEST[$name])) {
			$_REQUEST[$name] = '';
		}

		if (is_array($_REQUEST[$name])) {

			$multiReq = array();
			foreach ($_REQUEST[$name] as $one) {
				$reqValue = $xssClean ? _xssClean($one) : $one;
				$this->validateField($name, $reqValue, $validate);
				$multiReq[] = $reqValue;
			}
			return $multiReq;
		}

		$reqValue = $xssClean ? _xssClean($_REQUEST[$name]) : $_REQUEST[$name];

		$this->validateField($name, $reqValue, $validate);

		return $reqValue;
	}

	/**
	 * Checks if $method is being used.
	 * 
	 * @param String $method Method of action. Eg. POST, GET, PUT
	 * @return Boolean True if $method is currently the request method, false otherwise.
	 */
	public function isAction($method) {
		$method = strtoupper($method);
		return $_SERVER['REQUEST_METHOD'] == $method;
	}

	/**
	 * Sets form validation rules.
	 * 
	 * @param Array $rules Array of rules.
	 */
	public function setRules($rules) {
		$this->validationRules = $rules;
	}

	/**
	 * Adds more validation rules.
	 * 
	 * @param Array $rule.
	 */
	public function addRule($rule) {
		$this->validationRules[] = $rule;
	}

	/**
	 * Does a recursive search for rules corresponding the field provided.
	 * 
	 * @param String $field Field to lookup.
	 * @param Integer $count Number of validation rules.
	 * @param Array $rules Internal for recursive; holds all rules to return.
	 * @param Integer $i Internal for recursive; counter.
	 * @return Array Rules corresponding to the field.
	 */
	public function getRules($field, $count, $rules = array(), $i = 0) {
		if ($i >= $count) {
			return $rules;
		}
		if ($field === $this->validationRules[$i]['field']) {
			$rules[] = $this->validationRules[$i];
		}
		return $this->getRules($field, $count, $rules, ++$i);
	}

	/**
	 * Validates field. Throws an exception if invalid.
	 * 
	 * @param String $field Name of field currently validating.
	 * @param String $value Value of field currently validating.
	 * @param String $validate Specify validation rule to check - all by default.
	 * @throws Exception Invalid message exception.
	 */
	public function validateField($field, $value, $validate) {

		if ($validate === FALSE) {
			return TRUE;
		}

		// Get all rules in $this->validationRules under $field.
		$currRules = $this->getRules($field, count($this->validationRules));

		$fail = false;

		foreach ($currRules as $rule) {

			$ruleValue = $rule['ruleValue'];
			$ruleRule = $rule['rule'];

			// This is a hack...
			// 
			// An array $ruleValue is an indicator that incoming value is a form field.
			// We must get its value first, and assign it to $ruleValue making it a string.
			// 
			// Also make sure $ruleRule is not an array because
			// an array $ruleRule means that it's going to call a custom validator.
			if (is_array($ruleValue) && !is_array($ruleRule)) {
				$ruleValue = $this->post($ruleValue[0], FALSE);
			}

			// An array $ruleRule means that it's going to call a custom validator.
			if (is_array($ruleRule)) {
				$fail = call_user_func_array($ruleRule, $ruleValue);
				// Otherwise, proceed with generic validation.
			} else {
				// There can have more than one rule for a field.
				// By default, it runs all of them. But you can specify which to run in $this->post().
				// 
				// Check if we are running all rules.
				// If not, $validate is defining which rules to run.
				if (!_isSame($validate, 'all')) {
					// Each rules in $validate is delimited by |
					// Explode it and run the validator for each rule.
					$validateExpld = explode('|', $validate);
					foreach ($validateExpld as $val) {
						// Only run it if $rule[$ruleRule] loop/foreach is equal to $val.
						if (_isSame($val, $ruleRule)) {
							$fail |= $this->validator->{$val}($value, $ruleValue);
						}
					}
				} else {
					// Otherwise, Run validator for each rule
					$fail = $this->validator->{$ruleRule}($value, $ruleValue);
				}
			}

			if ($fail) {
				throw new Exception($rule['invalidMsg']);
			}
		}

		return TRUE;
	}

	/**
	 * Checks if request has been made on a name given - checks if it's empty or not.
	 * 
	 * @param Strubg $name Name of request.
	 * @return Boolean True if name requested, and is not empty, false otherwise.
	 */
	public function isRequest($name) {
		return isset($_REQUEST[$name]) && !empty($_REQUEST[$name]);
	}

}