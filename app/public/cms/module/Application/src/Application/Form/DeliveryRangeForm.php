<?php
namespace Application\Form;

use Zend\Form\Form;

class DeliveryRangeForm extends Form
{
    public function __construct($delivery_range)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'from',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'from width_150',
                'value' => $delivery_range->from,
            ),
            'options' => array(
                'label' => 'From:',
            ),
        ));
        
        $this->add(array(
            'name' => 'to',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'to width_150',
                'value' => $delivery_range->to,
            ),
            'options' => array(
                'label' => 'To:',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Update Range',
                'class' => 'button-primary button_inline'
            ),
        ));
        
    }
}