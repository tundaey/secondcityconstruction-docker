<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleEvent;

// models
use Application\Model\Users;
use Application\Model\UsersTable;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\Posts;
use Application\Model\PostsTable;
use Application\Model\CategoryRelationships;
use Application\Model\CategoryRelationshipsTable;
use Application\Model\Options;
use Application\Model\OptionsTable;
use Application\Model\Products;
use Application\Model\ProductsTable;
use Application\Model\Quotes;
use Application\Model\QuotesTable;
use Application\Model\Links;
use Application\Model\LinksTable; 
use Application\Model\Analitics;
use Application\Model\AnaliticsTable;
use Application\Model\Videos;
use Application\Model\VideosTable;
use Application\Model\Banners;
use Application\Model\BannersTable;
use Application\Model\ProductCategory;
use Application\Model\ProductCategoryTable;
use Application\Model\ProductCategoryRelationships;
use Application\Model\ProductCategoryRelationshipsTable;
use Application\Model\GalleryCategory;
use Application\Model\GalleryCategoryTable;
use Application\Model\GalleryCategoryRelationships;
use Application\Model\GalleryCategoryRelationshipsTable;
use Application\Model\DeliveryRange;
use Application\Model\DeliveryRangeTable;
use Application\Model\DeliveryTime;
use Application\Model\DeliveryTimeTable;
use Application\Model\DeliveryDisableDay;
use Application\Model\DeliveryDisableDayTable;
use Application\Model\DeliveryDisableTime;
use Application\Model\DeliveryDisableTimeTable;
use Application\Model\DeliveryZipCode;
use Application\Model\DeliveryZipCodeTable;
use Application\Model\Promotions;
use Application\Model\PromotionsTable;
use Application\Model\Orders;
use Application\Model\OrdersTable;
use Application\Model\Gallery;
use Application\Model\GalleryTable;

// helper
use Application\View\Helper\AdminNavigation;

// database
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
    
    // helper config
    public function getViewHelperConfig()
    {
    	return array(
    			        'factories' => array(
        					'adminNavigation' => function($sm) {
        					    $locator = $sm->getServiceLocator('\View\Helper'); // $sm is the view helper manager, so we need to fetch the main service manager
        						return new AdminNavigation($locator->get('Request'));
        					},
    			 ),
    	);
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Application\Model\UsersTable' =>  function($sm) {
    						$tableGateway = $sm->get('UsersTableGateway');
    						$table = new UsersTable($tableGateway);
    						return $table;
    					},
    					'UsersTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Users());
    						return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
    					},
    					// category
    					'Application\Model\CategoryTable' =>  function($sm) {
    						$tableGateway = $sm->get('CategoryTableGateway');
    						$table = new CategoryTable($tableGateway);
    						return $table;
    					},
    					'CategoryTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Category());
    						return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
    					},
    					// posts
    					'Application\Model\PostsTable' =>  function($sm) {
    						$tableGateway = $sm->get('PostsTableGateway');
    						$table = new PostsTable($tableGateway);
    						return $table;
    					},
    					'PostsTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Posts());
    						return new TableGateway('posts', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Category Relationships
    					'Application\Model\CategoryRelationshipsTable' =>  function($sm) {
    						$tableGateway = $sm->get('CategoryRelationshipsTableGateway');
    						$table = new CategoryRelationshipsTable($tableGateway);
    						return $table;
    					},
    					'CategoryRelationshipsTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new CategoryRelationships());
    						return new TableGateway('category_relationships', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Options
    					'Application\Model\OptionsTable' =>  function($sm) {
    					    $tableGateway = $sm->get('OptionsTableGateway');
    					    $table = new OptionsTable($tableGateway);
    					    return $table;
    					},
    					'OptionsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Options());
    					    return new TableGateway('options', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Product
    					'Application\Model\ProductsTable' =>  function($sm) {
    					$tableGateway = $sm->get('ProductsTableGateway');
    					$table = new ProductsTable($tableGateway);
    					return $table;
    					},
    					'ProductsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Products());
    					    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Product Category
    					'Application\Model\ProductCategoryTable' =>  function($sm) {
    					$tableGateway = $sm->get('ProductCategoryTableGateway');
    					$table = new ProductCategoryTable($tableGateway);
    					return $table;
    					},
    					'ProductCategoryTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new ProductCategory());
    					    return new TableGateway('product_category', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Product Category Relationships
    					'Application\Model\ProductCategoryRelationshipsTable' =>  function($sm) {
    					   $tableGateway = $sm->get('ProductCategoryRelationshipsTableGateway');
    					   $table = new ProductCategoryRelationshipsTable($tableGateway);
    					   return $table;
    					},
    					'ProductCategoryRelationshipsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new ProductCategoryRelationships());
    					    return new TableGateway('product_relationships', $dbAdapter, null, $resultSetPrototype);
    					},
    					
    					// Gallery
    					'Application\Model\GalleryTable' =>  function($sm) {
    					$tableGateway = $sm->get('GalleryTableGateway');
    					$table = new GalleryTable($tableGateway);
    					return $table;
    					},
    					'GalleryTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Gallery());
    					    return new TableGateway('gallery', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Gallery Category
        					'Application\Model\GalleryCategoryTable' =>  function($sm) {
        					$tableGateway = $sm->get('GalleryCategoryTableGateway');
        					$table = new GalleryCategoryTable($tableGateway);
    					return $table;
    					},
    					'GalleryCategoryTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new GalleryCategory());
    					    return new TableGateway('gallery_category', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Gallery Category Relationships
    					'Application\Model\GalleryCategoryRelationshipsTable' =>  function($sm) {
    					    $tableGateway = $sm->get('GalleryCategoryRelationshipsTableGateway');
    					    $table = new GalleryCategoryRelationshipsTable($tableGateway);
    					    return $table;
    					},
    					'GalleryCategoryRelationshipsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new GalleryCategoryRelationships());
    					    return new TableGateway('gallery_relationships', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Quotes
    					'Application\Model\QuotesTable' =>  function($sm) {
    					    $tableGateway = $sm->get('QuotesTableGateway');
    					    $table = new QuotesTable($tableGateway);
    					    return $table;
    					},
    					'QuotesTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Quotes());
    					    return new TableGateway('quotes', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Links
    					'Application\Model\LinksTable' =>  function($sm) {
    					    $tableGateway = $sm->get('LinksTableGateway');
    					    $table = new LinksTable($tableGateway);
    					    return $table;
    					},
    					'LinksTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Links());
    					    return new TableGateway('links', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Videos
    					'Application\Model\VideosTable' =>  function($sm) {
    					    $tableGateway = $sm->get('VideosTableGateway');
    					    $table = new VideosTable($tableGateway);
    					    return $table;
    					},
    					'VideosTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Videos());
    					    return new TableGateway('videos', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Analitics
    					'Application\Model\AnaliticsTable' =>  function($sm) {
    					    $tableGateway = $sm->get('AnaliticsTableGateway');
    					    $table = new AnaliticsTable($tableGateway);
    					    return $table;
    					},
    					'AnaliticsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Analitics());
    					    return new TableGateway('tracker', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Banners
    					'Application\Model\BannersTable' =>  function($sm) {
    					    $tableGateway = $sm->get('BannersTableGateway');
    					    $table = new BannersTable($tableGateway);
    					    return $table;
    					},
    					'BannersTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Banners());
    					    return new TableGateway('banners', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Delivery Range
        					'Application\Model\DeliveryRangeTable' =>  function($sm) {
        					$tableGateway = $sm->get('DeliveryRangeTableGateway');
        					$table = new DeliveryRangeTable($tableGateway);
        					return $table;
    					},
    					'DeliveryRangeTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new DeliveryRange());
    					    return new TableGateway('delivery_range', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Delivery Time
        					'Application\Model\DeliveryTimeTable' =>  function($sm) {
        					$tableGateway = $sm->get('DeliveryTimeTableGateway');
        					$table = new DeliveryTimeTable($tableGateway);
        					return $table;
    					},
    					    'DeliveryTimeTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new DeliveryTime());
    					    return new TableGateway('delivery_time', $dbAdapter, null, $resultSetPrototype);
    					},
					   // Delivery Disable Day
        					'Application\Model\DeliveryDisableDayTable' =>  function($sm) {
        					$tableGateway = $sm->get('DeliveryDisableDayTableGateway');
        					$table = new DeliveryDisableDayTable($tableGateway);
        					return $table;
    					},
    					'DeliveryDisableDayTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new DeliveryDisableDay());
    					    return new TableGateway('delivery_disable_day', $dbAdapter, null, $resultSetPrototype);
    					},
    					// Delivery Disable Time
    					   'Application\Model\DeliveryDisableTimeTable' =>  function($sm) {
        					$tableGateway = $sm->get('DeliveryDisableTimeTableGateway');
        					$table = new DeliveryDisableTimeTable($tableGateway);
        					return $table;
    					},
    					   'DeliveryDisableTimeTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new DeliveryDisableTime());
    					    return new TableGateway('delivery_disable_time', $dbAdapter, null, $resultSetPrototype);
    					},
    					   // Delivery Zip Code
        					'Application\Model\DeliveryZipCodeTable' =>  function($sm) {
        					$tableGateway = $sm->get('DeliveryZipCodeTableGateway');
        					$table = new DeliveryZipCodeTable($tableGateway);
        					return $table;
    					},
    					   'DeliveryZipCodeTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new DeliveryZipCode());
    					    return new TableGateway('delivery_zip_code', $dbAdapter, null, $resultSetPrototype);
    					},
        					// Promotions
        					'Application\Model\PromotionsTable' =>  function($sm) {
    					    $tableGateway = $sm->get('PromotionsTableGateway');
    					    $table = new PromotionsTable($tableGateway);
    					    return $table;
    					},
    					   'PromotionsTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Promotions());
    					    return new TableGateway('promotions', $dbAdapter, null, $resultSetPrototype);
    					},
        					// Order
        					'Application\Model\OrdersTable' =>  function($sm) {
        					$tableGateway = $sm->get('OrdersTableGateway');
        					$table = new OrdersTable($tableGateway);
        					return $table;
    					},
    					   'OrdersTableGateway' => function ($sm) {
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Orders());
    					    return new TableGateway('orders', $dbAdapter, null, $resultSetPrototype);
    					},    					
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
}
