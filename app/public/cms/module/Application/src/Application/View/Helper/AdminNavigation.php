<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class AdminNavigation extends AbstractHelper
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke($controller, $action, $basepath)
    {
        $host = $_SERVER['HTTP_HOST'];
        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
        
        if($matches[0] == 'projectwellnessnow.com') : // navigation only for project wellness
            $nav_array = array(
            		array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
            		array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            		#array("name" => "Pages", "route" => "pages", "uri" => "pages/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-page", "sub" => array("All Pages" => "all", "Add New" => "new")),
                    #array("name" => "Widgets", "route" => "widgets", "uri" => "widgets/slogan", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-plugins", "sub" => array("Slogan" => "slogan")),
                    array("name" => "Quotes", "route" => "quotes", "uri" => "quotes", "controller" => $controller, "active" => $action, "icon" => "dashicons-format-quote", "sub" => array()),
                    array("name" => "Videos", "route" => "videos", "uri" => "videos", "controller" => $controller, "active" => $action, "icon" => "dashicons-format-video", "sub" => array()),
                    array("name" => "Slider", "route" => "slider", "uri" => "slider", "controller" => $controller, "active" => $action, "icon" => "dashicons-images-alt2", "sub" => array()),
                    array("name" => "Links", "route" => "links", "uri" => "links", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-links", "sub" => array()),
                    array("name" => "Banners", "route" => "banners", "uri" => "banners", "controller" => $controller, "active" => $action, "icon" => "dashicons-megaphone", "sub" => array()),
                    array("name" => "Settings", "route" => "settings", "uri" => "settings/home-page", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-settings", "sub" => array('Home Page' => 'home-page', 'Social' => 'social', 'Email' => 'email')),
                ); 
        elseif ($matches[0] == 'treesanta.com') : // navigation only for project wellness
        $nav_array = array(
            array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()), 
            array("name" => "Product", "route" => "products", "uri" => "products", "controller" => $controller, "active" => $action, "icon" => "dashicons-cart", "sub" => array("All Products" => "index", "Orders" => "orders", "Categories" => "category", "Delivery" => "delivery", "Removal" => "removal", "Promotions" => "promo")),
            );
        elseif ($matches[0] == 'zerubariel.com') : // navigation only for project wellness
        $nav_array = array(
            array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
        );
        elseif ($matches[0] == 'gowebvision.com') : // navigation only for project wellness
            $nav_array = array(
                array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            );
        elseif ($matches[0] == 'shmcleaning.com') : // navigation only for project wellness
            $nav_array = array(
                array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            );
        elseif ($matches[0] == 'rhcloud.com') : // navigation only for project wellness
            $nav_array = array(
                array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            );
        elseif ($matches[0] == 'secondcityconstruction.com') : // navigation only for second city construction
            $nav_array = array(
                array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
                array("name" => "Before & After", "route" => "gallery", "uri" => "gallery/index", "controller" => $controller, "active" => $action, "icon" => "dashicons-format-gallery", "sub" => array("Pictures" => "index", "Categories" => "category")),
            );
        elseif ($matches[0] == 'bigbolt.net') : // navigation only for bigbolt
            $nav_array = array(
                array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            );
        endif;
        
        $nav_array = array(
            array("name" => "Dashboard", "route" => "dashboard", "uri" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
            array("name" => "Posts", "route" => "posts", "uri" => "posts/all", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")),
            array("name" => "Before & After", "route" => "gallery", "uri" => "gallery/index", "controller" => $controller, "active" => $action, "icon" => "dashicons-format-gallery", "sub" => array("Pictures" => "index", "Categories" => "category")),
        );
        
        $i = 0;
        $html = '<ul class="adminmenu">';
        foreach ($nav_array as $na) :
        
            if ($na['route'] == $na['controller']) :
                $html .= '<li class="sub-menu">' . '<a class="dashicons-dashboard-active-link" href="' . $basepath . $na['uri'] . '">' . '<div class="dashicons-dashboard menu-image active ' . $na['icon'] . '"><br /></div>' . '<div class="menu-name">' . $na['name'] . '</div>' . '</a>';
                if (count($na['sub']) > 0) :
                    $html .= '<ul class="submenu">';
                    foreach ($na['sub'] as $v => $k) :
                        if ($na['active'] == $k) :
                            $html .= '<li class="current"><a href="' . $basepath . $na['route'] . '/' . $k . '">' . $v . '</a></li>';
                         else :
                            $html .= '<li><a href="' . $basepath . $na['route'] . '/' . $k . '">' . $v . '</a></li>';
                        endif;
                    endforeach
                    ;
                    $html .= '</ul>';
                
    	
    	     endif;
             else :
                $html .= '<li class="sub-menu not-current">' . '<a href="' . $basepath . $na['uri'] . '">' . '<div class="dashicons-dashboard menu-image ' . $na['icon'] . '"><br /></div>' . '<div class="menu-name">' . $na['name'] . '</div>' . '</a>';
            endif;
            
            $html .= '</li>';
        endforeach
        ;
        
        return $html;
    }    
}