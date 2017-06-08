<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class VideosAddFilter extends InputFilter
{
public function __construct()
{		
    $this->add(array(
        'name'     => 'title',
        'required' => true,
        'validators' => array(
            array(
                'name'    => 'StringLength',
                'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 0,
                    'max'      => 200,
                ),
            ),
        ),
    ));
    
        $this->add(array(
        		'name'     => 'script',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 200,
                        ),
                    ), 
                ),
        ));
	}
}