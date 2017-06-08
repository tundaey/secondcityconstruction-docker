<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway

class Products implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $price;
    public $qty;
    public $description;
    public $image;
    public $type;
    public $position;
    public $variation;
    public $tax;
    
    public function exchangeArray($data) 
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->price = (!empty($data['price'])) ? $data['price'] : null;
        $this->qty = (!empty($data['qty'])) ? $data['qty'] : 0;
        $this->description = (!empty($data['description'])) ? $data['description'] : null;
        $this->image = (!empty($data['image'])) ? $data['image'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->position = (!empty($data['position'])) ? $data['position'] : null;
        $this->variation = (!empty($data['variation'])) ? $data['variation'] : null;
        $this->tax = (!empty($data['tax'])) ? $data['tax'] : 0;
    }	

	// Extraction. The Registration from the tutorial works even without it.
	// The standard Hydrator of the Form expects getArrayCopy to be able to bind
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}