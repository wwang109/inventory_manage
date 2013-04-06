<?php  

class product_Model extends Model {
	
	const PRODUCT_BEAN = 'products';
	const BRAND_BEAN = 'brands';
	
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
				$valid = $this->findproduct($prodNum);
				
				if($valid[1]) {
					$product = R::load(self::PRODUCT_BEAN, $valid[0]->id);
				}
				else {
					$product = R::dispense(self::PRODUCT_BEAN);
					$product->productNumber = trim($this->form->post('productNumber'));
				}
				$product->Name = trim($this->form->post('productName'));				
				
				$product->qtyUnit = trim($this->form->post('qtyUnit'));
				$product->comment = trim($this->form->post('comment'));		
				$product->dateAdded = date('Y-m-d');
				
				$this->loadLibrary('QqFileUploader', array(
			 	array('jpeg', 'jpg', 'gif', 'png', 'PNG'),
			 	FILE_MAX_SIZE));		
		
				$result = $this->lib['qqfileuploader']->handleUpload(UPLOAD_PATH);
					
				if (_betterKeyExists('success', $result)) {
					$product->image = $this->lib['qqfileuploader']->getUploadName();
				}					
				
	
				//checking brand options
				if($this->form->post('brandlist') == 'other')
					$brandName = trim($this->form->post('brand'));	
				else
					$brandName = $this->form->post('brandlist');	
				
				//Inserting a new brand
				if($brandName != "" && $brandName != 'other') {
					$this->addBrand($brandName, $product);
				}
				else {
					R::store($product);
				}
					
				return array('success'=>'Product has been updated', 'obj' =>$product);			
					
			}
			catch(Exception $e){
				return array('error'=> 'Could not store');
			}	
		}
	}
	
	public function getList($page, $sortby, $sortas, $amtPage, $options, $text) {

		$page = intval($page);
		
		switch ($sortby) {
			case 'productNumber':
			case 'Name':
			case 'brands_id':
			case 'qtyUnit':
				break;
			default:
				$sortby = 'dateAdded';
		}
		

		$sortas = $sortas == 'desc' ? 'desc' : 'asc';		
		$this->loadLibrary('pagination');
		
		if($text) {			
			switch($options){
				case 'Name':
				case 'Brand':
					break;
				default:
					$options = 'productNumber';			
			}			
			
			$calcPaging = $this->lib['pagination']->calculatePages(count(R::find(self::PRODUCT_BEAN, ' ' . $options . ' LIKE ?', array($text))), $amtPage, $page);
			$product = R::find(self::PRODUCT_BEAN, $options . ' LIKE ?' . ' ORDER BY ' . $sortby . ' ' . $sortas . ' LIMIT ' . $calcPaging['limit'][0] . ', ' . $amtPage, array($text));
		}
		else {
			$calcPaging = $this->lib['pagination']->calculatePages(count(R::find(self::PRODUCT_BEAN)), $amtPage, $page);
			$product = R::findAll(self::PRODUCT_BEAN, ' ORDER BY ' . $sortby . ' ' . $sortas . ' LIMIT ' . $calcPaging['limit'][0] . ', ' . $amtPage);
		
		}
		
		
		foreach($product as $rows){		
			$product[$rows->id]->brands_id = R::load(self::BRAND_BEAN, $rows->brands_id)->brandName;
		}
		
		//_debug($product);


		return array('OBJ'=>$product, 'paging'=>$calcPaging, 'sortBy'=>$sortby, 'sortAs'=>$sortas, 'perPage'=>$amtPage, 'option'=>$options, 'search'=>$text);		
		
		
		
		
		
		
		
		
		
		//return $product;
	}
	
	public function findproduct($prodNumber) {
		$res = R::findone(self::PRODUCT_BEAN, 'productNumber = ?', array($prodNumber));
		return $res ? array($res, TRUE) : array($prodNumber, FALSE, 'info', 'Product Number does not exist');		
	}
	
	public function findBrand($brand) {
		return R::findone(self::BRAND_BEAN, 'brandName = ?', array($brand));
	}
	public function findAllBrand() {
		return R::findAll(self::BRAND_BEAN);
	}

	public function addBrand($brandName, $product) {
		try{
			if(!$this->findBrand($brandName)){
				$brands = R::dispense(self::BRAND_BEAN);
				$brands->brandName = $brandName;
				$brands->dateAdded = date('Y-m-d');
				$brands->ownProduct[] = $product;		
			}
			else  {
				$brands = R::load(self::BRAND_BEAN, $this->findBrand($brandName)->id);
				$brands->ownProduct[] = $product;
			}
			return R::store($brands);
		}
		catch(exception $e){
			return $e;
		}

	}
	
	public function delete($product){
		$temp = $this->findproduct($product);
		try {
			if($temp[1]) {			
				$temp = R::load(self::PRODUCT_BEAN, $temp[0]->id);
				R::trash($temp);
			}
			else 
				return array('error'=>'Product Number could not be found');
		}
		catch(exception $e){
			return array('error'=> $e);
		}
		
		return array('success'=>'Product has been deleted');
	}
	/*
	public function search($option, $text) {		

		return $this->getList();	
		
	}
	*/
	
	
}