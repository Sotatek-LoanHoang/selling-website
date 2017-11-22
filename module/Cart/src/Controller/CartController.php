<?php
namespace Cart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cart\Entity\CartItem;
use Doctrine\Common\Collections\ArrayCollection;

class CartController extends AbstractActionController
{
  /**
   * Entity manager
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  private $cartManager;

  /**
   * Constructor
   */
  public function __construct($entityManager, $cartManager)
  {
    $this->entityManager = $entityManager;
    $this->cartManager = $cartManager;
  }

  /**
   * This is the default "index" action of the controller. It display
   * cart items
   */
  public function indexAction()
  {
    $items = $this->entityManager->getRepository(CartItem::class)->findByUser($this->currentUser());
    return new ViewModel([
      'items'=>$items
    ]);
  }

  public function addAction()
  {
    $data = $this->params()->fromQuery();
    $item = $this->entityManager->getRepository(CartItem::class)->findBy(['user'=>$this->currentUser()->getId(),
    'book'=>$data['book']]);
    if (count($item) == 1) {
      $this->cartManager->updateCartItem($item[0],['quantity'=>$item[0]->getQuantity()+$data['quantity']]);
    } else {
      $this->cartManager->addCartItem($data,$this->currentUser());
    }
    return $this->redirect()->toRoute('cart',['action'=>'index']);
  }

  public function deleteAction()
  {
    $data = $this->params()->fromQuery();
    $item = $this->entityManager->getRepository(CartItem::class)->findBy(['user_id'=>$this->currentUser()->getId(),
    'book_id'=>$data['book']]);
    if (count($item) == 1) {
      $this->cartManager->deleteCartItem($item[0]);
    }
  }

  public function updateAction()
  {
    $data = $this->params()->fromQuery();
    $item = $this->entityManager->getRepository(CartItem::class)->findBy(['user'=>$this->currentUser()->getId(),
    'book'=>$data['book']]);
    if (count($item) == 1) {
      $this->cartManager->updateCartItem($item[0],['quantity'=>$data['quantity']]);
    } else {
      $this->cartManager->addCartItem($data,$this->currentUser());
    }
    return $this->redirect()->toRoute('cart',['action'=>'index']);
  }
}
