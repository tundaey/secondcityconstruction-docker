<?php
namespace Application\Form;

use Zend\Form\Form;

class TalkForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method','post');
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'name' => 'cus_name',
            'attributes' => array(
                'type'  => 'text', 
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Full Name *'
            )
        ));
		
        $this->add(array(
            'name' => 'cus_email',
            'attributes' => array(
                'type'  => 'email',
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Email *'
            )
        ));
        
        $this->add(array(
            'name' => 'cus_phone',
            'attributes' => array(
                'type'  => 'text',
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Phone Number'
            )
        ));
        
        $this->add(array(
            'name' => 'cus_company',
            'attributes' => array(
                'type'  => 'text',
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Company'
            )
        ));
        
        $this->add(array(
            'name' => 'cus_msg',
            'attributes' => array(
                'type'  => 'textarea',
                'class'   => 'input-300 form-control form-control-textarea',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Describe Your Project In a Few Sentences ',
                'label_attributes' => array(
                    'class'  => 'textarea-lable-n'
                ),
            )
        ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => "Submit",
                'class'   => 'btn'
            ),
        )); 
    }
}