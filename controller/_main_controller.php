<?php

abstract class _Main_controller extends Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function renderWithSidebar($name, $alertVal = '', $alertMsg = '') {
		if(Session::get('loggedIn') == TRUE) {
			$this->loadModel('user');
			$this->dataRender('dp', $this->model['user']->getDP());
		}
		return $this->view->render(array('header', 'sidebar', $name, 'footer'), $alertVal, $alertMsg);
	}
	
	protected function render($name, $alertVal = '', $alertMsg = '') {
		return $this->view->render(array('header', $name, 'footer'), $alertVal, $alertMsg);
	}
	protected function renderPageOnly($name, $alertVal = '', $alertMsg = '') {
		return $this->view->render(array($name), $alertVal, $alertMsg);
	}      
	
	protected function dataRender($key, $value) {
		$this->view->{$key} = $value;
		return TRUE;
	}
}