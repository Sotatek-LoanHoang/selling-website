<?php
namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
  'router' => [
    'routes' => [
      'login' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/login',
          'defaults' => [
            'controller' => Controller\AuthController::class,
            'action' => 'login',
          ],
        ],
      ],
      'logout' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/logout',
          'defaults' => [
            'controller' => Controller\AuthController::class,
            'action' => 'logout',
          ],
        ],
      ],
      'not-authorized' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/not-authorized',
          'defaults' => [
            'controller' => Controller\AuthController::class,
            'action' => 'notAuthorized',
          ],
        ],
      ],
      'reset-password' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/reset-password',
          'defaults' => [
            'controller' => Controller\UserController::class,
            'action' => 'resetPassword',
          ],
        ],
      ],
      'users' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/users[/:action[/:id]]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[a-zA-Z0-9_-]*',
          ],
          'defaults' => [
            'controller' => Controller\UserController::class,
            'action' => 'index',
          ],
        ],
      ],
      'roles' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/roles[/:action[/:id]]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]*',
          ],
          'defaults' => [
            'controller' => Controller\RoleController::class,
            'action' => 'index',
          ],
        ],
      ],
      'permissions' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/permissions[/:action[/:id]]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]*',
          ],
          'defaults' => [
            'controller' => Controller\PermissionController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
];
