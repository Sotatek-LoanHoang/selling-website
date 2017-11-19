<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cart;

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
}
