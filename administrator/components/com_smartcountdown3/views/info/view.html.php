<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class smartCountdown3ViewInfo extends JViewLegacy
{
	protected $ostInfo;
	
	public function display($tpl = null)
	{
		require_once JPATH_COMPONENT.'/helpers/smartcountdown3.php';
		
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/smartcountdown3.php';
		$canDo	= osTicky2Helper::getActions();
		JToolBarHelper::title(JText::_('COM_SMARTCOUNTDOWN3_INFO'), 'smartcountdown3.png');

		if (JFactory::getUser()->authorise('core.admin')) {
			JToolBarHelper::preferences('com_smartcountdown3');
		}
	}
}
