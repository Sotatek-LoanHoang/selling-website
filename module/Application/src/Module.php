<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Module
{
  const VERSION = '3.0.0dev';

  public function getConfig()
  {
    return array_merge_recursive(
      include __DIR__ . '/../config/module.config.access.php',
      include __DIR__ . '/../config/module.config.controller.php',
      include __DIR__ . '/../config/module.config.route.php',
      include __DIR__ . '/../config/module.config.service.php',
      include __DIR__ . '/../config/module.config.view.php'
    );
  }

  /**
   * This method is called once the MVC bootstrapping is complete.
   */
  public function onBootstrap(MvcEvent $event)
  {
    $application = $event->getApplication();
    $serviceManager = $application->getServiceManager();

    // The following line instantiates the SessionManager and automatically
    // makes the SessionManager the 'default' one to avoid passing the
    // session manager as a dependency to other models.
    $sessionManager = $serviceManager->get(SessionManager::class);
    $navManager = $serviceManager->get(Service\NavManager::class);
    $url = $serviceManager->get('ViewHelperManager')->get('url');
    $navManager->addMenuItem(new Service\StaticNavItem([
      'id' => 'home',
      'label' => 'Home',
      'link' => $url('home'),
      'float' => 'left',
    ]));
  }
}

