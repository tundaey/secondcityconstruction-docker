<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class DeliveryDisableTimeTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAllBy($k,$v)
    {
        $resultSet = $this->tableGateway->select(array($k=>$v));
    
        return $resultSet;
    }
    
    public function fetchDate($k, $v)
    {
        // $resultSet = $this->tableGateway->select(array($k=>$v,$kk=>$vv));
        $resultSet = $this->tableGateway->select(array($k=>$v));
        return $resultSet;
    }
    
    public function insert(DeliveryDisableTime $v, $id)
    {
        $data = array(
            'day' => $v->day,
            'time' => $v->time,
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