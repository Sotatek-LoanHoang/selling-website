<?php
namespace Book\Service\Factory;

use Interop\Container\ContainerInterface;
use Book\Service\BookManager;

/**
 * This is the factory class for BookManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class BookManagerFactory
{
  /**
   * This method creates the BookManager service and returns its instance.
   */
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    return new BookManager($entityManager);
  }
}
