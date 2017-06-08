<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class DeliveryDisableDayTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAllBy($value)
    {
        $resultSet = $this->tableGateway->select(array('target'=>$value));
        
        return $resultSet;
    }
    
    public function insert(DeliveryDisableDay $link, $id)
    {
        $data = array(
            'day' => $link->day,
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