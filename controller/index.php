<?php 

class Index extends _Main_controller {

	public function __construct() {
		parent::__construct();
		$this->loadModel('login');
	}
	
	function index($action = null, $msg = null) {
		if($this->model['login']->isLogin())
			$this->render('index/index', $action, $msg);
		else
			$this->render('index/login', $action, $msg);	
				
	}	
	
	function login() {
		
		$res = $this->model['login']->login();
		if(_betterKeyExists('error', $res)) {
			$this->index('error', $res['error']);
		}
		else if(_betterKeyExists('success', $res)) {
			$this->index('success', $res['success']);
		}
		else {
			$this->index();
		}
		
	}
	
	function logout() {
		$res = $this->model['login']->logout();
		
		if(_betterKeyExists('error', $res)) {
			$this->index('error', $res['error']);
		}
		else {
			_redirect(URL);
			//$this->index('success', $res['success']);
		}
		
	}
	
}	