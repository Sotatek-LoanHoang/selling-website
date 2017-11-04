<?php


namespace Admin;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
class Module implements ConfigProviderInterface
{
     public function getConfig() {
    return include __DIR__ . '/../config/module.config.php';
  }

    public function getServiceConfig()  {
 return [
            'factories' => [
                Model\ProductTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProductTableGateway::class);
                    return new Model\ProductTable($tableGateway);
                },
                Model\ProductTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Product());
                    return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\ProductManageController::class => function($container) {
                    return new Controller\ProductManageController(
                        $container->get(Model\ProductTable::class)
                    );
                },
            ],
        ];
    }
}
