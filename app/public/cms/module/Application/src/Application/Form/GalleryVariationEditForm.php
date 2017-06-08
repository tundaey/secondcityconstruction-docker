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

class GalleryVariationEditForm extends Form
{
    public function __construct($product)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $product->name,
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'textarea',
                'autocomplete' => 'off',
                'value' => $product->description,
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
    
    public function addElements()
    {
        // File Input
        $file = new Element\File('image'); // val_1
        $file->setAttribute('class', 'custom-file-input');
        $this->add($file);
    }
    
    public function addInputFilter($config)
    {
        $inputFilter = new InputFilter\InputFilter();
    
        // File Input
        $fileInput = new InputFilter\FileInput('image');
    
        $fileInput->getValidatorChain()
        ->attachByName('filesize',      array('max' => 1048000))
        ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpeg,image/gif'))
        ->attachByName('fileimagesize', array('maxWidth' => 2000, 'maxHeight' => 2000));
    
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => './public/media/'.$config['website']['media'].'/product',
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);
    
        $this->setInputFilter($inputFilter);
    }
}