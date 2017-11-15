<?php
namespace User;

return [
  // The 'access_filter' key is used by the User module to restrict or permit
  // access to certain controller actions for unauthorized visitors.
  'access_filter' => [
    'controllers' => [
      Controller\UserController::class => [
        // Give access to "resetPassword", "message" and "setPassword" actions
        // to anyone.
        ['actions' => ['resetPassword', 'message', 'setPassword', 'signup', 'activate'], 'allow' => '*'],
        // Give access to "index", "add", "edit", "changePassword" actions to users having the "user.manage" permission.
        ['actions' => ['index', 'add'], 'allow' => '+user.manage'],
        ['actions' => ['view', 'changePassword', 'edit'], 'allow' => '@'],
      ],
      Controller\RoleController::class => [
        // Allow access to authenticated users having the "role.manage" permission.
        ['actions' => '*', 'allow' => '+role.manage']
      ],
      Controller\PermissionController::class => [
        // Allow access to authenticated users having "permission.manage" permission.
        ['actions' => '*', 'allow' => '+permission.manage']
      ],
    ]
  ],
];
