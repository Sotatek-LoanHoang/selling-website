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
   * Constructor.
   */
  public function __construct()
  {
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
}
