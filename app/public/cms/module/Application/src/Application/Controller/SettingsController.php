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
use Application\Form\SettingsForm;
use Application\Form\SettingsFilter;
use Application\Form\SocialForm;
use Application\Form\SocialFilter;
use Application\Form\EmailsForm;
use Application\Form\EmailsFilter;

// models
use Application\Model\Options; 

class SettingsController extends AbstractActionController
{ 
    public $optionsTable;  
   
    public function indexAction()
    {   
        return new ViewModel();
    }
    
    public function homePageAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $options = $this->getOptionsTable()->fetchAll();
        $form = new SettingsForm($options);
        $request = $this->getRequest();
    
        if($request->isPost()) :
            $form->setInputFilter(new SettingsFilter());
            $form->setData($request->getPost());
                if($form->isValid()) :
                    $data = $form->getData();
                    $data['val_1'] = $data['site_title'];
                    $data['val_2'] = $data['site_keyword'];
                    $data['val_3'] = $data['site_description'];
                    $option = new Options();
                    $option->exchangeArray($data);
                    $this->getOptionsTable()->updateHomePage($option);
                    $this->flashMessenger()->addMessage('Home Page updated.'); // add msg
                    return $this->redirect()->toRoute('social', array('action'=>'home-page')); // send to settings
                endif; // form valid
        endif; // post
    
        return new ViewModel(array('form'=>$form));
    }
    
    public function socialAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $options = $this->getOptionsTable()->fetchAll();
        $form = new SocialForm($options);
        $request = $this->getRequest();
    
        if($request->isPost()) :
            $form->setInputFilter(new SocialFilter());
            $form->setData($request->getPost());
                if($form->isValid()) :
                    $data = $form->getData();
                    $data['val_1'] = $data['facebook'];
                    $data['val_2'] = $data['twitter'];
                    $data['val_3'] = $data['youtube'];
                    $data['val_4'] = $data['pintrest'];
                    $option = new Options();
                    $option->exchangeArray($data);
                    $this->getOptionsTable()->updateSocial($option);
                    $this->flashMessenger()->addMessage('Social links updated.'); // add msg
                    return $this->redirect()->toRoute('settings', array('action'=>'social')); // send to settings
                endif; // form valid
        endif; // post
    
        return new ViewModel(array('form'=>$form));
    }
    
    public function emailAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $options = $this->getOptionsTable()->fetchAll();
        $form = new EmailsForm($options);
        $request = $this->getRequest();
    
        if($request->isPost()) :
            $form->setInputFilter(new EmailsFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                $data['val_1'] = $data['email_1'];
                $option = new Options();
                $option->exchangeArray($data);
                $this->getOptionsTable()->updateEmails($option);
                $this->flashMessenger()->addMessage('Social links updated.'); // add msg
                return $this->redirect()->toRoute('settings', array('action'=>'email')); // send to settings
            endif; // form valid
        endif; // post
    
        return new ViewModel(array('form'=>$form));
    }
    
    //-> get tables
    public function getOptionsTable()
    {
        if(! $this->optionsTable) {
            $sm = $this->getServiceLocator();
            $this->optionsTable = $sm->get('Application\Model\OptionsTable');
        }
        return $this->optionsTable;
    }
}
