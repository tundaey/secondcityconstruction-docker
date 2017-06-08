<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class QuotesTable
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
    
    public function insert(Quotes $quo)
    {
        $data = array(
            'content' => $quo->content,
            'date' => $quo->date,
        );
        $this->tableGateway->insert($data);
    }
    
    public function delete(Quotes $del)
    {
        $data = array(
            'id' => $del->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    /*
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
	//-> slogan
    public function fetchSlogan()
    {
        $resultSet = $this->tableGateway->select(array('name'=>'slogan'));
        return $resultSet->current();
    }
    
    public function updateSlogan(Options $opt)
    {
        $data = array(
            'val_1' => $opt->val_1, // slogan value
        );
        $this->tableGateway->update($data, array('name'=>'slogan'));
    }
    
    public function updateVideo(Options $opt)
    {
        $data = array(
            'val_1' => $opt->val_1, // slogan value
        );
        $this->tableGateway->update($data, array('name'=>'video'));
    }
    
    //->
    public function insertSlider(Options $opt)
    {
        $data = array(
            'name' => 'slide',
            'val_1' => $opt->val_1, // file location
            'val_2' => $opt->val_2, // title
            'val_3' => $opt->val_3, // description
            'val_4' => $opt->val_4, // link
            'val_5' => $opt->val_5, // order
        );
    
        $this->tableGateway->insert($data);
    }
    
    public function fetchAllSlides()
    {
        $resultSet = $this->tableGateway->select(array('name'=>'slide'));
        return $resultSet;
    }
    
    public function deleteSlides(Options $opt)
    {   
        $data = array(
            'id' => $opt->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    public function fetchSlider($id)
    {
        $resultSet = $this->tableGateway->select(array('id'=>$id));
        return $resultSet->current();
    }
    
    public function updateSlide(Options $opt)
    {
        $data = array(
            'val_2' => $opt->val_2, // title
            'val_3' => $opt->val_3, // description
            'val_4' => $opt->val_4, // link
            'val_5' => $opt->val_5, // order
        );
        $this->tableGateway->update($data, array('id'=>$opt->id));
    }
    
    /*
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select();
    	return $resultSet;
    }
    
    public function fetch($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet->current();
    }
    
    public function fetchAllBy($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet;
    }
    
    public function save(Category $cat)
    {
    	$data = array(
    			'name' => $cat->name,
    			'slug' => $cat->slug,
    			'parent' => $cat->parent,
    	);
    
    	$this->tableGateway->insert($data);
    }
    
    public function update(Category $cat)
    {
    	$data = array(
    	        'name' => $cat->name,
    			'slug' => $cat->slug,
    			'parent' => $cat->parent,
    	);
    
    	$this->tableGateway->update($data, array('category_id'=>$cat->category_id));
    }
    
    public function delete(Category $del)
    {
    	$data = array(
	       'category_id' => $del->category_id
    	);
    
    	$this->tableGateway->delete($data);
    }
    */
}