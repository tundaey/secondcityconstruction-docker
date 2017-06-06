<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;

class CommentsTable
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
    
    public function fetchAllBy($key, $value)
    {
        $resultSet = $this->tableGateway->select(array($key=>$value));
        return $resultSet;
    }
    
    public function insert(Comments $post)
    {
    	$data = array(
    			'post_id' => $post->post_id,
    			'name' => $post->name,
    			'email' => $post->email,
    	        'website' => $post->website,
    	        'message' => $post->message,
    	        'date' => $post->date,
    	        'status' => '0',
    	);
    
    	$this->tableGateway->insert($data);
    }
}