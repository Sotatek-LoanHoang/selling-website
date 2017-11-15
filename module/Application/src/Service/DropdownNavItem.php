<?php
namespace Application\Service;

class DropdownNavItem implements NavItemInterface
{
  private $param;
  private $active;
  public function __construct($param)
  {
    $this->param = $param;
  }
  public function render()
  {
    $item = $this->param;
    $id = isset($item['id']) ? $item['id'] : '';
    $isActive = ($id == $this->active);
    $label = isset($item['label']) ? $item['label'] : '';

    $result = '';

    if (isset($item['dropdown'])) {

      $dropdownItems = $item['dropdown'];

      $result .= '<li class="nav-item dropdown ' . ($isActive ? 'active' : '') . '">';
      $result .= '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">';
      $result .= $label . ' <b class="caret"></b>';
      $result .= '</a>';
      if (isset($item['float']) && $item['float'] == 'right')
        $result .= '<div class="dropdown-menu dropdown-menu-right">';
      else
        $result .= '<div class="dropdown-menu">';
      foreach ($dropdownItems as $item) {
        $link = isset($item['link']) ? $item['link'] : '#';
        $label = isset($item['label']) ? $item['label'] : '';
        $result .= '<a class="nav-link dropdown-item" href="' . $link . '">' . $label . '</a>';
      }
      $result .= '</div>';
      $result .= '</li>';

    } else {
      $link = isset($item['link']) ? $item['link'] : '#';

      $result .= $isActive ? '<li class="nav-item active">' : '<li class="nav-item">';
      $result .= '<a class="nav-link" href="' . $link . '">' . $label . '</a>';
      $result .= '</li>';
    }
    return $result;
  }
  public function setActive($active)
  {
    $this->active = $active;
  }
  public function getFloat()
  {
    return $this->param['float'];
  }
  public function getId()
  {
    return $this->param['id'];
  }
}
