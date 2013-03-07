<?php

/**
 * Super Model class. All models must derive from this.
 */
class Model extends MVC {

	/**
	 * Member variable for database object.
	 * 
	 * @var type Database
	 */
	protected $db;
	
	protected $rules;

	/**
	 * Creates Database object.
	 */
	public function __construct() {
		parent::__construct();
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}

}