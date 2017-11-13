<?php
namespace Book;

return [
  'service_manager' => [
    'factories' => [
      Service\BookManager::class => Service\Factory\BookManagerFactory::class,
    ],
  ],
];
