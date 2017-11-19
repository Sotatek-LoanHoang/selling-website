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

  /**
   * Constructor
   */
  public function __construct($entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * This is the default "index" action of the controller. It display
   * cart items
   */
  public function indexAction()
  {
    $cartItems = $this->entityManager->getRepository(CartItem::class)->findByUser($this->currentUser());
  }
}
