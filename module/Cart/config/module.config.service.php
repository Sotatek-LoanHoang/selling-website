<?php
namespace Cart;

return [
  'service_manager' => [
    'factories' => [
      Service\CartManager::class => Service\Factory\CartManagerFactory::class,
      ],
  ],
];
