<?php
namespace Application\Form;

use Zend\Form\Form;

class PostsForm extends Form
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
            'name' => 'feat_image',
            'attributes' => array(
                'type'  => 'textarea',
                'id' => 'redactor_content2'
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
            'name' => 'type',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    "page"=>"Page",
                    "disclaimer"=>"Disclaimer",
                    "post"=>"Blog"
                ),
            ),
            'attributes' => array(
                'id' => 'type'
            )
        ));
        
        // publish time        
        $this->add(array(
        		'name' => 'mm',
        		'type' => 'select',
        		'options' => array(
        				'value_options' => array(
        						"01"=>"01-Jan",
        						"02"=>"02-Feb",
        						"03"=>"03-Mar",
        						"04"=>"04-Apr",
        						"05"=>"05-May",
        						"06"=>"06-Jun",
        						"07"=>"07-Jul",
        						"08"=>"08-Aug",
        						"09"=>"09-Sep",
        						"10"=>"10-Oct",
        						"11"=>"11-Nov",
        						"12"=>"12-Dec"
        				),
        		),
        		'attributes' => array(
        				'value' => date("m"), // Set default value
        				'id' => 'mm'
        		)
        ));
        
        $this->add(array(
        		'name' => 'jj',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'jj',
        				'value' => date("d"),
        		),
        ));
        
        $this->add(array(
        		'name' => 'aa',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'aa',
        				'value' => date("Y"),
        		),
        ));
        
        $this->add(array(
        		'name' => 'hh',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'hh',
        				'value' => date("h"),
        		),
        ));
        
        $this->add(array(
        		'name' => 'mn',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'mn',
        				'value' => date("i"),
        		),
        ));
        
        // category
        $this->add(array(
        		'name' => 'cb',
        		'attributes' => array(
        				'type'  => 'checkbox',
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