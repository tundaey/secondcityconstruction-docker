<?php
namespace Application\Form;

use Zend\Form\Form;

class VideosAddForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'title'
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'script',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'title excerpt'
            ),
            'options' => array(
                'label' => 'Video',
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