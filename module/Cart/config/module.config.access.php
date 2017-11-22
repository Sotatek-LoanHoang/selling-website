<?php
namespace Cart;

return [
  // The 'access_filter' key is used by the User module to restrict or permit
  // access to certain controller actions for unauthorized visitors.
  'access_filter' => [
    'controllers' => [
      Controller\CartController::class => [
        ['actions' => ['index','add','delete', 'update'], 'allow' => '@'],
      ],
    ]
  ],
];
