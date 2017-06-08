<?php
namespace Register\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\Adapter;

class RegisterForm extends Form
{	
    public function __construct($name = null)
    {
    	parent::__construct('registration');
    	$this->setAttribute('method', 'post');
        
    	$this->add(array(
    			'name' => 'usr_name',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Your Name',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'usr_last_name',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Last Name',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'usr_ref',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Refer by',
    			),
    	));
    	
    	
    	$this->add(array(
    			'name' => 'usr_email',
    			'attributes' => array(
    					'type'  => 'email',
    			),
    			'options' => array(
    					'label' => 'E-mail*',
    			),
    	));
    
    	$this->add(array(
    			'name' => 'usr_password',
    			'attributes' => array(
    					'type'  => 'password',
    			),
    			'options' => array(
    					'label' => 'Password*',
    			),
    	));
    
    	$this->add(array(
    			'name' => 'usr_password_confirm',
    			'attributes' => array(
    					'type'  => 'password',
    			),
    			'options' => array(
    					'label' => 'Confirm Password*',
    			),
    	));
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Captcha',
    			'name' => 'captcha',
    			'options' => array(
    					'label' => 'Please verify you are human*',
    					'captcha' => new \Zend\Captcha\Image(array('ImgDir' => './public/images/captcha', 'ImgUrl' => 'images/captcha', 'font' => './data/font/arial.ttf','width' => 200,'height' => 100, 'dotNoiseLevel' => 40, 'lineNoiseLevel' => 3,'id' => 'register-captcha')),
    			),
    	));
    
    	$this->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Go',
    					'id' => 'submitbutton',
    			),
    	));
    }
}