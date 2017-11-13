<?php
namespace User;

return [
  'service_manager' => [
    'factories' => [
      \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
      Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
      Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
      Service\PermissionManager::class => Service\Factory\PermissionManagerFactory::class,
      Service\RbacManager::class => Service\Factory\RbacManagerFactory::class,
      Service\RoleManager::class => Service\Factory\RoleManagerFactory::class,
      Service\UserManager::class => Service\Factory\UserManagerFactory::class,
      Service\RbacAssertionManager::class => Service\Factory\RbacAssertionManagerFactory::class,
    ],
  ],
];
