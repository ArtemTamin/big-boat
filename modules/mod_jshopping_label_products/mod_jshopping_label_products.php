<?php
/**
* @version      3.3.1 18.12.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

    defined('_JEXEC') or die('Restricted access');
    error_reporting(error_reporting() & ~E_NOTICE);
    
    if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'jshopping.php')){
        JError::raiseError(500,"Please install component \"joomshopping\"");
    } 
    
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."factory.php"); 
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."functions.php");        
    JSFactory::loadCssFiles();
    JSFactory::loadLanguageFile();
    $jshopConfig = JSFactory::getConfig();         
        
    $product = JTable::getInstance('product', 'jshop');
    $label_id = $params->get('label_id'); 
    $count = $params->get('count_products', 4);
    
    $list = $product->getProductLabel($label_id, $count);   
    foreach($list as $key=>$value){
        $list[$key]->product_link = SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $value->category_id.'&product_id=' . $value->product_id ,1);
    }
    
    $noimage = $jshopConfig->noimage ? $jshopConfig->noimage : "noimage.gif";
    $show_image = $params->get('show_image',1);
    require(JModuleHelper::getLayoutPath('mod_jshopping_label_products'));        
?>