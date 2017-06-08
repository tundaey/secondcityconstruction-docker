<?php
namespace Application\Form;

use Zend\Form\Form;

class RevisionForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'title',
                'id' => 'title',
            ),
        ));
        
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'type'  => 'textarea',
                'id' => 'redactor_content'
                
            ),
        ));
        
        $this->add(array(
        		'name' => 'keyword',
        		'attributes' => array(
        			'type'  => 'text',
        		    'autocomplete' => 'off',
        		    'class' => 'title',
        		    'id' => 'keyword',
        		),
        ));
        
        $this->add(array(
        		'name' => 'excerpt',
        		'attributes' => array(
        			'type'  => 'textarea',
        			'class' => 'title excerpt',
        		    'id' => 'excerpt',
        		),
        ));
        
        $this->add(array(
        		'name' => 'status',
        		'attributes' => array(
        			'type'  => 'hidden',
        		    'value' => 'published',
        		    'id' => 'draft',
        		),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Publish',
                'class' => 'button-primary'
            ),
        )); 
    }
}