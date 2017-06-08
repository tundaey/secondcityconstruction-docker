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

class GalleryAddForm extends Form
{
    public function __construct($config, $root_cat, $cats)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->addElements();
        $this->addInputFilter($config);
        
        $this->add(array( // product name
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Image Title',
            ),
        ));
                 
        $this->add(array(
            'name' => 'description', // description
            'attributes' => array(
                'type'  => 'textarea',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Image Description',
            ),
        ));
        
        $this->add(array(
            'name' => 'position', // cart postition
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Image Position',
            ),
        ));
        
        if(count($cats)>0) :
            foreach ($cats as $ca) :
                $ct[] = $ca;
            endforeach;
        else :
            $ct = array();
        endif;
        
        $cat = array();
        if($root_cat->count() > 0) :
            foreach ($root_cat as $cc) : 
               $cat[$cc->category_id] = $cc->name;
                foreach ($ct as $c) :
                    if($cc->category_id == $c->parent) :
                        $cat[$c->category_id] = $cc->name.' > ' .$c->name;
                    endif;
                endforeach;
            endforeach;
        else :
            $cat[0] = 'No Categories';
        endif;
        
        $this->add(array(
            'name' => 'category_id',
            'type' => 'select',
            'options' => array(
                'label' => 'Parent',
                'value_options' => $cat,
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Picture',
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
        $fileInput->setRequired(true);
    
        $fileInput->getValidatorChain()
        ->attachByName('filesize',      array('max' => 1048000))
        ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpeg,image/gif'))
        ->attachByName('fileimagesize', array('maxWidth' => 2000, 'maxHeight' => 2000));
    
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => './public/media/'.$config['website']['media'].'/gallery',
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);
    
        $this->setInputFilter($inputFilter);
    }
    
}