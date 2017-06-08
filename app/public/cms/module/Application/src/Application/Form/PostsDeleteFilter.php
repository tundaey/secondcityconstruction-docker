<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PostsDeleteFilter extends InputFilter
{
public function __construct()
{		
        $this->add(array(
        		'name'     => 'cb',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
        ));
        
	}
}