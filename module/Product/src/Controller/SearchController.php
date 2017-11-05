<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\ProductTable;
use Product\Model\Product;
use Product\Form\SearchForm;

class SearchController extends AbstractActionController
{

  private $table;

  public function __construct(ProductTable $table)
  {
    $this->table = $table;
  }

  public function searchAction()
  {
    $form = new SearchForm();
    $request = $this->getRequest();
    if ($request->isPost()) {
      return new ViewModel(['form' => $form]);
    }
    $keyword = $request->getQuery('q');
    if ($keyword) {
      $results = $this->table->matchProduct($keyword);
      return new ViewModel([
        'results' => $results,
        'form' => $form
      ]);
    }
    return new ViewModel(['form' => $form]);
  }

}
