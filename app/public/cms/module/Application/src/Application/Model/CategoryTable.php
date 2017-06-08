<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;

class CategoryTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select();
    	return $resultSet;
    }
    
    public function fetch($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet->current();
    }
    
    public function fetchAllBy($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet;
    }
    
    public function save(Category $cat)
    {
    	$data = array(
    			'name' => $cat->name,
    			'slug' => $cat->slug,
    			'parent' => $cat->parent,
    	);
    
    	$this->tableGateway->insert($data);
    }
    
    public function update(Category $cat)
    {
    	$data = array(
    	        'name' => $cat->name,
    			'slug' => $cat->slug,
    			'parent' => $cat->parent,
    	);
    
    	$this->tableGateway->update($data, array('category_id'=>$cat->category_id));
    }
    
    public function delete(Category $del)
    {
    	$data = array(
	       'category_id' => $del->category_id
    	);
    
    	$this->tableGateway->delete($data);
    }
}