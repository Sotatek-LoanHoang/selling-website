<?php
namespace User\Service;

use User\Entity\User;
use User\Entity\Role;
use Zend\Math\Rand;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
  /**
   * Doctrine entity manager.
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * Role manager.
   * @var User\Service\RoleManager
   */
  private $roleManager;

  /**
   * Permission manager.
   * @var User\Service\PermissionManager
   */
  private $permissionManager;

  /**
   * Constructs the service.
   */
  public function __construct($entityManager, $roleManager, $permissionManager)
  {
    $this->entityManager = $entityManager;
    $this->roleManager = $roleManager;
    $this->permissionManager = $permissionManager;
    $this->createAdminUserIfNotExists();
  }

  /**
   * This method sign up a new user, user need to be activated before using.
   */
  public function signupUser($data)
  {
    // Do not allow several users with the same email address or username.
    if ($this->checkEmailExists($data['email'])) {
      throw new \Exception("User with email address " . $data['$email'] . " already exists");
    }

    if ($this->checkUserExists($data['username'])) {
      throw new \Exception("User with username " . $data['$username'] . " already exists");
    }

    // Create new User entity.
    $user = new User();
    $user->setUsername($data['username']);
    $user->setEmail($data['email']);

    if (isset($data['full_name']) && !empty($data['full_name']))
      $user->setFullName($data['full_name']);
    if (isset($data['birthday']) && !empty($data['birthday']))
      $user->setBirthday($data['birthday']);
    if (isset($data['gender']) && !empty($data['gender']))
      $user->setGender($data['gender']);

    // Encrypt password and store the password in encrypted state.
    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    $user->setPassword($passwordHash);

    if (isset($data['status']) && !empty($data['status']))
      $user->setStatus($data['status']);
    else
      $user->setStatus(User::STATUS_NOT_ACTIVATED);

    $currentDate = date('Y-m-d H:i:s');
    $user->setDateCreated($currentDate);

    // Assign roles to user.
    if (isset($data['roles']))
      $this->assignRoles($user, $data['roles']);
    else {
      $this->assignRoles($user, [$this->entityManager->getRepository(Role::class)
        ->findOneByName('Guest')]);
    }
    $this->generateActivateToken($user);
    // Add the entity to the entity manager.
    $this->entityManager->persist($user);

    // Apply changes to database.
    $this->entityManager->flush();

    return $user;
  }

  /**
   * This method adds a new user.
   */
  public function addUser($data)
  {
    // Do not allow several users with the same email address or username.
    if ($this->checkEmailExists($data['email'])) {
      throw new \Exception("User with email address " . $data['$email'] . " already exists");
    }

    if ($this->checkUserExists($data['username'])) {
      throw new \Exception("User with username " . $data['$username'] . " already exists");
    }

    // Create new User entity.
    $user = new User();
    $user->setUsername($data['username']);
    $user->setEmail($data['email']);

    if (isset($data['full_name']) && !empty($data['full_name']))
      $user->setFullName($data['full_name']);
    if (isset($data['birthday']) && !empty($data['birthday']))
      $user->setBirthday($data['birthday']);
    if (isset($data['gender']) && !empty($data['gender']))
      $user->setGender($data['gender']);

    // Encrypt password and store the password in encrypted state.
    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
    $user->setPassword($passwordHash);

    if (isset($data['status']) && !empty($data['status']))
      $user->setStatus($data['status']);
    else
      $user->setStatus(User::STATUS_ACTIVE);

    $currentDate = date('Y-m-d H:i:s');
    $user->setDateCreated($currentDate);

    // Assign roles to user.
    if (isset($data['roles']))
      $this->assignRoles($user, $data['roles']);
    else {
      $this->assignRoles($user, [$this->entityManager->getRepository(Role::class)
        ->findOneByName('Guest')]);
    }

    // Add the entity to the entity manager.
    $this->entityManager->persist($user);

    // Apply changes to database.
    $this->entityManager->flush();

    return $user;
  }

  /**
   * This method updates data of an existing user.
   */
  public function updateUser($user, $data)
  {
    // Do not allow to change user email or username if another user with such email or username already exits.
    if ($user->getEmail() != $data['email'] && $this->checkEmailExists($data['email'])) {
      throw new \Exception("Another user with email address " . $data['email'] . " already exists");
    }

    if (isset($data['email']) && !empty($data['email']))
    $user->setEmail($data['email']);
    if (isset($data['full_name']) && !empty($data['full_name']))
      $user->setFullName($data['full_name']);
    if (isset($data['birthday']) && !empty($data['birthday']))
      $user->setBirthday($data['birthday']);
    if (isset($data['gender']) && !empty($data['gender']))
      $user->setGender($data['gender']);
    if (isset($data['status']) && !empty($data['status']))
      $user->setStatus($data['status']);
    // Assign roles to user.
    $this->assignRoles($user, $data['roles']);
    // Apply changes to database.
    $this->entityManager->flush();

    return true;
  }

  /**
   * A helper method which assigns new roles to the user.
   */
  private function assignRoles($user, $roleIds)
  {
    // Remove old user role(s).
    $user->getRoles()->clear();

    // Assign new role(s).
    foreach ($roleIds as $roleId) {
      $role = $this->entityManager->getRepository(Role::class)
        ->find($roleId);
      if ($role == null) {
        throw new \Exception('Not found role by ID');
      }

      $user->addRole($role);
    }
  }

  /**
   * This method checks if at least one user presents, and if not, creates
   * 'Admin' user with email 'admin@example.com' and password 'admin123'.
   */
  public function createAdminUserIfNotExists()
  {
    $user = $this->entityManager->getRepository(User::class)->findOneBy([]);
    if ($user == null) {

      $this->permissionManager->createDefaultPermissionsIfNotExist();
      $this->roleManager->createDefaultRolesIfNotExist();
      error_log('asfasdfads');
      $user = new User();
      $user->setUsername('admin');
      $user->setEmail('admin@example.com');
      $user->setFullName('Admin');
      $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
      $user->setPassword($passwordHash);
      $user->setStatus(User::STATUS_ACTIVE);
      $user->setDateCreated(date('Y-m-d H:i:s'));

            // Assign user Administrator role
      $adminRole = $this->entityManager->getRepository(Role::class)
        ->findOneByName('Administrator');
      if ($adminRole == null) {
        throw new \Exception('Administrator role doesn\'t exist');
      }

      $user->getRoles()->add($adminRole);

      $this->entityManager->persist($user);
      $this->entityManager->flush();
    }
  }

  /**
   * Checks whether an active user with given username address already exists in the database.
   */
  public function checkUserExists($username)
  {

    $user = $this->entityManager->getRepository(User::class)
      ->findOneByUsername($username);

    return $user !== null;
  }

  /**
   * Checks whether an active user with given email address already exists in the database.
   */
  public function checkEmailExists($email)
  {

    $user = $this->entityManager->getRepository(User::class)
      ->findOneByEmail($email);

    return $user !== null;
  }

  /**
   * Checks that the given password is correct.
   */
  public function validatePassword($user, $password)
  {
    $passwordHash = $user->getPassword();

    if (password_verify($password, $passwordHash)) {
      return true;
    }

    return false;
  }

  /**
   * Generates a password reset token for the user. This token is then stored in database and
   * sent to the user's E-mail address. When the user clicks the link in E-mail message, he is
   * directed to the Set Password page.
   */
  public function generatePasswordResetToken($user)
  {
    // Generate a token.
    $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
    $user->setPasswordResetToken($token);

    $currentDate = date('Y-m-d H:i:s');
    $user->setPasswordResetTokenCreationDate($currentDate);

    $this->entityManager->flush();

    $subject = 'Password Reset';

    $httpHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    $passwordResetUrl = 'http://' . $httpHost . '/set-password?token=' . $token;

    $body = 'Please follow the link below to reset your password:\n';
    $body .= "$passwordResetUrl\n";
    $body .= "If you haven't asked to reset your password, please ignore this message.\n";

    // Send email to user.
    mail($user->getEmail(), $subject, $body);
  }

  /**
   * Checks whether the given password reset token is a valid one.
   */
  public function validatePasswordResetToken($passwordResetToken)
  {
    $user = $this->entityManager->getRepository(User::class)
      ->findOneByPasswordResetToken($passwordResetToken);

    if ($user == null) {
      return false;
    }

    $tokenCreationDate = $user->getPasswordResetTokenCreationDate();
    $tokenCreationDate = strtotime($tokenCreationDate);

    $currentDate = strtotime('now');

    if ($currentDate - $tokenCreationDate > 24 * 60 * 60) {
      return false; // expired
    }

    return true;
  }

  /**
   * This method sets new password by password reset token.
   */
  public function setNewPasswordByToken($passwordResetToken, $newPassword)
  {
    if (!$this->validatePasswordResetToken($passwordResetToken)) {
      return false;
    }

    $user = $this->entityManager->getRepository(User::class)
      ->findOneByPasswordResetToken($passwordResetToken);

    if ($user === null) {
      return false;
    }

    // Set new password for user
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $user->setPassword($passwordHash);

    // Remove password reset token
    $user->setPasswordResetToken(null);
    $user->setPasswordResetTokenCreationDate(null);

    $this->entityManager->flush();

    return true;
  }

  /**
   * This method is used to change the password for the given user. To change the password,
   * one must know the old password.
   */
  public function changePassword($user, $data)
  {
    $oldPassword = $data['old_password'];

    // Check that old password is correct
    if (!$this->validatePassword($user, $oldPassword)) {
      return false;
    }

    $newPassword = $data['new_password'];

    // Check password length
    if (strlen($newPassword) < 6 || strlen($newPassword) > 64) {
      return false;
    }

    // Set new password for user
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $user->setPassword($passwordHash);

    // Apply changes
    $this->entityManager->flush();

    return true;
  }

  /**
   * Generates an activate token for the user. This token is then stored in database and
   * sent to the user's E-mail address. When the user clicks the link in E-mail message, his
   * account is activated and redirect to home
   */
  public function generateActivateToken($user)
  {
    // Generate a token.
    $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
    $user->setActivateToken($token);

    $this->entityManager->flush();

    $subject = 'Account Activation';

    $httpHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    $passwordResetUrl = 'http://' . $httpHost . '/activate?token=' . $token;

    $body = 'Please follow the link below to activate your account:\n';
    $body .= "$passwordResetUrl\n";

    // Send email to user.
    mail($user->getEmail(), $subject, $body);
  }

  /**
   * Checks whether the given activation token is a valid one.
   */
  public function activateUser($activateToken)
  {
    $user = $this->entityManager->getRepository(User::class)
      ->findOneByActivateToken($activateToken);

    if ($user == null) {
      return false;
    }

    $user->setActivateToken(null);
    $user->setStatus(User::STATUS_ACTIVE);

    // Apply changes
    $this->entityManager->flush();
    return true;
  }
}

