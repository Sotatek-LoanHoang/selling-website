<?php
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Book\Entity\Book;
use Book\Entity\Author;
use Book\Entity\Genre;
use Book\Entity\Series;
use Book\Form\BookForm;

class BookController extends AbstractActionController
{
  /**
   * Entity manager
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;
  /**
   * Book manager
   * @var Book\Service\BookManager
   */
  private $bookManager;

  /**
   * Constructor
   */
  public function __construct($entityManager, $bookManager)
  {
    $this->entityManager = $entityManager;
    $this->bookManager = $bookManager;
  }

  /**
   * This is the default "index" action of the controller. It display
   * list of books
   */
  public function indexAction()
  {
    // Access control
    if (!$this->access('book.manage')) {
      $this->getResponse()->setStatusCode(401);
      return;
    }

    $books = $this->entityManager->getRepository(Book::class)
      ->findBy([], ['id' => 'ASC']);

    return new ViewModel([
      'books' => $books
    ]);
  }
  /**
   * This action displays a page allowing to add a new book.
   */
  public function addAction()
  {
    // Create book form
    $form = new BookForm();

    // Get the list of all available authors (sorted by name).
    $allAuthors = $this->entityManager->getRepository(Author::class)
      ->findBy([], ['name' => 'ASC']);
    $authorList = [];
    foreach ($allAuthors as $author) {
      $authorList[$author->getId()] = $author->getName();
    }

    $form->get('authors')->setValueOptions($authorList);

    // Get the list of all available series (sorted by name).
    $allSeries = $this->entityManager->getRepository(Series::class)
      ->findBy([], ['name' => 'ASC']);
    $seriesList = [];
    foreach ($allSeries as $series) {
      $seriesList[$series->getId()] = $series->getName();
    }

    $form->get('series')->setValueOptions($seriesList);

    // Get the list of all available genres (sorted by name).
    $allGenres = $this->entityManager->getRepository(Genre::class)
      ->findBy([], ['name' => 'ASC']);
    $genreList = [];
    foreach ($allGenres as $genre) {
      $genreList[$genre->getId()] = $genre->getName();
    }

    $form->get('genres')->setValueOptions($genreList);

    // Check if book has submitted the form
    if ($this->getRequest()->isPost()) {

      // Fill in the form with POST data
      $data = $this->params()->fromPost();

      $form->setData($data);

      // Validate form
      if ($form->isValid()) {

        // Get filtered and validated data
        $data = $form->getData();

        // Add book.
        $book = $this->bookManager->addBook($data);

        // Redirect to "view" page
        return $this->redirect()->toRoute(
          'books',
          ['action' => 'view', 'id' => $book->getId()]
        );
      }
    }
    return new ViewModel([
      'form' => $form
    ]);
  }

  /**
   * The "view" action displays a page allowing to view book's details.
   */
  public function viewAction()
  {
    $id = (int)$this->params()->fromRoute('id', -1);
    if ($id < 1) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    // Find a book with such ID.
    $book = $this->entityManager->getRepository(Book::class)
      ->find($id);

    if ($book == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    return new ViewModel([
      'book' => $book
    ]);
  }

  /**
   * The "edit" action displays a page allowing to edit book.
   */
  public function editAction()
  {
    $id = (int)$this->params()->fromRoute('id', -1);
    if ($id < 1) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    $book = $this->entityManager->getRepository(Book::class)
      ->find($id);

    if ($book == null) {
      $this->getResponse()->setStatusCode(404);
      return;
    }

    // Create book form
    $form = new BookForm();

    // Get the list of all available authors (sorted by name).
    $allAuthors = $this->entityManager->getRepository(Author::class)
      ->findBy([], ['name' => 'ASC']);
    $authorList = [];
    foreach ($allAuthors as $author) {
      $authorList[$author->getId()] = $author->getName();
    }

    $form->get('authors')->setValueOptions($authorList);

    // Get the list of all available series (sorted by name).
    $allSeries = $this->entityManager->getRepository(Series::class)
      ->findBy([], ['name' => 'ASC']);
    $seriesList = [];
    foreach ($allSeries as $series) {
      $seriesList[$series->getId()] = $series->getName();
    }

    $form->get('series')->setValueOptions($seriesList);

    // Get the list of all available genres (sorted by name).
    $allGenres = $this->entityManager->getRepository(Genre::class)
      ->findBy([], ['name' => 'ASC']);
    $genreList = [];
    foreach ($allGenres as $genre) {
      $genreList[$genre->getId()] = $genre->getName();
    }

    $form->get('genres')->setValueOptions($genreList);

    // Check if book has submitted the form
    if ($this->getRequest()->isPost()) {

      // Fill in the form with POST data
      $data = $this->params()->fromPost();

      $form->setData($data);

      // Validate form
      if ($form->isValid()) {

        // Get filtered and validated data
        $data = $form->getData();

        // Update the book.
        $this->bookManager->updateBook($book, $data);

        // Redirect to "view" page
        return $this->redirect()->toRoute(
          'books',
          ['action' => 'view', 'id' => $book->getId()]
        );
      }
    } else {

      $bookSeriesIds = [];
      foreach ($book->getSeries() as $series) {
        $bookSeriesIds[] = $series->getId();
      }
      $bookAuthorIds = [];
      foreach ($book->getAuthors() as $author) {
        $bookAuthorIds[] = $author->getId();
      }
      $bookGenreIds = [];
      foreach ($book->getGenres() as $genre) {
        $bookGenreIds[] = $genre->getId();
      }

      $form->setData(array(
        'title' => $book->getTitle(),
        'description' => $book->getDescription(),
        'publisher' => $book->getPublisher(),
        'releaseDate' => $book->getReleaseDate(),
        'printLength' => $book->getPrintLength(),
        'authors' => $bookAuthorIds,
        'series' => $bookSeriesIds,
        'genres' => $bookGenreIds,
      ));
    }

    return new ViewModel(array(
      'book' => $book,
      'form' => $form
    ));
  }
}
