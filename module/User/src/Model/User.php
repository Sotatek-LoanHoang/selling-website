<?php
namespace User\Model;

use DomainException;

class User
{
  public $id;
  public $username;
  public $email;
  public $full_name;
  public $birthday;
  public $gender;
  public $password;

  public function exchangeArray(array $data)
  {
    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->username = !empty($data['username']) ? $data['username'] : null;
    $this->email = !empty($data['email']) ? $data['email'] : null;
    $this->full_name = !empty($data['full_name']) ? $data['full_name'] : null;
    $this->birthday = !empty($data['birthday']) ? $data['birthday'] : null;
    $this->gender = !empty($data['gender']) ? $data['gender'] : null;
    $this->password = !empty($data['password']) ? $data['password'] : null;
  }
}
?>
