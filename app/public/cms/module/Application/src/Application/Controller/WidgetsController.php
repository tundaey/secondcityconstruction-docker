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
use Application\Form\SloganForm;
use Application\Form\SloganFilter;
use Application\Model\Options;

class WidgetsController extends AbstractActionController
{
    public $optionsTable;  
     
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        return new ViewModel();
    }
    
    public function sloganAction()
    {
        $options = $this->getOptionsTable()->fetchAll();
        $form = new SloganForm($options);
        $request = $this->getRequest();
        
        if($request->isPost()) :
            $form->setInputFilter(new SloganFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                // slogan
                $data['val_1'] = $data['slogan'];
                $option = new Options();
                $option->exchangeArray($data);
                $this->getOptionsTable()->updateSlogan($option);
                // video
                $data['val_1'] = $data['video'];
                $option = new Options();
                $option->exchangeArray($data);
                $this->getOptionsTable()->updateVideo($option);
                $this->flashMessenger()->addMessage('Widgets updated.'); // add msg
                return $this->redirect()->toRoute('widgets', array("action" => "slogan")); // send to slogan page
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
