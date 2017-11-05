<?php
namespace Product\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\ProductTable;
use Product\Model\Product;

class SearchController extends AbstractActionController {

	private $table;

	public function __construct(ProductTable $table) {
		$this->table= $table;
	}

	public function searchAction() {
		$request=$this->getRequest();
		if($request->isPost()){
			$keyword=$request->getPost('key');
		}
		else return new ViewModel([ 'results' => null]);
		$results=$this->table->matchProduct($keyword);
		return new ViewModel([
			'results' => $results,
		]);
	}

}