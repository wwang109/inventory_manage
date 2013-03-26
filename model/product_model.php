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
				$valid = $this->findproduct($prodNum);
				
				if($valid[1]) {
					$product = R::load(self::PRODUCT_BEAN, $valid[0]->id);
				}
				else {
					$product = R::dispense(self::PRODUCT_BEAN);
					$product->productNumber = trim($this->form->post('productNumber'));
				}
				$product->Name = trim($this->form->post('productName'));
				$product->Brand = trim($this->form->post('brand'));
				$product->qtyUnit = trim($this->form->post('qtyUnit'));
				$product->comment = trim($this->form->post('comment'));		
				
				$this->loadLibrary('QqFileUploader', array(
			 	array('jpeg', 'jpg', 'gif', 'png', 'PNG'),
			 	FILE_MAX_SIZE));		
		
				$result = $this->lib['qqfileuploader']->handleUpload(UPLOAD_PATH);
					
				if (_betterKeyExists('success', $result)) {
					$product->image = $this->lib['qqfileuploader']->getUploadName();
				}					
				R::store($product);
				return array('success'=>'Product has been updated', 'obj' =>$product);			
					
			}
			catch(Exception $e){
				return array('error'=> 'Could not store');
			}	
		}
	}
	
	public function getList($search, $page, $sortby, $sortas) {
		$page = intval($page);
			switch ($sortby) {
			case 'productNumber':
			case 'Name':
			case 'Brand':
			case 'qtyUnit':
				break;
			default:
				$sortby = 'dateAdded';
		}

		$sortas = $sortas == 'desc' ? 'desc' : 'asc';		
		$this->loadLibrary('pagination');
		if($search) {
			switch($search[1]) {
				case 'Name':
				case 'Brand':
					break;
				default:
					$search[1] = 'productNumber';
			}
			$res = R::find(self::PRODUCT_BEAN, ' ' . $search[1] . ' LIKE ?', array($search[0]));
			$calcPaging = $this->lib['pagination']->calculatePages(count($res), 10, $page);
			$List = R::find(self::PRODUCT_BEAN, $search[1] . ' LIKE ?' . ' ORDER BY ' . $sortby . ' ' . $sortas . ' LIMIT ' . $calcPaging['limit'][0] . ', ' . 10, array($search[0]));
		}
		else {
			$calcPaging = $this->lib['pagination']->calculatePages(R::count(self::PRODUCT_BEAN), 10, $page);		
			$List = R::findall(self::PRODUCT_BEAN, 'ORDER BY ' . $sortby . ' ' . $sortas . ' LIMIT ' . $calcPaging['limit'][0] . ', ' . 10);
		}
		return array('OBJ'=>$List, 'paging'=>$calcPaging, 'sortBy'=>$sortby, 'sortAs'=>$sortas);
		
	}
	
	public function findproduct($prodNumber) {
		$res = R::findone(self::PRODUCT_BEAN, 'productNumber = ?', array($prodNumber));
		return $res ? array($res, TRUE) : array($prodNumber, FALSE, 'info', 'Product Number does not exist');		
	}
	
	public function search() {
		if(!$this->form->isAction('POST')) {
			return;
		}
		
		$field = $this->form->post('txtbox');
		$field = '%' . $field . '%';
		$option = $this->form->post('options');
		
		return array($field, $option);		
		
	}
	
	
	
}