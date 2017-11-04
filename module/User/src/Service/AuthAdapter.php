<?php
namespace User\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class AuthAdapter implements AdapterInterface
{
  private $username = null;
  private $password = null;
  private $table = null;
  public function __construct($username, $password, $table)
  {
    $this->username = $username;
    $this->password = $password;
    $this->table = $table;
  }

  public function authenticate()
  {
    $code = Result::SUCCESS;
    $messages = [];
    if (!$this->username || $this->username === '') {
      $messages[] = "Invalid username input";
      $code = Result::FAILURE_CREDENTIAL_INVALID;
    }
    if (!$this->password || $this->password === '') {
      $messages[] = "Invalid password input";
      $code = Result::FAILURE_CREDENTIAL_INVALID;
    }
    if ($code === Result::FAILURE_CREDENTIAL_INVALID) {
      return new Result($code, null, $messages);
    }
    $user = $this->table->getUser($this->username);
    if ($user == null) {
      $messages[] = "Username not found";
      $code = Result::FAILURE_IDENTITY_NOT_FOUND;
      return new Result($code, null, $messages);
    }
    error_log($this->password);
    error_log($user->password);
    if (password_verify($this->password, $user->password)) {
      $messages[] = "Authentication success";
    }
    else {
      $messages[] = "Authentication failure";
      $code = Result::FAILURE_CREDENTIAL_INVALID;
    }
    return new Result($code, $this->username, $messages);
  }
}
?>
