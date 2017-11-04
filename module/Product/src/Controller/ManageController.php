<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\ProductTable;
use Product\Model\Product;
use Product\Form\ProductForm;

class ManageController extends AbstractActionController
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

        $form = new ProductForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if(!$request->isPost()) {
            return['form' => $form];
        }

        $product = new Product();

        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());
        if(! $form->isValid()) {
            return['form'=>$form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveProduct($product);
        return $this->redirect()->toRoute('manage');
    }

  public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('manage');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteProduct($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('manage');
        }

        return [
            'id'    => $id,
            'product' => $this->table->getProduct($id),
        ];
    }

    public function editAction(){
    $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('manage', ['action' => 'add']);
        }

        // Retrieve the product with the specified id. Doing so raises
        // an exception if the product is not found, which should result
        // in redirecting to the landing page.
        try {
            $product = $this->table->getProduct($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('manage', ['action' => 'index']);
        }

        $form = new ProductForm();
        $form->bind($product);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveProduct($product);

        // Redirect to product list
        return $this->redirect()->toRoute('manage', ['action' => 'index']);
    	
    }
}
