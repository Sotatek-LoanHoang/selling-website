<?php
namespace Cart\Model;

use DomainException;

class Item
{
  public $id;
  public $quantity;

  public function exchangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->quantity = !empty($data['quantity']) ? $data['quantity'] : null;
  }
}
?>
