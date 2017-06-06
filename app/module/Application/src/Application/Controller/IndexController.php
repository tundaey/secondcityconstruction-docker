<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;

// forms
use Application\Form\CommentsForm;
use Application\Form\CommentsFilter;

class IndexController extends AbstractActionController
{
    public $postsTable, $categoryRelationshipsTable, $categoryTable, $commentsTable, $galleryTable, $galleryCategoryTable, $galleryCategoryRelationshipsTable;
    
    public function indexAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/';
        $this->layout()->nav = 'home'; 
        $this->layout()->meta_keywords ='Roofer Chicago, Chicago Roofing, Second City Roofing, Chicago Roofing Contractor, Residential Roofing Chicago, Chicagoland Commercial Roofing, Flat Roof in Chicago, Roofing Installation, Roofing, Chicago, Contractor';
        $this->layout()->meta_description = 'Second City Roofing, a renowned Roofer in Chicago. Get the best value on Chicago roofing services, and warranty on the highest quality roofing and home improvement work from the best in Chicagoland.';
        $this->layout()->type = 'website';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
        
        return new ViewModel();
    }
    
    public function aboutChicagoRooferAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/about-chicago-roofer/';
        $this->layout()->nav = 'about';
        $this->layout()->meta_keywords ='roofing company chicago, roofing contractor chicago, roofers chicago';
        $this->layout()->meta_description = 'Involved in roofing for more than 45 years, Second City Roofing &amp; Construction stands out among all roofers in Chicago and holding the position of most trusted contractor for all kind of roof works.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
         
        return new ViewModel();
    }
        
    public function roofingChicagoAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-chicago/';
        $this->layout()->nav = 'roofing';
        $this->layout()->meta_keywords ='roofing service chicago, roofer service in chicago';
        $this->layout()->meta_description = 'Your First Choice For Roofing Chicago, IL. Get the best value, service, and warranty on the highest quality roofing work from the best in Chicago.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
        
        $this->layout()->gallery_category = $this->getGalleryCategoryTable()->fetchAll(); 
        
        return new ViewModel();
    }
        
    public function exteriorRemodelingChicagoAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/exterior-remodeling-chicago/';
        $this->layout()->nav = 'exterior';
        $this->layout()->meta_keywords ='exterior remodeling chicago';
        $this->layout()->meta_description = 'Contact Second City Roofing &amp; Construction, Chicago, for  complete exterior remodeling &amp; upgrades from siding to fencing.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
    
        return new ViewModel();
    }
    
    public function chicagoRoofingEstimateQuoteAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/chicago-roofing-estimate-quote/';
        $this->layout()->nav = 'contact';
        $this->layout()->meta_keywords ='roof estimate chicago, roof replacement chicago, roof installations chicago';
        $this->layout()->meta_description = 'Second City Roofing &amp; Construction, Chicago provides FREE Estimates &amp; Quotes for all kind of Roofing Work. Dial 773-384-6300 to get FREE initial consultation from roofing expert.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
    
        return new ViewModel();
    }
    
    public function thankYouContactUsAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/thank-you-contact-us/';
        $this->layout()->nav = 'contact';
        $this->layout()->meta_keywords ='';
        $this->layout()->meta_description = '';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
    
        $this->layout()->gallery_category = $this->getGalleryCategoryTable()->fetchAll();
    
        return new ViewModel();
    }
    
    // optimization for places
    
    public function roofingBellwoodIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-bellwood-il/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Bellwood IL, Roofing in Bellwood, Remodeling Bellwood, Roofing, Remodeling, Bellwood, 60104';
        $this->layout()->meta_description = 'You have reached the right place for the best roofing in Bellwood, IL 60104! We provide the best options, services and prices in all of Bellwood, IL for your roofing requirements.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'Roofing-Bellwood-IL-300x188.gif';
        
        return new ViewModel();
    }
    
    public function roofingBerwynIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-berwyn-il/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Berwyn IL, Roofing in Berwyn IL, Roofing, Berwyn, 60402';
        $this->layout()->meta_description = 'You are in the right place for all roofing services in Berwyn, IL 60402. Our roofing company with over 45 years helping residents in Berwyn with all roofing needs.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'Roofing-Berwyn-IL-300x188.jpg';
    
        return new ViewModel();
    }
    
    public function roofingBroadviewIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-broadview-il-60155/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Broadview IL 60402, Remodeling Broadview, Roofing in Broadview, Roofing, Broadview, 60155';
        $this->layout()->meta_description = 'With over 45 years of roofing experience, Second City Roofing offer roofing service in Broadview, IL 60155 at the greatest value, without compromising on the quality of services.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-broadview-il-60155.jpg';
    
        return new ViewModel();
    }
    
    public function roofingBurbankIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-burbank-il-60459/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Burbank IL 60459, Remodeling Burbank, Roofing in Burbank, Roofing, Burbank, 60459';
        $this->layout()->meta_description = 'Second City Roofing is here to provide you with the best roofing services in all of Burbank, IL 60459!';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-burbank-il-60459.jpg';
    
        return new ViewModel();
    }
    
    public function roofingCiceroIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-cicero-il-60804/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Cicero IL 60804, Remodeling Cicero, Roofing in Cicero, Roofing, Cicero, 60804';
        $this->layout()->meta_description = 'Providing roofing solutions in Cicero, IL 60804 and all of Chicagoland for over 45 years, Second City Roofing is here to help you get what you need!';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-cicero-il-60804.jpg';
    
        return new ViewModel();
    }
    
    public function roofingForestParkIlAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-forest-park-il-60130/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roofing Forest Park IL 60130, Remodeling Forest Park, Roofing in Forest Park, Roofing, Forest Park, 60130';
        $this->layout()->meta_description = 'Forest Park leading provider of roofing solutions, Second City Roofing and Remodeling has over 45 years of experience and expertise that you not only need, but deserve!';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-forest-park-il-60130.jpg';
    
        return new ViewModel();
    }
    
    public function privacyPolicyAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/privacy-policy/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='privacy policy';
        $this->layout()->meta_description = 'Our online privacy policy.';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
    
        return new ViewModel();
    }
    
    public function blogAction()
    {
        $this->layout('layout/blog');
        $this->layout()->nav = 'blog';
    
        // get relevent posts
        $blog_cat = $this->getCategoryTable()->fetchBlogCategory(1);
        
        foreach ($blog_cat as $bs) :
            $blog_cat_val = $this->getCategoryRelationshipsTable()->fetchAllBy('category_id', $bs->category_id);
            foreach ($blog_cat_val as $bcv) :
                $posts[] = $bcv->post_id;
            endforeach;
        endforeach;
    
        $posts = array_unique($posts);
        $data['posts']  = $this->getPostsTable()->fetchPosts($posts);
    
        $paginator = new Paginator(new \Zend\Paginator\Adapter\Iterator($data['posts']));
        $paginator->setCurrentPageNumber($this->params()->fromRoute('num'));
        $paginator->setItemCountPerPage(10);
    
        // og:tags
        $this->layout()->og_title = 'WebVision Blog';
        $this->layout()->og_image = '';
        $this->layout()->og_name = 'WebVision';
        $this->layout()->og_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->layout()->og_description = 'Recent content from our blog';
    
        return new ViewModel(array('data' => $data, 'paginator' => $paginator));
    }
    
    public function blogPostAction()
    {
        $this->layout('layout/blog');
    
        $uri = $this->params()->fromRoute('uri');
    
        $data['post']  = $this->getPostsTable()->fetchByUri($uri);
        
        // og:tags
        $this->layout()->og_title = $data['post']->title;
        $this->layout()->og_image = ($data['post']->feat_image != '') ? $data['post']->feat_image : '';
        $this->layout()->og_name = 'WebVision';
        $this->layout()->og_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->layout()->og_description = $data['post']->excerpt;
    
        // forms
        $form = new CommentsForm();
    
        $request = $this->getRequest();
    
        $form_status = false;
    
        if($request->isPost()) :
            $form->setInputFilter(new CommentsFilter());
            $form->setData($request->getPost());
    
            if($form->isValid()) :
                $post = $form->getData();
                $date = new \DateTime();
                $post['post_id'] = $data['post']->post_id;
                $post['date'] = $date->format('Y-m-d H:i:s');
                $ins = new Comments();
                $ins->exchangeArray($post);
                $this->getCommentsTable()->insert($ins);
                $form_status = true;
            endif;
        endif;
    
        // get comments
        $comments = $this->getCommentsTable()->fetchAllBy('post_id', $data['post']->post_id);
    
        return new ViewModel(array('data' => $data, 'form' => $form, 'uri' => $uri, 'form_status' => $form_status, 'comments' => $comments));
    }
    
    /*
     * STATIC ARTICLES
     */
    
    public function roofing101Action()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/roofing-101/';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='Roof System, Roofing Fire Resistance, Roofing Appearance, Roof Ventilation and Insulation';
        $this->layout()->meta_description = 'Several factors have to be considered in choosing the system that suits the roof of the house or building, including preferences and budget. These criteria includes: durability, aesthetics, architectural style and cost.';
        $this->layout()->type = 'article';
        $this->layout()->img = '101.jpg';
    
        return new ViewModel();
    }
    
    /*
     * LANDING PAGE
     */
    
    public function lpRoofingAction()
    {
        $this->layout('layout/lp');
    
        $page = $this->params()->fromRoute('page');
        //echo "page".$page;exit;
        $this->layout()->url = 'http://www.secondcityconstruction.com/lp/roofing.html';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='';
        $this->layout()->meta_description = '';
        $this->layout()->type = 'article';
        $this->layout()->img = '';
             
        return new ViewModel(array('page' => $page));
    }
    
    public function lpMasonryAction()
    {
        $this->layout('layout/lp');
    
        $page = $this->params()->fromRoute('page');
        //echo "page".$page;exit;
        $this->layout()->url = 'http://www.secondcityconstruction.com/lp/masonry.html';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='';
        $this->layout()->meta_description = '';
        $this->layout()->type = 'article';
        $this->layout()->img = '';
         
        return new ViewModel(array('page' => $page));
    }
    
    public function lpSidingAction()
    {
        $this->layout('layout/lp');
    
        $page = $this->params()->fromRoute('page');
        //echo "page".$page;exit;
        $this->layout()->url = 'http://www.secondcityconstruction.com/lp/siding.html';
        $this->layout()->nav = '';
        $this->layout()->meta_keywords ='';
        $this->layout()->meta_description = '';
        $this->layout()->type = 'article';
        $this->layout()->img = '';
         
        return new ViewModel(array('page' => $page));
    }
    
    /*
     * * GALLERY
     */
    
    public function galleryAction()
    {
        $this->layout()->url = 'http://www.secondcityconstruction.com/gallery/';
        $this->layout()->nav = 'gallery';
        $this->layout()->meta_keywords ='';
        $this->layout()->meta_description = 'Roofing Before and After Gallery';
        $this->layout()->type = 'article';
        $this->layout()->img = 'roofing-chicago-il-300x188.jpg';
        $this->layout()->gallery_category = $this->getGalleryCategoryTable()->fetchAll();
        
        $slug = $this->params()->fromRoute('slug');
        
        $gallery_category = $this->getGalleryCategoryTable()->fetch('slug', $slug); 
        $gallery_relationships = $this->getGalleryCategoryRelationshipsTable()->fetchAllBy('category_id', $gallery_category->category_id);
        
        foreach ($gallery_relationships as $gr) :
            $galleries[$gr->gallery_id] = $this->getGalleryTable()->fetch($gr->gallery_id);
            $pictures[$gr->gallery_id] = $this->getGalleryTable()->fetchAllBy('variation', $gr->gallery_id, 'position');
        endforeach;
    
        return new ViewModel(array('galleries' => $galleries, 'pictures' => $pictures, 'gallery_category' => $gallery_category));
    }
    
    // redicrect with correct SEO
    public function tuckpointingChicagoAction()
    {
        $this->redirect()->toRoute('exterior_remodeling_chicago')->setStatusCode(301);
    }
    public function interiorRemodelingChicagoAction()
    {
        $this->redirect()->toRoute('exterior_remodeling_chicago')->setStatusCode(301);
    }
    public function porchBuilderChicagoAction()
    {
        $this->redirect()->toRoute('exterior_remodeling_chicago')->setStatusCode(301);
    }
    public function roofingBellwoodIAction()
    {
        $this->redirect()->toRoute('roofing_bellwood_il')->setStatusCode(301);
    }
    
    /*
     * * TABLES
     */
    
    public function getCommentsTable()
    {
        if(! $this->commentsTable) {
            $sm = $this->getServiceLocator();
            $this->commentsTable = $sm->get('Application\Model\CommentsTable');
        }
        return $this->commentsTable;
    }
    
    public function getCategoryRelationshipsTable()
    {
        if(! $this->categoryRelationshipsTable) {
            $sm = $this->getServiceLocator();
            $this->categoryRelationshipsTable = $sm->get('Application\Model\CategoryRelationshipsTable');
        }
        return $this->categoryRelationshipsTable;
    }
    
    public function getPostsTable()
    {
        if(! $this->postsTable) {
            $sm = $this->getServiceLocator();
            $this->postsTable = $sm->get('Application\Model\PostsTable');
        }
        return $this->postsTable;
    }
    
    public function getCategoryTable()
    {
        if(! $this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Application\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
    
    public function getGalleryTable()
    {
        if(! $this->galleryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryTable = $sm->get('Application\Model\GalleryTable');
        }
        return $this->galleryTable;
    }
    
    public function getGalleryCategoryTable()
    {
        if(! $this->galleryCategoryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryCategoryTable = $sm->get('Application\Model\GalleryCategoryTable');
        }
        return $this->galleryCategoryTable;
    }
    
    public function getGalleryCategoryRelationshipsTable()
    {
        if(! $this->galleryCategoryRelationshipsTable) {
            $sm = $this->getServiceLocator();
            $this->galleryCategoryRelationshipsTable = $sm->get('Application\Model\GalleryCategoryRelationshipsTable');
        }
        return $this->galleryCategoryRelationshipsTable;
    }
    
}
