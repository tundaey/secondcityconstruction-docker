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
use Zend\Authentication\AuthenticationService;

class MediaController extends AbstractActionController
{
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->authService = new AuthenticationService();
        if(! $this->authService->hasIdentity()) {
            $this->redirect()->toRoute("home");
        }
        $auth = $this->authService;
        $this->identity = $auth->getIdentity();
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $this->layout('layout/blank');
        
        return new ViewModel();
    }

    public function uploadImageAction()
    {
        $this->layout('layout/blank'); 
        $config = $this->getServiceLocator()->get('Config'); // get websites config
        $dir = './public/media/'.$config['website']['media'].'/img/'; // upload folder
        
        $name = $_FILES['file']['tmp_name'];
        
        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);
        
        if ($_FILES['file']['type'] == 'image/png' || $_FILES['file']['type'] == 'image/jpg' || $_FILES['file']['type'] == 'image/gif' || $_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/pjpeg') {
            
            switch ($_FILES['file']['type']) {
            	case 'image/png' : $ext = '.png'; break;
            	case 'image/jpg' : $ext = '.jpg'; break;
            	case 'image/gif' : $ext = '.gif'; break;
            	case 'image/jpeg' : $ext = '.jpg'; break;
            	case 'image/pjpeg' : $ext = '.jpg'; break;
            }
            
            $filename = md5(date('YmdHis')) . $ext;
            $file = $dir . $filename;
            
            // copying
            copy($_FILES['file']['tmp_name'], $file);
        }
        
        return new ViewModel(array('filename' => $filename, 'config'=>$config));
    }
	
    public function uploadFileAction()
    {
    	$this->layout('layout/blank');
    	$config = $this->getServiceLocator()->get('Config'); // get websites config
    	
    	$dir = './public/media/'.$config['website']['media'].'/files/'; // upload folder
    	copy($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name']);
    	
		$filename = $_FILES['file']['name'];
    	
    	return new ViewModel(array('config' => $config, 'filename'=>$filename));
    }
    
    public function dataAction()
    {
        $config = $this->getServiceLocator()->get('Config'); // get websites config
        
        $this->layout('layout/blank');
        
        return new ViewModel(array('config'=>$config));
    }
}
