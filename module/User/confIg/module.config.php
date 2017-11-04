<?php
namespace User;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\UserController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'get' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/users[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults'=> [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'auth' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/:action',
                    'constraints' => [
                        'action' => 'login|signup|logout',
                    ],
                    'defaults'=> [
                        'controller' => Controller\AuthController::class,
                        'action' => 'login',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'user' => __DIR__ . '/../view',
        ],
    ],
];
?>
