<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway

class Orders implements InputFilterAwareInterface
{
    public $id;
    public $fname;
    public $lname;
    public $email;
    public $phone;
    public $del_day;
    public $del_time;
    public $del_address;
    public $del_city;
    public $del_state;
    public $del_zip;
    public $del_instructions;
    public $rem_time;
    public $rem_day;
    public $rem_instruction;
    public $bil_address;
    public $bil_city;
    public $bil_state;
    public $bil_zip;
    public $order_items;
    public $order_tax;
    public $order_amount;
    public $order_promo;
    public $order_promo_percent;
    public $order_transaction_id;
    public $order_cc;
    public $date;
    
    public function exchangeArray($data) 
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->fname     = (!empty($data['fname'])) ? $data['fname'] : null;
        $this->lname     = (!empty($data['lname'])) ? $data['lname'] : null;
        $this->phone     = (!empty($data['phone'])) ? $data['phone'] : null;
        $this->email     = (!empty($data['email'])) ? $data['email'] : null;
        $this->del_day = (!empty($data['del_day'])) ? $data['del_day'] : null;
        $this->del_time = (!empty($data['del_time'])) ? $data['del_time'] : null;
        $this->del_address = (!empty($data['del_address'])) ? $data['del_address'] : null;
        $this->del_city = (!empty($data['del_city'])) ? $data['del_city'] : null;
        $this->del_state = (!empty($data['del_state'])) ? $data['del_state'] : null;
        $this->del_zip = (!empty($data['del_zip'])) ? $data['del_zip'] : null;
        $this->del_instructions = (!empty($data['del_instructions'])) ? $data['del_instructions'] : null;
        $this->rem_time     = (!empty($data['rem_time'])) ? $data['rem_time'] : null;
        $this->rem_day     = (!empty($data['rem_day'])) ? $data['rem_day'] : null;
        $this->rem_instruction     = (!empty($data['rem_instruction'])) ? $data['rem_instruction'] : null;
        $this->bil_address = (!empty($data['bil_address'])) ? $data['bil_address'] : null;
        $this->bil_city = (!empty($data['bil_city'])) ? $data['bil_city'] : null;
        $this->bil_state = (!empty($data['bil_state'])) ? $data['bil_state'] : null;
        $this->bil_zip = (!empty($data['bil_zip'])) ? $data['bil_zip'] : null;
        $this->order_items = (!empty($data['order_items'])) ? $data['order_items'] : null;
        $this->order_amount = (!empty($data['order_amount'])) ? $data['order_amount'] : null;
        $this->order_tax = (!empty($data['order_tax'])) ? $data['order_tax'] : null;
        $this->order_promo = (!empty($data['order_promo'])) ? $data['order_promo'] : null;
        $this->order_promo_percent = (!empty($data['order_promo_percent'])) ? $data['order_promo_percent'] : null;
        $this->order_transaction_id = (!empty($data['order_transaction_id'])) ? $data['order_transaction_id'] : 0;
        $this->order_cc = (!empty($data['order_cc'])) ? $data['order_cc'] : null;
        $this->date     = (!empty($data['date'])) ? $data['date'] : null;
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
                'name'     => 'zip_code',
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
                            'max'      => 10,
                        ),
                    ),
                ),
            )));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}