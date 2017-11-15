<?php
namespace Application;

return [
  // The 'access_filter' key is used by the User module to restrict or permit
  // access to certain controller actions for unauthorized visitors.
  'access_filter' => [
    'options' => [
      // The access filter can work in 'restrictive' (recommended) or 'permissive'
      // mode. In restrictive mode all controller actions must be explicitly listed
      // under the 'access_filter' config key, and access is denied to any not listed
      // action for not logged in users. In permissive mode, if an action is not listed
      // under the 'access_filter' key, access to it is permitted to anyone (even for
      // not logged in users. Restrictive mode is more secure and recommended to use.
      'mode' => 'restrictive'
    ],
    'controllers' => [
      Controller\IndexController::class => [
        // Allow anyone to visit "index" and "about" actions
        ['actions' => ['index'], 'allow' => '*'],
      ],
    ]
  ],
];
