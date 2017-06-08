<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class OrdersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
    		$select->order(array('id'=>'DESC'));
    	});
    		 
		return $resultSet;
    }
    
    public function fetchAllBy($key,$val)
    {
        $resultSet = $this->tableGateway->select(array($key=>$val));
        
        return $resultSet;
    }
    
    public function fetchBy($key,$val)
    {
        $resultSet = $this->tableGateway->select(array($key=>$val));
    
        return $resultSet->current();
    }
    
    public function insert(Orders $v)
    {   
        $data = array(
            'fname' => $v->fname,
            'lname' => $v->lname,
            'email' => $v->email,
            'phone' => $v->phone,
            'del_day' => $v->del_day,
            'del_time' => $v->del_time,
            'del_address' => $v->del_address,
            'del_zip' => $v->del_zip,
            'del_instructions' => $v->del_instructions,
            'rem_time' => $v->rem_time,
            'rem_day' => $v->rem_day,
            'rem_instruction' => $v->rem_instruction,
            'bil_address' => $v->bil_address,
            'bil_city' => $v->bil_city,
            'bil_state' => $v->bil_state,
            'bil_zip' => $v->bil_zip,
            'order_items' => $v->order_items,
            'order_amount' => $v->order_amount,
            'order_tax' => $v->order_tax,
            'order_promo' => $v->order_promo,
            'order_promo_percent' => $v->order_promo_percent,
            'order_transaction_id' => $v->order_transaction_id,
            'order_cc' => $v->order_cc,
            'date' => $v->date
        );
        $this->tableGateway->insert($data);
    }
    
    public function updateTax(Orders $o)
    {
        $data = array(
            'order_tax' => $o->order_tax
        );
    
        $this->tableGateway->update($data, array('id'=>$o->id));
    }
    
    public function delete($id)
    {
        $data = array(
            'id' => $id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function fetchTax()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array(new \Zend\Db\Sql\Expression('SUM(`order_tax`) as order_tax')));
            
        }); 
        return $resultSet->current();
    }
}