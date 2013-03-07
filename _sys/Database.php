<?php

/**
 * An extension of the PDO class.
 */
class Database extends PDO {
	
	public static function configureR($dbType, $dbHost, $dbName, $dbUser, $dbPass) {
		R::setup($dbType . ':host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
	}

	/**
	 * Construct the PDO class.
	 * 
	 * @param String $dbType Type of database to use (eg. mysql)
	 * @param String $dbHost Host of database (eg. localhost)
	 * @param String $dbName Name of the database
	 * @param String $dbUser Username to database
	 * @param String $dbPass Password to database
	 */
	public function __construct($dbType, $dbHost, $dbName, $dbUser, $dbPass) {
		parent::__construct($dbType . ':host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
	}

}