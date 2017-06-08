<?php
namespace Application\Form;

use Zend\Form\Form;

class DeliveryTimeForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'start',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'start width_150',
            ),
            'options' => array(
                'label' => 'From:',
            ),
        ));
        
        $this->add(array(
            'name' => 'end',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'end width_150',
            ),
            'options' => array(
                'label' => 'To:',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Time',
                'class' => 'button-primary button_inline'
            ),
        ));
        
    }
}