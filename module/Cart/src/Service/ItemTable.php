<?php
namespace Cart\Service;

use RuntimeException;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\TableGatewayInterface;
use User\Model\Item;

class ItemTable
{
  private $tableGateway;
  private $auth;

  public function __construct(TableGatewayInterface $tableGateway)
  {
    $this->tableGateway = $tableGateway;
    $this->auth = new AuthenticationService();
  }

  public function fetchAll()
  {
    return $this->tableGateway->select();
  }

  public function getItems()
  {
    if (!$this->auth->hasIdentity()) return [];
    $rowset = $this->tableGateway->select(['username' => $this->auth->getIdentity()]);
    $result = [];
    foreach ($rowset as $row) {
      $result[] = $row;
    }
    return $result;
  }

  public function saveItems($items)
  {
    if (!$this->auth->hasIdentity()) return [];
    foreach ($items as $item) {
      $this->tableGateway->update(['quantity' => $item->quantity], ['username' => $this->auth->getIdentity(), 'id' => $item->id]);
    }
  }

  public function deleteItems()
  {
    if (!$this->auth->hasIdentity()) return [];
    $this->tableGateway->delete(['username' => $this->auth->getIdentity()]);
  }
}
?>
