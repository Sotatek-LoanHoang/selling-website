<?php
namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\ArrayInput;
use User\Validator\UserExistsValidator;
use User\Validator\EmailExistsValidator;

/**
 * This form is used to collect user's username, email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class UserForm extends Form
{
  /**
   * Scenario ('create' or 'update' or 'signup').
   * @var string
   */
  private $scenario;

  /**
   * Entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager = null;

  /**
   * Current user.
   * @var User\Entity\User
   */
  private $user = null;

  /**
   * Constructor.
   */
  public function __construct($scenario = 'signup', $entityManager = null, $user = null)
  {
    // Define form name
    parent::__construct('user-form');

    // Set POST method for this form
    $this->setAttribute('method', 'post');

    // Save parameters for internal use.
    $this->scenario = $scenario;
    $this->entityManager = $entityManager;
    $this->user = $user;

    $this->addElements();
    $this->addInputFilter();
  }

  /**
   * This method adds elements to form (input fields and submit button).
   */
  protected function addElements()
  {
    // Add "username" field
    $this->add([
      'type' => 'text',
      'name' => 'username',
      'options' => [
        'label' => 'Username',
      ],
    ]);

    // Add "email" field
    $this->add([
      'type' => 'text',
      'name' => 'email',
      'options' => [
        'label' => 'E-mail',
      ],
    ]);

    // Add "full_name" field
    $this->add([
      'type' => 'text',
      'name' => 'full_name',
      'options' => [
        'label' => 'Full Name',
      ],
    ]);

    // Add "birthday" field
    $this->add([
      'type' => 'date',
      'name' => 'birthday',
      'options' => [
        'label' => 'Birthday',
      ],
    ]);

    // Add "gender" field
    $this->add([
      'type' => 'select',
      'name' => 'gender',
      'options' => [
        'empty_option' => 'Choose your gender',
        'label' => 'Gender',
        'value_options' => [
          1 => 'Male',
          2 => 'Female',
        ]
      ],
    ]);

    if ($this->scenario == 'create' || $this->scenario == 'signup') {

      // Add "password" field
      $this->add([
        'type' => 'password',
        'name' => 'password',
        'options' => [
          'label' => 'Password',
        ],
      ]);

      // Add "confirm_password" field
      $this->add([
        'type' => 'password',
        'name' => 'confirm_password',
        'options' => [
          'label' => 'Confirm password',
        ],
      ]);
    }

    if ($this->scenario == 'create' || $this->scenario == 'update') {
      // Add "status" field
      $this->add([
        'type' => 'select',
        'name' => 'status',
        'options' => [
          'label' => 'Status',
          'value_options' => [
            1 => 'Active',
            2 => 'Retired',
          ]
        ],
      ]);

      // Add "roles" field
      $this->add([
        'type' => 'select',
        'name' => 'roles',
        'attributes' => [
          'multiple' => 'multiple',
        ],
        'options' => [
          'label' => 'Role(s)',
        ],
      ]);
    }

    // Add the Submit button
    $this->add([
      'type' => 'submit',
      'name' => 'submit',
      'attributes' => [
        'value' => 'Create'
      ],
    ]);
  }

  /**
   * This method creates input filter (used for form filtering/validation).
   */
  private function addInputFilter()
  {
    // Create main input filter
    $inputFilter = new InputFilter();
    $this->setInputFilter($inputFilter);


    if ($this->scenario == 'create' || $this->scenario == 'signup') {
      // Add input for "username" field
      $inputFilter->add([
        'name' => 'username',
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
          [
            'name' => UserExistsValidator::class,
            'options' => [
              'entityManager' => $this->entityManager,
              'user' => $this->user
            ],
          ],
        ],
      ]);
    }
    // Add input for "email" field
    $inputFilter->add([
      'name' => 'email',
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
        [
          'name' => 'EmailAddress',
          'options' => [
            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
            'useMxCheck' => false,
          ],
        ],
        [
          'name' => EmailExistsValidator::class,
          'options' => [
            'entityManager' => $this->entityManager,
            'user' => $this->user
          ],
        ],
      ],
    ]);

    // Add input for "full_name" field
    $inputFilter->add([
      'name' => 'full_name',
      'required' => false,
      'filters' => [
        ['name' => 'StringTrim'],
      ],
      'validators' => [
        [
          'name' => 'StringLength',
          'options' => [
            'min' => 1,
            'max' => 512
          ],
        ],
      ],
    ]);

    // Add input for "birthday" field
    $inputFilter->add([
      'name' => 'birthday',
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

    // Add input for "gender" field
    $inputFilter->add([
      'name' => 'gender',
      'required' => false,
      // 'filters' => [
      //   ['name' => 'ToInt'],
      // ],
    ]);

    if ($this->scenario == 'create' || $this->scenario == 'signup') {

      // Add input for "password" field
      $inputFilter->add([
        'name' => 'password',
        'required' => true,
        'filters' => [],
        'validators' => [
          [
            'name' => 'StringLength',
            'options' => [
              'min' => 6,
              'max' => 64
            ],
          ],
        ],
      ]);

      // Add input for "confirm_password" field
      $inputFilter->add([
        'name' => 'confirm_password',
        'required' => true,
        'filters' => [],
        'validators' => [
          [
            'name' => 'Identical',
            'options' => [
              'token' => 'password',
            ],
          ],
        ],
      ]);
    }

    if ($this->scenario == 'create' || $this->scenario == 'update') {

    // Add input for "status" field
      $inputFilter->add([
        'name' => 'status',
        'required' => true,
        'filters' => [
          ['name' => 'ToInt'],
        ],
        'validators' => [
          ['name' => 'InArray', 'options' => ['haystack' => [1, 2]]]
        ],
      ]);

    // Add input for "roles" field
      $inputFilter->add([
        'class' => ArrayInput::class,
        'name' => 'roles',
        'required' => true,
        'filters' => [
          ['name' => 'ToInt'],
        ],
        'validators' => [
          ['name' => 'GreaterThan', 'options' => ['min' => 0]]
        ],
      ]);
    }
  }
}