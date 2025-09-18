<?php
	defined('_JEXEC') or die;
	$element = 'mod_jshopping_ajaxsearch';
	$db = JFactory::getDbo();

	$db->setQuery("DELETE FROM `#__extensions` WHERE element = '".$element."' AND `type` = 'module'");
	$db->query();

	$db->setQuery("SELECT `id` FROM `#__modules` WHERE `module` = '".$element."'");
	$id = $db->loadResultArray();

	if (count($id)) {
		$db->setQuery("DELETE FROM `#__modules_menu` WHERE `moduleid` IN (".implode(',', $id).")");
		$db->query();
	}

	$db->setQuery("DELETE FROM `#__modules` WHERE `module`='".$element."'");
	$db->query();

	jimport('joomla.filesystem.folder');
	foreach(array(
		'modules/'.$element.'/',
		'components/com_jshopping/addons/'.$element.'/',
		'components/com_jshopping/templates/addons/ajaxsearch/',
		'components/com_jshopping/views/ajaxsearch/'
	) as $folder){JFolder::delete(JPATH_ROOT.'/'.$folder);}

	jimport('joomla.filesystem.file');
	foreach(array(
		'language/en-GB/en-GB.'.$element.'.ini',
		'components/com_jshopping/controllers/ajaxsearch.php'
	) as $file){JFile::delete(JPATH_ROOT.'/'.$file);}
?>