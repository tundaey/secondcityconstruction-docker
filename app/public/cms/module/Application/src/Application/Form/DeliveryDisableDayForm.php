<?php
namespace Application\Form;

use Zend\Form\Form;

class DeliveryDisableDayForm extends Form
{
    public function __construct($cc)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        

        foreach ($cc as $c) :
            $cat[$c] = $c;
        endforeach;
            
        
        $this->add(array(
            'name' => 'day',
            'type' => 'select',
            'options' => array(
                'label' => 'Remove Day',
                'value_options' => $cat,
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
                'value' => 'Remove Day',
                'class' => 'button-primary button_inline'
            ),
        ));
        
    }
}