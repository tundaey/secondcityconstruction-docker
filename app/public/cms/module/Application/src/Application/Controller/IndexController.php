<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// forms & filters
use Application\Form\LoginForm;
use Application\Form\LoginFilter;

// authentication
use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    public $config;
    
    public function tetAction()
    {
        return new ViewModel();
    }
    public function indexAction()
    {
        $messages = '';
        
        $this->layout('layout/login');
        $this->config = $this->getServiceLocator()->get('Config');
        
        $session = new Container('user');
        $request = $this->getRequest();
        
        $form = new LoginForm(null,$this->getRequest()->getBaseUrl().'/images/captcha');
        
        if ($request->isPost()) :
            $form->setInputFilter(new LoginFilter());
            $form->setData($request->getPost());
        
            if ($form->isValid()) :
            
                $data = $form->getData();
                $sm = $this->getServiceLocator();
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                
                // session container
                $session->user_email = $data['usr_email'];
                $staticSalt = $this->config['static_salt'];
                
                $authAdapter = new AuthAdapter($dbAdapter,
                		'users', // there is a method setTableName to do the same
                		'usr_email', // there is a method setIdentityColumn to do the same
                		'usr_password', // there is a method setCredentialColumn to do the same
                		"MD5(CONCAT('$staticSalt', ?, usr_password_salt))" // setCredentialTreatment(parametrized string) 'MD5(?)'
                );
                $authAdapter
                ->setIdentity($data['usr_email'])
                ->setCredential($data['usr_password']) 
                ;
                
                $auth = new AuthenticationService();
                $result = $auth->authenticate($authAdapter);
                
                switch ($result->getCode()) {
                	case Result::FAILURE_IDENTITY_NOT_FOUND:
                
                		$this->flashMessenger()->setNamespace('error')->addMessage('User name or password is incorrect.');
                		$this->flashMessenger()->setNamespace('email')->addMessage($data['usr_email']);
                		#return $this->redirect()->toRoute('home');
                
                		break;
                
                	case Result::FAILURE_CREDENTIAL_INVALID:
                
                		$this->flashMessenger()->setNamespace('error')->addMessage('User name or password is incorrect.');
                		$this->flashMessenger()->setNamespace('email')->addMessage($data['usr_email']);
                		#return $this->redirect()->toRoute('home');
                
                		break;
                
                	case Result::SUCCESS:
                		$storage = $auth->getStorage();
                		$storage->write($authAdapter->getResultRowObject(
                				null,
                				'usr_password'
                		));
                
                		return $this->redirect()->toRoute('dashboard');
                
                		break;
                
                	default:
                		// do stuff for other failure
                		echo 'other fail';
                		break;
                }
                
                foreach ($result->getMessages() as $message) {
                	$messages .= "$message\n"; // echo $messages;
                }
                
            endif; //-> from isValid
        endif; //-> from isPost
        // echo $_SERVER['HTTP_HOST'];
        
        return new ViewModel(array('form' => $form, 'config' => $this->config, 'messages' => $messages));
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
    
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }
    
        $auth->clearIdentity();

        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
    
        // msg
        $this->flashMessenger()->addMessage('See you again soon!');
    
        return $this->redirect()->toRoute('home');
    }
}
