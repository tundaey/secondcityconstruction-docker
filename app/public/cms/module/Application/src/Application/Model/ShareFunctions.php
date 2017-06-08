<?php
namespace Application\Model;

class ShareFunctions 
{
    function adminNav($controller, $action) 
    {   
        $nav_array = array(
                        array("name" => "Dashboard", "route" => "dashboard", "controller" => $controller, "active" => $action, "icon" => "", "sub" => array()),
                        array("name" => "Blog Posts", "route" => "posts", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-post", "sub" => array("All Posts" => "all", "Add New" => "new", "Categories" => "category")), 
                        array("name" => "Pages", "route" => "pages", "controller" => $controller, "active" => $action, "icon" => "dashicons-admin-page", "sub" => array())
                    );
        
        return $nav_array;
    }
}