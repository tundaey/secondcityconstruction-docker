<?php
namespace Application\Form;

use Zend\Form\Form;

class PostsDeleteForm extends Form
{
    public function __construct($option)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'cb',
            'attributes' => array(
                'type'  => 'checkbox',
            ),
            'options' => array(
                'label' => 'Slug',
            ),
        ));
        
        $this->add(array(
        		'name' => 'bulk_action',
        		'attributes' => array(
        			'type'  => 'hidden',
        		    'value' => '0',
        		    'id' => 'bulk_action',
        		),
        ));
        
        if($option=='trash') : // all post / trash
	        $this->add(array(
	        		'name' => 'bulk_actions',
	        		'type' => 'select',
	        		'options' => array(
	        		        'disable_inarray_validator' => true,
	        				'value_options' => array(
	        						'0' => 'Bulk Actions',
	        						'2' => 'Restore',
	        						'3' => 'Delete Permanently',
	        				),
	        		),
    	            'attributes' => array(
    	            		'class' => 'bulk_actions',
    	            ),
	        ));
        else :        
	        $this->add(array(
	        		'name' => 'bulk_actions',
	        		'type' => 'select',
	        		'options' => array(
	        				'value_options' => array(
	        						'0' => 'Bulk Actions',
	        						'1' => 'Trash',
	        				),
	        		),
	               'attributes' => array(
	                   'class' => 'bulk_actions',
	               ),
	        ));
	    endif;
       
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Apply',
                'class' => 'button-secondary'
            ),
        ));
        
    }
}