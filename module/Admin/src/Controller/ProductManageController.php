<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\ProductTable;

class ProductManageController extends AbstractActionController
{
    private $table;

   public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        return new ViewModel([
            'products' => $this->table->fetchAll(),
        ]);
    }

    public function addAction(){

    }

    public function deleteAction(){

    }

    public function editAction(){
    	
    }
}
