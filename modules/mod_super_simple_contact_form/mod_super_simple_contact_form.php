<?php 
	/*
	# ------------------------------------------------------------------------
	# Extensions for Joomla 3.x
	# ------------------------------------------------------------------------
	# Copyright (C) 2015 standardcompany.ru. All Rights Reserved.
	# @license - PHP files are GNU/GPL V2.
	# Author: standardcompany.ru
	# Websites:  http://standardcompany.ru
	# Date modified: 10/02/2015
	# ------------------------------------------------------------------------
	*/

	defined('_JEXEC') or die;
	$document = JFactory::getDocument();
	$layout = $params->get('layout', 'default');
	require JModuleHelper::getLayoutPath('mod_super_simple_contact_form', '$layout');

?>