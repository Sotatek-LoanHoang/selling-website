<?php
namespace User;

return [
  'default_permissions' => [
    'user.manage' => 'Manage users',
    'permission.manage' => 'Manage permissions',
    'role.manage' => 'Manage roles',
    'profile.any.view' => 'View anyone\'s profile',
    'profile.any.manage' => 'Manage anyone\'s profile',
    'profile.own.manage' => 'Manage own profile',
  ],
  'default_roles' => [
    'Administrator' => [
      'description' => 'A person who manages users, roles, etc.',
      'parent' => null,
      'permissions' => [
        'user.manage',
        'role.manage',
        'permission.manage',
        'profile.any.manage',
      ],
    ],
    'Guest' => [
      'description' => 'A person who can log in and view own profile.',
      'parent' => null,
      'permissions' => [
        'profile.any.view',
        'profile.own.manage',
      ],
    ],
  ],
];
