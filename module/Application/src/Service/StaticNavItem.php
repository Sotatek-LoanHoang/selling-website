<?php
namespace Application\Service;

class StaticNavItem implements NavItemInterface
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
    $link = isset($item['link']) ? $item['link'] : '#';
    $result .= $isActive ? '<li class="nav-item active">' : '<li class="nav-item">';
    $result .= '<a class="nav-link" href="' . $link . '">' . $label . '</a>';
    $result .= '</li>';
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
