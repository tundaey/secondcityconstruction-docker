<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class BannersAddFilter extends InputFilter
{
public function __construct()
{		
        $this->add(array(
        		'name'     => 'source',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ), 
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 0, 
                            'max'      => 21000,
                        ),
                    ),
                ),
        ));
	}
}