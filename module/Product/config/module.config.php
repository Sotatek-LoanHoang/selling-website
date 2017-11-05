<?php

namespace Product;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'manage' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/product[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ManageController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'search' => [
                'type' => 'literal',
                'options' =>[
                    'route' => '/search',
                    'defaults' => [
                        'controller' =>Controller\SearchController::class,
                        'action' => 'search',
                    ],

                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
?>
