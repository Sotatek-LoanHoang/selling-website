<?php
namespace User;

return [
  'view_manager' => [
    'template_path_stack' => [
      __DIR__ . '/../view',
    ],
  ],
    // We register module-provided view helpers under this key.
  'view_helpers' => [
    'factories' => [
      View\Helper\Access::class => View\Helper\Factory\AccessFactory::class,
      View\Helper\CurrentUser::class => View\Helper\Factory\CurrentUserFactory::class,
    ],
    'aliases' => [
      'access' => View\Helper\Access::class,
      'currentUser' => View\Helper\CurrentUser::class,
    ],
  ],

];
