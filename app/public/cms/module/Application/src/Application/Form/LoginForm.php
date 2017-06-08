<?php
namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($email = null, $base)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'usr_email',
            'attributes' => array(
                'type'  => 'email',
                'value' => $email,
                'placeholder' => 'Enter your email'
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'password',
                'placeholder' => 'Enter your password'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
        		'type' => 'Zend\Form\Element\Captcha',
        		'name' => 'captcha',
        		'options' => array(
        				'label' => 'Please verify you are human*',
        				'captcha' => new \Zend\Captcha\Image(array('ImgDir' => './public/images/captcha', 'ImgUrl' => $base, 'font' => './data/font/arial.ttf','width' => 270, 'wordLen' => 4, 'height' => 85, 'dotNoiseLevel' => 40, 'lineNoiseLevel' => 3,'id' => 'register-captcha')),
        		),
                'attributes' => array(
                    'placeholder' => 'Enter text in image',
                    'autocomplete' => 'off'
                ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Log In',
                'class' => 'button-primary'
            ),
        )); 
    }
}