<?php
namespace Book\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a genre
 * @ORM\Entity()
 * @ORM\Table(name="genre")
 */
class Genre
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
   * Many Genres have Many Books.
   * @ORM\ManyToMany(targetEntity="Book")
   * @ORM\JoinTable(name="book_genre",
   *      joinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")},
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
   * Returns genre ID.
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Sets genre ID.
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
   * Assign a book to genre.
   */
  public function addBook($book)
  {
    $this->books->add($book);
  }

  /**
   * Returns the array of books assigned to genre.
   */
  public function getBooks()
  {
    return $this->books;
  }
}
