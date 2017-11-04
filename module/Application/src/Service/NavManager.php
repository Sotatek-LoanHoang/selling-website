<?php
namespace Application\Service;

use Zend\Authentication\AuthenticationService;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
  /**
   * Auth service.
   * @var Zend\Authentication\Authentication
   */
  private $authService;
  private $table;
  /**
   * Url view helper.
   * @var Zend\View\Helper\Url
   */
  private $urlHelper;

  /**
   * Constructs the service.
   */
  public function __construct($table, $urlHelper)
  {
    $this->table = $table;
    $this->urlHelper = $urlHelper;
    $this->authService = new AuthenticationService();
  }

  /**
   * This method returns menu items depending on whether user has logged in or not.
   */
  public function getMenuItems()
  {
    $url = $this->urlHelper;
    $items = [];

    $items[] = [
      'id' => 'home',
      'label' => 'Home',
      'link' => $url('home')
    ];
        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
    if (!$this->authService->hasIdentity()) {
      $items[] = [
        'id' => 'login',
        'label' => 'Log in',
        'link' => $url('auth', ['action' => 'login']),
        'float' => 'right'
      ];
      $items[] = [
        'id' => 'signup',
        'label' => 'Sign up',
        'link' => $url('auth', ['action' => 'signup']),
        'float' => 'right'
      ];
    }
    else {
      $user = $this->table->getUser($this->authService->getIdentity());
      $name = (isset($user->full_name)) ? $user->full_name : $this->authService->getIdentity();
      $items[] = [
        'id' => 'cart',
        'label' => "Shopping Cart",
        'float' => 'right',
        'link' => $url('cart', ['action' => 'index']),
      ];
      $items[] = [
        'id' => 'logout',
        'label' => $name,
        'float' => 'right',
        'dropdown' => [
          [
            'id' => 'logout',
            'label' => 'Sign out',
            'link' => $url('auth', ['action' => 'logout']),
          ],
        ],
      ];
    }

    return $items;
  }
}
