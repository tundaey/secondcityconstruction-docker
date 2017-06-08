<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Register\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// form & filter
use Register\Form\RegisterForm;
use Register\Form\RegisterFilter;

// model
use Application\Model\Users;

// email
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController
{
    public $usersTable;
       
    public function indexAction()
    {
        $this->layout('layout/login');
    	$users = $this->getUsersTable()->fetchAll();
    
    	$form = new RegisterForm(null,$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter(new RegisterFilter($this->getServiceLocator()));
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$data = $form->getData();
    			$data = $this->prepareData($data);
    			$auth = new Users();
    			$auth->exchangeArray($data);
    			$this->getUsersTable()->saveUser($auth);
                
    			$this->flashMessenger()->addMessage("User Saved");
    
    			return $this->redirect()->toRoute('register');
    		}
    	}
    
    	return new ViewModel(array('form' => $form));
    }
    
    //-> supporting functions
    public function prepareData($data)
    {
    	$data['usr_active'] = 1;
    	$data['usr_password_salt'] = $this->generateDynamicSalt();
    	$data['usr_password'] = $this->encriptPassword(
    			$this->getStaticSalt(),
    			$data['usr_password'],
    			$data['usr_password_salt']
    	);
    
    	$date = new \DateTime();
    	$data['usr_registration_date'] = $date->format('Y-m-d H:i:s');
    	$data['usr_registration_token'] = md5(uniqid(mt_rand(), true)); // $this->generateDynamicSalt();
    	$data['usr_email_confirmed'] = 1;
    	$data['usr_url'] = md5(uniqid(mt_rand(), true));
    
    	$data['usr_ip'] = $_SERVER['REMOTE_ADDR'];
    	$data['usr_device'] = '1';
    
    	return $data;
    }
    
    public function generateDynamicSalt()
    {
    	$dynamicSalt = '';
    	for ($i = 0; $i < 50; $i++) {
    		$dynamicSalt .= chr(rand(33, 126));
    	}
    	return $dynamicSalt;
    }
    
    public function getStaticSalt()
    {
    	$staticSalt = '';
    	$config = $this->getServiceLocator()->get('Config');
    	$staticSalt = $config['static_salt'];
    	return $staticSalt;
    }
    
    public function encriptPassword($staticSalt, $password, $dynamicSalt)
    {
    	return $password = md5($staticSalt . $password . $dynamicSalt);
    }
    
    //-> get tables
    public function getUsersTable()
    {
    	if (!$this->usersTable) {
    		$sm = $this->getServiceLocator();
    		$this->usersTable = $sm->get('Application\Model\UsersTable');
    	}
    	return $this->usersTable;
    }
}
