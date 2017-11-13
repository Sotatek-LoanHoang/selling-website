<?php
namespace Book\Service;

use Book\Entity\Book;
use Book\Entity\Author;

class BookManager
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
  public function addBook($data)
  {
    // Create new Book entity.
    $book = new Book();
    $book->setTitle($data['title']);
    if (isset($data['description']) && !empty($data['description']))
      $book->setDescription($data['description']);
    if (isset($data['printLength']) && !empty($data['printLength']))
      $book->setPrintLength($data['printLength']);
    if (isset($data['releaseDate']) && !empty($data['releaseDate']))
      $book->setReleaseDate($data['releaseDate']);
    if (isset($data['publisher']) && !empty($data['publisher']))
      $book->setPublisher($data['publisher']);
    if (isset($data['authors']))
      $this->assignAuthors($book, $data['authors']);
    if (isset($data['genres']))
      $this->assignGenres($book, $data['genres']);
    if (isset($data['series']))
      $this->assignSeries($book, $data['series']);
    // Add the entity to the entity manager.
    $this->entityManager->persist($book);
    // Apply changes to database.
    $this->entityManager->flush();
    return $book;
  }
  public function updateBook($book, $data)
  {
    $book->setTitle($data['title']);
    if (isset($data['description']) && !empty($data['description']))
      $book->setDescription($data['description']);
    if (isset($data['printLength']) && !empty($data['printLength']))
      $book->setPrintLength($data['printLength']);
    if (isset($data['releaseDate']) && !empty($data['releaseDate']))
      $book->setReleaseDate($data['releaseDate']);
    if (isset($data['publisher']) && !empty($data['publisher']))
      $book->setPublisher($data['publisher']);
    if (isset($data['authors']))
      $this->assignAuthors($book, $data['authors']);
    if (isset($data['genres']))
      $this->assignGenres($book, $data['genres']);
    if (isset($data['series']))
      $this->assignSeries($book, $data['series']);
    // Apply changes to database.
    $this->entityManager->flush();
    return true;
  }
  public function deleteBook($book)
  {
    $this->entityManager->remove($book);
    $this->entityManager->flush();
  }
  private function assignAuthors($book, $authorIds)
  {
    $book->getAuthors()->clear();

    foreach ($authorIds as $authorId) {
      $author = $this->entityManager->getRepository(Author::class)
        ->find($authorId);
      if ($author == null) {
        throw new \Exception('Not found author by ID');
      }

      $book->addRole($author);
    }
  }
  private function assignGenres($book, $genreIds)
  {
    $book->getGenres()->clear();

    foreach ($genreIds as $genreId) {
      $genre = $this->entityManager->getRepository(Genre::class)
        ->find($genreId);
      if ($genre == null) {
        throw new \Exception('Not found genre by ID');
      }

      $book->addRole($genre);
    }
  }
  private function assignSeries($book, $seriesIds)
  {
    $book->getSeries()->clear();

    foreach ($seriesIds as $seriesId) {
      $series = $this->entityManager->getRepository(Series::class)
        ->find($seriesId);
      if ($series == null) {
        throw new \Exception('Not found series by ID');
      }

      $book->addRole($series);
    }
  }
}

