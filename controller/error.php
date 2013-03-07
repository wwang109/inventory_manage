<?php

class Error extends _Main_controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($errorCode) {
		$errorCode = intval($errorCode);
		$msg = '';
		switch($errorCode) {
			case 404:
				$msg = '404 - This page doesn\'t exist';
				break;
			case 500:
				$msg = '500 - Application error. Please contact administrator!';
				break;
			default:
				$msg = 'Unknown error. Please contact administrator!';
		}
		$this->dataRender('msg', $msg);
		http_response_code($errorCode);
		$this->render('error/index');
	}

}