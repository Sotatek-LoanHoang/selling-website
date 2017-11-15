<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{
  /**
   * Menu items array.
   * @var array
   */
  protected $items = [];

  /**
   * Active item's ID.
   * @var string
   */
  protected $activeItemId = '';

  /**
   * Constructor.
   * @param array $items Menu items.
   */
  public function __construct($items = [])
  {
    $this->items = $items;
  }

  /**
   * Sets menu items.
   * @param array $items Menu items.
   */
  public function setItems($items)
  {
    $this->items = $items;
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
    if (count($this->items) == 0)
      return ''; // Do nothing if there are no items.

    $result = '<nav class="navbar navbar-expand-md navbar-light bg-light">';
    $result .= '<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent">';
    $result .= '<span class="navbar-toggler-icon"></span>';
    $result .= '</button>';
    $result .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    $result .= '<a class="navbar-brand" href="/">Bookstore</a>';
    $result .= '<ul class="navbar-nav">';
    if (isset($this->activeItemId) && !empty($this->activeItemId)) {
      if (isset($this->items[$this->activeItemId]))
        $this->items[$this->activeItemId]->setActive(true);
    }
    // Render items
    foreach ($this->items as $item) {
      if ($item->getFloat() == 'left')
        $result .= $item->render();
    }

    $result .= '</ul>';
    $result .= '<ul class="navbar-nav ml-auto">';

    // Render items
    foreach ($this->items as $item) {
      if ($item->getFloat() == 'right')
        $result .= $item->render();
    }

    $result .= '</ul>';
    $result .= '</div>';
    $result .= '</nav>';

    return $result;

  }
}
