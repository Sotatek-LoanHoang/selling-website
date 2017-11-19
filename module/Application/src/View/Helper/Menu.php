<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{
  /**
   * Nav manager.
   * @var array
   */
  protected $navManager = [];

  /**
   * Active item's ID.
   * @var string
   */
  protected $activeItemId = '';

  /**
   * Constructor.
   */
  public function __construct($navManager)
  {
    $this->navManager = $navManager;
  }

  /**
   * Sets ID of the active items.
   * @param string $activeItemId
   */
  public function setActiveItemId($activeItemId)
  {
    $this->activeItemId = $activeItemId;
  }

  /**
   * Renders the menu.
   * @return string HTML code of the menu.
   */
  public function render()
  {
    return $this->navManager->render();
  }
}
