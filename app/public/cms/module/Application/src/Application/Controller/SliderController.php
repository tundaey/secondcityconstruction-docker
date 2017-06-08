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

// forms
use Application\Form\SliderAddForm;
use Application\Form\SliderAddFilter;
use Application\Form\SliderDeleteForm;
use Application\Form\SliderDeleteFilter;
use Application\Form\SliderEditForm;
use Application\Form\SliderEditFilter;

// models
use Application\Model\Options;

class SliderController extends AbstractActionController
{
    public $optionsTable;  
    public $categoryTable;
    
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
        $slides = $this->getOptionsTable()->fetchAllSlides();
        
        $form_add = new SliderAddForm($config);
        $form_delete = new SliderDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new SliderDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) : 
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $opt = new Options();
                                $opt->exchangeArray($data);
                                $this->getOptionsTable()->deleteSlides($opt);
                                unlink('./public/media/'.$config['website']['media'].'/slider/'.$data['file'][$cb]); // delete file
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Slide deleted.');
                        return $this->redirect()->toRoute('slider');
                 endif;  // post['delete']
            else :
                $post = array_merge_recursive(
                    $request->getPost()->toArray(),
                    $request->getFiles()->toArray()
                );
                 
                $form_add->setData($post);
                if($form_add->isValid()) :
                
                    $data = $form_add->getData();
                     
                    // image/png,image/x-png,image/jpeg,image/gif
                    switch ($data["val_1"]['type']) {
                        case 'image/png' 	: $ext = '.png'; break;
                        case 'image/x-png' 	: $ext = '.png'; break;
                        case 'image/jpeg' 	: $ext = '.jpg'; break;
                        case 'image/gif' 	: $ext = '.gif'; break;
                    }
                     
                    $file = $data["val_1"]["tmp_name"];
                    $file_full = md5(mktime()).$ext;
                    
                    rename($file, './public/media/'.$config['website']['media'].'/slider/'.$file_full);
                    
                    $data['val_1'] = $file_full;
                    $option = new Options();
                    $option->exchangeArray($data);
                    $this->getOptionsTable()->insertSlider($option);
                    $this->flashMessenger()->addMessage('Slide added.');
                    
                    return $this->redirect()->toRoute('slider');
                endif; // if isValid    
            endif;
            
        endif; // isPost
        
        return new ViewModel(array('form_add' => $form_add,'slides' => $slides,'form_delete' => $form_delete, 'config'=>$config));
    }
    
    public function editAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        $slide = $this->getOptionsTable()->fetchSlider($id);
        $form = new SliderEditForm($slide);
        $request = $this->getRequest();
        if ($request->isPost()) :
                $form->setInputFilter(new SliderEditFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) : 
                    $data = $form->getData();
                    $data['id'] = $id;
                    $opt = new Options();
                    $opt->exchangeArray($data);
                    $this->getOptionsTable()->updateSlide($opt);
                    $this->flashMessenger()->addMessage('Slide edited.');
                    return $this->redirect()->toRoute('slider');
                else :
                    var_dump($form->getMessages());
                endif; // if isValid
        endif;
        return new ViewModel(array('form' => $form,'slide' => $slide,'id' => $id, 'config'=>$config));
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
    public function getCategoryTable()
    {
        if(! $this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Application\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
}
