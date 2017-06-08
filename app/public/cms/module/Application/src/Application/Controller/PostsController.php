<?php
/**
 * Zend Framework (http://framework.zend.com/)
 * @link http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

// forms & filters
use Application\Form\CategoryAddForm;
use Application\Form\CategoryAddFilter;
use Application\Form\CategoryDeleteForm;
use Application\Form\CategoryDeleteFilter;
use Application\Form\CategoryEditForm;
use Application\Form\CategoryEditFilter;
use Application\Form\PostsForm;
use Application\Form\PostsFilter;
use Application\Form\PostsEditForm;
use Application\Form\PostsDeleteForm;
use Application\Form\PostsDeleteFilter;
use Application\Form\RevisionForm;
use Application\Form\RevisionFilter;

// models
use Application\Model\Category;
use Application\Model\Posts;

class PostsController extends AbstractActionController
{
    public $categoryTable;
    public $postsTable;
    public $authService;
    public $identity;
    public $categoryRelationshipsTable;
    
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
        
        // $this->redirect()->toRoute("posts", array("action" => "all"));
        return new ViewModel();
    }
    public function deleteAction()
    {
        return new ViewModel();
    }
    public function allAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        // multi action
        $option = $this->params()->fromRoute('id'); // fetchAllCountBy
        $trash = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'trash'); // get all trash posts
        $published = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'published'); // get all published posts
        $all = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'all'); // get all posts
        $draft = $this->getPostsTable()->fetchAllCountBy('parent', 0, 'draft'); // get
        // all posts
        if(isset($option)) :
            $posts = $this->getPostsTable()->fetchAllPublicBy('parent', 0, $option); // get specific status posts
        else :
            $option = 'all';
            $posts = $this->getPostsTable()->fetchAllPublicBy('parent', 0, $option); // get all active posts
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
    
    public function trashAction()
    {
        $id = $this->params()->fromRoute('id');
        if(! isset($id)) :return $this->redirect()->toRoute('posts', array("action" => "new"));
		        
		 endif;
        $this->getPostsTable()->trash($id); // move post to trash
        $this->flashMessenger()->addMessage('Post moved to trash.');
        return $this->redirect()->toRoute('posts', array("action" => "all"));
    }
    public function revisionAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        if(! isset($id)) :return $this->redirect()->toRoute('posts', array("action" => "new")); endif;
        $right = $this->getPostsTable()->fetch('post_id', $id);
        $left = $this->getPostsTable()->revisionPrevies('parent', $right);
        $next = $this->getPostsTable()->nextPrevies('parent', $right);
        $preview = $this->getPostsTable()->revisionPrevies('parent', $right);
        $current = $this->getPostsTable()->fetch('post_id', $right->parent); // current
        // published
        $current_revision = $this->getPostsTable()->currentRevision('parent', $current->post_id); // latest
        // revision
        $form = new RevisionForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            $form->setInputFilter(new RevisionFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                $data['author'] = $current->author;
                $data['content'] = $right->content;
                $data['parent'] = $right->parent;
                $data['title'] = $right->title;
                if($current->title != $right->title ) : // checking for url
                    $data['uri'] = $this->getPostsTable()->fetchUriDuplicates($this->seoUri($data['title']),'.html');
                else :
                    $data['uri'] = $right->uri;
                endif;
                $data['keyword'] = $right->keyword;
                $data['excerpt'] = $right->excerpt;
                $data['status'] = $current->status;
                $date = new \DateTime();
                $data['date'] = $date->format('Y-m-d H:i:s');
                $data['modified'] = $date->format('Y-m-d H:i:s');
                $data['type'] = 'post';
                $post = new Posts();
                $post->exchangeArray($data);
                $post->date_publish = $current->date;
                $id = $this->getPostsTable()->update($post);
                $this->flashMessenger()->addMessage('Post restored.');
                return $this->redirect()->toRoute('posts', array("action" => "edit","id" => $current->post_id));
	    	endif;
    	endif;
        return new ViewModel(array('left' => $left,'right' => $right,'preview' => $preview,'next' => $next,'current' => $current,'current_revision' => $current_revision,'form' => $form,'id' => $id));
    }
    public function newAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $category = $this->getCategoryTable()->fetchAll();
        $form = new PostsForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            $form->setInputFilter(new PostsFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                if($data['feat_image'] != '') : // add featured image or trim($data['feat_image']) != '<p><br></p>'
                    $img = $this->get_images($data['feat_image'], TRUE);
                    $data['feat_image'] = $img[0]->attr->src;
                endif;
                $data['author'] = $this->identity->usr_id;
                $date = new \DateTime();
                $d = $data['aa'] . '-' . $data['mm'] . '-' . $data['jj'] . ' ' . $data['hh'] . ':' . $data['mn'];
                $data['date'] = date('Y-m-d H:i:s', strtotime($d));
                $data['modified'] = $date->format('Y-m-d H:i:s');
                $uri = $this->getPostsTable()->fetchUriDuplicates($this->seoUri($data['title']),'.html');
                $data['uri'] = $uri; // Final URL
                $post = new Posts();
                $post->exchangeArray($data);
                $id = $this->getPostsTable()->save($post);
                $this->getCategoryRelationshipsTable()->save($data['cb'], $id); // save category
                $this->flashMessenger()->addMessage('Post published.');
                return $this->redirect()->toRoute('posts', array("action" => "edit","id" => $id));
           endif;
        endif;
        return new ViewModel(array('category' => $category,'form' => $form));
    }
    public function editAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        if(! isset($id)) :return $this->redirect()->toRoute('posts', array("action" => "new")); endif;
        $config = $this->getServiceLocator()->get('Config'); // get websites config
        $post = $this->getPostsTable()->fetch('post_id', $id);
        $posts = $this->getPostsTable()->fetchAllRevisionCountBy('parent', $id);
        $post_current = $this->getPostsTable()->currentRevision('parent', $id);
        $form = new PostsEditForm($post,$this->identity);
        $request = $this->getRequest();
        if($request->isPost()) :
            $form->setInputFilter(new PostsFilter());
            $form->setData($request->getPost());
            if($form->isValid()) : 
                $data = $form->getData();
                if($data['feat_image'] != '' or trim($data['feat_image']) != '<p><br></p>') : // add featured image
                    $img = $this->get_images($data['feat_image'], TRUE);
                    $data['feat_image'] = $img[0]->attr->src;
                endif; 
                $this->getCategoryRelationshipsTable()->save($data['cb'], $post->post_id); // save category
                $data['author'] = $this->identity->usr_id;
                /*
                if($data['uri'] != $post->uri ) : // checking for url
                    $data['uri'] = $this->getPostsTable()->fetchUriDuplicates($this->seoUri($data['title']),'.html');
                else :
                    $data['uri'] = $post->uri;
                endif;
                */
                $date = new \DateTime();
                $data['modified'] = $date->format('Y-m-d H:i:s');
                if($data['type'] == 'disclaimer' || $data['type'] == 'page') : // remove from categories
                    $this->getCategoryRelationshipsTable()->deleteByPostId($id);
                endif;
                $d = $data['aa'] . '-' . $data['mm'] . '-' . $data['jj'] . ' ' . $data['hh'] . ':' . $data['mn'];
                $post = new Posts();
                $post->exchangeArray($data);
                $post->date_publish = date('Y-m-d H:i:s', strtotime($d)); 
                $this->getPostsTable()->update($post); // update post
                $this->flashMessenger()->addMessage('Post updated.');
                return $this->redirect()->toRoute('posts', array("action" => "edit","id" => $id));
             else :
                return $this->redirect()->toRoute('posts', array("action" => "edit","id" => $id));
            endif;
    	endif;
        $category = $this->getCategoryTable()->fetchAll();
        $category_selected = $this->getCategoryRelationshipsTable()->fetchAllBy('post_id', $post->post_id);

        return new ViewModel(array('category' => $category,'category_selected' => $category_selected,'form' => $form,'post' => $post,'posts' => $posts,'post_current' => $post_current,'id' => $id, 'config'=>$config, 'user' => $this->identity));
    }
    public function categoryEditAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        $category = $this->getCategoryTable()->fetch('category_id', $id);
        $categories = $this->getCategoryTable()->fetchAll();
        $form = new CategoryEditForm($category,$categories);
        $request = $this->getRequest();
        if($request->isPost()) :
            $form->setInputFilter(new CategoryEditFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'), $category, $_POST['slug']));
            $form->setData($request->getPost());
            if($form->isValid()) :
                $data = $form->getData();
                $cat = new Category();
                $cat->exchangeArray($data);
                $this->getCategoryTable()->update($cat);
                $this->flashMessenger()->addMessage('Categories edited.');
                return $this->redirect()->toRoute('posts', array("action" => "category"));
            endif;
		 // if isValid
        endif;
        return new ViewModel(array('form' => $form,'category' => $category,'id' => $id));
    }
    public function categoryAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $category_root = $this->getCategoryTable()->fetchAllBy('parent', 0);
        
        $form_add = new CategoryAddForm($category_root);
        $form_delete = new CategoryDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new CategoryDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['category_id'] = $cb;
                                $del = new Category();
                                $del->exchangeArray($data);
                                $this->getCategoryTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Categories deleted.');
                        return $this->redirect()->toRoute('posts', array("action" => "category"));
                 endif;  // post['delete']
            else :
                $form_add->setInputFilter(new CategoryAddFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')));
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $cat = new Category();
                    $cat->exchangeArray($data);
                    $this->getCategoryTable()->save($cat);
                    $this->flashMessenger()->addMessage('Categories added.');
                    return $this->redirect()->toRoute('posts', array("action" => "category"));
                endif;  // if isValid
            endif;
        endif; // isPost
        
        $category = $this->getCategoryTable()->fetchAll();
        $cat_rel = $this->getCategoryRelationshipsTable()->fetchAll();
        
        foreach ($cat_rel as $cr) : // category count number
            if($this->getPostsTable()->isTrash($cr->post_id) == TRUE) :
                $cat_count[$cr->category_id][$cr->post_id] = 'on';
            endif;
        endforeach;
        return new ViewModel(array('form_add' => $form_add,'category' => $category,'form_delete' => $form_delete, 'cat_count'=>$cat_count));
    }
    // -> get tables
    public function getCategoryTable()
    {
        if(! $this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Application\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
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
        $title = preg_replace('/[^a-z0-9]/i','-', $title);
        $title = str_replace(" & ","-",strtolower($title));
        $title = str_replace("&","",strtolower($title));
        $title = str_replace('"','',strtolower($title));
        $title = str_replace("'","",strtolower($title));
        $title = str_replace(" ? ","",strtolower($title));
        $title = str_replace("?","",strtolower($title));
        $title = str_replace(":","",strtolower($title));
        $title = str_replace(",","",strtolower($title));
        $title = str_replace(" ","-",strtolower($title));
        $title = str_replace("--","-",strtolower($title));
        $title = str_replace("---","-",strtolower($title));
        $title = (substr($title, -1) == '-') ? substr($title, 0, -1) : $title;
        
        return $title;
    }
}
