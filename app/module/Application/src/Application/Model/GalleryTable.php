<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class GalleryTable
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
    
    public function fetch($id)
    {
        $resultSet = $this->tableGateway->select(array('id'=>$id));
        return $resultSet->current();
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
    
    public function insert(Gallery $p)
    {
        $data = array(
            'name' => $p->name,
            'description' => $p->description,
            'position' => $p->position,
            'variation' => $p->variation
        );
    
        $this->tableGateway->insert($data);
    
        $id = $this->tableGateway->lastInsertValue;
    
        return $id;
    }
    
    public function insertFirstVariation(Gallery $p)
    {
        $data = array(
            'name' => $p->name,
            'position' => '10',
            'image' => $p->image,
            'variation' => $p->id
        );
    
        $this->tableGateway->insert($data);
    
        return true;
    }
    
    public function update(Gallery $pro)
    {
        if(isset($pro->image['name']) && $pro->image['name'] != '' || isset($pro->image) && !is_array($pro->image) && $pro->image != '') :
    
        $data = array(
            'name' => $pro->name,
            'image' => $pro->image,
            'description' => $pro->description,
            'position' => $pro->position,
        );
    
        else :
    
        $data = array(
            'name' => $pro->name,
            'description' => $pro->description,
            'position' => $pro->position,
        );
    
        endif;
    
        $this->tableGateway->update($data, array('id'=>$pro->id));
    }
    
    public function delete(Gallery $p)
    {
        $data = array(
            'id' => $p->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function deleteVariation(Gallery $p)
    {
        $data = array(
            'variation' => $p->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function insertVariation(Gallery $p)
    {
        $data = array(
            'name' => $p->name,
            'image' => $p->image,
            'description' => $p->description,
            'position' => $p->position,
            'variation' => $p->id
        );
    
        $this->tableGateway->insert($data);
    
        $id = $this->tableGateway->lastInsertValue;
    
        return $id;
    }
    
    /*
    
    
    
    
    
    
    
    
    
    
    
    
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
    
    */
}