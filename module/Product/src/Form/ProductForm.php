<?php
namespace Product\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
  public function __construct($name = null)
  {
        // We will ignore the name provided to the constructor
    parent::__construct('product');

    $this->add([
      'name' => 'id',
      'type' => 'hidden',
    ]);
    $this->add([
      'name' => 'name',
      'type' => 'text',
      'options' => [
        'label' => 'Name',
      ],
    ]);
    $this->add([
      'name' => 'content',
      'type' => 'text',
      'options' => [
        'label' => 'Description',
      ],
    ]);
    $this->add([
      'name' => 'price',
      'type' => 'number',
      'options' => [
        'label' => 'Price',
      ],
      'attributes' => [
        'min' => '1',
      ]
    ]);
    $this->add([
      'name' => 'image',
      'type' => 'text',
      'options' => [
        'label' => 'Image Url',
      ],
    ]);
    $this->add([
      'name' => 'submit',
      'type' => 'submit',
      'attributes' => [
        'value' => 'Go',
        'id' => 'submitbutton',
      ],
    ]);
  }
}
