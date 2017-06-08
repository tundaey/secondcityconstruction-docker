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
use Zend\Authentication\AuthenticationService;

use Application\Form\PostsForm;
use Application\Form\PostsFilter;
use Application\Form\PostsEditForm;
use Application\Form\PostsDeleteForm;
use Application\Form\PostsDeleteFilter;
use Application\Form\RevisionForm;
use Application\Form\RevisionFilter;

// models
use Application\Model\Posts;

class PagesController extends AbstractActionController
{
    public $postsTable;
    public $authService;
    public $identity;
    public $categoryRelationshipsTable;
    public $categoryTable;
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->authService = new AuthenticationService();
        if(! $this->authService->hasIdentity()) {
            $this->redirect()->toRoute("home");
        }
        $auth = $this->authService;
        $this->identity = $auth->getIdentity();
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        return new ViewModel();
    }
    
    public function newAction()
    {
    	return new ViewModel();
    }
    
    public function allAction()
    {
    	// multi action
        $option = $this->params()->fromRoute('id'); // fetchAllCountBy
        $trash = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'trash'); // get all trash posts
        $published = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'published'); // get all published posts
        $all = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'all'); // get all posts
        $draft = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'draft'); // get
        // all posts
        if(isset($option)) :
            $posts = $this->getPostsTable()->fetchAllPublicBy('parent', 0, $option);
                 // get specific status posts
        else :
            $option = 'all';
            $posts = $this->getPostsTable()->fetchAllPublicBy('parent', 0, $option);
                // get all active posts
        endif;
        $i = 0;
        foreach ($posts as $cat) : // get current revisions of posts
            $categories = $this->getCategoryRelationshipsTable()->fetchAllBy('post_id', $cat['post_id']);
            $category_relationship = '';
            foreach ($categories as $cr) :
                $cat = $this->getCategoryTable()->fetch('category_id', $cr['category_id']);
                $category_relationship[] = array('name' => $cat->name,'category_id' => $cat->category_id);
            endforeach;
            $posts[$i]['categories'] = $category_relationship;
            $i ++;
            $category_relationship = ''; // clear array
        endforeach;
        $form = new PostsDeleteForm($option);
        $request = $this->getRequest();
        if($request->isPost()) :
            $form->setInputFilter(new PostsDeleteFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                if($data['bulk_action'] == 1) : // move to trash
                    foreach ($data['cb'] as $cb) : // mutltiple trash
                        $this->getPostsTable()->trash($cb);
                    endforeach;
                    $this->flashMessenger()->addMessage('Post moved to trash.');
                    return $this->redirect()->toRoute('posts', array("action" => "all",'id' => $option));
                 elseif($data['bulk_action'] == 2) : // move to restore
                    foreach ($data['cb'] as $cb) : // mutltiple restore
                        $this->getPostsTable()->restore($cb);
                    endforeach;
                    $this->flashMessenger()->addMessage('Post moved.');
                    return $this->redirect()->toRoute('posts', array("action" => "all",'id' => 'trash'));
                 elseif($data['bulk_action'] == 3) : // delete
                    foreach ($data['cb'] as $cb) : // mutltiple deletion
                        $this->getPostsTable()->delete($cb);
                        $this->getPostsTable()->deleteByParentId($cb);
                        $this->getCategoryRelationshipsTable()->deleteByPostId($cb);
                    endforeach;
                    $this->flashMessenger()->addMessage('Post deleted.');
                    return $this->redirect()->toRoute('posts', array("action" => "all",'id' => 'trash'));
                endif;
    	   endif;
		 // isValid
    	endif;
        return new ViewModel(array('posts' => $posts,'trash' => $trash,'published' => $published,'all' => $all,'draft' => $draft,'form' => $form,'option' => $option));
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    // -> get tables
    public function getPostsTable()
    {
        if(! $this->postsTable) {
            $sm = $this->getServiceLocator();
            $this->postsTable = $sm->get('Application\Model\PostsTable');
        }
        return $this->postsTable;
    }
    public function getCategoryRelationshipsTable()
    {
        if(! $this->categoryRelationshipsTable) {
            $sm = $this->getServiceLocator();
            $this->categoryRelationshipsTable = $sm->get('Application\Model\CategoryRelationshipsTable');
        }
        return $this->categoryRelationshipsTable;
    }
    public function getCategoryTable()
    {
        if(! $this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Application\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
    //-> support functions
    /**
     * Returns all img tags in a HTML string with the option to include img tag attributes
     *
     * @author Joshua Baker
     *
     * @example $post_images[0]->html = <img src="example.jpg">
     * $post_images[0]->attr->width = 500
     *
     * @param $html_string string The HTML string
     * @param $get_attrs boolean If TRUE all of the img tag attributes will be returned
     * @return $post_images array An array of objects
     */
     function get_images($html_string, $get_attrs = FALSE)
     {
    $post_images = array();
    // Get all images
    preg_match_all('/<img (.+)>/', $html_string, $image_matches, PREG_SET_ORDER);
    // Loop the images and add the raw img html tag to $post_images
    foreach ($image_matches as $image_match)
     {
     @$post_image->html = $image_match[0];
     // If attributes have been requested get them and add them to the $post_image
     if ($get_attrs == TRUE)
     {
     preg_match_all('/\s+?(.+)="([^"]*)"/U', $image_match[0], $image_attr_matches, PREG_SET_ORDER);
     foreach ($image_attr_matches as $image_attr)
         {
             @$post_image->attr->{$image_attr[1]} = $image_attr[2];
     }
     }
     $post_images[] = $post_image;
     }
     return $post_images;
     }
     //-> seo friendly
     public function seoUri($title)
     {
         // $title = preg_replace('/[^a-z0-9]/i','-', $title);
         $title = str_replace(" & ","-",strtolower($title));
         $title = str_replace("&","",strtolower($title));
         $title = str_replace('"','',strtolower($title));
         $title = str_replace("'","",strtolower($title));
             $title = str_replace(" ? ","-",strtolower($title));
             $title = str_replace("?","-",strtolower($title));
             $title = str_replace(":","",strtolower($title));
             $title = str_replace(",","",strtolower($title));
             $title = str_replace(" ","-",strtolower($title));

             return $title;
    }
}
