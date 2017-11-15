<?php
namespace Book\Service;

use Book\Entity\Author;
use Book\Entity\Book;

class AuthorManager
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
  public function addAuthor($data)
  {
    // Create new Author entity.
    $author = new Author();
    $author->setName($data['name']);
    if (isset($data['books']))
      $this->assignBooks($author, $data['books']);
    // Add the entity to the entity manager.
    $this->entityManager->persist($author);
    // Apply changes to database.
    $this->entityManager->flush();
    return $author;
  }
  public function updateAuthor($author, $data)
  {
    $author->setName($data['name']);
    if (isset($data['books']))
      $this->assignBooks($author, $data['books']);
    // Apply changes to database.
    $this->entityManager->flush();
    return true;
  }
  public function deleteAuthor($author)
  {
    $this->entityManager->remove($author);
    $this->entityManager->flush();
  }
  private function assignBooks($author, $bookIds)
  {
    $author->getBooks()->clear();

    foreach ($bookIds as $bookId) {
      error_log($bookId);
      $book = $this->entityManager->getRepository(Book::class)
        ->find($bookId);
      if ($book == null) {
        throw new \Exception('Not found book by ID');
      }

      $author->addBook($book);
    }
  }
}

