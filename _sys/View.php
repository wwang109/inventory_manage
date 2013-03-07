<?php

/**
 * Displayer for the MVC.
 */
class View {

	public function __construct() {
		
	}

	/**
	 * Includes template view.
	 * 
	 * @param String $name Name of view.
	 * @param Boolean $noInclude Whether to include header and footer or not. False (includes header and footer) by default.
	 */
	public function render($with = array(), $alertVal = '', $alertMsg = '') {
		if (!empty($alertVal)) {
			_alert($this, $alertVal, $alertMsg);
		}
		
		if (!empty($with)) {
			
			foreach ($with as $one) {
				$path = VIEWS . $one . '.php';
				
				if(file_exists($path)) {
					require $path;
				}
			}
			
			
		}
		return TRUE;
		
	}



}