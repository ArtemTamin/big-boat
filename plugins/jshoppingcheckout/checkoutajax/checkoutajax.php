<?php
	/**
    * @version      1.6.6 27.01.2019
    * @author       Garry
    * @copyright    Copyright (C) 2019 joom-shopping.com. All rights reserved.
    * @license      GNU GPL v3
    */
defined('_JEXEC') or die('Restricted access');
class plgJshoppingCheckoutCheckoutAjax extends JPlugin
{               
	function __construct(&$subject, $config = array())
	{
		$document = JFactory::getDocument();
		$jshopConfig = JSFactory::getConfig();

		if(JRequest::getVar('controller') == 'user' && JRequest::getVar('task') == 'loginsave')
		{
			JRequest::setVar(JSession::getFormToken(), '1', 'post', true);
		}
		if ( JRequest::getVar('task')!='finish' && $document->getType() == 'html' )
		{
			$this->loadLanguage('checkoutajax', JPATH_ROOT.'/plugins/jshoppingcheckout/checkoutajax');
			$document->addScriptDeclaration("var checkoutajax = checkoutajax || {};checkoutajax.states_plugin_enabled='".(int)JPluginHelper::isEnabled('jshoppingcheckout', 'states')."';");
			$document->addScriptDeclaration("var checkoutajax_show_small_cart = ".$jshopConfig->show_cart_all_step_checkout.";");
			$document->addCustomTag('<link rel="stylesheet" type="text/css" href="'.JURI::root().'plugins/jshoppingcheckout/checkoutajax/checkoutajax.css" />');
			$document->addCustomTag('<script type="text/javascript" src="'.JURI::root().'plugins/jshoppingcheckout/checkoutajax/checkoutajax.js"></script>');
		}
		parent::__construct($subject, $config);
	}
	
	function onBeforeDisplayRegisterView(&$view)
	{
		if (!$this->params->get('usestandartlogin')){
			$this->setLayout($view);
		}
	}
	
	function onBeforeDisplayLoginView(&$view)
	{
		if (!$this->params->get('usestandartlogin')){
			$this->setLayout($view);
		}
	}
	
	function onBeforeDisplayCheckoutStep2View(&$view)
	{
		$this->setLayout($view);
	}
 
	function onBeforeDisplayCheckoutStep3View(&$view)
	{
		$this->setLayout($view);
	}
 
	function onBeforeDisplayCheckoutStep4View(&$view)
	{
		$this->setLayout($view);
	}
 
	function onBeforeDisplayCheckoutStep5View(&$view)
	{
		$this->setLayout($view);
	}
 
	function onAfterDisplayCheckoutNavigator(&$view)
	{
		$this->setLayout($view, 'empty');
	}
	
	private function setLayout(&$view, $layout = 'checkoutajax'){
		
		$view->addTemplatePath(JPATH_ROOT.'/components/com_jshopping/templates/addon_checkoutajax/');
		$view->setLayout($layout);
		$view->set('usestandartlogin', $this->params->get('usestandartlogin'));
	}
	
	
}
