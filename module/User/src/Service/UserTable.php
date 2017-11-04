<?php
namespace User\Service;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use User\Model\User;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUser($username)
    {
        $rowset = $this->tableGateway->select(['username' => $username]);
        $row = $rowset->current();
        return $row;
    }

    public function isEmailExists($email)
    {
        $rowset = $this->tableGateway->select(['email' => $email]);
        $row = $rowset->current();
        return $row != null;
    }

    public function saveUser(User $user)
    {
        $data = [
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'full_name' => $user->full_name,
            'birthday' => $user->birthday,
            'gender' => $user->gender
        ];

        $username = (int)$user->username;

        if (!$this->getUser($username)) {
            $this->tableGateway->insert($data);
            return;
        }

        $this->tableGateway->update($data, ['username' => $username]);
    }

    public function deleteUser($username)
    {
        $this->tableGateway->delete(['username' => (int)$username]);
    }
}
?>
