<?php

class Validator {

	public function __construct() {
		
	}

	public function isRequired($value, $ruleValue = '') {
		$value = trim($value);
		return empty($value);
	}

	public function isValidEmail($value, $ruleValue = '') {
		return !filter_var($value, FILTER_VALIDATE_EMAIL);
	}

	public function isMinLength($value, $ruleValue = '') {
		return strlen($value) < $ruleValue;
	}

	public function isMaxLength($value, $ruleValue = '') {
		return strlen($value) > $ruleValue;
	}

	public function isAlpha($value, $ruleValue = '') {
		return !ctype_alpha($value);
	}

	public function isAlphaNum($value, $ruleValue = '') {
		return !ctype_alnum($value);
	}

	public function isDigit($value, $ruleValue = '') {
		return !ctype_digit($value);
	}

	public function isMatch($value, $ruleValue = '') {
		return !_isSame($value, $ruleValue);
	}

	public function isGreaterThan($value, $ruleValue = '') {
		return $value < $ruleValue;
	}

	public function isLessThan($value, $ruleValue = '') {
		return $value > $ruleValue;
	}

}