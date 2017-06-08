<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway

class Users implements InputFilterAwareInterface
{
    public $usr_id;
    public $usr_name;
    public $usr_last_name;
    public $usr_email;
    public $usr_email_confirmed;
    public $usr_url;    
    public $usr_active;
    public $usr_password_salt;
    public $usr_password;
    public $usr_registration_date;
    public $usr_registration_token;
    public $usr_ref;
    public $usr_ip;
    public $usr_device;
    
    public function exchangeArray($data) 
    {
        $this->usr_id     = (!empty($data['usr_id'])) ? $data['usr_id'] : null;
        $this->usr_name = (!empty($data['usr_name'])) ? $data['usr_name'] : null;
        $this->usr_last_name = (!empty($data['usr_last_name'])) ? $data['usr_last_name'] : null;
        $this->usr_email = (!empty($data['usr_email'])) ? $data['usr_email'] : null;
        $this->usr_email_confirmed = (isset($data['usr_email_confirmed'])) ? $data['usr_email_confirmed'] : null;
        $this->usr_url = (isset($data['usr_url'])) ? $data['usr_url'] : null;
        $this->usr_active = (isset($data['usr_active'])) ? $data['usr_active'] : null;
        $this->usr_password_salt = (!empty($data['usr_password_salt'])) ? $data['usr_password_salt'] : null;        
        $this->usr_password = (!empty($data['usr_password'])) ? $data['usr_password'] : null;
        $this->usr_registration_date = (!empty($data['usr_registration_date'])) ? $data['usr_registration_date'] : null;
        $this->usr_registration_token = (!empty($data['usr_registration_token'])) ? $data['usr_registration_token'] : null;
        $this->usr_ref = (!empty($data['usr_ref'])) ? $data['usr_ref'] : null;
        $this->usr_ip = (isset($data['usr_ip'])) ? $data['usr_ip'] : null;
        $this->usr_device = (isset($data['usr_device'])) ? $data['usr_device'] : null;
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
                'name'     => 'usr_email',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_password',
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
                            'max'      => 16,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }	
}