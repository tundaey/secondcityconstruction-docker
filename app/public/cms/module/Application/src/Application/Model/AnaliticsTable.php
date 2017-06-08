<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\ShareFunctions;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class AnaliticsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
     
    public function fetchPageViews()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) 
        {   
            $select->columns(array('date', 'views' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            $select->group('date');
            $select->limit(30);
            $select->order('date DESC');
        });
        return $resultSet;
    }
    
    public function fetchUsers()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array('date', 'views' => new \Zend\Db\Sql\Expression('COUNT(DISTINCT ip)')));
            $select->group(array('date'));
            $select->order('date DESC');
            $select->limit(30);
        });
        return $resultSet;
    }
    
    public function fetchTopPages()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array('page', 'views' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            $select->group(array('page'));
            $select->order('views DESC');
            $select->limit(20);
        });
        return $resultSet;
    }
    
    public function fetchTopLanguage()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array('browser_language', 'views' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            $select->group(array('browser_language'));
            $select->order('views DESC');
            $select->limit(21);
        });
        return $resultSet;
    }
    
    public function fetchTopScreenResolution()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array('screen_resolution', 'views' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            $select->group(array('screen_resolution'));
            $select->order('views DESC');
            $select->limit(20);
        });
        return $resultSet;
    }
    
    public function fetchTopLocation()
    {
        $resultSet = $this->tableGateway->select(function (Select $select)
        {
            $select->columns(array('city', 'state', 'views' => new \Zend\Db\Sql\Expression('COUNT(*)')));
            $select->group(array('city'));
            $select->order('views DESC');
            $select->limit(21);
        });
        return $resultSet;
    }
    
    /*
        
    public function insert(Links $link)
    {
        $data = array(
            'name' => $link->name,
            'link' => $link->link,
            'date' => $link->date,
        );
        $this->tableGateway->insert($data);
    }
    
    public function delete(Links $del)
    {
        $data = array(
            'id' => $del->id
        );
    
        $this->tableGateway->delete($data);
    }
    
    
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