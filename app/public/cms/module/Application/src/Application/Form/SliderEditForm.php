<?php
namespace Application\Form;

use Zend\Form\Form;

class SliderEditForm extends Form
{
    public function __construct($slide)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'val_2',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $slide->val_2,
            ),
        ));
        
        $this->add(array(
            'name' => 'val_3',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $slide->val_3,
            ),
        ));
        
        $this->add(array(
            'name' => 'val_4',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $slide->val_4,
            ),
        ));
        
        $this->add(array(
            'name' => 'val_5',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $slide->val_5,
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