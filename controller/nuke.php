<?php

class Nuke extends _Main_controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($docreate = 1) {
		ini_set('max_execution_time', 300); // Update max execution time -- it takes a while to create these without R::freeze
		R::nuke();
		
		if($docreate == 1){
			$user = R::dispense('users');
			$user->username = 'test';
			$user->password = '11b7721e6861590e9abad1e73c1ba1369902b6ebeae26e001fbcb3d036bf5e7a';
			
			R::store($user);

			$brands = R::dispense('brands');
			$brands->brandName = 'other';
			R::store($brands);
		}
		
	}
	
}