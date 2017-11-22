<?php
namespace Book\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class BookForm extends Form
{
  public function __construct()
  {
    parent::__construct('book-form');
    $this->setAttribute('method', 'post');

    $this->addElements();
    $this->addInputFilter();
  }
  protected function addElements()
  {
    // Add "title" field
    $this->add([
      'type' => 'text',
      'name' => 'title',
      'options' => [
        'label' => 'Title',
      ],
    ]);

      // Add "price" field
    $this->add([
      'type' => 'number',
      'name' => 'price',
      'options' => [
        'label' => 'Price',
      ],
    ]);

    // Add "description" field
    $this->add([
      'type' => 'textarea',
      'name' => 'description',
      'options' => [
        'label' => 'Description',
      ],
    ]);

    // Add "publisher" field
    $this->add([
      'type' => 'text',
      'name' => 'publisher',
      'options' => [
        'label' => 'Publisher',
      ],
    ]);

    // Add "releaseDate" field
    $this->add([
      'type' => 'date',
      'name' => 'releaseDate',
      'options' => [
        'label' => 'Release Date',
      ],
    ]);

    // Add "printLength" field
    $this->add([
      'type' => 'number',
      'name' => 'printLength',
      'attributes' => [
        'min' => '1',
        'max' => '100000',
        'step' => '1', // default step interval is 1
      ],
      'options' => [
        'label' => 'Print Length',
      ],
    ]);

    // Add "authors" field
    $this->add([
      'type' => 'select',
      'name' => 'authors',
      'attributes' => [
        'multiple' => 'multiple',
      ],
      'options' => [
        'label' => 'Author(s)',
      ],
    ]);

    // Add "series" field
    $this->add([
      'type' => 'select',
      'name' => 'series',
      'attributes' => [
        'multiple' => 'multiple',
      ],
      'options' => [
        'label' => 'Series',
      ],
    ]);

    // Add "genres" field
    $this->add([
      'type' => 'select',
      'name' => 'genres',
      'attributes' => [
        'multiple' => 'multiple',
      ],
      'options' => [
        'label' => 'Genre(s)',
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
      'name' => 'title',
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
    // Add input for "description" field
    $inputFilter->add([
      'name' => 'description',
      'required' => false,
      'filters' => [['name' => 'StringTrim'], ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 0,
            'max' => 1024
          ],
        ],
      ],
    ]);

    // Add input for "publisher" field
    $inputFilter->add([
      'name' => 'publisher',
      'required' => false,
      'filters' => [
        ['name' => 'StringTrim'],
      ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 1,
            'max' => 128
          ],
        ],
      ],
    ]);

    // Add input for "releaseDate" field
    $inputFilter->add([
      'name' => 'releaseDate',
      'required' => false,
      'validators' => [
        [
          'name' => 'Date',
          'options' => [
            'format' => 'Y-m-d',
          ],
        ],
      ],
    ]);

    // Add input for "printLength" field
    $inputFilter->add([
      'name' => 'printLength',
      'required' => false,
      'validators' => [
        [
          'name' => 'GreaterThan',
          'options' => [
            'min' => 1,
            'inclusive' => true,
          ],
        ],
      ],
    ]);

    // Add input for "authors" field
    $inputFilter->add([
      'class' => ArrayInput::class,
      'name' => 'authors',
      'required' => false,
      'filters' => [
        ['name' => 'ToInt'],
      ],
      'validators' => [
        ['name' => 'GreaterThan', 'options' => ['min' => 0]]
      ],
    ]);

    // Add input for "series" field
    $inputFilter->add([
      'class' => ArrayInput::class,
      'name' => 'series',
      'required' => false,
      'filters' => [
        ['name' => 'ToInt'],
      ],
      'validators' => [
        ['name' => 'GreaterThan', 'options' => ['min' => 0]]
      ],
    ]);

    // Add input for "genres" field
    $inputFilter->add([
      'class' => ArrayInput::class,
      'name' => 'genres',
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
