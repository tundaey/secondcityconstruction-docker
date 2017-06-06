<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

// database
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;

// models
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\Comments;
use Application\Model\CommentsTable;
use Application\Model\Posts;
use Application\Model\PostsTable;
use Application\Model\CategoryRelationships;
use Application\Model\CategoryRelationshipsTable;
use Application\Model\Gallery;
use Application\Model\GalleryTable;
use Application\Model\GalleryCategory;
use Application\Model\GalleryCategoryTable;
use Application\Model\GalleryCategoryRelationships;
use Application\Model\GalleryCategoryRelationshipsTable;

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
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
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
                // comments
                'Application\Model\CommentsTable' =>  function($sm) {
                    $tableGateway = $sm->get('CommentsTableGateway');
                    $table = new CommentsTable($tableGateway);
                    return $table;
                },
                'CommentsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Comments());
                    return new TableGateway('comments', $dbAdapter, null, $resultSetPrototype);
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
