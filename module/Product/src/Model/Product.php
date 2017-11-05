<?php
namespace Product\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator\GreaterThan;

class Product implements InputFilterAwareInterface
{
  public $id;
  public $name;
  public $content;
  public $image;
  public $price;

  public function exchangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->name = !empty($data['name']) ? $data['name'] : null;
    $this->content = !empty($data['content']) ? $data['content'] : null;
    $this->image = !empty($data['image']) ? $data['image'] : null;
    $this->price = !empty($data['price']) ? $data['price'] : null;
  }

  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new DomainException(sprintf(
      '%s does not allow injection of an alternate input filter',
      __CLASS__
    ));
  }

  public function getInputFilter()
  {
    if ($this->inputFilter) {
      return $this->inputFilter;
    }

    $inputFilter = new InputFilter();

    $inputFilter->add([
      'name' => 'id',
      'required' => true,
      'filters' => [
        ['name' => ToInt::class],
      ],
    ]);

    $inputFilter->add([
      'name' => 'name',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
      ],
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 100,
          ],
        ],
      ],
    ]);

    $inputFilter->add([
      'name' => 'content',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
      ],
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 100,
          ],
        ],
      ],
    ]);

    $inputFilter->add([
      'name' => 'price',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
        ['name' => ToInt::class],
      ],
      'validators' => [
        [
          'name' => GreaterThan::class,
          'options' => [
            'min' => 1,
            'inclusive' => true,
          ],
        ],
      ],
    ]);
    $this->inputFilter = $inputFilter;
    return $this->inputFilter;
  }

  public function getArrayCopy()
  {
    return [
      'id' => $this->id,
      'content' => $this->content,
      'image' => $this->image,
      'name' => $this->name,
      'price' => $this->price,
    ];
  }
}
