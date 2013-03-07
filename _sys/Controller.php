<?php

/**
 * Super Controller class. All controllers must derive from this.
 */
class Controller extends MVC {

	/**
	 * Member variable for View object.
	 * 
	 * @var View
	 */
	protected $view;



	/**
	 * Creates View and Model object.
	 */
	public function __construct() {
		parent::__construct();
		$this->view = new View();
	}
	
	public function beforeCall($currentFunction, $arguments) { return TRUE; }



}