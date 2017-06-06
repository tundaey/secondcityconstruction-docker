<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class PostsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	
    public function fetchPostCount()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {            
            $select->where->equalTo('parent', 0);
            $select->where->equalTo('trash', 0);
            $select->where->equalTo('type', 'post');
            $select->where->equalTo('status', 'published');
        });
        return $resultSet->count();
    }
    
    public function fetchAllBy($key, $val)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($key, $val)
        {
            $select->where->equalTo($key, $val);
            $select->where->equalTo('trash', 0);
            $select->where->equalTo('type', 'post');
            $select->where->equalTo('status', 'published');
            $select->order(array('date'=>'DESC'));
        });
    
        return $resultSet;
    }
    
    public function fetchPosts($ids)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($ids)
        {
            $select->where->in('post_id', $ids);
            $select->where->equalTo('trash', 0);
            $select->where->equalTo('type', 'post');
            $select->where->equalTo('status', 'published');
            $select->order(array('date'=>'DESC'));
        });
    
        return $resultSet;
    }
    
    public function fetchPost($id)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($id)
        {
            $select->where->equalTo('post_id', $id);
            $select->where->equalTo('trash', 0);
            $select->where->equalTo('status', 'published');
        });
    
        return $resultSet->current();
    }
    
    public function fetchByUri($uri)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($uri)
        {
            $select->where->equalTo('uri', $uri);
            $select->where->equalTo('parent', 0);
            $select->where->equalTo('status', 'published');
        });
        
        return $resultSet->current();
    }
    
    public function fetchDisclaimers()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->where->equalTo('trash', 0);
            $select->where->equalTo('type', 'disclaimer');
            $select->where->equalTo('status', 'published');
        });
    
        return $resultSet;
    }
    
    public function isTrash($id)
    {
        $resultSet = $this->tableGateway->select(array('post_id'=>$id));
        $result = $resultSet->current();
         
        if($result->trash > 0) :
        return FALSE;
        else :
        return TRUE;
        endif;
    }
}