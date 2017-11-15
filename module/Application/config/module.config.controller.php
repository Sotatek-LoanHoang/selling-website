<?php
namespace Application;

return [
  'controllers' => [
    'factories' => [
      Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
    ],
  ],
];
