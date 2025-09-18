<?php
defined('_JEXEC') or die('Restricted access');

if (!defined('DS')) {
	define('DS',DIRECTORY_SEPARATOR);
}

jimport('joomla.form.formfield');

class JFormFieldJShoppingCategories extends JFormFieldList
{
	protected $type = 'jshoppingcategories';
	
	var $options = array();
	
	protected function getInput()
	{
		$html = array();
		$attr = '';
		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
			$attr .= ' disabled="disabled"';
		}
		
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';
		
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
		
		if (JFile::exists(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jshopping'.DS.'jshopping.php')) {
			$this->getOptions();
		}
		
		if ((string) $this->element['readonly'] == 'true') {
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';
		} else {
			if(isset($this->options[0]) && $this->options[0] != ''){
				$html[] = JHtml::_('select.genericlist', $this->options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
			} else {
				return '<strong style="line-height: 2em">' . JText::_('MOD_EFFECT_CONTENT_JOOMSHOPPING_NOT_INSTALLED_OR_NOT_CATEGORIES') . '</strong>';
			}
		}
		
		return implode($html);
	}
	
	protected function getOptions() {
		$session = JFactory::getSession();
		$attr = '';
		
		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		
		if ( (string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') {
			$attr .= ' disabled="disabled"';
		}
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';
		
		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query->select('`category_id` AS id, `name_ru-RU` AS name, `category_parent_id` AS parent')
			->from($db->quoteName('#__jshopping_categories'))
			->order($db->quoteName('ordering') . ' ASC');
		
		$db->setQuery($query);
   		$results = $db->loadObjectList();
   		
		if(count($results)){
			$temp_options = array();
			
			foreach ($results as $item) {
				array_push($temp_options, array($item->id, $item->name, $item->parent));	
			}
			foreach ($temp_options as $option) {
				if($option[2] == 0) {
					$this->options[] = JHtml::_('select.option', $option[0], $option[1]);
					$this->recursive_options($temp_options, 1, $option[0]);
				}
			}		
		} 
	}
	
	function bind( $array, $ignore = '' ) {
		if (key_exists( 'field-name', $array ) && is_array( $array['field-name'] )) {
			$array['field-name'] = implode( ',', $array['field-name'] );
		}
		
		return parent::bind( $array, $ignore );
	}
	
	function recursive_options($temp_options, $level, $parent){
		foreach ($temp_options as $option) {
			if($option[2] == $parent) {
				$level_string = '';
				for ($i = 0; $i < $level; $i++) {
					$level_string .= '- ';
				}
				$this->options[] = JHtml::_('select.option',  $option[0], $level_string . $option[1]);
				$this->recursive_options($temp_options, $level+1, $option[0]);
			}
		}
	}
}