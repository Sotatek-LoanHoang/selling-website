<?php
namespace Cart\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Cart\Controller\CartController;
use Cart\Service\CartManager;
/**
 * This is the factory for CartController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CartControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    $cartManager = $container->get(CartManager::class);
    // Instantiate the controller and inject dependencies
    return new CartController($entityManager,$cartManager);
  }
}
