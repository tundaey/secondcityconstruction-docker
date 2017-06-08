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
use Application\Form\LinksAddForm;
use Application\Form\LinksAddFilter;
use Application\Form\LinksDeleteForm;
use Application\Form\LinksDeleteFilter;

// models
use Application\Model\Links;

class LinksController extends AbstractActionController
{
    public $linksTable;
    
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $form_add = new LinksAddForm();
        $form_delete = new LinksDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new LinksDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $del = new Links();
                                $del->exchangeArray($data);
                                $this->getLinksTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Quote deleted.');
                        return $this->redirect()->toRoute('links');
                 endif;  // post['delete']
            else :
                $form_add->setInputFilter(new LinksAddFilter());
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $date = new \DateTime();
                    $data['date'] = $date->format('Y-m-d H:i:s');
                    $quo = new Links();
                    $quo->exchangeArray($data);
                    $this->getLinksTable()->insert($quo);
                    $this->flashMessenger()->addMessage('Quote added.');
                    return $this->redirect()->toRoute('links');
                endif;
                        // if isValid
            endif;
        endif; // isPost
        $links = $this->getLinksTable()->fetchAll();
        return new ViewModel(array('form_add' => $form_add, 'form_delete' => $form_delete, 'links'=>$links));
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    // -> get tables
    public function getLinksTable()
    {
        if(! $this->linksTable) {
            $sm = $this->getServiceLocator();
            $this->linksTable = $sm->get('Application\Model\LinksTable');
        }
        return $this->linksTable;
    }
}
