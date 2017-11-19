<?php
namespace Cart\Entity;

use User\Entity\User;
use Book\Entity\Book;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents an item in uesr's cart
 * @ORM\Entity()
 * @ORM\Table(name="cart_item")
 */
class CartItem
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="User\Entity\User")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Book\Entity\Book")
   * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
   */
  protected $book;

  /**
   * @ORM\Column(name="quantity")
   */
  protected $quantity;

  public function __construct()
  {
  }

  /**
   * Returns user
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * Sets user
   */
  public function setUser($user)
  {
    $this->user = $user;
  }

  /**
   * Returns book
   */
  public function getBook()
  {
    return $this->book;
  }

  /**
   * Sets book
   */
  public function setBook($book)
  {
    $this->book = $book;
  }

  /**
   * Returns quantity
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Sets quantity
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;
  }

}
