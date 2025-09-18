<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

// Define the DS constant under Joomla! 3.0
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class JFormFieldModuleTemplate extends JFormField {

	var $_name = 'moduletemplate';

	var	$type = 'moduletemplate';

	function getInput(){
		return JFormFieldModuletemplate::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
	}
	
	function fetchElement($name, $value, &$node, $control_name) {

		jimport('joomla.filesystem.folder');

		$moduleTemplatesPath = JPATH_SITE.DS.'modules'.DS.'mod_jshopping_extended_filter'.DS.'tmpl';
		$moduleTemplatesFolders = JFolder::folders($moduleTemplatesPath);

		$db = JFactory::getDBO();

		$query = "SELECT template FROM #__template_styles WHERE client_id = 0 AND home = 1";

		$db->setQuery($query);
		$defaultemplate = $db->loadResult();
		$templatePath = JPATH_SITE.DS.'templates'.DS.$defaultemplate.DS.'html'.DS.'mod_jshopping_extended_filter';

		if (JFolder::exists($templatePath)){
			$templateFolders = JFolder::folders($templatePath);
			$folders = @array_merge($templateFolders, $moduleTemplatesFolders);
			$folders = @array_unique($folders);
		} else {
			$folders = $moduleTemplatesFolders;
		}

		$exclude = 'Default';
		$options = array ();

		foreach ($folders as $folder) {
			if ($folder == $exclude) {
				continue ;
			}
			$options[] = JHTML::_('select.option', $folder, $folder);
		}

		array_unshift($options, JHTML::_('select.option','Default','-- '.JText::_('MOD_JSHOP_EFILTER_USE_DEFAULT').' --'));

		$fieldName = $name;
			
		return JHTML::_('select.genericlist', $options, $fieldName, 'class="inputbox"', 'value', 'text', $value, $control_name.$name);

	}

}
