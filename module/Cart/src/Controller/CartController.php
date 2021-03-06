<?php
namespace Cart\Controller;

use Cart\Form\CartForm;
use Cart\Model\Item;
use Cart\Service\ItemTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Product\Model\ProductTable;

class CartController extends AbstractActionController
{
  private $itemTable;
  private $productTable;

  public function __construct(ItemTable $itemTable, ProductTable $productTable)
  {
    $this->itemTable = $itemTable;
    $this->productTable = $productTable;
  }
  public function indexAction()
  {
    $auth = new AuthenticationService();
    if (!$auth->hasIdentity()) {
      return $this->redirect()->toRoute('auth', ['action' => 'login']);
    }
    $items = $this->itemTable->getItems();
    $newItems = [];
    foreach ($items as $item) {
      $product = $this->productTable->getProduct($item->id);
      $newItems[$item->id] = [
        "quantity" => $item->quantity,
        "name" => $product->name,
        "image" => $product->image,
        "price" => $product->price,
      ];
    }
    $form = new CartForm($items);
    $request = $this->getRequest();
    if (!$request->isPost()) {
      return ['form' => $form, 'items' => $newItems];
    }
    $form->setData($request->getPost());
    if (!$form->isValid()) {
      return ['form' => $form];
    }
    if (!$form->isValid()) {
      return [
        'form' => $form,
        'items' => $newItems,
      ];
    }
    $data = $form->getData();
    $items = [];
    foreach ($data as $key => $value) {
      // error_log($key);
      if ($key != 'submit') {
        $temp = new Item();
        $temp->exchangeArray(['id' => $key, 'quantity' => $value]);
        $newItems[$item->id]["quantity"] = $value;
        $items[] = $temp;
      }
    }
    $this->itemTable->saveItems($items);
    return [
      'form' => $form,
      'items' => $newItems,
    ];
  }
  public function addAction()
  {
    $auth = new AuthenticationService();
    if (!$auth->hasIdentity()) {
      return $this->redirect()->toRoute('auth', ['action' => 'login']);
    }
    $request = $this->getRequest();
    if (!$request->isPost()) {
      return $this->redirect()->toRoute('cart');
    }
    $data = $request->getPost();
    $item = $this->itemTable->getItem($data['id']);
    if (isset($item)){
      $item->quantity += $data['quantity'];
    } else {
      $item = new Item();
      $item->exchangeArray($data);
    }
    $item = $this->itemTable->saveItem($item);
    return $this->redirect()->toRoute('cart');
  }
}
?>
