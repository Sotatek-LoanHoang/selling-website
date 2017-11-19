<?php
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Book\Entity\Book;
use Book\Entity\Author;
use Book\Entity\Genre;
use Doctrine\Common\Collections\ArrayCollection;

class SearchController extends AbstractActionController
{
  /**
   * Entity manager
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Constructor
   */
  public function __construct($entityManager)
  {
    $this->entityManager = $entityManager;
  }

  /**
   * This is the default "index" action of the controller. It display
   * search results
   */
  public function indexAction()
  {
    if ($this->getRequest()->isPost()) {
      return new ViewModel();
    }
    $data = $this->params()->fromQuery();
    if (isset($data['type']) && $data['type'] != 'book' && $data['type'] != 'author') {
      $data['type'] = 'all';
    }
    if (isset($data['q']) && !empty($data['q'])) {
      if ($data['type'] == 'book') {
        $books = $this->entityManager->getRepository(Book::class)
          ->createQueryBuilder('b')
          ->where('b.title LIKE :query')
          ->orderBy('b.title', 'ASC')
          ->setParameter('query', '%' . $data['q'] . '%')
          ->getQuery()
          ->getResult();
      } else if ($data['type'] == 'author') {
        $books = $this->entityManager->getRepository(Book::class)
          ->createQueryBuilder('b')
          ->innerJoin('b.authors', 'a')
          ->where('a.name LIKE :query')
          ->setParameter('query', '%' . $data['q'] . '%')
          ->getQuery()
          ->getResult();
      } else {
        $books = $this->entityManager->getRepository(Book::class)
          ->createQueryBuilder('b')
          ->innerJoin('b.authors', 'a')
          ->where('a.name LIKE :query')
          ->orWhere('b.title LIKE :query')
          ->setParameter('query', '%' . $data['q'] . '%')
          ->getQuery()
          ->getResult();
      }
      return new ViewModel([
        'books' => $books,
        'type' => $data['type'],
        'q' => $data['q'],
      ]);
    }
    return new ViewModel();
  }
}
