<?php
namespace Application\Form;

use Zend\Form\Form;

class DeliveryDisableTimeForm extends Form
{
    public function __construct($cc)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        foreach ($cc as $c) :
            $cat['0'] = 'select day';
            $cat[$c] = $c;
        endforeach;
        
        $this->add(array(
            'name' => 'day',
            'type' => 'select',
            'attributes' => array(
                'class' => 'day',
            ),
            'options' => array(
                'label' => 'Remove Day',
                'value_options' => $cat,
            ),
        ));
        
        $this->add(array(
            'name' => 'time',
            'type' => 'select',
            'attributes' => array(
                'class' => 'time',
            ),
            'options' => array(
                'label' => 'Remove Hours',
                'value_options' => array(''=>'select day'),
                'disable_inarray_validator' => true,
            ),
        ));
        
        /*
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'from width_150',
            ),
            'options' => array(
                'label' => 'From:',
            ),
        ));
        */
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Remove Hour',
                'class' => 'button-primary button_inline'
            ),
        ));
        
    }
}