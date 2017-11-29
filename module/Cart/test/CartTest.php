<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ApplicationTest\Controller;

use Cart\Controller\CartController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Stdlib\ArrayUtils;
use Prophecy\Argument;
use Cart\Entity\CartItem;
use User\Entity\User;
use Zend\ServiceManager\ServiceManager;
use Cart\Service\CartManager;
use User\Service\AuthManager;
use User\Controller\AuthController;
use Doctrine\ORM\EntityManager;

class CartControllerTest extends AbstractHttpControllerTestCase
{
  protected $cartmanage ;
  protected $authmanage ;  
  protected $entitymanage;
  protected $traceError = false;

  public function setUp()
  {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
      $configOverrides = [];

    $this->setApplicationConfig(ArrayUtils::merge(
      include __DIR__ . '/../../../config/application.config.php',
      $configOverrides
    ));
    parent::setUp();
	$this->configureServiceManager($this->getApplicationServiceLocator());
  }
  protected function configureServiceManager(ServiceManager $services)
{
    $services->setAllowOverride(true);

    $services->setService('config', $this->updateConfig($services->get('config')));
    $services->setService(CartManager::class, $this->mockCartManager()->reveal());
    $services->setService(AuthManager::class, $this->mockAuthManager()->reveal());
    
    $services->setService(EntityManager::class, $this->mockEntityManager()->reveal());
    $services->setAllowOverride(false);
}

protected function updateConfig($config)
{
    $config['db'] = [];
    return $config;
}
protected function mockEntityManager()
{
    $this->entitymanage = $this->prophesize(EntityManager::class);
    return $this->entitymanage;
}

protected function mockCartManager()
{
    $this->cartmanage = $this->prophesize(CartManager::class);
    return $this->cartmanage;
}
protected function mockAuthManager()
{
    $this->authmanage = $this->prophesize(AuthManager::class);
    return $this->authmanage;
}
  public function testCartUpdate()
  {
	
  	$this->authmanage
      ->login(Argument::type('string'),Argument::type('string'),Argument::type("bool"))
      ->shouldNotBeCalled();
    $this->cartmanage->addCartItem(Argument::type('array'),Argument::type(User::class))
        ->shouldBeCalled();
    $this->cartmanage->UpdateCartItem(Argument::type(CartItem::class),Argument::type('array'))
        ->shouldBeCalled();
    $this->entitymanage->getRepository(CartItem::class)
        ->shouldBeCalled();


      $postData = [
      'username' => 'admin',
      'password' => 'admin123',
    ];
    $this->dispatch('/login', 'POST', $postData);

     $postData = [
      'book' => 'tttt',
      'quantity' => 3 ,
    ];
    $this->dispatch('/cart/updateAction','POST',$postData);
    $this->assertResponseStatusCode(200);
	$postData = [
      'book' => 'tttt',
    ];
    $this->dispatch('/cart/updateAction','POST',$postData);
    $this->assertResponseStatusCode(200);
	$postData = [
      'quantity' => 3 ,
    ];
    $this->dispatch('/cart/updateAction','POST',$postData);
    $this->assertResponseStatusCode(200);
	
  }

}