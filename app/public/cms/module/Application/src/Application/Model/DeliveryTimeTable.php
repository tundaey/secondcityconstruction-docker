<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class DeliveryTimeTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAllBy($key, $value)
    {
        $resultSet = $this->tableGateway->select(array($key=>$value));
        
        return $resultSet;
    }
    
    public function insert(DeliveryTime $link, $id)
    {
        $data = array(
            'start' => $link->start,
            'end' => $link->end,
            'target' => $id,
        );
        $this->tableGateway->insert($data);
    }
    
    public function delete($id)
    {
        $data = array(
            'id' => $id
        );
    
        $this->tableGateway->delete($data);
    }
}