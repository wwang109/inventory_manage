<?php

/**
 * Bootstrap for the MVC application.
 * This bootstrap is a singleton.
 */
class Bootstrap {

	/**
	 * Self variable to achieve singleton.
	 * 
	 * @var Bootstrap $bootstrap
	 */
	public static $bootstrap;

	/**
	 * MVC object.
	 * 
	 * @var MVC $mvc
	 */
	public $mvc;

	/**
	 * Initializes the MVC application.
	 * 
	 * @return Self An instance of the bootstrap.
	 */
	public static function run() {
		if (!isset(self::$bootstrap)) {
			self::$bootstrap = new Bootstrap();
		}

		return self::$bootstrap;
	}

	/**
	 * Everything starts here.
	 * 
	 * @return N/A. Return is used it skip the rest of the lines.
	 */
	private function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		Session::setFingerprint();
		Session::setTimeout();
		date_default_timezone_set(TIMEZONE);

		if (IS_R) {
			Database::configureR(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		}

		if (isset($url[0])) {
			$controllerName = $url[0];
		}
		if (isset($url[1])) {
			$methodName = $url[1];
		}
		if (count($url) > 2) {
			$params = array_splice($url, 2);
		}

		$this->mvc = new MVC();

		if (empty($controllerName)) {
			$this->mvc->loadController('index');
			$this->mvc->controller['index']->index();
			return;
		}

		$this->mvc->loadController($controllerName);
		if (!isset($this->mvc->controller[$controllerName])) {
			_showError(404);
			return;
		}

		// Set $controller to mvc's controller
		$controller = $this->mvc->controller[$controllerName];
		$methodName = isset($methodName) ? $methodName : 'index';
		if (isset($params)) {
			$paramsCount = count($params);
		} else {
			$params = array();
			$paramsCount = 0;
		}

		try {
			$reflection = new ReflectionMethod($controller, $methodName);
		} catch (Exception $e) {
			//_log('NOTICE', $e);
			_showError(404);
			return;
		}

		// Call methods
		if ($reflection->isPublic()) {

			if (
					  $reflection->getNumberOfParameters() >= $paramsCount &&
					  $reflection->getNumberOfRequiredParameters() <= $paramsCount &&
					  $methodName != 'beforeCall'
			) {
				$res = $controller->beforeCall($methodName, $params);
				if ($res) {
					return call_user_func_array(array($controller, $methodName), $params);
				}
			}
		}

		_showError(404);
	}

}