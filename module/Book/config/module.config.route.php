<?php
namespace Book;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
  'router' => [
    'routes' => [
      'books' => [
        'type' => Segment::class,
        'options' => [
          'route' => '/books[/:action[/:id]]',
          'constraints' => [
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[a-zA-Z0-9_-]*',
          ],
          'defaults' => [
            'controller' => Controller\BookController::class,
            'action' => 'index',
          ],
        ],
      ],
    ],
  ],
];
