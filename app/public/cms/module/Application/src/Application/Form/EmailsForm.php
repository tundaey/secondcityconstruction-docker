<?php
namespace Application\Form;

use Zend\Form\Form;

class EmailsForm extends Form 
{
    public function __construct($options)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        foreach ($options as $option) :
            if($option->name == 'emails') :
                $email_1 = $option->val_1;
            endif;
        endforeach;
         
        $this->add(array(
            'name' => 'email_1',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $email_1,
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Update',
                'class' => 'button-primary'
            ),
        )); 
    }
}