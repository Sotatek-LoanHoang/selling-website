<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use User\Service\UserTable;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                View\Helper\Menu::class => function ($container) {
                    $navManager = $container->get(Service\NavManager::class);
                    return new View\Helper\Menu($navManager->getMenuItems());
                },
            ],
        ];
    }
    public function getServiceConfig(){
        return [
            'factories' => [
                Service\NavManager::class => function ($container) {
                    $table = $container->get(UserTable::class);

                    $viewHelperManager = $container->get('ViewHelperManager');
                    $urlHelper = $viewHelperManager->get('url');

                    return new Service\NavManager($table, $urlHelper);
                },
            ]
        ];
    }
}
