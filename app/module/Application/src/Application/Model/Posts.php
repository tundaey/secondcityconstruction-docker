<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway

class Posts implements InputFilterAwareInterface
{
    public $post_id;
    public $parent;
    public $author;
    public $date;
    public $content;
    public $title;
    public $uri;
    public $keyword;
    public $excerpt;
    public $feat_image;
    public $modified;
    public $type;
    public $status;
    public $trash;
    
    public $cb;
    public $count;
    
    public function exchangeArray($data) 
    {
        $this->post_id     = (!empty($data['post_id'])) ? $data['post_id'] : null;
        $this->parent     = (!empty($data['parent'])) ? $data['parent'] : null;
        $this->author = (!empty($data['author'])) ? $data['author'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
        $this->content = (!empty($data['content'])) ? $data['content'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->uri = (!empty($data['uri'])) ? $data['uri'] : null;
        $this->keyword = (!empty($data['keyword'])) ? $data['keyword'] : null;
        $this->excerpt = (!empty($data['excerpt'])) ? $data['excerpt'] : null;
        $this->feat_image = (!empty($data['feat_image'])) ? $data['feat_image'] : null;
        $this->modified = (!empty($data['modified'])) ? $data['modified'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->trash = (!empty($data['trash'])) ? $data['trash'] : null;
        
        $this->cb = (!empty($data['cb'])) ? $data['cb'] : null;
        $this->count = (!empty($data['count'])) ? $data['count'] : null;
    }	

	// Extraction. The Registration from the tutorial works even without it.
	// The standard Hydrator of the Form expects getArrayCopy to be able to bind
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'author',
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}