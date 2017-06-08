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

// forms
use Application\Form\VideosAddForm;
use Application\Form\VideosAddFilter;
use Application\Form\VideosDeleteForm;
use Application\Form\VideosDeleteFilter;

// models
use Application\Model\Videos;

class VideosController extends AbstractActionController
{
    public $videosTable;
    
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $form_add = new VideosAddForm();
        $form_delete = new VideosDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new VideosDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $del = new Videos();
                                $del->exchangeArray($data);
                                $this->getVideosTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Video deleted.');
                        return $this->redirect()->toRoute('videos');
                 endif;  // post['delete']
            else :
                $form_add->setInputFilter(new VideosAddFilter());
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $date = new \DateTime();
                    $data['date'] = $date->format('Y-m-d H:i:s');
                    $quo = new Videos();
                    $quo->exchangeArray($data);
                    $this->getVideosTable()->insert($quo);
                    $this->flashMessenger()->addMessage('Video added.');
                    return $this->redirect()->toRoute('videos');
                endif;  // if isValid
            endif;
        endif; // isPost
        $videos = $this->getVideosTable()->fetchAll();
        return new ViewModel(array('form_add' => $form_add, 'form_delete' => $form_delete, 'videos'=>$videos));
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    // -> get tables
    public function getVideosTable()
    {
        if(! $this->videosTable) {
            $sm = $this->getServiceLocator();
            $this->videosTable = $sm->get('Application\Model\VideosTable');
        }
        return $this->videosTable;
    }
}
