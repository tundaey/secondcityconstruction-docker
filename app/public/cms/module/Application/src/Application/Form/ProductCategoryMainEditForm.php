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

class ProductCategoryMainEditForm extends Form
{
    public function __construct($cat,$cats, $config)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');
        
        $this->addElements();
        //$this->addInputFilter($config);
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $cat->name,
            ),
            
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'textarea',
                'autocomplete' => 'off',
                'value' => $cat->description,
            ),
        
        ));
        
        $this->add(array(
            'name' => 'slug',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $cat->slug,
            ),
        ));
        
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $cat->position,
            ),
        ));
        
        $this->add(array(
        		'name' => 'category_id',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => $cat->category_id,
        		),
        
        ));
        
        foreach ($cats as $c) :
            if($c->parent == 0) : 
                $vo[$c->category_id] = $c->name;
            endif;
        endforeach;
        
        $this->add(array(
        		'name' => 'parent',
        		'type' => 'select',
        		'options' => array(
        				'value_options' => $vo, /*array(
        				        /*
        						 '1' => 'Article',
        						'2' => 'News',
        				        '22' => 'Recipes',
        				), */
        		      'disable_inarray_validator' => true,
        		),
            'attributes' => array(
            		'value' => $cat->parent, // Set default value
            )
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