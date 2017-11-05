<?php
namespace Cart;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

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
                    'defaults'=> [
                        'controller' => Controller\CartController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'cart' => __DIR__ . '/../view',
        ],
    ],
];
?>
