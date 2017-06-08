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
use Application\Form\BannersAddForm;
use Application\Form\BannersAddFilter;
use Application\Form\BannersDeleteForm;
use Application\Form\BannersDeleteFilter; 

// models
use Application\Model\Banners;

class BannersController extends AbstractActionController
{
    public $bannersTable;
    public $postsTable;
     
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $posts = $this->getPostsTable()->fetchAllPublicBy('parent', 0, 'all'); // get all active posts
        $form_add = new BannersAddForm($posts);
        $form_delete = new BannersDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new BannersDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $del = new Banners();
                                $del->exchangeArray($data);
                                $this->getBannersTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Banner deleted.');
                        return $this->redirect()->toRoute('banners');
                 endif;  // banner['delete']
            else :
                $form_add->setInputFilter(new BannersAddFilter());
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $date = new \DateTime();
                    $data['date'] = $date->format('Y-m-d H:i:s');
                    $ins = new Banners();
                    $ins->exchangeArray($data); 
                    $this->getBannersTable()->insert($ins);
                    $this->flashMessenger()->addMessage('Banner added.');
                    return $this->redirect()->toRoute('banners');
                endif; // if isValid
            endif;
        endif; // isPost
        $banners = $this->getBannersTable()->fetchAll();
        return new ViewModel(array('form_add' => $form_add, 'form_delete' => $form_delete, 'banners'=>$banners));
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    // -> get tables
    public function getBannersTable()
    {
        if(! $this->bannersTable) {
            $sm = $this->getServiceLocator();
            $this->bannersTable = $sm->get('Application\Model\BannersTable');
        }
        return $this->bannersTable;
    }
    public function getPostsTable()
    {
        if(! $this->postsTable) {
            $sm = $this->getServiceLocator();
            $this->postsTable = $sm->get('Application\Model\PostsTable');
        }
        return $this->postsTable;
    }
}
