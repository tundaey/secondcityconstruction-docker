<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
// the object will be hydrated by Zend\Db\TableGateway\TableGateway

class Analitics implements InputFilterAwareInterface
{
    public $id;
    public $page;
    public $date;
    public $time;
    public $ip;
    public $country;
    public $city;
    public $query_string;
    public $http_referer;
    public $http_user_agent;
    public $isbot;
    public $latitude;
    public $longitude;
    public $state;
    public $screen_resolution;
    
    public $code_name;
    public $browser_name;
    public $browser_version;
    public $cookies_enabled;
    public $browser_language;
    public $platform;
    
    public $views; // for count
    
    public function exchangeArray($data) 
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->page     = (!empty($data['page'])) ? $data['page'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
        $this->time = (!empty($data['time'])) ? $data['time'] : null;
        $this->ip = (!empty($data['ip'])) ? $data['ip'] : null;
        $this->country = (!empty($data['country'])) ? $data['country'] : null;
        $this->city = (!empty($data['city'])) ? $data['city'] : null;
        $this->query_string = (!empty($data['query_string'])) ? $data['query_string'] : null;
        $this->http_referer = (!empty($data['http_referer'])) ? $data['http_referer'] : null;
        $this->http_user_agent = (!empty($data['http_user_agent'])) ? $data['http_user_agent'] : null;
        $this->longitude = (!empty($data['longitude'])) ? $data['longitude'] : null;
        $this->latitude = (!empty($data['latitude'])) ? $data['latitude'] : null;
        $this->state = (!empty($data['state'])) ? $data['state'] : null;
        $this->screen_resolution = (!empty($data['screen_resolution'])) ? $data['screen_resolution'] : null;
        $this->browser_version = (!empty($data['browser_version'])) ? $data['browser_version'] : null;
        $this->browser_language = (!empty($data['browser_language'])) ? $data['browser_language'] : null;
        
        $this->views = (!empty($data['views'])) ? $data['views'] : null;
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
                'name'     => 'ip',
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