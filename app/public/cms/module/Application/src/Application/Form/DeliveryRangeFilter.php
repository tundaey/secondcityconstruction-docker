<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class DeliveryRangeFilter extends InputFilter
{
public function __construct()
{		
        $this->add(array(
        		'name'     => 'from',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
        ));
        
        $this->add(array(
            'name'     => 'to',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
	}
}