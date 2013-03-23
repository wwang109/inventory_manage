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
	
		function index($page = 1, $sortby = 'dateAdded', $sortas = 'asc') {
			$result = $this->model['product']->getList($page, $sortby, $sortas);
			$this->dataRender('data', $result);	
			$this->render('product/index');
		}	
		
		function manage($product = null, $action = null, $msg = null){
			if($product) {
				$list = $this->model['product']->findProduct($product);
				$this->dataRender('data', $list[0]);
				if(!$list[1]) {
					$action = $list[2];
					$msg = $list[3];
				}
			}
			$this->render('product/manage', $action, $msg);
		}
		
		function add(){
			$res = $this->model['product']->add();
			if(_betterKeyExists('error', $res))
				$this->render('product/manage');
			else {
				$this->manage($res['obj']->productNumber, 'success', $res['success']);
				
			}
		}

		
	
}	