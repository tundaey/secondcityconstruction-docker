<?php
namespace Application\Form;

use Zend\Form\Form;

class CommentsForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('comments');
        $this->setAttribute('method','post');
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text', 
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Name'
            )
        ));
		
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'email',
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'website',
            'attributes' => array(
                'type'  => 'text',
                'class'   => 'input-300 form-control',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Website'
            )
        ));
        
        $this->add(array(
            'name' => 'message',
            'attributes' => array(
                'type'  => 'textarea',
                'class'   => 'input-300 form-control form-control-textarea',
                'placeholder' => '',
                'autocomplete' => 'off',
                'spellcheck' => 'false'
            ),
            'options' => array(
                'label' => 'Message',
                'label_attributes' => array(
                    'class'  => 'textarea-lable-blog'
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