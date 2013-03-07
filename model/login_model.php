<?php

class login_Model extends Model {
	
	const USER_BEAN = 'users';
	
	public function __construct() {

		parent::__construct();
		
	}
	
	public function isLogin() {
		if(Session::get('logged') == TRUE)
			return TRUE;
		else {
			return FALSE;
		}
		
	}
	
	
	public function login() {

		if (!$this->form->isAction('POST')) {
			return FALSE;
		}

		try {
			$login = $this->form->post('username');
			$password = $this->form->post('password');
			
		} catch (Exception $e) {
			return array('error' => $e->getMessage());
		}

		if ($this->isLoginCredValid($login, $password)) {
			Session::init();
			Session::set('loggedUsername', $login);
			Session::set('logged', TRUE);
			return array('success' => 'Login success!');
		}

		return array('error' => 'Login failed!');
	}
	
	public function logout(){
		if($this->isLogin()){
			Session::destroy();
			return array('success' => 'Logout success!');
		}
		else 
			return array('error' => 'Not logged In');
	}		
	
	public function isLoginCredValid($username, $password) {
		return R::findOne(self::USER_BEAN, 'username = ? AND password = ?', array($username, Hash::create($password)));
	}
	
	
	
}