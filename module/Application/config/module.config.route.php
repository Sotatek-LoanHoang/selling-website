<?php
namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
  'router' => [
    'routes' => [
      'home' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
];
