<?php


namespace Product;

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
                Controller\ManageController::class => function($container) {
                    return new Controller\ManageController(
                        $container->get(Model\ProductTable::class)
                    );
                },
                Controller\SearchController::class => function($container) {
                    return new Controller\SearchController(
                        $container->get(Model\ProductTable::class)
                    );
                },
            ],
        ];
    }
}
