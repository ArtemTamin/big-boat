<?php
/**
* @version		1.6.2
* @author		MAXXmarketing GmbH
* @copyright	Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
*/

defined('_JEXEC') or die;
error_reporting(error_reporting() & ~E_NOTICE);
if (!file_exists(JPATH_SITE.'/components/com_jshopping/jshopping.php')){
	JError::raiseError(500,"Please install component \"joomshopping\"");
}
require_once (JPATH_SITE.'/components/com_jshopping/lib/factory.php');
require_once (JPATH_SITE.'/components/com_jshopping/lib/functions.php');
JSFactory::loadCssFiles();
JSFactory::loadJsFiles();
JSFactory::loadLanguageFile();
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_jshopping_ajaxsearch/css/ajaxsearch.css');
$document->addScript(JURI::root().'modules/mod_jshopping_ajaxsearch/js/ajaxsearch.js');

$tmp = new stdClass();
$tmp->category_id = 0;
$tmp->name = JText::_('JALL');
$categories_select = array_merge(array($tmp) , buildTreeCategory(1));

$adv_search = $params->get('advanced_search');
$show_cat_filer = $params->get('cat_filter');
$include_subcat = $params->get('include_subcat', 0);

$category_id = JRequest::getInt('acategory_id');

if (empty($category_id) || !$category_id){
	$category_id = intval($params->get('category_id'));
}

if (intval($params->get('active_cur_cat'))){
	if (!$category_id){
		$category_id = JRequest::getInt('category_id');
	}
}

if ($adv_search){
	$adv_search_link = SEFLink('index.php?option=com_jshopping&controller=search',1);
}
$search = JRequest::getVar('search','');
require(JModuleHelper::getLayoutPath('mod_jshopping_ajaxsearch'));