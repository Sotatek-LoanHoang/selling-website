<?php
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Book\Entity\Book;
use Book\Entity\Author;
use Book\Entity\Genre;
use Book\Entity\Series;
use Book\Form\AuthorForm;

class AuthorController extends AbstractActionController
{
  /**
   * Entity manager
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;
  /**
   * Author manager
   * @var Book\Service\AuthorManager
   */
  private $authorManager;

  /**
   * Constructor
   */
  public function __construct($entityManager, $authorManager)
  {
    $this->entityManager = $entityManager;
    $this->authorManager = $authorManager;
  }

  /**
   * This is the default "index" action of the controller. It display
   * list of authors
   */
  public function indexAction()
  {
    // Access control
    if (!$this->access('book.manage')) {
      $this->getResponse()->setStatusCode(401);
      return;
    }

    $authors = $this->entityManager->getRepository(Author::class)
      ->findBy([], ['id' => 'ASC']);

    return new ViewModel([
      'authors' => $authors
    ]);
  }
  /**
   * This action displays a page allowing to add a new book.
   */
  public function addAction()
  {
    // Create book form
    $form = new AuthorForm();

    // Get the list of all available books (sorted by name).
    $allBooks = $this->entityManager->getRepository(Book::class)
      ->findBy([], ['title' => 'ASC']);
    $bookList = [];
    foreach ($allBooks as $book) {
      $bookList[$book->getId()] = $book->getTitle();
    }

    $form->get('books')->setValueOptions($bookList);

    // Check if book has submitted the form
    if ($this->getRequest()->isPost()) {

      // Fill in the form with POST data
      $data = $this->params()->fromPost();

      $form->setData($data);

      // Validate form
      if ($form->isValid()) {

        // Get filtered and validated data
        $data = $form->getData();

        // Add author.
        $author = $this->authorManager->addAuthor($data);

        // Redirect to "view" page
        return $this->redirect()->toRoute(
          'authors',
          ['action' => 'view', 'id' => $author->getId()]
        );
      }
    }
    return new ViewModel([
      'form' => $form
    ]);
  }

  /**
   * The "view" action displays a page allowing to view author's details.
   */
  public function viewAction()
  {
    $id = (int)$this->params()->fromRoute('id', -1);
    if ($id < 1) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    // Find a author with such ID.
    $author = $this->entityManager->getRepository(Author::class)
      ->find($id);

    if ($author == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    return new ViewModel([
      'author' => $author
    ]);
  }

  /**
   * The "edit" action displays a page allowing to edit author.
   */
  public function editAction()
  {
    $id = (int)$this->params()->fromRoute('id', -1);
    if ($id < 1) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $author = $this->entityManager->getRepository(Author::class)
      ->find($id);

    if ($author == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    // Create author form
    $form = new AuthorForm();

    // Get the list of all available books (sorted by name).
    $allBooks = $this->entityManager->getRepository(Book::class)
      ->findBy([], ['title' => 'ASC']);
    $bookList = [];
    foreach ($allBooks as $book) {
      $bookList[$book->getId()] = $book->getTitle();
    }

    $form->get('books')->setValueOptions($bookList);

    // Check if author has submitted the form
    if ($this->getRequest()->isPost()) {

      // Fill in the form with POST data
      $data = $this->params()->fromPost();

      $form->setData($data);

      // Validate form
      if ($form->isValid()) {

        // Get filtered and validated data
        $data = $form->getData();

        // Update the author.
        $this->authorManager->updateAuthor($author, $data);

        // Redirect to "view" page
        return $this->redirect()->toRoute(
          'authors',
          ['action' => 'view', 'id' => $author->getId()]
        );
      }
    } else {

      $authorBookIds = [];
      foreach ($author->getBooks() as $book) {
        $authorBookIds[] = $book->getId();
      }

      $form->setData(array(
        'name' => $author->getName(),
        'books' => $authorBookIds,
      ));
    }

    return new ViewModel(array(
      'author' => $author,
      'form' => $form
    ));
  }
}
