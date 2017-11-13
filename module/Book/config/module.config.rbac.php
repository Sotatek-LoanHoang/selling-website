<?php
namespace Book;

return [
  'default_permissions' => [
    'book.manage' => 'Manage books',
  ],
  'default_roles' => [
    'Administrator' => [
      'permissions' => [
        'book.manage',
      ],
    ],
  ],
];
