<?php
namespace Application\Form;

use Zend\Form\Form;

class ProductCategoryEditForm extends Form
{
    public function __construct($cat,$cats)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
                'value' => $cat->name,
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
}