<?php
    /**
    * @version      1.6.6 27.01.2019
    * @author       Garry
    * @copyright    Copyright (C) 2019 joom-shopping.com. All rights reserved.
    * @license      GNU GPL v3
    */
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDbo();

$name = "Addon Checkout Ajax";
$element = "checkoutajax";

// delete plugin
$db->setQuery("DELETE FROM `#__extensions` WHERE `element` = '".$element."' AND `type` = 'plugin'");
$db->query();

// delete folder
jimport('joomla.filesystem.folder');
foreach(array(
	'/plugins/jshoppingcheckout/'.$element.'/',
	'/components/com_jshopping/templates/addon_'.$element.'/',
	'components/com_jshopping/addons/'.$element.'/'
) as $folder){JFolder::delete(JPATH_ROOT.'/'.$folder);}

// delete files
jimport('joomla.filesystem.file');
foreach(array(
	'/components/com_jshopping/images/'.$element.'-enter.png',
	'/components/com_jshopping/images/'.$element.'-inactive.png',
	'/components/com_jshopping/images/'.$element.'-refresh.png'
) as $file){JFile::delete(JPATH_ROOT.'/'.$file);}

?>
