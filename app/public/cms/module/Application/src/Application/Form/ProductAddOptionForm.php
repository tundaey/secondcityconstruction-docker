<?php
namespace Application\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

use Zend\Http\PhpEnvironment\Request;
use Zend\Filter;
use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;
use Zend\Validator;

class ProductAddOptionForm extends Form
{
    public function __construct()
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array( // product name
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Product Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'qty', 
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Quantity',
            ),
        ));
        
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Price',
            ),
        ));
        
        $this->add(array(
            'name' => 'position', // cart postition
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Position',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Option',
                'class' => 'button-primary'
            ),
        )); 
    }
}