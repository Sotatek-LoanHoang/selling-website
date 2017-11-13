<?php
namespace Book\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Book\Controller\BookController;
use Book\Service\BookManager;

/**
 * This is the factory for BookController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class BookControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    $userManager = $container->get(BookManager::class);

    // Instantiate the controller and inject dependencies
    return new BookController($entityManager, $userManager);
  }
}
