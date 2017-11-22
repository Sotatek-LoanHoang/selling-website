<?php
namespace Cart;

use Zend\Router\Http\Segment;

return [
  'router' => [
    'routes' => [
      'cart' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/cart[/:action]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
          ],
          'defaults' => [
            'controller' => Controller\CartController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
];
