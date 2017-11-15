<?php
namespace Book\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AuthorForm extends Form
{
  public function __construct()
  {
    parent::__construct('author-form');
    $this->setAttribute('method', 'post');

    $this->addElements();
    $this->addInputFilter();
  }
  protected function addElements()
  {
    // Add "name" field
    $this->add([
      'type' => 'text',
      'name' => 'name',
      'options' => [
        'label' => 'Author\'s Name',
      ],
    ]);

    // Add "books" field
    $this->add([
      'type' => 'select',
      'name' => 'books',
      'attributes' => [
        'multiple' => 'multiple',
      ],
      'options' => [
        'label' => 'Book(s)',
      ],
    ]);

    // Add the Submit button
    $this->add([
      'type' => 'submit',
      'name' => 'submit',
      'attributes' => [
        'value' => 'Create'
      ],
    ]);
  }
  protected function addInputFilter()
  {
    // Create main input filter
    $inputFilter = new InputFilter();
    $this->setInputFilter($inputFilter);

    // Add input for "username" field
    $inputFilter->add([
      'name' => 'name',
      'required' => true,
      'filters' => [
        ['name' => 'StringTrim'],
      ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 1,
            'max' => 64
          ],
        ],
      ],
    ]);

    // Add input for "books" field
    $inputFilter->add([
      'class' => ArrayInput::class,
      'name' => 'books',
      'required' => false,
      'filters' => [
        ['name' => 'ToInt'],
      ],
      'validators' => [
        ['name' => 'GreaterThan', 'options' => ['min' => 0]]
      ],
    ]);
  }
}
