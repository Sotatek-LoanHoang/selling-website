<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ApplicationTest\Controller;

use Book\Controller\Search;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Stdlib\ArrayUtils;
use Prophecy\Argument;
use Book\Entity\Book;
use Book\Entity\Author;
use Zend\ServiceManager\ServiceManager;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
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
  }
  
  public function testIndexAction()
  {
  	
     $postData = [
      'type' => 'book',
      'q' => 'xxx',
    ];
    $this->dispatch('/search','POST',$postData);
    $this->assertResponseStatusCode(500);
	 $postData = [
      'type' => 'author',
      'q' => 'yyy',
    ];
    $this->dispatch('/search','POST',$postData);
    $this->assertResponseStatusCode(500);
	 $postData = [
      'type' => 'book',
    ];
    $this->dispatch('/search','POST',$postData);
    $this->assertResponseStatusCode(500);
	 $postData = [
      'q' => 'xxx',
    ];
    $this->dispatch('/search','POST',$postData);
    $this->assertResponseStatusCode(500);
    
  }

}