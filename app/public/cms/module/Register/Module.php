<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Register;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

// Module
use Zend\ModuleManager\ModuleManager;

// database
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

// Add this for SMTP transport
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    // db config
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					// Add this for SMTP transport
    					'mail.transport' => function (ServiceManager $serviceManager) {
    						$config = $serviceManager->get('Config');
    						$transport = new Smtp();
    						$transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
    						return $transport;
    					},
    			),
    			
    	);
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}