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
use Zend\Console\Response;

class DashboardController extends AbstractActionController
{
    public $analiticsTable;
    
    public function indexAction()
    {
        $page_views = $this->getAnaliticsTable()->fetchPageViews();
        $users = $this->getAnaliticsTable()->fetchUsers();
        $top_page = $this->getAnaliticsTable()->fetchTopPages();
        $top_language = $this->getAnaliticsTable()->fetchTopLanguage();
        $top_screen_resolution = $this->getAnaliticsTable()->fetchTopScreenResolution();
        $top_location = $this->getAnaliticsTable()->fetchTopLocation();

        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        return new ViewModel(array('page_views'=>$page_views,'users'=>$users, 'top_location'=>$top_location, 'top_pages'=>$top_page, 'top_language'=>$top_language, 'top_screen_resolution'=>$top_screen_resolution));
    }
     
    // -> get tables
    public function getAnaliticsTable()
    {
        if(! $this->analiticsTable) {
            $sm = $this->getServiceLocator();
            $this->analiticsTable = $sm->get('Application\Model\AnaliticsTable');
        }
        return $this->analiticsTable;
    }
}
