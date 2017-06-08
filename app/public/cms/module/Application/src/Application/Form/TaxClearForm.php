<?php
namespace Application\Form;

use Zend\Form\Form;

class TaxClearForm extends Form 
{
    public function __construct($tax)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Clear Tax: $'.$tax,
                'class' => 'button-primary'
            ),
        )); 
    }
}