<?php
namespace Application\Form;

use Zend\Form\Form;

class GalleryCategoryAddForm extends Form
{
    public function __construct($c)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'slug',
            'attributes' => array(
                'type'  => 'text',
                'autocomplete' => 'off',
            ),
            'options' => array(
                'label' => 'Slug',
            ),
        ));
        
        if($c->count() > 0) :
            $cat['0'] = 'New Category';
            foreach ($c as $cc) :
                $cat[$cc->category_id] = $cc->name;
            endforeach;
        else :
            $cat[0] = 'New Category';
        endif;
            
        $this->add(array(
            'name' => 'parent',
            'type' => 'select',
            'options' => array(
                'label' => 'Parent',
                'value_options' => $cat,
            ),
        ));
        
        $this->add(array(
            'name' => 'position',
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
                'value' => 'Add New Category',
                'class' => 'button-primary'
            ),
        )); 
    }
}