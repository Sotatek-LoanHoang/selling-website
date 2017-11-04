<?php
namespace User\Form;

use User\Validator\UserExistsValidator;
use User\Validator\EmailExistsValidator;
use User\Service\UserTable;
use Zend\Form\Form;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\StripNewLines;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\Regex;

class SignupForm extends Form
{
  private $table = null;
  public function __construct(UserTable $table)
  {
    $this->table = $table;
    parent::__construct('signup');

    $this->add([
      'name' => 'username',
      'type' => 'text',
      'options' => [
        'label' => 'Username',
      ],
    ]);
    $this->add([
      'name' => 'email',
      'type' => 'email',
      'options' => [
        'label' => 'Email',
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
      'name' => 'full_name',
      'type' => 'text',
      'options' => [
        'label' => 'Full name',
      ],
    ]);
    $this->add([
      'name' => 'birthday',
      'type' => 'date',
      'options' => [
        'label' => 'Birthday',
      ],
    ]);
    $this->add([
      'name' => 'gender',
      'type' => 'select',
      'options' => [
        'label' => 'Gender',
        'empty_option' => 'Please choose your gender',
        'value_options' => [
          '0' => 'Male',
          '1' => 'Female',
        ]
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
        [
          'name' => UserExistsValidator::class,
          'options' => [
            'table' => $this->table,
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
    $inputFilter->add([
      'name' => 'email',
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
            'min' => 1,
            'max' => 254,
          ],
        ],
        [
          'name' => EmailAddress::class,
        ],
        [
          'name' => EmailExistsValidator::class,
          'options' => [
            'table' => $this->table,
          ],
        ],
      ],
    ]);
    $inputFilter->add([
      'name' => 'birthday',
      'required' => false,
      'validators' => [
        [
          'name' => Date::class,
        ],
      ],
    ]);
    $inputFilter->add([
      'name' => 'gender',
      'required' => false,
    ]);
    $inputFilter->add([
      'name' => 'full_name',
      'required' => false,
    ]);
    $this->setInputFilter($inputFilter);
  }
}
?>
