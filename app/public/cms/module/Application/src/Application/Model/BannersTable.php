<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class BannersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    } 
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order(array('date'=>'DESC'));
        });
        return $resultSet;
    }   
    
    public function delete(Banners $del)
    {
        $data = array(
            'id' => $del->id
        );
         
        $this->tableGateway->delete($data);
    }
    
    public function insert(Banners $ins)
    {
        $data = array(
            'source' => $ins->source,
            'position' => $ins->position,
            'date' => $ins->date,
        );
        $this->tableGateway->insert($data);
    }
}