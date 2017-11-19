<?php
namespace Cart\Service\Factory;

use Interop\Container\ContainerInterface;
use Cart\Service\CartManager;

/**
 * This is the factory class for CartManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class CartManagerFactory
{
  /**
   * This method creates the CartManager service and returns its instance.
   */
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    return new CartManager($entityManager);
  }
}
