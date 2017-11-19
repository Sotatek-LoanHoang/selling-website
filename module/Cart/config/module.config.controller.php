<?php
namespace Cart;

return [
  'controllers' => [
    'factories' => [
      Controller\CartController::class => Controller\Factory\CartControllerFactory::class,
    ],
  ],
];
