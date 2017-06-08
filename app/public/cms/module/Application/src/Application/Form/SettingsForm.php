<?php
namespace Application\Form;

use Zend\Form\Form;

class SettingsForm extends Form 
{
    public function __construct($options)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        foreach ($options as $option) :
            if($option->name == 'settings') :
                $site_title = $option->val_1;
                $site_keyword = $option->val_2;
                $site_description = $option->val_3;
            elseif($option->name == 'video') :
                $video = $option->val_1;
            endif;
        endforeach;
         
        $this->add(array(
            'name' => 'site_title',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $site_title,
            ),
        ));
        
        $this->add(array(
            'name' => 'site_keyword',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $site_keyword,
            ),
        ));
        
        $this->add(array(
            'name' => 'site_description',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $site_description,
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