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
use Application\Form\QuotesAddForm;
use Application\Form\QuotesAddFilter;
use Application\Form\QuotesDeleteForm;
use Application\Form\QuotesDeleteFilter;

// models
use Application\Model\Quotes;

class QuotesController extends AbstractActionController
{
    public $quotesTable;
    
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $form_add = new QuotesAddForm();
        $form_delete = new QuotesDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new QuotesDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $del = new Quotes();
                                $del->exchangeArray($data);
                                $this->getQuoteTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Quote deleted.');
                        return $this->redirect()->toRoute('quotes');
                 endif;  // post['delete']
            else :
                $form_add->setInputFilter(new QuotesAddFilter());
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $date = new \DateTime();
                    $data['date'] = $date->format('Y-m-d H:i:s');
                    $quo = new Quotes();
                    $quo->exchangeArray($data);
                    $this->getQuotesTable()->insert($quo);
                    $this->flashMessenger()->addMessage('Quote added.');
                    return $this->redirect()->toRoute('quotes');
                endif;
                        // if isValid
            endif;
        endif; // isPost
        $quotes = $this->getQuotesTable()->fetchAll();
        return new ViewModel(array('form_add' => $form_add, 'form_delete' => $form_delete, 'quotes'=>$quotes));
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    // -> get tables
    public function getQuotesTable()
    {
        if(! $this->quotesTable) {
            $sm = $this->getServiceLocator();
            $this->quotesTable = $sm->get('Application\Model\QuotesTable');
        }
        return $this->quotesTable;
    }
}
