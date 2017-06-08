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

class ProductVariationEditForm extends Form
{
    public function __construct($product)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $product->name,
            ),
        ));
        
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $product->price,
            ),
        ));
        
        $this->add(array(
            'name' => 'qty',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $product->qty,
            ),
        ));
        
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $product->position,
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