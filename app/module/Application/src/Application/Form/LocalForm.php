<?php
namespace Application\Form;

use Zend\Form\Form;

class LocalForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method','post');
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'name' => 'bus_name',
            'attributes' => array(
                'type'  => 'text', 
                'class'   => 'input-lg form-control',
                'placeholder' => 'Business Name',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
        ));
		
        $this->add(array(
            'name' => 'zip',
            'attributes' => array(
                'type'  => 'text',
                'class'   => 'input-sm form-control',
                'placeholder' => 'Zip Code',
                'autocomplete' => 'off'
            ),
        ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Check my Listing',
                'class'   => 'btn'
            ),
        )); 
    }
}