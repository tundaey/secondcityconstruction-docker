<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class GalleryCategoryTable
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
    
    public function fetch($key, $value)
    {
    	$resultSet = $this->tableGateway->select(array($key=>$value));
    	return $resultSet->current();
    }
    
    public function fetchAllBy($key, $value)
    {
        $rowset = $this->tableGateway->select(function (Select $select) use ($key, $value) {
            
            if(is_numeric($value)) : 
                $select->where->equalTo($key, $value);
            else :
                if($value == '>') : 
                    $select->where->greaterThan($key, 0);
                else :
                    $select->where->lessThan($key, 0);
                endif;
            endif;
            $select->order('position ASC');
        });
        
        return  $rowset;
    }
    
    public function save(GalleryCategory $cat)
    {
    	$data = array(
    			'name' => $cat->name,
    			'slug' => $cat->slug,
    			'parent' => $cat->parent,
    	        'position' => $cat->position,
    	);
    	
    	$this->tableGateway->insert($data);
    }
    
    public function delete(GalleryCategory $del)
    {
    	$data = array(
	       'category_id' => $del->category_id
    	);
    
    	$this->tableGateway->delete($data);
    }
    
    public function update(GalleryCategory $cat)
    {   
        if(isset($cat->image['name']) && $cat->image['name'] != '' || isset($cat->image) && !is_array($cat->image) &&$cat->image != '') :

        	$data = array(
        	        'name' => $cat->name,
        			'slug' => $cat->slug,
        			'parent' => $cat->parent,
            	    'image' => $cat->image,
            	    'description' => $cat->description,
        	        'position' => $cat->position,
        	);
        else :
            $data = array(
                'name' => $cat->name,
                'slug' => $cat->slug,
                'parent' => $cat->parent,
                'description' => $cat->description,
                'position' => $cat->position,
            );
        endif;
        
    	$this->tableGateway->update($data, array('category_id'=>$cat->category_id));
    }
    
}