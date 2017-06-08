<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'dashboard' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Dashboard',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            
            'logout' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/logout[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'logout',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            
            ),
            
            'posts' => array(
            		'type'    => 'Segment',
            		'options' => array(
            				'route'    => '/posts[/:action][/:id]',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller'    => 'Posts',
            						'action'        => 'index',
            				),
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'id' => '[a-z0-9]*',
            				),
            		),
            		
            ),

            'pages' => array(
            		'type'    => 'Segment',
            		'options' => array(
            				'route'    => '/pages[/:action][/:id]',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller'    => 'Pages',
            						'action'        => 'index',
            				),
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'id' => '[a-z0-9]*',
            				),
            		),
            
            ),
            
            'widgets' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/widgets[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Widgets',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'quotes' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/quotes[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Quotes',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'settings' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/settings[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Settings',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'links' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/links[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Links',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'videos' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/videos[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Videos',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'slider' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/slider[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Slider',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'products' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/products[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Products',
                        'action'        => 'index', 
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'gallery' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/gallery[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Gallery',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'banners' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/banners[/:action][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Banners',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-z0-9]*',
                    ),
                ),
            
            ),
            
            'media' => array(
            		'type'    => 'Literal',
            		'options' => array(
            				'route'    => '/media',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Application\Controller',
            						'controller'    => 'Media',
            						'action'        => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'default' => array(
            						'type'    => 'Segment',
            						'options' => array(
            								'route'    => '/[:action]',
            								'constraints' => array(
            										'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            								),
            								'defaults' => array(
            								),
            						),
            				),
            		),
            ),
        ),
    ),
    'service_manager' => array( 
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ), 
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Dashboard' => 'Application\Controller\DashboardController',
            'Application\Controller\Posts' => 'Application\Controller\PostsController',
            'Application\Controller\Pages' => 'Application\Controller\PagesController',
            'Application\Controller\Media' => 'Application\Controller\MediaController',
            'Application\Controller\Widgets' => 'Application\Controller\WidgetsController',
            'Application\Controller\Slider' => 'Application\Controller\SliderController',
            'Application\Controller\Quotes' => 'Application\Controller\QuotesController',
            'Application\Controller\Videos' => 'Application\Controller\VideosController',
            'Application\Controller\Links' => 'Application\Controller\LinksController',
            'Application\Controller\Settings' => 'Application\Controller\SettingsController',
            'Application\Controller\Banners' => 'Application\Controller\BannersController',
            'Application\Controller\Products' => 'Application\Controller\ProductsController',
            'Application\Controller\Gallery' => 'Application\Controller\GalleryController',
        ),
    ), 
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
