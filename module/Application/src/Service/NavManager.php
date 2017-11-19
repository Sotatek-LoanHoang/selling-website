<?php
namespace Application\Service;

use Application\Service\NavComponentInterface;


/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager implements NavComponentInterface
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

  public function render()
  {
    if (count($this->menuItems) == 0)
      return ''; // Do nothing if there are no items.

    $result = '<nav class="navbar navbar-expand-md navbar-light bg-light">';
    $result .= '<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent">';
    $result .= '<span class="navbar-toggler-icon"></span>';
    $result .= '</button>';
    $result .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    $result .= '<a class="navbar-brand" href="/">Bookstore</a>';
    $result .= '<ul class="navbar-nav">';
    // if (isset($this->activeItemId) && !empty($this->activeItemId)) {
    //   if (isset($this->menuItems[$this->activeItemId]))
    //     $this->menuItems[$this->activeItemId]->setActive(true);
    // }
  // Render items
    foreach ($this->menuItems as $item) {
      if ($item->getFloat() == 'left')
        $result .= $item->render();
    }

    $result .= '</ul>';
    $result .= '<ul class="navbar-nav ml-auto">';

  // Render items
    foreach ($this->menuItems as $item) {
      if ($item->getFloat() == 'right')
        $result .= $item->render();
    }

    $result .= '</ul>';
    $result .= '</div>';
    $result .= '</nav>';

    return $result;
  }
}


