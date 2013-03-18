<?php 

class Product extends _Main_controller {

	public function __construct() {
		parent::__construct();
		$this->loadModel('product');
	}
	
		public function beforeCall($currentFunction, $args) {
			$this->loadModel('login');
			if($this->model['login']->isLogin())
				return TRUE;
			return FALSE;
		}
	
		function index($action = null, $msg = null) {
			
			$this->render('product/index', $action, $msg);
		}	
		
		function manage($product = null, $action = null, $msg = null){
			if($product) {
				$list = $this->model['product']->findProduct($product);
				$this->dataRender('data', $list);
			}
			$this->render('product/manage');
		}
		
		function add(){
			$res = $this->model['product']->add();
			if(betterKeyExists('error', $res))
				$this->render('product/manage', 'error', $res['error']);
			else
				$this->manage($res['obj'], 'success', $res['success']);
		}
		
		function find() {
			
			
		}
		
	
}	