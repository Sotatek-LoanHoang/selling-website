<?php
namespace Book\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a book
 * @ORM\Entity()
 * @ORM\Table(name="book")
 */
class Book
{
  /**
   * @ORM\Id
   * @ORM\Column(name="id")
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @ORM\Column(name="title")
   */
  protected $title;

  /**
   * @ORM\Column(name="description")
   */
  protected $description;

  /**
   * @ORM\Column(name="publisher")
   */
  protected $publisher;

  /**
   * @ORM\Column(name="print_length")
   */
  protected $printLength;

  /**
   * @ORM\Column(name="release_date")
   */
  protected $releaseDate;

  /**
   * Many Books have Many Authors.
   * @ORM\ManyToMany(targetEntity="Author")
   * @ORM\JoinTable(name="book_author",
   *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="author_id", referencedColumnName="id")}
   *      )
   */
  private $authors;

  /**
   * @ORM\ManyToMany(targetEntity="Book\Entity\Genre")
   * @ORM\JoinTable(name="book_genre",
   *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
   *      )
   */
  private $genres;

  /**
   * @ORM\ManyToMany(targetEntity="Book\Entity\Series")
   * @ORM\JoinTable(name="book_series",
   *      joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="series_id", referencedColumnName="id")}
   *      )
   */
  private $series;

  /**
   * Constructor.
   */
  public function __construct()
  {
    $this->$authors = new ArrayCollection();
    $this->$genres = new ArrayCollection();
    $this->$series = new ArrayCollection();
  }

  /**
   * Returns book ID.
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Sets book ID.
   * @param int $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * Returns title.
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Sets title.
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * Returns description.
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Sets description.
   * @param string $description
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }

  /**
   * Returns print length.
   * @return string
   */
  public function getPrintLength()
  {
    return $this->printLength;
  }

  /**
   * Sets print length.
   * @param string $printLength
   */
  public function setPrintLength($printLength)
  {
    $this->printLength = $printLength;
  }

  /**
   * Returns release date.
   * @return string
   */
  public function getReleaseDate()
  {
    return $this->releaseDate;
  }

  /**
   * Sets release date.
   * @param string $releaseDate
   */
  public function setReleaseDate($releaseDate)
  {
    $this->releaseDate = $releaseDate;
  }

  /**
   * Returns publisher.
   * @return string
   */
  public function getPublisher()
  {
    return $this->publisher;
  }

  /**
   * Sets publisher.
   * @param string $publisher
   */
  public function setPublisher($publisher)
  {
    $this->publisher = $publisher;
  }

  /**
   * Assign a author to book.
   */
  public function addAuthor($author)
  {
    $this->authors->add($author);
  }

  /**
   * Returns the array of authors assigned to book.
   */
  public function getAuthors()
  {
    return $this->authors;
  }

  /**
   * Assign a genre to book.
   */
  public function addGenre($genre)
  {
    $this->genres->add($genre);
  }

  /**
   * Returns the array of genres assigned to book.
   */
  public function getGenres()
  {
    return $this->genres;
  }

  /**
   * Assign a series to book.
   */
  public function addSeries($series)
  {
    $this->series->add($series);
  }

  /**
   * Returns the array of series assigned to book.
   */
  public function getSeries()
  {
    return $this->series;
  }
}
