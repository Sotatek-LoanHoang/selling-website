<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use User\Controller\AuthController;
use User\Service\AuthManager;
use Application\Service\NavManager;
use Application\Service\StaticNavItem;
use Application\Service\DropdownNavItem;
use Doctrine\ORM\EntityManager;
use User\Entity\User;

class Module
{
  /**
   * This method returns the path to module.config.php file.
   */
  public function getConfig()
  {
    return array_merge_recursive(
      include __DIR__ . '/../config/module.config.access.php',
      include __DIR__ . '/../config/module.config.controller.php',
      include __DIR__ . '/../config/module.config.db.php',
      include __DIR__ . '/../config/module.config.rbac.php',
      include __DIR__ . '/../config/module.config.route.php',
      include __DIR__ . '/../config/module.config.service.php',
      include __DIR__ . '/../config/module.config.view.php'
    );
  }

  /**
   * This method is called once the MVC bootstrapping is complete and allows
   * to register event listeners.
   */
  public function onBootstrap(MvcEvent $event)
  {
    // Get event manager.
    $eventManager = $event->getApplication()->getEventManager();
    $sharedEventManager = $eventManager->getSharedManager();
    // Register the event listener method.
    $sharedEventManager->attach(
      AbstractActionController::class,
      MvcEvent::EVENT_DISPATCH,
      [$this, 'onDispatch'],
      100
    );
    $serviceManager = $event->getApplication()->getServiceManager();
    $navManager = $serviceManager->get(NavManager::class);
    $authService = $serviceManager->get(\Zend\Authentication\AuthenticationService::class);
    $url = $serviceManager->get('ViewHelperManager')->get('url');

    // Display login button in navigation bar if not logged in otherwise display
    // profile dropdown
    if (!$authService->hasIdentity()) {
      $navManager->addMenuItem(new StaticNavItem([
        'id' => 'login',
        'label' => 'Sign in',
        'link' => $url('login'),
        'float' => 'right'
      ]));
    } else {
      $user = $serviceManager->get(EntityManager::class)->getRepository(User::class)->findOneByUsername($authService->getIdentity());
      $name = (!empty($user->getFullName())) ? $user->getFullName() : $authService->getIdentity();
      $navManager->addMenuItem(new DropdownNavItem([
        'id' => 'profile',
        'label' => $name,
        'float' => 'right',
        'dropdown' => [
          [
            'id' => 'viewProfile',
            'label' => 'View Profile',
            'link' => $url('users', ['action' => 'view', 'id' => $user->getId()]),
          ],
          [
            'id' => 'logout',
            'label' => 'Sign out',
            'link' => $url('logout')
          ],
        ]
      ]));
      $access = $serviceManager->get('ViewHelperManager')->get('access');
      $manage = [];
      if ($access('user.manage')) {
        $manage[] = [
          'id' => 'users',
          'label' => 'Manage Users',
          'link' => $url('users')
        ];
      }
      if ($access('role.manage')) {
        $manage[] = [
          'id' => 'roles',
          'label' => 'Manage Roles',
          'link' => $url('roles')
        ];
      }
      if ($access('permission.manage')) {
        $manage[] = [
          'id' => 'roles',
          'label' => 'Manage Permissions',
          'link' => $url('permissions')
        ];
      }
      if (!empty($manage)) {
        $navManager->addMenuItem(new DropdownNavItem([
          'id' => 'manage',
          'label' => 'Manage',
          'float' => 'left',
          'dropdown' => $manage
        ]));
      }
    }
  }

  /**
   * Event listener method for the 'Dispatch' event. We listen to the Dispatch
   * event to call the access filter. The access filter allows to determine if
   * the current visitor is allowed to see the page or not. If he/she
   * is not authorized and is not allowed to see the page, we redirect the user
   * to the login page.
   */
  public function onDispatch(MvcEvent $event)
  {
    // Get controller and action to which the HTTP request was dispatched.
    $controller = $event->getTarget();
    $controllerName = $event->getRouteMatch()->getParam('controller', null);
    $actionName = $event->getRouteMatch()->getParam('action', null);
    $serviceManager = $event->getApplication()->getServiceManager();

    // Convert dash-style action name to camel-case.
    $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));

    // Get the instance of AuthManager service.
    $authManager = $serviceManager->get(AuthManager::class);

    // Execute the access filter on every controller except AuthController
    // (to avoid infinite redirect).
    if ($controllerName != AuthController::class) {
      $result = $authManager->filterAccess($controllerName, $actionName);

      if ($result == AuthManager::AUTH_REQUIRED) {
        // Remember the URL of the page the user tried to access. We will
        // redirect the user to that URL after successful login.
        $uri = $event->getApplication()->getRequest()->getUri();
        // Make the URL relative (remove scheme, user info, host name and port)
        // to avoid redirecting to other domain by a malicious user.
        $uri->setScheme(null)
          ->setHost(null)
          ->setPort(null)
          ->setUserInfo(null);
        $redirectUrl = $uri->toString();

        // Redirect the user to the "Login" page.
        return $controller->redirect()->toRoute(
          'login',
          [],
          ['query' => ['redirectUrl' => $redirectUrl]]
        );
      } else if ($result == AuthManager::ACCESS_DENIED) {
        // Redirect the user to the "Not Authorized" page.
        return $controller->redirect()->toRoute('not-authorized');
      }
    }
  }
}
