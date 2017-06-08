<?php
namespace Application\Form;

use Zend\Form\Form;

class ProductPromoAddForm extends Form
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
            'name' => 'percent',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'title',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Percent',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Promo',
                'class' => 'button-primary'
            ),
        )); 
    }
}