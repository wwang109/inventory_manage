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
		$this->render('product/index', $action = null, $msg = null);
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
			
		$brand = $this->model['product']->findAllBrand();
		$this->dataRender('brand', $brand);
		$this->render('product/manage', $action, $msg);
	}
		
	function add(){
			
		$res = $this->model['product']->add();
		if(_betterKeyExists('error', $res))
			$this->render('product/manage', 'error', $res['error']);
		else {
			$this->manage($res['obj']->productNumber, 'success', $res['success']);				
		}
	}
		
	function delete($product = null) {
		$res = $this->model['product']->delete($product);
			
		if(_betterKeyExists('error', $res))
			$this->render('product/manage', 'error', $res['error']);
		else {
			$this->manage(null, 'success', $res['success']);
		}			
	}
		
	function getList($page = 1, $sortby = 'dateAdded', $sortas = 'asc', $amtPage = 2, $option = 'productNumber', $text = "") {
		$result = $this->model['product']->getList($page, $sortby, $sortas, $amtPage, $option, $text);
		$this->dataRender('data', $result);
		$this->renderPageOnly('product/table');
			
	}
		
	function search($option, $text) {
		$text = '%' . $text . '%';
		$this->getList(1, 'dateAdded', 'asc', 2, $option, $text);	
	}	
	
}	