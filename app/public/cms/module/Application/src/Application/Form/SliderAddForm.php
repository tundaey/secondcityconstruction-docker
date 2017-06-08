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

class SliderAddForm extends Form
{
    public function __construct($config)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->addElements();
        $this->addInputFilter($config);
        
        $this->add(array( // val_2 = title
            'name' => 'val_2',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'val_3', // val_3 description
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
        
        $this->add(array(
            'name' => 'val_4', // val_4 link location
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Link',
            ),
        ));
        
        $this->add(array(
            'name' => 'val_5', // val_5 order
            'attributes' => array(
                'type'  => 'text',
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
                'value' => 'Add New Category',
                'class' => 'button-primary'
            ),
        )); 
    }
    
    public function addElements()
    {
        // File Input
        $file = new Element\File('val_1'); // val_1
        $file->setAttribute('class', 'custom-file-input');
        $this->add($file);
    }
    
    public function addInputFilter($config)
    {   
        $inputFilter = new InputFilter\InputFilter();
    
        // File Input
        $fileInput = new InputFilter\FileInput('val_1');
        $fileInput->setRequired(true);
    
        $fileInput->getValidatorChain()
        ->attachByName('filesize',      array('max' => 1048000))
        ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpeg,image/gif'))
        ->attachByName('fileimagesize', array('maxWidth' => 2000, 'maxHeight' => 2000));
    
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => './public/media/'.$config['website']['media'].'/slider',
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);
    
        $this->setInputFilter($inputFilter);
    }
    
}