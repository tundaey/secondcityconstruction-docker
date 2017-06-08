<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class DeliveryRangeTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetch($key, $value)
    {
        $resultSet = $this->tableGateway->select(array($key=>$value));
        return $resultSet->current();
    }
    
    public function update(DeliveryRange $d, $id)
    {
        $data = array(
            'from' => $d->from,
            'to' => $d->to,
        );
    
        $this->tableGateway->update($data, array('id'=>$id));
    }
}