<?php

defined('_JEXEC') or die ;

class JFormFieldHeader extends JFormField {

	function getInput(){
		return JFormFieldHeader::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
	}

    public function fetchElement($name, $value, &$node, $control_name)
    {

        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root(true).'/modules/mod_jshopping_extended_filter/assets/css/filter.css');

        return '<div class="paramHeaderContainer"><div class="paramHeaderContent">'.JText::_($value).'</div><div class="clear"></div></div>';
    }

    public function fetchTooltip($label, $description, &$node, $control_name, $name)
    {
        return NULL;
    }

}