<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class ProductsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->order('position');
        });
        
        return $resultSet;
    }
    
    public function fetchAllBy($k,$v,$order)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($k,$v,$order)
        {
            $select->where(array($k=>$v));
            $select->order($order);
        });
        
        return $resultSet;
    }
    
    public function fetch($id)
    {
        $resultSet = $this->tableGateway->select(array('id'=>$id));
        return $resultSet->current();
    }
    
    public function delete(Products $p)
    {
        $data = array(
            'id' => $p->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function deleteVariation(Products $p)
    {
        $data = array(
            'variation' => $p->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function insert(Products $p)
    {
        $data = array(
            'name' => $p->name,  
            'price' => $p->price,
            'qty' => $p->qty,
            'description' => $p->description,
            'image' => $p->image,
            'type' => '2',
            'position' => $p->position,
            'variation' => '0',
            'tax' => $p->tax
        );
    
        $this->tableGateway->insert($data);
        
        $id = $this->tableGateway->lastInsertValue;
        
        return $id;
    }
    
    public function insertFirstVariation(Products $p)
    {
        $data = array(
            'name' => $p->name,
            'price' => $p->price,
            'qty' => $p->qty,
            'type' => '2',
            'position' => '10',
            'variation' => $p->id
        );
    
        $this->tableGateway->insert($data);
        
        return true;
    }
    
    public function insertVariation(Products $p)
    {
        $data = array(
            'name' => $p->name,
            'price' => $p->price,
            'qty' => $p->qty,
            'position' => $p->position,
            'variation' => $p->id
        );
    
        $this->tableGateway->insert($data);
    
        $id = $this->tableGateway->lastInsertValue;
    
        return $id;
    }
    
    public function updateVariation(Products $p)
    {
        $data = array(
            'name' => $p->name,
            'price' => $p->price,
            'qty' => $p->qty,
            'position' => $p->position,
        );
    
        $this->tableGateway->update($data, array('id'=>$p->id));
    }
    
    public function update(Products $pro)
    {
        if(isset($pro->image['name']) && $pro->image['name'] != '' || isset($pro->image) && !is_array($pro->image) && $pro->image != '') :
        
            $data = array(
                'name' => $pro->name,
                'image' => $pro->image,
                'description' => $pro->description,
                'type' => '2',
                'position' => $pro->position,
                'tax' => $pro->tax,
            );
            
        else :
        
            $data = array(
                'name' => $pro->name,
                'price' => $pro->price,
                'qty' => $pro->qty,
                'description' => $pro->description,
                'type' => '2',
                'position' => $pro->position,
                'tax' => $pro->tax,
            );
            
        endif;
        
        $this->tableGateway->update($data, array('id'=>$pro->id));
    }
}