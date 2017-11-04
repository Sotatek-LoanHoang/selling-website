<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\StripNewLines;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\Regex;

class LoginForm extends Form
{
  public function __construct()
  {
    parent::__construct('login');

    $this->add([
      'name' => 'username',
      'type' => 'text',
      'options' => [
        'label' => 'Username',
      ],
    ]);
    $this->add([
      'name' => 'password',
      'type' => 'password',
      'options' => [
        'label' => 'Password',
      ],
    ]);
    $this->add([
      'name' => 'submit',
      'type' => 'submit',
      'attributes' => [
        'value' => 'Submit',
        'id' => 'submitbutton',
      ],
    ]);
    $this->setAttribute('method', 'POST');
    $this->addInputFilter();
  }
  public function addInputFilter()
  {
    $inputFilter = new InputFilter();

    $inputFilter->add([
      'name' => 'username',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
        ['name' => StripNewlines::class],
      ],
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 6,
            'max' => 50,
          ],
        ],
        [
          'name' => Regex::class,
          'options' => [
            'pattern' => '/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/',
            'message' => 'The input can consist of letters and digits, with hyphens, underscores'
          ],
        ],
      ],
    ]);

    $inputFilter->add([
      'name' => 'password',
      'required' => true,
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 60,
          ],
        ],
      ],
    ]);
    $this->setInputFilter($inputFilter);
  }
}
?>
