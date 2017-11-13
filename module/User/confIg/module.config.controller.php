<?php
namespace User;

return [
  'controllers' => [
    'factories' => [
      Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
      Controller\PermissionController::class => Controller\Factory\PermissionControllerFactory::class,
      Controller\RoleController::class => Controller\Factory\RoleControllerFactory::class,
      Controller\UserController::class => Controller\Factory\UserControllerFactory::class,
    ],
  ],
  // We register module-provided controller plugins under this key.
  'controller_plugins' => [
    'factories' => [
      Controller\Plugin\AccessPlugin::class => Controller\Plugin\Factory\AccessPluginFactory::class,
      Controller\Plugin\CurrentUserPlugin::class => Controller\Plugin\Factory\CurrentUserPluginFactory::class,
    ],
    'aliases' => [
      'access' => Controller\Plugin\AccessPlugin::class,
      'currentUser' => Controller\Plugin\CurrentUserPlugin::class,
    ],
  ],
];
