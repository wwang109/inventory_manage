<?php

/**
 * The super class of this MVC application.
 * Controller and Model derives from this.
 */
class MVC {

	// NOTE: Have to be public because it is accessed directly from Bootstrap.
	public $controller; 
	protected $lib;
	protected $form;
	protected $model;

	/**
	 * Initializes controller, lib, model arrays, Form object
	 */
	public function __construct() {
		$this->controller = array();
		$this->lib = array();
		$this->model = array();

		$this->form = new Form();

		// NOTE: let's assume that we'll always need session.
		Session::init();
	}

	/**
	 * Loads a controller into the $controller array.
	 * 
	 * @param String $name Controller name.
	 */
	public function loadController($name) {

		$path = CONTROLLERS . $name . '.php';

		if (file_exists($path)) {
			require_once $path;

			$name = ucfirst($name);
			//if (!_isAbstract($name)) {
				$this->controller[strtolower($name)] = new $name();  // Name of $this->model
			//}
		}
	}

	/**
	 * Loads a library into the $lib array.
	 * 
	 * @param String $name Library name.
	 */
	public function loadLibrary($name, $args = array()) {

		$name = ucfirst($name);

		$path = LIBS . $name . '.php';

		if (file_exists($path)) {
			require_once $path;

			$reflectionObj = new ReflectionClass($name);
			$this->lib[strtolower($name)] = $reflectionObj->newInstanceArgs($args);
		}
	}

	/**
	 * Loads a model into $model array.
	 * 
	 * @param String $name Model name.
	 */
	protected function loadModel($name) {

		$path = MODELS . $name . '_model.php';

		if (file_exists($path)) {
			require_once MODELS . strtolower($name) . '_model.php';

			$modelName = ucfirst($name) . '_Model';
			$this->model[strtolower($name)] = new $modelName();  // Name of $this->model
		}
	}

}