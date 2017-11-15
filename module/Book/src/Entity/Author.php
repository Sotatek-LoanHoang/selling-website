<?php
namespace Book\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents an author
 * @ORM\Entity()
 * @ORM\Table(name="author")
 */
class Author
{
  /**
   * @ORM\Id
   * @ORM\Column(name="id")
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(name="name")
   */
  protected $name;

  /**
   * Many Authors have Many Books.
   * @ORM\ManyToMany(targetEntity="Book")
   * @ORM\JoinTable(name="book_author",
   *      joinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")}
   *      )
   */
  private $books;

  /**
   * Constructor.
   */
  public function __construct()
  {
    $this->books = new ArrayCollection();
  }

  /**
   * Returns author ID.
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Sets author ID.
   * @param int $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * Returns name.
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets name.
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * Assign a book to author.
   */
  public function addBook($book)
  {
    $this->books->add($book);
  }

  /**
   * Returns the array of books assigned to author.
   */
  public function getBooks()
  {
    return $this->books;
  }
}