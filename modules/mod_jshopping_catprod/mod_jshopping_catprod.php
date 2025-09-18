<?php
defined('_JEXEC') or die;
error_reporting(error_reporting() & ~E_NOTICE);    

if (!file_exists(JPATH_SITE . '/components/com_jshopping/jshopping.php')) {
	JError::raiseError(500, JText::_('MOD_JSHOPPING_CATPROD_JOOMSHOPPING_NOT_INSTALL'));
}

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_jshopping/models');
require_once dirname(__FILE__).'/helper.php';
require_once (JPATH_SITE . '/components/com_jshopping/lib/factory.php'); 
require_once (JPATH_SITE . '/components/com_jshopping/lib/jtableauto.php');
require_once (JPATH_SITE . '/components/com_jshopping/tables/config.php'); 
require_once (JPATH_SITE . '/components/com_jshopping/lib/functions.php');
require_once (JPATH_SITE . '/components/com_jshopping/lib/multilangfield.php');

$list = modJshoppingCatprodHelper::getCatsArray($params);
require JModuleHelper::getLayoutPath('mod_jshopping_catprod', $params->get('layout', 'default'));
?>