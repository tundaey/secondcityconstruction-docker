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

// forms & filters
use Application\Form\GalleryCategoryAddForm;
use Application\Form\GalleryCategoryAddFilter;
use Application\Form\GalleryAddForm;
use Application\Form\GalleryAddOptionForm;
use Application\Form\GalleryAddOptionFilter;
use Application\Form\GalleryDeleteForm;
use Application\Form\GalleryDeleteFilter;
use Application\Form\GalleryEditForm;
use Application\Form\GalleryEditFilter;
use Application\Form\GalleryVariationEditForm;
use Application\Form\GalleryVariationEditFilter;
 
use Application\Form\ProductAddForm;
use Application\Form\ProductAddFilter;
use Application\Form\ProductDeleteForm;
use Application\Form\ProductDeleteFilter;
use Application\Form\ProductEditForm;
use Application\Form\ProductEditFilter;
use Application\Form\ProductCategoryEditForm;
use Application\Form\ProductCategoryEditFilter;

use Application\Form\ProductCategoryMainEditForm;
use Application\Form\ProductCategoryMainEditFilter;
use Application\Form\ProductAddOptionForm;
use Application\Form\ProductAddOptionFilter;

use Application\Form\ProductPromoAddForm;
use Application\Form\ProductPromoAddFilter;
use Application\Form\ProductPromoDeleteForm;
use Application\Form\ProductPromoDeleteFilter;

use Application\Form\DeliveryRangeForm;
use Application\Form\DeliveryRangeFilter;
use Application\Form\DeliveryTimeForm;
use Application\Form\DeliveryTimeFilter;
use Application\Form\DeliveryDisableDayForm;
use Application\Form\DeliveryDisableDayFilter;
use Application\Form\DeliveryDisableTimeForm;
use Application\Form\DeliveryDisableTimeFilter;
use Application\Form\DeliveryZipCodeForm;
use Application\Form\DeliveryZipCodeFilter;


use Application\Form\CategoryDeleteForm;
use Application\Form\CategoryAddProductFilter;
use Application\Form\CategoryDeleteFilter;


// models
use Application\Model\GalleryCategory;
use Application\Model\Gallery;
use Application\Model\GalleryCategoryRelationships;




use Application\Model\Options;
use Application\Model\Products;

use Application\Model\ProductCategoryRelationships;
use Application\Model\DeliveryRange;
use Application\Model\DeliveryTime;
use Application\Model\DeliveryDisableDay;
use Application\Model\DeliveryDisableTime;
use Application\Model\DeliveryZipCode;
use Application\Model\Promotions;



class GalleryController extends AbstractActionController
{
    public $galleryCategoryTable, $galleryCategoryRelationshipsTable, $galleryTable;
    
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
        $root_categories = $this->getGalleryCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getGalleryCategoryTable()->fetchAllBy('parent', '>');
        $gallery = $this->getGalleryTable()->fetchAll();
    
        $form_add = new GalleryAddForm($config, $root_categories, $category);
        $form_delete = new ProductDeleteForm();
        $request = $this->getRequest(); 
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new GalleryDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                            if($data['bulk_action']==1) :
                                foreach ($data['cb'] as $cb) : // mutltiple deletion
                                    $data['id'] = $cb;
                                    
                                    // delete all files in category
                                    $del_files = $this->getGalleryTable()->fetchAllBy('variation', $data['id'], "position");
                                    foreach ($del_files as $df) :
                                        unlink('./public/media/'.$config['website']['media'].'/gallery/'.$df->image); 
                                    endforeach;
                                    
                                    $pro = new Gallery();
                                    $pro->exchangeArray($data);
                                    $this->getGalleryTable()->delete($pro);
                                    $this->getGalleryTable()->deleteVariation($pro);
                                    $this->getGalleryCategoryRelationshipsTable()->deleteGallery($pro);
                                    
                                endforeach;
                            endif; // bulk_action
                            $this->flashMessenger()->addMessage('Product deleted.');
                            return $this->redirect()->toRoute('gallery');
                        endif;  // post['delete'] 
                    
                    else : // add new gallery picture
                    
                        $post = array_merge_recursive(
                            $request->getPost()->toArray(),
                            $request->getFiles()->toArray()
                        );
                         
                        $form_add->setData($post);
                        
                        if($form_add->isValid()) :

                            $data = $form_add->getData();
                             
                            // image/png,image/x-png,image/jpeg,image/gif
                            switch ($data["image"]['type']) {
                                case 'image/png' 	: $ext = '.png'; break;
                                case 'image/x-png' 	: $ext = '.png'; break;
                                case 'image/jpeg' 	: $ext = '.jpg'; break;
                                case 'image/gif' 	: $ext = '.gif'; break;
                            }
     
                            $file = $data["image"]["tmp_name"];
                            $file_full = md5(mktime()).$ext;
                        
                            rename($file, './public/media/'.$config['website']['media'].'/gallery/'.$file_full);
                            
                            $this->image_resize('./public/media/' . $config['website']['media'] . '/gallery/' . $file_full, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full, $width = 500, $height = 500);
                            
                            $data['image'] = $file_full;
                            // add product
                            $p = new Gallery();
                            $p->exchangeArray($data);
                            $id = $this->getGalleryTable()->insert($p);
                            $data['id'] = $id;
                            $p->exchangeArray($data);
                            $this->getGalleryTable()->insertFirstVariation($p);
                            // add category
                            $p = new GalleryCategoryRelationships();
                            $p->exchangeArray($data);
                            $this->getGalleryCategoryRelationshipsTable()->insert($p);
                            // add msg
                            $this->flashMessenger()->addMessage('Picture added.');
    
                        return $this->redirect()->toRoute('gallery');
                    endif; // if isValid
                endif;    
        endif; // isPost
    
        // geting ready for category view
        $root_categories = $this->getGalleryCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getGalleryCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getGalleryCategoryRelationshipsTable()->fetchAll();
    
        return new ViewModel(array('form_add' => $form_add,'form_delete' => $form_delete, 'config'=>$config, 'gallery'=>$gallery, 'root_categories' => $root_categories, 'category' => $category, 'cat_rel' => $cat_rel));
    }
    
    public function variationsAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $id = $this->params()->fromRoute('id');
        $gallery = $this->getGalleryTable()->fetch($id);
        
        $form_add = new GalleryAddOptionForm($config);
        $form_delete = new GalleryDeleteForm();
        
        $request = $this->getRequest();
        
        if ($request->isPost()) :
            // separete forms
            $form_delete->setInputFilter(new GalleryDeleteFilter());
            $form_delete->setData($request->getPost());
            if($_POST['submit'] == 'Apply') :
                if($form_delete->isValid()) :
                    $data = $form_delete->getData();
                    if($data['bulk_action']==1) :
                        foreach ($data['cb'] as $cb) : // mutltiple deletion
                            $data['id'] = $cb;
                            $pro = new Gallery();
                            $pro->exchangeArray($data);
                            $this->getGalleryTable()->delete($pro);
                            unlink('./public/media/'.$config['website']['media'].'/gallery/'.$data['file'][$cb]); // delete file
                        endforeach;
                    endif; // bulk_action                    
                    $this->flashMessenger()->addMessage('Product option deleted.');
                    // return $this->redirect()->toRoute('gallery', array('action' => 'variations', 'id' => $id));
                endif;  // post['delete']
            
            elseif($_POST['submit'] == 'Add Option') :
                    
                    $post = array_merge_recursive(
                        $request->getPost()->toArray(),
                        $request->getFiles()->toArray()
                    );
                    
                    $form_add->setData($post);
                    
                    if($form_add->isValid()) :
                        
                        $data = $form_add->getData();
                         
                        // image/png,image/x-png,image/jpeg,image/gif
                        switch ($data["image"]['type']) {
                            case 'image/png' 	: $ext = '.png'; break;
                            case 'image/x-png' 	: $ext = '.png'; break;
                            case 'image/jpeg' 	: $ext = '.jpg'; break;
                            case 'image/gif' 	: $ext = '.gif'; break;
                        }
                         
                        $file = $data["image"]["tmp_name"];
                        $file_full = md5(mktime()).$ext;
                        
                        rename($file, './public/media/'.$config['website']['media'].'/gallery/'.$file_full);
                        
                        $this->image_resize('./public/media/' . $config['website']['media'] . '/gallery/' . $file_full, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full, $width = 500, $height = 500);
                        
                        $data['image'] = $file_full;
                        
                        $data['id'] = $id;
                        $pro = new Gallery();
                        $pro->exchangeArray($data);
                        $this->getGalleryTable()->insertVariation($pro);
                        $this->flashMessenger()->addMessage('Image was added.');
                    return $this->redirect()->toRoute('gallery', array('action' => 'variations', 'id' => $id));
                endif;
            endif;
            
            
        endif;
        
        $product_variations = $this->getGalleryTable()->fetchAllBy('variation',$id,'position');
    
        return new ViewModel(array( 'gallery' => $gallery, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'product_variations' => $product_variations, 'form_delete' => $form_delete));
    }
    
    public function categoryMainEditAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $id = $this->params()->fromRoute('id');
        $category = $this->getGalleryCategoryTable()->fetch('category_id', $id);
        $categories = $this->getGalleryCategoryTable()->fetchAll();
        $form_add = new ProductCategoryMainEditForm($category, $categories, $config);
        $request = $this->getRequest();
            
        if ($request->isPost()) :
             
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
        
            $form_add->setData($post);
            if($form_add->isValid()) :
                
                $data = $form_add->getData();     
                if($data['image']['name'] != '') : // check for image update
                    // image/png,image/x-png,image/jpeg,image/gif
                    switch ($data["image"]['type']) {
                        case 'image/png' 	: $ext = '.png'; break;
                        case 'image/x-png' 	: $ext = '.png'; break;
                        case 'image/jpeg' 	: $ext = '.jpg'; break;
                        case 'image/gif' 	: $ext = '.gif'; break;
                    }
                 
                    $file = $data["image"]["tmp_name"];
                    $file_full = md5(mktime()).$ext;
                    
                    rename($file, './public/media/'.$config['website']['media'].'/gallery/'.$file_full);
                    
                    $data['image'] = $file_full;
                endif;
                // update category
                $product = new GalleryCategory();
                $product->exchangeArray($data);
                $this->getGalleryCategoryTable()->update($product);
                // add category
                $this->flashMessenger()->addMessage('Category edited.');
                
               return $this->redirect()->toRoute('gallery', array("action" => "category"));
            endif; // if isValid
            
        endif;
        
        return new ViewModel(array('form' => $form_add,'category' => $category,'id' => $id, 'config' => $config));
    }
    
    public function categoryAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array(
            'site_name' => $config['website']['site_name']
        ));
        
        $form_add = new GalleryCategoryAddForm($this->getGalleryCategoryTable()->fetchAllBy('parent', 0));
        $form_delete = new CategoryDeleteForm();
        $request = $this->getRequest();
        if ($request->isPost()) :        
            if ($_POST['submit'] == 'Apply') : // Todo finding better way to separete forms
                $form_delete->setInputFilter(new CategoryDeleteFilter());
                $form_delete->setData($request->getPost());
                if ($form_delete->isValid()) :
                    $data = $form_delete->getData();
                    if ($data['bulk_action'] == 1) :
                        foreach ($data['cb'] as $cb) : // mutltiple deletion
                            $data['category_id'] = $cb;
                            $del = new GalleryCategory();
                            $del->exchangeArray($data);
                            $this->getGalleryCategoryTable()->delete($del);
                        endforeach;                    
                    endif; // bulk_action
                        $this->flashMessenger()->addMessage('Gallery deleted.');
                    return $this->redirect()->toRoute('gallery', array("action" => "category"));                
                endif; // post['delete']
                
            else :
                $form_add->setInputFilter(new GalleryCategoryAddFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')));
                $form_add->setData($request->getPost());
                if ($form_add->isValid()) :
                    $data = $form_add->getData();  
                    $cat = new GalleryCategory();
                    $cat->exchangeArray($data);
                    $this->getGalleryCategoryTable()->save($cat);
                    $this->flashMessenger()->addMessage('Gallery added.');
                    return $this->redirect()->toRoute('gallery', array("action" => "category"));                
                endif; // if isValid
            endif;
        endif; // isPost
        $root_categories = $this->getGalleryCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getGalleryCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getGalleryCategoryRelationshipsTable()->fetchAll();
        
        $cat_count = 0;
        return new ViewModel(array('form_add' => $form_add,'category' => $category,'form_delete' => $form_delete, 'cat_count'=>$cat_count, 'root_categories' => $root_categories));
    }
    
    
    public function editAction()
    {
            // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array(
            'site_name' => $config['website']['site_name']
        ));
        
        $id = $this->params()->fromRoute('id');
        $gallery = $this->getGalleryTable()->fetch($id);
        // categories
        $root_categories = $this->getGalleryCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getGalleryCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getGalleryCategoryRelationshipsTable()->fetch('gallery_id', $gallery->id);
        
        $form_add = new GalleryAddOptionForm($config);
        $form_delete = new GalleryDeleteForm();
        $form = new GalleryEditForm($gallery, $root_categories, $category, $cat_rel);
        
        $request = $this->getRequest();
        if ($request->isPost()) :
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);
            if ($form->isValid()) :
                
                $data = $form->getData();
                if ($data['image']['name'] != '') : // check for image update
                    switch ($data["image"]['type']) {
                        case 'image/png':
                            $ext = '.png';
                            break;
                        case 'image/x-png':
                            $ext = '.png';
                            break;
                        case 'image/jpeg':
                            $ext = '.jpg';
                            break;
                        case 'image/gif':
                            $ext = '.gif';
                            break;
                    }
                    
                    $file = $data["image"]["tmp_name"];
                    $file_full = md5(mktime()) . $ext;
                    
                    rename($file, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full);
                    
                    $this->image_resize('./public/media/' . $config['website']['media'] . '/gallery/' . $file_full, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full, $width = 500, $height = 500);
                    
                    $data['image'] = $file_full;
                
                endif;        
                        
                $data['id'] = $id;
                
                // gallery table update
                $pro = new Gallery();
                $pro->exchangeArray($data);
                $this->getGalleryTable()->update($pro);
                // gallery and category relationship update
                $pc = new GalleryCategoryRelationships();
                $data['id'] = $data['cat_rel_id'];
                $pc->exchangeArray($data);
                $this->getGalleryCategoryRelationshipsTable()->update($pc);
                $this->flashMessenger()->addMessage('Picture edited.');
                return $this->redirect()->toRoute('gallery');
            else :
                foreach ($form->getMessages() as $m) :
                    var_dump($m);
                endforeach
                ;
            endif;
         // if isValid
        endif;
    
        return new ViewModel(array( 'form' => $form, 'product' => $gallery, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'form_delete' => $form_delete));
    }
    
    public function variationEditAction()
    {
            // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array(
            'site_name' => $config['website']['site_name']
        ));
        
        $id = $this->params()->fromRoute('id');
        $gallery = $this->getGalleryTable()->fetch($id);
        // categories
        $root_categories = $this->getGalleryCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getGalleryCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getGalleryCategoryRelationshipsTable()->fetch('gallery_id', $gallery->id);
        
        $form_add = new GalleryAddOptionForm($config);
        $form_delete = new GalleryDeleteForm();
        $form = new GalleryVariationEditForm($gallery);
        
        $request = $this->getRequest();
        if ($request->isPost()) :
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            
            $form->setData($post);
            if ($form->isValid()) :
                
                $data = $form->getData();
                if ($data['image']['name'] != '') : // check for image update
                    switch ($data["image"]['type']) {
                        case 'image/png':
                            $ext = '.png';
                            break;
                        case 'image/x-png':
                            $ext = '.png';
                            break;
                        case 'image/jpeg':
                            $ext = '.jpg';
                            break;
                        case 'image/gif':
                            $ext = '.gif';
                            break;
                    }
                    
                    $file = $data["image"]["tmp_name"];
                    $file_full = md5(mktime()) . $ext;
                    
                    rename($file, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full); 

                    $this->image_resize('./public/media/' . $config['website']['media'] . '/gallery/' . $file_full, './public/media/' . $config['website']['media'] . '/gallery/' . $file_full, $width = 500, $height = 500);
                    
                    $data['image'] = $file_full;
                    unlink('./public/media/'.$config['website']['media'].'/gallery/'.$gallery->image); // delete file
                endif;        
                        
                $data['id'] = $id;
                
                // gallery table update
                $pro = new Gallery();
                $pro->exchangeArray($data);
                $this->getGalleryTable()->update($pro);                
                $this->flashMessenger()->addMessage('Picture edited.');
                return $this->redirect()->toRoute('gallery', array('action' => 'variations', 'id' => $gallery->variation));
                
            else :
                foreach ($form->getMessages() as $m) :
                    var_dump($m);
                endforeach;
            endif;
         // if isValid
        endif;
    
        return new ViewModel(array( 'form' => $form, 'product' => $gallery, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'form_delete' => $form_delete));
    }
    
    //-> get tables
    
    public function getGalleryCategoryRelationshipsTable()
    {
        if(! $this->galleryCategoryRelationshipsTable) {
            $sm = $this->getServiceLocator();
            $this->galleryCategoryRelationshipsTable = $sm->get('Application\Model\GalleryCategoryRelationshipsTable');
        }
        return $this->galleryCategoryRelationshipsTable;
    }
    
    public function getGalleryCategoryTable()
    {
        if(! $this->galleryCategoryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryCategoryTable = $sm->get('Application\Model\GalleryCategoryTable');
        }
        return $this->galleryCategoryTable;
    }
    
    public function getGalleryTable()
    {
        if(! $this->galleryTable) {
            $sm = $this->getServiceLocator();
            $this->galleryTable = $sm->get('Application\Model\GalleryTable');
        }
        return $this->galleryTable;
    }
    
    /*
     * * PICTURE RESIZE
     */
    
    function image_resize($src, $dst, $width, $height, $crop=0){
    
        if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
    
        $type = strtolower(substr(strrchr($src,"."),1));
        if($type == 'jpeg') $type = 'jpg';
        switch($type){
            case 'bmp': $img = imagecreatefromwbmp($src); break;
            case 'gif': $img = imagecreatefromgif($src); break;
            case 'jpg': $img = imagecreatefromjpeg($src); break;
            case 'png': $img = imagecreatefrompng($src); break;
            default : return "Unsupported picture type!";
        }
    
        // resize
        if($crop){
            if($w < $width or $h < $height) return "Picture is too small!";
            $ratio = max($width/$w, $height/$h);
            $h = $height / $ratio;
            $x = ($w - $width / $ratio) / 2;
            $w = $width / $ratio;
        }
        else{
            if($w < $width and $h < $height) return "Picture is too small!";
            $ratio = min($width/$w, $height/$h);
            $width = $w * $ratio;
            $height = $h * $ratio;
            $x = 0;
        }
    
        $new = imagecreatetruecolor($width, $height);
    
        // preserve transparency
        if($type == "gif" or $type == "png"){
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
    
        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
    
        switch($type){
            case 'bmp': imagewbmp($new, $dst); break;
            case 'gif': imagegif($new, $dst); break;
            case 'jpg': imagejpeg($new, $dst); break;
            case 'png': imagepng($new, $dst); break;
        }
        return true;
    }
}
