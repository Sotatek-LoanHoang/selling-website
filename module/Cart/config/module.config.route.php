<?php
namespace Cart;

use Zend\Router\Http\Literal;

return [
  'router' => [
    'routes' => [
      'search' => [
        'type' => Literal::class,
        'options' => [
          'route' => '/cart',
          'defaults' => [
            'controller' => Controller\CartController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
];
