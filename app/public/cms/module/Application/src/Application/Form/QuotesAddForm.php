<?php
namespace Application\Form;

use Zend\Form\Form;

class QuotesAddForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'type'  => 'textarea',
                'class' => 'title excerpt'
            ),
            'options' => array(
                'label' => 'Quote',
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