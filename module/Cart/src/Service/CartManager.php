<?php
namespace Cart\Service;

use Cart\Entity\CartItem;

class CartManager
{
  /**
   * Doctrine entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  public function __construct($entityManager)
  {
    $this->entityManager = $entityManager;
  }
  public function addCartItem($data)
  {
  }
  public function updateCartItem($author, $data)
  {
  }
  public function deleteCartItem($author)
  {
  }
}

