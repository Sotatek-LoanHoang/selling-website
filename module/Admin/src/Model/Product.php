<?php
namespace Admin\Model;

class Product
{
	public $id;
	public $name;
	public $content;
	public $image;

	public function exchangeArray(array $data) {
		$this->id= !emty($data['id'])? $data['id'] : null;
		$this->name= !emty($data['name'])? $data['name'] : null;
		$this->content= !emty($data['content'])? $data['content'] : null;
		$this->id= !emty($data['image'])? $data['image'] : null;
	}
}