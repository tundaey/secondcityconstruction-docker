<?php
namespace Application\Form;

use Zend\Form\Form;

class PostsEditForm extends Form
{
    public function __construct($v,$u)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
        		'name' => 'post_id',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => $v->post_id,
        		),
        ));
        
        if($u->usr_id == 21) :
            $this->add(array(
            		'name' => 'uri',
            		'attributes' => array(
        				'type'  => 'text',
            		    'autocomplete' => 'off',
            		    'class' => 'uri',
        				'value' => $v->uri,
            		),
            ));
        else :
            if($v->rights == 1) : // readonly if post is protected
                $this->add(array(
                    'name' => 'uri',
                    'attributes' => array(
                        'type'  => 'text',
                        'autocomplete' => 'off',
                        'class' => 'uri',
                        'value' => $v->uri,
                        'readonly' => 'readonly'
                    ),
                ));
            else :            
                $this->add(array(
                    'name' => 'uri',
                    'attributes' => array(
                        'type'  => 'text',
                        'autocomplete' => 'off',
                        'class' => 'uri',
                        'value' => $v->uri
                    ),
                ));
            endif; // rights
        endif; // usr
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'title',
                'id' => 'title',
                'value' => $v->title, 
            ),
        ));
        
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'type'  => 'textarea',
                'id' => 'redactor_content',
                'value' => $v->content,
            ),
        ));
        
        $img = ($v->feat_image != NULL)?  '<img src="'.$v->feat_image.'" />' : '';
        
        $this->add(array(
            'name' => 'feat_image',
            'attributes' => array(
                'type'  => 'textarea',
                'id' => 'redactor_content2',
                'value' => $img,
            ),
        ));
        
        $this->add(array(
        		'name' => 'keyword',
        		'attributes' => array(
        			'type'  => 'text',
        		    'autocomplete' => 'off',
        		    'class' => 'title keyword',
        		    'value' => $v->keyword,
        		),
        ));
        
        $this->add(array(
            'name' => 'rights',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $v->rights,
            ),
        ));
        
        if($u->usr_id == 21) :
            $this->add(array(
                'name' => 'rights',
                'type' => 'select',
                'options' => array(
                    'value_options' => array(
                        "0"=> "Protect : Off",
                        "1"=>"Protect : On"
                    ),
                ),
                'attributes' => array(
                    'value' => $v->rights,
                )
            ));
        else :
            $this->add(array(
                'name' => 'rights',
                'attributes' => array(
                    'type'  => 'hidden',
                    'value' => $v->rights
                ),
            ));
        endif;
        
        $this->add(array(
        		'name' => 'excerpt',
        		'attributes' => array(
        			'type'  => 'textarea',
        			'class' => 'title excerpt',
        		    'value' => $v->excerpt,
        		    'id' => 'excerpt',
        
        		),
        ));
        
        $this->add(array(
        		'name' => 'status',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => $v->status,
        				'id' => 'draft',
        		),
        ));
        
        $this->add(array(
        		'name' => 'parent',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => $v->post_id,
        		),
        ));
        
        $date = new \DateTime();
        
        $this->add(array(
        		'name' => 'date',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => $date->format('Y-m-d H:i:s'),
        		),
        ));
        
        $types = array('page'=>'Page','disclaimer'=>'Disclaimer','post'=>'Blog');
        
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
                'value' => $v->type, // Set default value
                'id' => 'type'
            )
        ));
        
        /*
        $this->add(array(
        		'name' => 'mm',
        		'type' => 'select',
        ));
        */
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
        				'value' => date("m", strtotime($v->date)), // Set default value
        				'id' => 'mm'
        		)
        ));
        
        // date
        $this->add(array(
        		'name' => 'jj',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'jj',
        				'value' => date("d", strtotime($v->date)),
        		),
        ));
        
        $this->add(array(
        		'name' => 'aa',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'aa',
        				'value' => date("Y", strtotime($v->date)),
        		),
        ));
        
        $this->add(array(
        		'name' => 'hh',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'hh',
        				'value' => date("h", strtotime($v->date)),
        		),
        ));
        
        $this->add(array(
        		'name' => 'mn',
        		'attributes' => array(
        				'type'  => 'text',
        				'autocomplete' => 'off',
        				'id' => 'mn',
        				'value' => date("i", strtotime($v->date)),
        		),
        ));
        
        // category
        $this->add(array(
        		'name' => 'cb',
        		'attributes' => array(
        				'type'  => 'checkbox',
        		),
        ));
        
        // set button for submit
        if($v->status == 'draft') :
            $this->add(array(
                'name' => 'submit',
                'attributes' => array(
                    'type'  => 'submit',
                    'value' => 'Publish',
                    'class' => 'button-primary',
                    'id' => 'publish'
                ),
            ));
         else :
             $this->add(array(
             		'name' => 'submit',
             		'attributes' => array(
             				'type'  => 'submit',
             				'value' => 'Update',
             				'class' => 'button-primary',
             				'id' => 'publish'
             		),
             ));
       endif;
    }
}