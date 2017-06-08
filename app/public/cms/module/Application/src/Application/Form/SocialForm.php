<?php
namespace Application\Form;

use Zend\Form\Form;

class SocialForm extends Form 
{
    public function __construct($options)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        foreach ($options as $option) :
            if($option->name == 'social') :
                $facebook = $option->val_1;
                $twitter = $option->val_2;
                $youtube = $option->val_3;
                $pintrest = $option->val_4;
            endif;
        endforeach;
         
        $this->add(array(
            'name' => 'facebook',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $facebook,
            ),
        ));
        
        $this->add(array(
            'name' => 'twitter',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $twitter,
            ),
        ));
        
        $this->add(array(
            'name' => 'youtube',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $youtube,
            ),
        ));
        
        $this->add(array(
            'name' => 'pintrest',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $pintrest,
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