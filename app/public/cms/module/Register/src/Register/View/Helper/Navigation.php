<?php 
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Navigation extends AbstractHelper
{	
	
	public function __construct()
	{
	   
	}
	
	public function __invoke($basePath,$navSelected)
	{
	    $nav = array("Home Page" => "", "About Us" => "about.html", "Services & Pricing" => "services.html", "Our Work" => "our-work.html", "Contact Us" => "contact.html");
	    
	    $html = '';
	    
	    foreach ($nav as $n => $v) :
	       if($v == $navSelected) :
	           $html .=  '<li class="selected"><a class="selected" href="'.$basePath.'/'.$v.'">'.$n.'</a></li>';
	       else :
	           $html .=  '<li><a href="'.$basePath.'/'.$v.'">'.$n.'</a></li>';
	       endif;	       
	    endforeach;
	    	    	
		echo $html;
	}        
}