<?php
namespace Book;

return [
  // The 'access_filter' key is used by the User module to restrict or permit
  // access to certain controller actions for unauthorized visitors.
  'access_filter' => [
    'controllers' => [
      Controller\BookController::class => [
        ['actions' => ['index', 'add', 'edit', 'view'], 'allow' => '+book.manage'],
      ],
    ]
  ],
];
