<?php
namespace Application\Form;

use Zend\Form\Form;

class LinksAddForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'title',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'link',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'title',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Link',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Quote',
                'class' => 'button-primary'
            ),
        )); 
    }
}