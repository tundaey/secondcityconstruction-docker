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
    
    public function fetchUriDuplicates($uri,$ext)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($uri, $ext)
    	{
    	    $select->where->equalTo('uri', $uri.$ext);
    	    $select->where->equalTo('parent', 0);
    		$select->columns(array('count'=>new \Zend\Db\Sql\Expression('count(*)')));
    	});
    	
    	if($resultSet->current()->count > 0) :
            $uri = $uri.'-'.rand(100, 999);
    	endif;
    	
    	return $uri.$ext;
    }
    
    public function fetchAllRevisionCountBy($key, $value)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $value)
    	{
    	    $select->where->equalTo($key, $value);
    		$select->columns(array('count'=>new \Zend\Db\Sql\Expression('count(*)')));
    	});
    	 
    	return $resultSet->current();
    }
    
    public function fetchAllPublicBy($key, $value, $status)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $value, $status) 
    	{
    		$select->where->equalTo($key, $value);
    		if($status == 'all') : 
    			$select->where->equalTo('trash', 0);
    		elseif($status == 'trash') :
    		  $select->where->equalTo('trash', 1);
    		else :
    		    $select->where->equalTo('trash', 0);
    			$select->where->equalTo('status', $status);
    		endif;
    		$select->order(array('date'=>'DESC'));
    	});
    	
    	return $resultSet->toArray();
    }
    
    public function fetchAllCountBy($key, $value, $status)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $value, $status) 
    	{
    		$select->where->equalTo($key, $value);
    		if($status == 'all') :
    			$select->where->equalTo('trash', 0);
    		elseif($status == 'trash') :
    		    $select->where->equalTo('trash', 1);
    		else :
    		    $select->where->equalTo('trash', 0);
    		    $select->where->equalTo('status', $status);
    		endif;
    			$select->columns(array('count'=>new \Zend\Db\Sql\Expression('count(*)')));
    	});
    		 
    	return $resultSet->current();
    }
    
    public function fetchAllTrashBy($key, $value)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $value) {
    		$select->where->equalTo($key, $value);
    		$select->where->equalTo('trash', 1);
    		$select->order(array('modified'=>'DESC'));
    	});
    		 
    		return $resultSet;
    }
    
    public function revisionPrevies($key, $val)
    {	
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $val) {
    		$select->where->equalTo($key, $val->parent);
    		$select->where->lessThan('date', $val->date);
    		$select->order(array('modified'=>'DESC'));
    		$select->limit(1);
    	});
    		 
    	return $resultSet->current();
    }
    
    public function nextPrevies($key, $val)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $val) {
    		$select->where->equalTo($key, $val->parent);
    		$select->where->greaterThan('date', $val->date);
    		$select->order(array('modified'=>'ASC'));
    		$select->limit(1);
    	});
    		 
    		return $resultSet->current();
    }
    
    public function currentRevision($key, $val)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($key, $val) {
    		$select->where->equalTo($key, $val);
    		$select->order(array('modified'=>'DESC'));
    		$select->limit(1);
    	}); 
    	
    	return $resultSet->current();
    }
    
    public function fetch($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet->current();
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
    
    public function save(Posts $post)
    {
        // insert main post
    	$data = array(
    			'author'     => $post->author,
    			'date'       => $post->date,
    			'content'    => $post->content,
        	    'title'      => $post->title,
    	        'uri'        => $post->uri,
    	        'keyword'    => $post->keyword,
        	    'excerpt'    => $post->excerpt,
    	        'feat_image' => $post->feat_image,
        	    'modified'   => $post->modified,
        	    'type'       => $post->type,
        	    'status'     => $post->status,
    	);
    	
    	$this->tableGateway->insert($data);
    	
    	$id = $this->tableGateway->lastInsertValue;
    	
    	// insert history
    	$data = array(
    	        'parent'     => $this->tableGateway->lastInsertValue,
    			'author'     => $post->author,
    			'date'       => $post->date,
    			'content'    => $post->content,
    	        'uri'        => $post->uri,
    			'title'      => $post->title,
    			'keyword'    => $post->keyword,
    			'excerpt'    => $post->excerpt,
    	        'feat_image' => $post->feat_image,
    			'modified'   => $post->modified,
    			'type'       => $post->type,
    			'status'     => 'inherit',
    	);
    	
    	$this->tableGateway->insert($data);
    	
    	return $id;
    }
    
    public function update(Posts $post) // used by post/edit & post/revision
    { 
        // update main post
    	$data = array(
    	        'parent'     => '0',
    	        'date'       => $post->date_publish,
    	        'author'     => $post->author,
    			'content'    => $post->content,
        	    'title'      => $post->title,
    	        'uri'        => $post->uri,
    	        'keyword'    => $post->keyword,
        	    'excerpt'    => $post->excerpt,
    	        'feat_image' => $post->feat_image,
        	    'modified'   => $post->modified,
        	    'type'       => $post->type,
        	    'status'     => $post->status,
    	        'rights'     => $post->rights,
    	);
    	
    	$this->tableGateway->update($data, array('post_id'=>$post->parent));
    	
    	// create history
    	$data = array(
    			'parent'     => $post->parent,
    			'author'     => $post->author,
    			'date'       => $post->date,
    			'content'    => $post->content,
    			'title'      => $post->title,
    	        'uri'        => $post->uri,
    			'keyword'    => $post->keyword,
    			'excerpt'    => $post->excerpt,
    	        'feat_image' => $post->feat_image,
    			'modified'   => $post->modified,
    			'type'       => $post->type,
    			'status'     => 'inherit',
    	        'rights'     => $post->rights,
    	);
    	
    	$this->tableGateway->insert($data);
    	
    	return $this->tableGateway->lastInsertValue;
    }
    
    public function trash($id)
    {   
    	$data = array(
    			'trash' => '1'
    	);
    	$this->tableGateway->update($data, array('post_id'=>$id));
    }
    
    public function restore($id)
    {
    	$data = array(
    			'trash' => '0'
    	);
    	$this->tableGateway->update($data, array('post_id'=>$id));
    }
    
    public function delete($id)
    {
    	$data = array(
	       'post_id' => $id
    	);
    
    	$this->tableGateway->delete($data);
    }
    
    public function deleteByParentId($id)
    {
    	$data = array(
    			'parent' => $id
    	);
    
    	$this->tableGateway->delete($data);
    }
}