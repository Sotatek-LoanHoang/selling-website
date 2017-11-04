<?php
namespace User\Validator;

use Zend\Validator\AbstractValidator;
use User\Model\User;

class EmailExistsValidator extends AbstractValidator
{
  protected $options = array(
    'table' => null,
  );
  const INVALID = 'emailInvalid';
  const EMAIL_EXISTS = 'emailExists';

  protected $messageTemplates = array(
    self::INVALID => "Invalid type given. String expected",
    self::EMAIL_EXISTS => "Another user with such an email already exists",
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
    if ($table->isEmailExists($value)) {
      $this->error(self::EMAIL_EXISTS);
      return false;
    }
    return true;
  }
}
