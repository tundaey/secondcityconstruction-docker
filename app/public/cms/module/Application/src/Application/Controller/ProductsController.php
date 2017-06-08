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
use Application\Form\ProductAddForm;
use Application\Form\ProductAddFilter;
use Application\Form\ProductDeleteForm;
use Application\Form\ProductDeleteFilter;
use Application\Form\ProductEditForm;
use Application\Form\ProductEditFilter;
use Application\Form\ProductVariationEditForm;
use Application\Form\ProductVariationEditFilter;
use Application\Form\ProductCategoryEditForm;
use Application\Form\ProductCategoryEditFilter;
use Application\Form\ProductCategoryAddForm;
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
use Application\Model\Options;
use Application\Model\Products;
use Application\Model\ProductCategory;
use Application\Model\ProductCategoryRelationships;
use Application\Model\DeliveryRange;
use Application\Model\DeliveryTime;
use Application\Model\DeliveryDisableDay;
use Application\Model\DeliveryDisableTime;
use Application\Model\DeliveryZipCode;
use Application\Model\Promotions;
use Application\Form\TaxClearForm;
use Application\Model\Orders;


class ProductsController extends AbstractActionController
{
    public $optionsTable;  
    public $categoryTable;
    public $productsTable;
    public $productCategoryTable;
    public $productCategoryRelationshipsTable;
    public $deliveryRangeTable;
    public $deliveryTimeTable;
    public $deliveryDisableDayTable;
    public $deliveryDisableTimeTable;
    public $deliveryZipCodeTable;
    public $promotionsTable;
    public $ordersTable;
    
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
        $root_categories = $this->getProductCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getProductCategoryTable()->fetchAllBy('parent', '>');
        $products = $this->getProductsTable()->fetchAll();
        
        $form_add = new ProductAddForm($config, $root_categories, $category);
        $form_delete = new ProductDeleteForm();
        $request = $this->getRequest();
        if($request->isPost()) :
            if($_POST['submit'] == 'Apply') : // Todo finding better way to
                // separete forms
                $form_delete->setInputFilter(new ProductDeleteFilter());
                $form_delete->setData($request->getPost());
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) : 
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $pro = new Products(); 
                                $pro->exchangeArray($data);
                                $this->getProductsTable()->delete($pro);
                                $this->getProductsTable()->deleteVariation($pro);
                                unlink('./public/media/'.$config['website']['media'].'/product/'.$data['file'][$cb]); // delete file
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Product deleted.');
                        return $this->redirect()->toRoute('products');
                 endif;  // post['delete']
            else :
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
                    
                    rename($file, './public/media/'.$config['website']['media'].'/product/'.$file_full);
                    
                    $data['image'] = $file_full;
                    // add product
                    $product = new Products();
                    $product->exchangeArray($data);                    
                    $id = $this->getProductsTable()->insert($product);
                    $data['id'] = $id;
                    $product->exchangeArray($data);
                    $this->getProductsTable()->insertFirstVariation($product);
                    // add category 
                    $product = new ProductCategoryRelationships();
                    $data['product_id'] = $id; 
                    $product->exchangeArray($data); 
                    $this->getProductCategoryRelationshipsTable()->insert($product);
                    // add msg
                    $this->flashMessenger()->addMessage('Product added.');
                    
                    return $this->redirect()->toRoute('products');
                endif; // if isValid    
            endif;
            
        endif; // isPost
        
        // geting ready for category view
        $root_categories = $this->getProductCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getProductCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getProductCategoryRelationshipsTable()->fetchAll();
        
        return new ViewModel(array('form_add' => $form_add,'form_delete' => $form_delete, 'config'=>$config, 'products'=>$products, 'root_categories' => $root_categories, 'category' => $category, 'cat_rel' => $cat_rel));
    }
    
    public function editAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        $product = $this->getProductsTable()->fetch($id);
        // categories
        $root_categories = $this->getProductCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getProductCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getProductCategoryRelationshipsTable()->fetch('product_id', $product->id);
        
        $form_add = new ProductAddOptionForm();
        $form_delete = new ProductDeleteForm();
        $form = new ProductEditForm($product, $root_categories, $category, $cat_rel);
        
        $request = $this->getRequest();
        if ($request->isPost()) :     
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            $form->setData($post);
            if($form->isValid()) :
            
                $data = $form->getData();
                if($data['image']['name'] != '') : // check for image update
                    switch ($data["image"]['type']) {
                        case 'image/png' 	: $ext = '.png'; break;
                        case 'image/x-png' 	: $ext = '.png'; break;
                        case 'image/jpeg' 	: $ext = '.jpg'; break;
                        case 'image/gif' 	: $ext = '.gif'; break;
                    }
                 
                    $file = $data["image"]["tmp_name"];
                    $file_full = md5(mktime()).$ext;
                    
                    rename($file, './public/media/'.$config['website']['media'].'/product/'.$file_full);
                    
                    $data['image'] = $file_full;
                endif;
                
                $data['id'] = $id;
                // product table update
                $pro = new Products();
                $pro->exchangeArray($data);
                $this->getProductsTable()->update($pro);
                // product and category relationship update
                $pc = new ProductCategoryRelationships();
                $data['id'] = $data['cat_rel_id'];
                $pc->exchangeArray($data);
                $this->getProductCategoryRelationshipsTable()->update($pc);
                $this->flashMessenger()->addMessage('Product edited.');
                return $this->redirect()->toRoute('products');
                
                else :
                    foreach ($form->getMessages() as $m) :
                        var_dump($m);
                    endforeach;
            endif; // if isValid
        endif;
        
        return new ViewModel(array( 'form' => $form, 'product' => $product, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'form_delete' => $form_delete));
    }
    
    public function variationEditAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $id = $this->params()->fromRoute('id');
        $product = $this->getProductsTable()->fetch($id);
            
        $form_add = new ProductAddOptionForm();
        $form_delete = new ProductDeleteForm();
        $form = new ProductVariationEditForm($product);
    
        $request = $this->getRequest();
        if ($request->isPost()) :
            $form->setInputFilter(new ProductVariationEditFilter());
            $form->setData($request->getPost());
            if($form->isValid()) :
                $form->getData($request->getPost());
                $data = $form->getData();
                $data['id'] = $id;
                // product table update
                $pro = new Products();
                $pro->exchangeArray($data);
                $this->getProductsTable()->updateVariation($pro);              
                $this->flashMessenger()->addMessage('Product variation edited.');
            return $this->redirect()->toRoute('products', array('action'=>'variations','id'=>$product->variation));
        
            else :
            foreach ($form->getMessages() as $m) :
                // var_dump($m);
            endforeach;
        endif; // if isValid
        endif;
    
        return new ViewModel(array( 'form' => $form, 'product' => $product, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'form_delete' => $form_delete));
    }
    
    public function variationsAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $id = $this->params()->fromRoute('id');
        $product = $this->getProductsTable()->fetch($id);
        
        $form_add = new ProductAddOptionForm();
        $form_delete = new ProductDeleteForm();
        
        $request = $this->getRequest();
        
        if ($request->isPost()) :
        // separete forms
        $form_delete->setInputFilter(new ProductDeleteFilter());
        $form_delete->setData($request->getPost());
            if($_POST['submit'] == 'Apply') :
                if($form_delete->isValid()) :
                $data = $form_delete->getData();
                    if($data['bulk_action']==1) :
                        foreach ($data['cb'] as $cb) : // mutltiple deletion
                        $data['id'] = $cb;
                        $pro = new Products();
                        $pro->exchangeArray($data);
                        $this->getProductsTable()->delete($pro);
                        endforeach;
                    endif; // bulk_action
                $this->flashMessenger()->addMessage('Product option deleted.');
                return $this->redirect()->toRoute('products', array('action' => 'variations', 'id' => $id));
                endif;  // post['delete']
            
            elseif($_POST['submit'] == 'Add Option') :
                $form_add->setInputFilter(new ProductAddOptionFilter());
                $form_add->setData($request->getPost());
                if($form_add->isValid()) :
                    $data = $form_add->getData();
                    $data['id'] = $id;
                    $pro = new Products();
                    $pro->exchangeArray($data);
                    $this->getProductsTable()->insertVariation($pro);
                    $this->flashMessenger()->addMessage('Product variation was added.');
                    return $this->redirect()->toRoute('products', array('action' => 'variations', 'id' => $id));
                endif;
            endif;
            
            
        endif;
        
        $product_variations = $this->getProductsTable()->fetchAllBy('variation',$id,'position');
    
        return new ViewModel(array( 'product' => $product, 'id' => $id, 'config' => $config, 'form_add' => $form_add, 'product_variations' => $product_variations, 'form_delete' => $form_delete));
    }
    
    public function categoryEditAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        $category = $this->getProductCategoryTable()->fetch('category_id', $id);
        $categories = $this->getProductCategoryTable()->fetchAll();
        $form = new ProductCategoryEditForm($category, $categories);
        $request = $this->getRequest();
            if ($request->isPost()) :
                $form->setInputFilter(new ProductCategoryEditFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'), $category, $_POST['slug'])); 
                $form->setData($request->getPost());
                if ($form->isValid()) : 
                    $data = $form->getData();
                    $cat = new ProductCategory();
                    $cat->exchangeArray($data); 
                    $this->getProductCategoryTable()->update($cat);
                    $this->flashMessenger()->addMessage('Category edited.');
                    return $this->redirect()->toRoute('products', array("action" => "category"));             
                endif; // if isValid
            endif;
        return new ViewModel(array('form' => $form,'category' => $category,'id' => $id));
    }
    
    public function categoryMainEditAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $id = $this->params()->fromRoute('id');
        $category = $this->getProductCategoryTable()->fetch('category_id', $id);
        $categories = $this->getProductCategoryTable()->fetchAll();
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
                    
                    rename($file, './public/media/'.$config['website']['media'].'/product/'.$file_full);
                
                    $data['image'] = $file_full;
                endif;
                // update category
                $product = new ProductCategory();
                $product->exchangeArray($data);
                $this->getProductCategoryTable()->update($product);
                // add category
                $this->flashMessenger()->addMessage('Category edited.');
                
               return $this->redirect()->toRoute('products', array("action" => "category"));
            endif; // if isValid
            /*
            $form->setInputFilter(new ProductCategoryMainEditFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'), $category, $_POST['slug']));
            $form->setData($request->getPost());
            if ($form->isValid()) :
                $data = $form->getData();
                $cat = new ProductCategory();
                $cat->exchangeArray($data);
                $this->getProductCategoryTable()->update($cat);
                $this->flashMessenger()->addMessage('Category edited.');
                return $this->redirect()->toRoute('products', array("action" => "category"));
                else :
                    var_dump($form->getMessages());
            endif; // if isValid
        endif;
        */
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
        
        $form_add = new ProductCategoryAddForm($this->getProductCategoryTable()->fetchAllBy('parent', 0));
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
                            $del = new ProductCategory();
                            $del->exchangeArray($data);
                            $this->getProductCategoryTable()->delete($del);
                        endforeach;                    
                    endif; // bulk_action
                        $this->flashMessenger()->addMessage('Product categories deleted.');
                    return $this->redirect()->toRoute('products', array("action" => "category"));                
                endif; // post['delete']
                
            else :
                $form_add->setInputFilter(new CategoryAddProductFilter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')));
                $form_add->setData($request->getPost());
                if ($form_add->isValid()) :
                    $data = $form_add->getData();  
                    $cat = new ProductCategory();
                    $cat->exchangeArray($data);
                    $this->getProductCategoryTable()->save($cat);
                    $this->flashMessenger()->addMessage('Product Category added.');
                    return $this->redirect()->toRoute('products', array("action" => "category"));                
                endif; // if isValid
            endif;
        endif; // isPost
        $root_categories = $this->getProductCategoryTable()->fetchAllBy('parent', 0);
        $category = $this->getProductCategoryTable()->fetchAllBy('parent', '>');
        $cat_rel = $this->getProductCategoryRelationshipsTable()->fetchAll();
        
        $cat_count = 0;
        return new ViewModel(array('form_add' => $form_add,'category' => $category,'form_delete' => $form_delete, 'cat_count'=>$cat_count, 'root_categories' => $root_categories));
    }
    
    public function deliveryAction() 
    {   
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array(
            'site_name' => $config['website']['site_name']
        ));
        
        // get info from db
        $delivery_range = $this->getDeliveryRangeTable()->fetch('id', 1);
        $delivery_times = $this->getDeliveryTimeTable()->fetchAllBy('target',1);
        $delivery_disable_days = $this->getDeliveryDisableDayTable()->fetchAllBy(1);
        $delivery_disable_times = $this->getDeliveryDisableTimeTable()->fetchAllBy('target',1);
        $delivery_zip_code = $this->getDeliveryZipCodeTable()->fetchAllBy('target',1);
        
        // delivery range by date
        $day_ranges = new DateRange($delivery_range->from, $delivery_range->to);
        
        // date range
        $day_range = array();
        foreach ($day_ranges as $drs) :
            $day_range[] = date('Y-m-d', $drs);
        endforeach;
        
        // disable days
        $delivery_disable_day = array();
        foreach ($delivery_disable_days as $dd) :
            $delivery_disable_day[] = $dd;
        endforeach;
        
        // array only with valid days
        foreach ($delivery_disable_day as $dr) :
            if(in_array($dr->day, $day_range)) :
                if(($key = array_search($dr->day, $day_range)) !== false) {
                    unset($day_range[$key]);
                } 
            endif;
        endforeach;
        
        // time
        $delivery_time = array();
        foreach ($delivery_times as $dt) :
            $delivery_time[] = $dt;
        endforeach;
        
        // forms
        $form_range = new DeliveryRangeForm($delivery_range);
        $form_time = new DeliveryTimeForm();
        $form_disable_day = new DeliveryDisableDayForm($day_range);
        $form_disable_time = new DeliveryDisableTimeForm($day_range);
        $form_zip_code = new DeliveryZipCodeForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) :
            if($_POST['submit'] == 'Update Range') :
                $form_range->setInputFilter(new DeliveryRangeFilter());
                $form_range->setData($request->getPost());
                if($form_range->isValid()) :
                    $data = $form_range->getData();
                    $d = new DeliveryRange();
                    $d->exchangeArray($data);
                    $this->getDeliveryRangeTable()->update($d, 1);
                    $this->flashMessenger()->addMessage('Delivery range is set.');
                    return $this->redirect()->toRoute('products', array('action' => 'delivery'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Add Time') : 
                $form_time->setInputFilter(new DeliveryTimeFilter());
                $form_time->setData($request->getPost());
                if($form_time->isValid()) :
                    $data = $form_time->getData(); 
                    $d = new DeliveryTime();
                    $d->exchangeArray($data);
                    $this->getDeliveryTimeTable()->insert($d, 1);
                    $this->flashMessenger()->addMessage('Delivery time is set.');
                    return $this->redirect()->toRoute('products', array('action' => 'delivery'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Remove Day') :
                $form_disable_day->setInputFilter(new DeliveryDisableDayFilter());
                $form_disable_day->setData($request->getPost());
                if($form_disable_day->isValid()) :
                    $data = $form_disable_day->getData();
                    $d = new DeliveryDisableDay();
                    $d->exchangeArray($data);
                    $this->getDeliveryDisableDayTable()->insert($d, 1);
                    $this->flashMessenger()->addMessage('Delivery day is removed.');
                    return $this->redirect()->toRoute('products', array('action' => 'delivery'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Remove Hour') :
                $form_disable_time->setInputFilter(new DeliveryDisableTimeFilter());
                $form_disable_time->setData($request->getPost());
                if($form_disable_time->isValid()) :
                    $data = $form_disable_time->getData();
                    $d = new DeliveryDisableTime();
                    $d->exchangeArray($data);
                    $this->getDeliveryDisableTimeTable()->insert($d, 1);
                    $this->flashMessenger()->addMessage('Delivery time is removed.');
                    return $this->redirect()->toRoute('products', array('action' => 'delivery'));
                endif;  // isValid                
            elseif ($_POST['submit'] == 'Add Zip Code') :
                $form_zip_code->setInputFilter(new DeliveryZipCodeFilter());
                $form_zip_code->setData($request->getPost());
                if($form_zip_code->isValid()) :
                    $data = $form_zip_code->getData();
                    $d = new DeliveryZipCode();
                    $d->exchangeArray($data);
                    $this->getDeliveryZipCodeTable()->insert($d, 1);
                    $this->flashMessenger()->addMessage('Delivery zip code was added.');
                    return $this->redirect()->toRoute('products', array('action' => 'delivery'));
                endif;  // isValid
            endif;
            /*
            
            */
        endif; // isPost
        	
        return new ViewModel(array('form_range' => $form_range, 'delivery_range' => $delivery_range, 'form_time' => $form_time, 'delivery_time' => $delivery_time, 'delivery_disable_day' => $delivery_disable_day, 'day_range' => $day_range, 'form_disable_day' => $form_disable_day, 'form_disable_time' => $form_disable_time, 'delivery_disable_times' => $delivery_disable_times, 'form_zip_code' => $form_zip_code, 'delivery_zip_code' => $delivery_zip_code));
    }
    
    public function ordersAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $orders = $this->getOrdersTable()->fetchAll();
        $tax = $this->getOrdersTable()->fetchTax();
        
        $form = new TaxClearForm(round($tax->order_tax, 2));
        $request = $this->getRequest();
        
        if($request->isPost()):
            $to = $this->getOrdersTable()->fetchAll();
            foreach ($to as $p) :
                $data['id'] = $p->id;
                $data['order_tax'] = '';
                $ord = new Orders();
                $ord->exchangeArray($data);
                $this->getOrdersTable()->updateTax($ord);
             endforeach;
             $this->flashMessenger()->addMessage('Tax was removed.');
            $this->redirect()->toRoute('products', array('action'=>'orders'));            
        endif;
        
        return new ViewModel(array('orders' => $orders, 'config' => $config, 'form' => $form));
    }
    
    public function orderAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
        
        $id = $this->params()->fromRoute('id');
        $order = $this->getOrdersTable()->fetchBy('id', $id);
        
        foreach (json_decode($order->order_items) as $k => $v) :
            $m = $this->getProductsTable()->fetch($k);
            $q = explode('-', $v);
            $p = $this->getProductsTable()->fetch($q[0]);
            $cart[$k]['name'] = $m->name;
            $cart[$k]['sub'] = $p->name;
            $cart[$k]['qty'] = $q[1];
            $cart[$k]['price'] = $p->price;
        endforeach;
            
        return new ViewModel(array('order' => $order, 'id' => $id, 'config' => $config, 'cart' => $cart));
    }
    
    public function deliveryAjaxTimeAction()
    {
        $this->layout('layout/blank');   
        $dd = $this->getDeliveryDisableTimeTable()->fetchDate('day', $_POST['day']);
        
        if($dd->count()>0) :
            
            $hours = array();
            foreach ($dd as $d) :
                $hours[] = $d->time;
            endforeach; 
            
            $empty = 0;
            foreach ($this->getDeliveryTimeTable()->fetchAllBy('target', $_POST['calendar']) as $dt) :
                $date = $dt->start.' - '.$dt->end;
                $key = array_search($date, $hours);
                if($key === false) :
                    echo '<option value="'.$date.'">'.$date.'</option>'; $empty++;
                endif;
            endforeach;
            
            // add msg if all hours removed
            if($empty == 0) :
                echo '<option value="">all hours removed</option>';
            endif;
        else : // no result found
            foreach ($this->getDeliveryTimeTable()->fetchAllBy('target', $_POST['calendar']) as $dt) :
                $date = $dt->start.' - '.$dt->end;
                echo '<option value="'.$date.'">'.$date.'</option>';
            endforeach;
        endif;
        
    }
    
    public function deliveryDayTimeDeleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->getDeliveryDisableTimeTable()->delete($id);
        $this->flashMessenger()->addMessage('Selected time was removed from disable list.');
        return $this->redirect()->toRoute('products', array('action' => 'delivery'));
    }
    
    public function deliveryTimeDeleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->getDeliveryTimeTable()->delete($id);
        $this->flashMessenger()->addMessage('Selected time was deleted.');
        return $this->redirect()->toRoute('products', array('action' => 'delivery'));
    }
    
    public function deliveryDayDeleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->getDeliveryDisableDayTable()->delete($id);
        $this->flashMessenger()->addMessage('Selected day was deleted.');
        return $this->redirect()->toRoute('products', array('action' => 'delivery'));
    }
    
    public function deliveryZipCodeDeleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $this->getDeliveryZipCodeTable()->delete($id);
        $this->flashMessenger()->addMessage('Selected zip code was deleted.');
        return $this->redirect()->toRoute('products', array('action' => 'delivery'));
    }
    
    /*
     * Removal
     */
    
    public function removalAction()
    {
        // cms personalization
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array(
            'site_name' => $config['website']['site_name']
        ));
    
        // get info from db
        $delivery_range = $this->getDeliveryRangeTable()->fetch('id', 2);
        $delivery_times = $this->getDeliveryTimeTable()->fetchAllBy('target',2);
        $delivery_disable_days = $this->getDeliveryDisableDayTable()->fetchAllBy(2);
        $delivery_disable_times = $this->getDeliveryDisableTimeTable()->fetchAllBy('target',2);
        $delivery_zip_code = $this->getDeliveryZipCodeTable()->fetchAllBy('target',2);
    
        // delivery range by date
        $day_ranges = new DateRange($delivery_range->from, $delivery_range->to);
    
        // date range
        $day_range = array();
        foreach ($day_ranges as $drs) :
            $day_range[] = date('Y-m-d', $drs);
        endforeach;
    
        // disable days
        $delivery_disable_day = array();
        foreach ($delivery_disable_days as $dd) :
            $delivery_disable_day[] = $dd;
        endforeach;
    
        // array only with valid days
        foreach ($delivery_disable_day as $dr) :
            if(in_array($dr->day, $day_range)) :
                if(($key = array_search($dr->day, $day_range)) !== false) {
                    unset($day_range[$key]);
                }
            endif;
        endforeach;
    
        // time
        $delivery_time = array();
        foreach ($delivery_times as $dt) :
            $delivery_time[] = $dt;
        endforeach;
    
        // forms
        $form_range = new DeliveryRangeForm($delivery_range);
        $form_time = new DeliveryTimeForm();
        $form_disable_day = new DeliveryDisableDayForm($day_range);
        $form_disable_time = new DeliveryDisableTimeForm($day_range);
        $form_zip_code = new DeliveryZipCodeForm();
    
        $request = $this->getRequest();
        if ($request->isPost()) :
            if($_POST['submit'] == 'Update Range') :
                $form_range->setInputFilter(new DeliveryRangeFilter());
                $form_range->setData($request->getPost());
                if($form_range->isValid()) :
                    $data = $form_range->getData();
                    $d = new DeliveryRange();
                    $d->exchangeArray($data);
                    $this->getDeliveryRangeTable()->update($d, 2);
                    $this->flashMessenger()->addMessage('Removal range is set.');
                    return $this->redirect()->toRoute('products', array('action' => 'removal'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Add Time') :
                $form_time->setInputFilter(new DeliveryTimeFilter());
                $form_time->setData($request->getPost());
                if($form_time->isValid()) :
                    $data = $form_time->getData();
                    $d = new DeliveryTime();
                    $d->exchangeArray($data);
                    $this->getDeliveryTimeTable()->insert($d, 2);
                    $this->flashMessenger()->addMessage('Removal time is set.');
                    return $this->redirect()->toRoute('products', array('action' => 'removal'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Remove Day') :
                $form_disable_day->setInputFilter(new DeliveryDisableDayFilter());
                $form_disable_day->setData($request->getPost());
                if($form_disable_day->isValid()) :
                    $data = $form_disable_day->getData();
                    $d = new DeliveryDisableDay();
                    $d->exchangeArray($data);
                    $this->getDeliveryDisableDayTable()->insert($d, 2);
                    $this->flashMessenger()->addMessage('Removal day is removed.');
                return $this->redirect()->toRoute('products', array('action' => 'removal'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Remove Hour') :
                $form_disable_time->setInputFilter(new DeliveryDisableTimeFilter());
                $form_disable_time->setData($request->getPost());
                if($form_disable_time->isValid()) :
                    $data = $form_disable_time->getData();
                    $d = new DeliveryDisableTime();
                    $d->exchangeArray($data);
                    $this->getDeliveryDisableTimeTable()->insert($d, 2);
                    $this->flashMessenger()->addMessage('Removal time is removed.');
                return $this->redirect()->toRoute('products', array('action' => 'removal'));
                endif;  // isValid
            elseif ($_POST['submit'] == 'Add Zip Code') :
                $form_zip_code->setInputFilter(new DeliveryZipCodeFilter());
                $form_zip_code->setData($request->getPost());
                if($form_zip_code->isValid()) :
                    $data = $form_zip_code->getData();
                    $d = new DeliveryZipCode();
                    $d->exchangeArray($data);
                    $this->getDeliveryZipCodeTable()->insert($d, 2);
                    $this->flashMessenger()->addMessage('Removal zip code was added.');
                    return $this->redirect()->toRoute('products', array('action' => 'removal'));
                endif;  // isValid
            endif;
            /*
        
            */
        endif; // isPost
         
        return new ViewModel(array('form_range' => $form_range, 'delivery_range' => $delivery_range, 'form_time' => $form_time, 'delivery_time' => $delivery_time, 'delivery_disable_day' => $delivery_disable_day, 'day_range' => $day_range, 'form_disable_day' => $form_disable_day, 'form_disable_time' => $form_disable_time, 'delivery_disable_times' => $delivery_disable_times, 'form_zip_code' => $form_zip_code, 'delivery_zip_code' => $delivery_zip_code));
    }
    
    /*
     * Promo
     */
    public function promoAction()
    {
        // cms personalization 
        $config = $this->getServiceLocator()->get('Config');
        $this->layout()->setVariables(array('site_name' => $config['website']['site_name']));
    
        $form_add = new ProductPromoAddForm();
        $form_delete = new ProductPromoDeleteForm();
        $request = $this->getRequest();
            if($request->isPost()) :
                if($_POST['submit'] == 'Apply') : // Todo finding better way to
                    // separete forms
                    $form_delete->setInputFilter(new ProductPromoDeleteFilter());
                    $form_delete->setData($request->getPost());
                    
                    if($form_delete->isValid()) :
                        $data = $form_delete->getData();
                        if($data['bulk_action']==1) :
                            foreach ($data['cb'] as $cb) : // mutltiple deletion
                                $data['id'] = $cb;
                                $del = new Promotions();
                                $del->exchangeArray($data);
                                $this->getPromotionsTable()->delete($del);
                            endforeach;
                        endif; // bulk_action
                        $this->flashMessenger()->addMessage('Promo deleted.');
                        return $this->redirect()->toRoute('products', array('action' => 'promo'));
                    endif;  // post['delete']
                else :
                    $form_add->setInputFilter(new ProductPromoAddFilter());
                    $form_add->setData($request->getPost());
                    if($form_add->isValid()) :
                        $data = $form_add->getData();
                        $quo = new Promotions();
                        $quo->exchangeArray($data);
                        $this->getPromotionsTable()->insert($quo);
                        $this->flashMessenger()->addMessage('Promo added.');
                        return $this->redirect()->toRoute('products', array('action' => 'promo'));
                    endif;
                    // if isValid
                endif;
            endif; // isPost
            $links = $this->getPromotionsTable()->fetchAll();
        return new ViewModel(array('form_add' => $form_add, 'form_delete' => $form_delete, 'links'=>$links));
    }
    
    
    //-> get tables
    public function getOrdersTable()
    {
        if(! $this->ordersTable) {
            $sm = $this->getServiceLocator();
            $this->ordersTable = $sm->get('Application\Model\OrdersTable');
        }
        return $this->ordersTable;
    }
    public function getOptionsTable()
    {
        if(! $this->optionsTable) {
            $sm = $this->getServiceLocator();
            $this->optionsTable = $sm->get('Application\Model\OptionsTable');
        }
        return $this->optionsTable;
    } 
    public function getPromotionsTable()
    {
        if(! $this->promotionsTable) {
            $sm = $this->getServiceLocator();
            $this->promotionsTable = $sm->get('Application\Model\PromotionsTable');
        }
        return $this->promotionsTable;
    }   
    public function getDeliveryRangeTable()
    {
        if(! $this->deliveryRangeTable) {
            $sm = $this->getServiceLocator();
            $this->deliveryRangeTable = $sm->get('Application\Model\DeliveryRangeTable');
        }
        return $this->deliveryRangeTable;
    }
    public function getDeliveryZipCodeTable()
    {
        if(! $this->deliveryZipCodeTable) {
            $sm = $this->getServiceLocator();
            $this->deliveryZipCodeTable = $sm->get('Application\Model\DeliveryZipCodeTable');
        }
        return $this->deliveryZipCodeTable;
    }
    public function getDeliveryTimeTable()
    {
        if(! $this->deliveryTimeTable) {
            $sm = $this->getServiceLocator();
            $this->deliveryTimeTable = $sm->get('Application\Model\DeliveryTimeTable');
        }
        return $this->deliveryTimeTable;
    }
    public function getDeliveryDisableDayTable()
    {
        if(! $this->deliveryDisableDayTable) {
            $sm = $this->getServiceLocator();
            $this->deliveryDisableDayTable = $sm->get('Application\Model\DeliveryDisableDayTable');
        }
        return $this->deliveryDisableDayTable;
    }
    public function getDeliveryDisableTimeTable()
    {
        if(! $this->deliveryDisableTimeTable) {
            $sm = $this->getServiceLocator();
            $this->deliveryDisableTimeTable = $sm->get('Application\Model\DeliveryDisableTimeTable');
        }
        return $this->deliveryDisableTimeTable;
    }
    public function getProductsTable()
    {
        if(!$this->productsTable) {
            $sm = $this->getServiceLocator();
            $this->productsTable = $sm->get('Application\Model\ProductsTable');
        }
        return $this->productsTable;
    }
    public function getCategoryTable()
    {
        if(! $this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Application\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
    public function getProductCategoryTable()
    {
        if(! $this->productCategoryTable) {
            $sm = $this->getServiceLocator();
            $this->productCategoryTable = $sm->get('Application\Model\ProductCategoryTable');
        }
        return $this->productCategoryTable;
    }
    public function getProductCategoryRelationshipsTable()
    {
        if(! $this->productCategoryRelationshipsTable) {
            $sm = $this->getServiceLocator();
            $this->productCategoryRelationshipsTable = $sm->get('Application\Model\ProductCategoryRelationshipsTable');
        }
        return $this->productCategoryRelationshipsTable;
    }
}
