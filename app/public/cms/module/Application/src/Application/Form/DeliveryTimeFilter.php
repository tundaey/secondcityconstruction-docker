<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class DeliveryTimeFilter extends InputFilter
{
public function __construct()
{		
        $this->add(array(
        		'name'     => 'start',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
        ));
        
        $this->add(array(
            'name'     => 'end',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
	}
}