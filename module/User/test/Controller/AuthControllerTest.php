<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ApplicationTest\Controller;

use User\Controller\AuthController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use User\Service\AuthManager;
use Zend\Stdlib\ArrayUtils;
use Prophecy\Argument;
use Zend\ServiceManager\ServiceManager;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
  protected $authmanager;
  protected $traceError = false;

  public function setUp()
  {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
      $configOverrides = [];

    $this->setApplicationConfig(ArrayUtils::merge(
      include __DIR__ . '/../../../../config/application.config.php',
      $configOverrides
    ));
    parent::setUp();
    $this->configureServiceManager($this->getApplicationServiceLocator());
  }

    protected function configureServiceManager(ServiceManager $services)
  {
      $services->setAllowOverride(true);

      $services->setService('config', $this->updateConfig($services->get('config')));
      $services->setService(AuthManager::class, $this->mockAuthManager()->reveal());

      $services->setAllowOverride(false);
  }

  protected function updateConfig($config)
  {
      $config['db'] = [];
      return $config;
  }

  protected function mockAuthManager()
  {
      $this->authmanager = $this->prophesize(AuthManager::class);
      return $this->authmanager;
  }
  
  public function testLoginActionCanBeAccessed()
  {
    $this->dispatch('/login', 'GET');
    $this->assertResponseStatusCode(200);
    $this->assertModuleName('User');
    $this->assertControllerName(AuthController::class);
    $this->assertControllerClass('AuthController');
    $this->assertMatchedRouteName('login');
  }
  public function testLoginActionRequiredFields()
  {
    $this->authmanager
      ->login(Argument::type('string'),Argument::type('string'),Argument::type("bool"))
      ->shouldNotBeCalled();


      $postData = [
      'username' => 'admin',
      'password' => 'admin123',
    ];
    $this->dispatch('/login', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'username' => 'admin@example.com',
    ];

    $this->dispatch('/login', 'POST', $postData);
    $this->assertResponseStatusCode(200);
    $postData = [
      'password' => 'admin123',
    ];
    $this->dispatch('/login', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'username' => 'test_user',
      'password' => '123',
    ];
    $this->dispatch('/login', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'username' => 'admin@example.com',
      'password' => '123',
    ];
    $this->dispatch('/login', 'POST', $postData);
    $this->assertResponseStatusCode(200);
  }
}