<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use User\Controller\AuthController;
use Zend\Stdlib\ArrayUtils;
use Prophecy\Argument;
use User\Model\User;
use User\Service\UserTable;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\ServiceManager\ServiceManager;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
  protected $userTable = null;
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
    $services->setService(UserTable::class, $this->mockUserTable()->reveal());

    $services->setAllowOverride(false);
  }

  protected function updateConfig($config)
  {
    $config['db'] = [];
    return $config;
  }

  protected function mockUserTable()
  {
    $this->userTable = $this->prophesize(UserTable::class);
    return $this->userTable;
  }

  public function testSignupActionCanBeAccessed()
  {
    $this->dispatch('/signup', 'GET');
    $this->assertResponseStatusCode(200);
    $this->assertModuleName('user');
    $this->assertControllerName(AuthController::class);
    $this->assertControllerClass('AuthController');
    $this->assertMatchedRouteName('auth');
  }

  public function testSignupActionRequiredFields()
  {
    $this->userTable
      ->saveUser(Argument::type(User::class))
      ->shouldNotBeCalled();
    $this->userTable
      ->isEmailExists(Argument::type('string'))
      ->shouldBeCalled();
    $this->userTable
      ->getUser(Argument::type('string'))
      ->shouldBeCalled();
    $postData = [
      'username' => 'test_user',
      'password' => 'test_password',
    ];
    $this->dispatch('/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'username' => 'test_user',
      'email' => 'test_email@testdomain.com',
    ];
    $this->dispatch('/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);

    $postData = [
      'email' => 'test_email@testdomain.com',
      'password' => 'test_password',
    ];
    $this->dispatch('/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);
    $this->userTable
      ->saveUser(Argument::type(User::class))
      ->shouldBeCalled();
    $postData = [
      'username' => 'test_user',
      'email' => 'test_email@testdomain.com',
      'password' => 'test_password',
      'full_name' => '',
      'birthday' => '',
      'gender' => '',
    ];
    $this->dispatch('/signup', 'POST', $postData);
    $this->assertResponseStatusCode(200);

  }
}
