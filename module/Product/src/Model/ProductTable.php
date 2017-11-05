<?php
namespace Product\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

class ProductTable {

	private $tableGateway;

	public function __construct(TableGatewayInterface $tableGateway) {
		$this->tableGateway= $tableGateway;
	}

	public function fetchAll() {
		return $this->tableGateway->select();
	}

	public function getProduct($id) {
		$id=(int) $id;
		$rowset=$this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if(!$row) {
			throw new RuntimeException(sqrintf('could not find row with identifier %d',$id ));
		}
		return $row;
	}

	public function saveProduct(Product $product) {
		 $data = [
		 	'name' => $product->name,
		 	'content' => $product->content,
		 	'image' => $product->image,

		 ];
		 $id = (int)$product->id;
		 if($id===0) {
		 	$this->tableGateway->insert($data);
		 	return;
		 }
		 if(!$this->getProduct($id)) {
		 	throw new RuntimeException(sprintf('could not update product with identifier %d; does not exist', $id));
		 }
		 $this->tableGateway->update($data,['id'=>$id]);
	}

	public function deleteProduct($id) {
		$this->tableGateway->delete(['id' => (int)$id]);
	}

	public function matchProduct($keyword) {
	$rowset = $this->tableGateway->select(function (Select $select) use($keyword) {
    $select->where->like('name', $keyword.'%');
    $select->order('name ASC');
});
		return $rowset;

	}


}