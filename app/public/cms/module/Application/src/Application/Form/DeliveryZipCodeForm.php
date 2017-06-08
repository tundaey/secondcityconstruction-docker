<?php
namespace Application\Form;

use Zend\Form\Form;

class DeliveryZipCodeForm extends Form 
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
         
        $this->add(array(
            'name' => 'zip_code',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'class' => 'width_150',
            ),
            'options' => array(
                'label' => 'Zip Code: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Zip Code',
                'class' => 'button-primary button_inline'
            ),
        )); 
    }
}