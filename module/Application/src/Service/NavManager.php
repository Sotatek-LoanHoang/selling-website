<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
  /**
   * Menu items
   * @var array
   */
  private $menuItems;
  /**
   * Auth service.
   * @var Zend\Authentication\Authentication
   */
  private $authService;

  /**
   * Url view helper.
   * @var Zend\View\Helper\Url
   */
  private $urlHelper;

  /**
   * RBAC manager.
   * @var User\Service\RbacManager
   */
  private $rbacManager;

  /**
   * Constructs the service.
   */
  public function __construct($authService, $urlHelper, $rbacManager)
  {
    $this->authService = $authService;
    $this->urlHelper = $urlHelper;
    $this->rbacManager = $rbacManager;
    $this->menuItems = [];
  }

  /**
   * This method add an menu item
   */
  public function addMenuItem(NavItemInterface $item)
  {
    $this->menuItems[$item->getId()] = $item;
  }

  /**
   * This method add an menu item
   */
  public function addMenuItems(array $items)
  {
    foreach ($items as $item)
      $this->menuItems[$item->getId()] = $item;
  }

  /**
   * This method returns menu items depending on whether user has logged in or not.
   */
  public function getMenuItems()
  {
    return $this->menuItems;
  }
}


