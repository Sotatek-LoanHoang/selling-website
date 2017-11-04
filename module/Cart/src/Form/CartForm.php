<?php
namespace Cart\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

class CartForm extends Form
{
  public function __construct($items)
  {
    parent::__construct('cart');

    foreach($items as $item) {
      $this->add([
        'name' => $item->id,
        'type' => 'number',
        'attributes' => [
          'value' => $item->quantity,
          'id' => $item->id,
        ],
      ]);
    }
    $this->add([
      'name' => 'submit',
      'type' => 'submit',
      'attributes' => [
        'value' => 'Update',
        'id' => 'submitbutton',
      ],
    ]);
    $this->setAttribute('method', 'POST');
  }
}
?>
