<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ApplicationTest\Controller;

use User\Controller\UserController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use User\Service\UserManager;
use Zend\Stdlib\ArrayUtils;
use Prophecy\Argument;
use User\Entity\User;
use Zend\ServiceManager\ServiceManager;

class UserControllerTest extends AbstractHttpControllerTestCase
{
  protected $usermanager;
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
      $services->setService(UserManager::class, $this->mockUserManager()->reveal());

      $services->setAllowOverride(false);
  }

  protected function updateConfig($config)
  {
      $config['db'] = [];
      return $config;
  }

  protected function mockUserManager()
  {
      $this->usermanager = $this->prophesize(UserManager::class);
      return $this->usermanager;
  }

  public function testSignupActionCanBeAccessed()
  {
    $this->dispatch('/users/sigup', 'GET');
    $this->assertResponseStatusCode(302);
    $this->assertModuleName('User');
    $this->assertControllerName(UserController::class);
    $this->assertControllerClass('UserController');
    $this->assertMatchedRouteName('users');
  }
     
  public function testSignupActionRequiredFields()
  {
    $this->usermanager
      ->signupUser(Argument::type('array'))
      ->shouldNotBeCalled();
    
    $postData = [
      'username' => 'demo',
      'password' => '12345678',
    ];
    $this->dispatch('/users/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);
    $postData = [
      'username' => 'demo',
      'email' => 'dm@gmail.com',
    ];
    $this->dispatch('/users/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);
    $postData = [
      'email' => 'dm@gmail.com',
      'password' => '12345678',
    ];
    $this->dispatch('/users/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'username' => 'demo',
      'email' =>'dm@gmail.com',
      'password' => '12345678',
    ];
    $this->dispatch('/users/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);
  }
}