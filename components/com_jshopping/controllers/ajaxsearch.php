<?php
/**
* @version		1.7.3
* @author		MAXXmarketing GmbH
* @copyright	Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
*/

defined('_JEXEC') or die;

class JshoppingControllerAjaxsearch extends JControllerLegacy {

	public function display($cachable = false, $urlparams = false) {

		$jinput       = JFactory::getApplication()->input;
		$displaycount = $jinput->getInt('displaycount');

		$module       = JModuleHelper::getModule('jshopping_ajaxsearch');
		$moduleParams = new JRegistry($module->params);
		$moreResults  = $moduleParams->get('more_results', 0);

		$modellist    = JSFactory::getModel('productssearch', 'jshop');
		$productlist  = JSFactory::getModel('productList', 'jshop');
		$productlist->setModel($modellist);
		$productlist->load();
		$rows         = $productlist->getProducts();
		$total        = count($rows);

		if( $total > $displaycount ) {
			$rows = array_slice($rows, 0, $displaycount);
		} else {
			$moreResults = 0;
		}

		if( $total ) {
			JFactory::getLanguage()->load('mod_jshopping_ajaxsearch', JPATH_SITE, $lang->lang, true);
			$moreResultsLink = SEFLink('index.php?option=com_jshopping&controller=search&task=result&setsearchdata=1&search_type=' . $search_type . '&category_id=' . $jinput->getInt('category_id') . '&search=' . $jinput->getString('search') . '&include_subcat=' . $include_subcat, 1);
			$view_name       = 'ajaxsearch';
			$view_config     = array('template_path' => JPATH_COMPONENT . '/templates/addons/' . $view_name);
			$view            = $this->getView($view_name, getDocumentType(), '', $view_config);
			$view->setLayout('ajaxsearch');
			$view->assign('rows', $rows);
			$view->assign('moreResults', $moreResults);
			$view->assign('moreResultsLink', $moreResultsLink);
			$view->display();
		}
		die;
	}
}