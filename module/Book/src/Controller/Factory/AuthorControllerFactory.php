<?php
namespace Book\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Book\Controller\AuthorController;
use Book\Service\AuthorManager;

/**
 * This is the factory for AuthorController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class AuthorControllerFactory implements FactoryInterface
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get('doctrine.entitymanager.orm_default');
    $userManager = $container->get(AuthorManager::class);

    // Instantiate the controller and inject dependencies
    return new AuthorController($entityManager, $userManager);
  }
}
