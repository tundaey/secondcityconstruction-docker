<?php
namespace Application\Form;

use Zend\Form\Form;

class BannersAddForm extends Form
{
    public function __construct($posts)
    {
        parent::__construct('form');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'source',
            'attributes' => array( 
                'type'  => 'textarea',
                'class' => 'title excerpt'
            ),
            'options' => array(
                'label' => 'Banner Code',
            ),
        ));
        
        foreach ($posts as $post) :
            $p[$post['uri']] = $post['title'];
        endforeach;
                
        $this->add(array(
            'name' => 'position',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    'category' => array('label'=>'Category',
                        'options' => array('home' => 'Home Page', 'blog-category' => 'Blog Category')),
                    'posts' => array('label' => 'Posts',
                        'options' => $p)),
                'label' => 'Position',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Banner',
                'class' => 'button-primary'
            ),
        )); 
    }
}