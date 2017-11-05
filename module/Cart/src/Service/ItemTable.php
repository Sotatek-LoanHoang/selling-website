<?php
namespace Cart\Service;

use RuntimeException;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\TableGatewayInterface;
use Cart\Model\Item;

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
  public function getItem($id)
  {
    if (!$this->auth->hasIdentity()) return [];
    $rowset = $this->tableGateway->select(['username' => $this->auth->getIdentity(), 'id' => $id]);
    return $rowset->current();
  }
  public function saveItems(array $items)
  {
    if (!$this->auth->hasIdentity()) return;
    foreach ($items as $item) {
      if ($this->tableGateway->select([
        'username' => $this->auth->getIdentity(),
        'id' => $item->id
      ])->count() === 0)
        $this->tableGateway->update(
        [
          'quantity' => $item->quantity,
        ],
        [
          'username' => $this->auth->getIdentity(),
          'id' => $item->id,
        ]
      );
      else
        $this->tableGateway->insert(
        [
          'username' => $this->auth->getIdentity(),
          'id' => $item->id,
          'quantity' => $item->quantity,
        ]
      );
    }
  }
  public function saveItem(Item $item)
  {
    if (!$this->auth->hasIdentity()) return;
    error_log($item->id.' '.$item->quantity);
    if ($this->tableGateway->select([
      'username' => $this->auth->getIdentity(),
      'id' => $item->id
    ])->count() !== 0)
      $this->tableGateway->update(
      [
        'quantity' => $item->quantity,
      ],
      [
        'username' => $this->auth->getIdentity(),
        'id' => $item->id,
      ]
    );
    else
      $this->tableGateway->insert(
      [
        'username' => $this->auth->getIdentity(),
        'id' => $item->id,
        'quantity' => $item->quantity,
      ]
    );
  }
  public function deleteItems()
  {
    if (!$this->auth->hasIdentity()) return;
    $this->tableGateway->delete(['username' => $this->auth->getIdentity()]);
  }
}
?>
