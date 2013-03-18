<?php  

class product_Model extends Model {
	
	const PRODUCT_BEAN = 'products';
	
	public function __construct() {

		parent::__construct();
		
	}
	
	public function add() {
		
		if(!$this->form->isAction('POST')) {
			return;
		}
		$prodNum = trim($this->form->post('productNumber'));
		
		if($prodNum == '') {
			return array('error'=> 'Product Number is empty');
		}
		
		else {
					
			try{
				if($this->findproduct($prodNum)) {
					return $this->edit($prodNum);
				}
				else {
					return $this->insert($prodNum);
				}
			}
			
			catch(Exception $e) {
				return array('error'=> 'Could not store');
			}
				
		}
	}
	
	public function getList() {
		
		
	}
	
	public function edit($prodNum) {
		
		$product = $this->findproduct($prodNum);
		$product = R::load(self::PRODUCT_BEAN, $product->id);

		$product->Name = trim($this->form->post('productName'));
		$product->Brand = trim($this->form->post('brand'));
		$product->qtyUnit = trim($this->form->post('qtyUnit'));
		$product->comment = trim($this->form->post('comment'));		
		
		if($this->form->post('qqfile') != null) {
			$this->loadLibrary('QqFileUploader', array(
			 array('jpeg', 'jpg', 'gif', 'png', 'PNG'),
			 FILE_MAX_SIZE));		
		
			$result = $this->lib['qqfileuploader']->handleUpload(UPLOAD_PATH);
			if (_betterKeyExists('success', $result)) {
			$product->image = $this->lib['qqfileuploader']->getUploadName();
			}
			else {
				return array('error'=>$result['error']);
			}					
		}
		
		R::store($product);
		return array('success'=>'Product has been updated');
		
	}
	
	public function insert($prodNum) {
		
		$product = R::dispense(self::PRODUCT_BEAN);
		$product->productNumber = $prodNum;
		$product->Name = trim($this->form->post('productName'));
		$product->Brand = trim($this->form->post('brand'));
		$product->dateAdded = date('Y-m-d H:i:s');
		$product->qtyUnit = trim($this->form->post('qtyUnit'));
		$product->comment = trim($this->form->post('comment'));
		
		if($this->form->post('qqfile') != null) {
			$this->loadLibrary('QqFileUploader', array(
			 array('jpeg', 'jpg', 'gif', 'png', 'PNG'),
			 FILE_MAX_SIZE));		
		
			$result = $this->lib['qqfileuploader']->handleUpload(UPLOAD_PATH);
			if (_betterKeyExists('success', $result)) {
			$product->image = $this->lib['qqfileuploader']->getUploadName();
			}
			else {
				return array('error'=>$result['error']);
			}					
		}	
		
		R::store($product);
		return array('success'=> 'Product has been added');		
		
	}
	
	public function findproduct($prodNumber) {
		return R::findone(self::PRODUCT_BEAN, 'productNumber = ?', array($prodNumber));		
	}
	
}