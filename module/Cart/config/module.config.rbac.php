<?php
namespace Cart;

return [
  'default_permissions' => [
    'cart.manage' => 'Manage own cart',
  ],
  'default_roles' => [
    'Administrator' => [
      'permissions' => [
        'cart.manage',
      ],
    ],
    'Guest' => [
      'permissions' => [
        'cart.manage',
      ],
    ],
  ],
];
