<?php
namespace Cart\Service;

use Cart\Entity\CartItem;
use Book\Entity\Book;

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
  public function addCartItem($data,$user)
  {
    $item = new CartItem();
    $book = $this->entityManager->getRepository(Book::class)->find($data['book']);
    $item->setBook($book);
    $item->setQuantity($data['quantity']);
    $item->setUser($user);
    $this->entityManager->persist($item);
    $this->entityManager->flush();
    return $item;
  }
  public function updateCartItem($item, $data)
  {
    $item->setQuantity($data['quantity']);
    $this->entityManager->flush();
  }
  public function deleteCartItem($item)
  {
    $this->entityManager->remove($item);
    $this->entityManager->flush();
  }
}

