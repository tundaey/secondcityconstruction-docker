<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
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
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
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
            'about_chicago_roofer' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/about-chicago-roofer[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'aboutChicagoRoofer',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
                        
            'roofing_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-chicago/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'exterior_remodeling_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/exterior-remodeling-chicago[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'exteriorRemodelingChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            'chicago_roofing_estimate_quote' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/chicago-roofing-estimate-quote[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'chicagoRoofingEstimateQuote',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'thank_you_contact_us' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/thank-you-contact-us[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'thankYouContactUs',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'tuckpointing_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/tuckpointing-chicago[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'tuckpointingChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'gallery' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/gallery[/:slug]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'gallery',
                    ),
                    'constraints' => array(
                        'slug' => '[a-zA-Z0-9_-]*',
                    ),
                ),
            
            ),
            
            /*
             * LANDING PAGE ROUTES
             */
            
            'lp_roofing' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/lp/roofing.html',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'lpRoofing',
                    ),
                    'constraints' => array(
                        'slug' => '[a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z0-9\._-]*',
                    ),
                ),
            ),
            
            'lp_masonry' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/lp/masonry.html',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'lpMasonry',
                    ),
                    'constraints' => array(
                        'slug' => '[a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z0-9\._-]*',
                    ),
                ),
            ),
            
            'lp_siding' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/lp/siding.html',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'lpSiding',
                    ),
                    'constraints' => array(
                        'slug' => '[a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z0-9\._-]*',
                    ),
                ),
            ),
            
            /*
             * * SEO PAGES
             */
            'roofing_bellwood_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-bellwood-il[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingBellwoodIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_berwyn_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-berwyn-il[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingBerwynIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_broadview_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-broadview-il-60155[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingBroadviewIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_burbank_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-burbank-il-60459[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingBurbankIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_cicero_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-cicero-il-60804[/]', 
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingCiceroIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_forest_park_il' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-forest-park-il-60130[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingForestParkIl',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            /*
             *** STATIC PAGES
             */
            
            'roofing_101' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-101[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofing101',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),            
            
            /*
             *  * OTHER
             */
            'privacy_policy' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/privacy-policy[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'privacyPolicy',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'blog_post' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/blog[/:uri]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'blogPost',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'blog' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/blog[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'blog',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            // redirect seo
             
            'interior_remodeling_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/interior-remodeling-chicago[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'interiorRemodelingChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'tuckpointing_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/tuckpointing-chicago[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'tuckpointingChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'roofing_bellwood_i' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/roofing-bellwood-i[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'roofingBellwoodI',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
            'porch_builder_chicago' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/porch-builder-chicago[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'porchBuilderChicago',
                    ),
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'uri' => '[a-z0-9-.]*',
                    ),
                ),
            ),
            
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
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
            'Application\Controller\Index' => 'Application\Controller\IndexController'
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
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
