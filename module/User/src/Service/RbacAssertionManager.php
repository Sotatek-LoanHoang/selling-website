<?php
namespace User\Service;

use Zend\Permissions\Rbac\Rbac;
use User\Entity\User;

/**
 * This service is used for invoking user-defined RBAC dynamic assertions.
 */
class RbacAssertionManager
{
  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Auth service.
   * @var Zend\Authentication\AuthenticationService
   */
  private $authService;

  /**
   * Constructs the service.
   */
  public function __construct($entityManager, $authService)
  {
    $this->entityManager = $entityManager;
    $this->authService = $authService;
  }

  /**
   * This method is used for dynamic assertions.
   */
  public function assert(Rbac $rbac, $permission, $params)
  {
    error_log('adsfasf');
    $currentUser = $this->entityManager->getRepository(User::class)
      ->findOneByUsername($this->authService->getIdentity());

    if ($permission == 'profile.own.manage' && $params['user']->getId() == $currentUser->getId())
      return true;
    if ($permission == 'profile.own.view' && $params['user']->getId() == $currentUser->getId())
      return true;

    return false;
  }
}



