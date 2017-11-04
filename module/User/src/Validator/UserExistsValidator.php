<?php
namespace User\Validator;

use Zend\Validator\AbstractValidator;
use User\Model\User;

class UserExistsValidator extends AbstractValidator
{
  protected $options = [
    'table' => null,
  ];
  const INVALID = 'usernameInvalid';
  const USER_EXISTS = 'userExists';

  protected $messageTemplates = array(
    self::INVALID => "Invalid type given. String expected",
    self::USER_EXISTS => "Another user with such an username already exists",
  );

  public function __construct($options = null)
  {
    if (is_array($options)) {
      if (isset($options['table']))
        $this->options['table'] = $options['table'];
    }
    parent::__construct($options);
  }

  public function isValid($value)
  {
    if (!is_string($value)) {
      $this->error(self::INVALID);
      return false;
    }
    $table = $this->options['table'];
    if ($table->getUser($value)) {
      $this->error(self::USER_EXISTS);
      return false;
    }
    return true;
  }
}
