<?php
namespace Book\Service\Factory;

use Interop\Container\ContainerInterface;
use Book\Service\AuthorManager;

/**
 * This is the factory class for AuthorManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class AuthorManagerFactory
{
  /**
   * This method creates the AuthorManager service and returns its instance.
   */
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    return new AuthorManager($entityManager);
  }
}
