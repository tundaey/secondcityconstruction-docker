<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class DeliveryZipCodeTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAllBy($key,$val)
    {
        $resultSet = $this->tableGateway->select(array($key=>$val));
        
        return $resultSet;
    }
    
    public function insert(DeliveryZipCode $v, $id)
    {
        $data = array(
            'zip_code' => $v->zip_code,
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