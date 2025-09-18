<?php	
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDbo();
$db->setQuery("DELETE FROM `#__extensions` WHERE element='detailtabs' AND folder='jshoppingproducts'");
$db->query();
jimport('joomla.filesystem.folder');
foreach(array(
	'/components/com_jshopping/templates/addons/detailtabs/',
	'/plugins/jshoppingproducts/detailtabs/',
	'/administrator/components/com_jshopping/addons/addon_detailtabs/'
) as $folder){JFolder::delete(JPATH_ROOT.$folder);}
?>