<?php
namespace Application\Form;

use Zend\Form\Form;

class ProductPromoDeleteForm extends Form
{
    public function __construct()
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
        
        $this->add(array(
        		'name' => 'bulk_actions',
        		'type' => 'select',
        		'options' => array(
        				'value_options' => array(
        						'0' => 'Bulk Actions',
        						'1' => 'Delete',
        				),
        		),
                'attributes' => array(
                		'class' => 'bulk_actions',
                ),
        ));
        
       
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