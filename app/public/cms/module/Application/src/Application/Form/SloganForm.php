<?php
namespace Application\Form;

use Zend\Form\Form;

class SloganForm extends Form
{
    public function __construct($options)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        foreach ($options as $option) :
            if($option->name == 'slogan') :
                $slogan = $option->val_1;
            elseif($option->name == 'video') :
                $video = $option->val_1;
            endif;
        endforeach;
        
        $this->add(array(
            'name' => 'slogan',
            'attributes' => array(
                'type'  => 'textarea',
                'value' => $slogan
            ),
        ));
        
        $this->add(array(
            'name' => 'video',
            'attributes' => array(
                'type'  => 'textarea',
                'value' => $video
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