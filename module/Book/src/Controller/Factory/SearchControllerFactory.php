<?php
namespace Book\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Book\Controller\SearchController;

/**
 * This is the factory for SearchController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class SearchControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');

    // Instantiate the controller and inject dependencies
    return new SearchController($entityManager);
  }
}
