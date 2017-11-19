<?php
namespace Book;

return [
  'controllers' => [
    'factories' => [
      Controller\BookController::class => Controller\Factory\BookControllerFactory::class,
      Controller\AuthorController::class => Controller\Factory\AuthorControllerFactory::class,
      Controller\SearchController::class => Controller\Factory\SearchControllerFactory::class,
    ],
  ],
];
