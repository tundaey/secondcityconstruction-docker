<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class DeliveryDisableDayFilter extends InputFilter
{
public function __construct()
{		
        $this->add(array(
        		'name'     => 'day',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
        ));
	}
}