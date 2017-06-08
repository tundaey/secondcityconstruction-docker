<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class ProductCategoryEditFilter extends InputFilter
{
public function __construct($sm,$cat,$post)
{		
        $this->add(array(
        		'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 200,
                        ),
                    ),
                    array(
                    		'name' =>'NotEmpty',
                    		'options' => array(
                    				'messages' => array(
                    						\Zend\Validator\NotEmpty::IS_EMPTY => 'Please enter Category Name!'
                    				),
                    		),
                    ),
                    
                ),
        ));
        
        if($cat->slug !== $post) :
            $this->add(array(
            		'name'     => 'slug',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            		    array(
            		    		'name' =>'NotEmpty',
            		    		'options' => array(
            		    				'messages' => array(
            		    						\Zend\Validator\NotEmpty::IS_EMPTY => 'Please enter Slug!'
            		    				),
            		    		),
            		    ),
            		    array(
            						'name'    => 'StringLength',
            						'options' => array(
            								'encoding' => 'UTF-8',
            								'min'      => 0,
            								'max'      => 200,
            						),
            				),
            		    array(
            		    		'name' => 'Regex',
            		    		'options' => array(
            		    				'pattern' => '/^[0-9a-z-_]+$/',
            		    				'messages' => array('regexNotMatch'=>'Invalid input, only a-z 0-9 - _ characters allowed. No empty spaces between characters.'),
            		    		),
            		    ),
            		    array(
            		    		'name'		=> 'Zend\Validator\Db\NoRecordExists',
            		    		'options' => array(
            		    				'table'   => 'product_category',
            		    				'field'   => 'slug',
            		    				'adapter' => $sm,
                		    		    'messages' => array(
                		    		    		\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'The specified slug already exists.'
                		    		    ),
            		    		),
                		        
            		    ),
            		),
            ));
        endif;
	}
}