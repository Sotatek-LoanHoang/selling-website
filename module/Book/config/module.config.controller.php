<?php
namespace Book;

return [
  'controllers' => [
    'factories' => [
      Controller\BookController::class => Controller\Factory\BookControllerFactory::class,
    ],
  ],
];
