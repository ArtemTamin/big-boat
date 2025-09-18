<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class JshoppingViewSearch extends JViewLegacy {

	function display($tpl = null) {	
		
				$dispatcher = JDispatcher::getInstance();
				$mainframe = JFactory::getApplication();
				JSFactory::loadLanguageFile();
				$jshopConfig = JSFactory::getConfig();

				require_once (JPATH_SITE.DS.'modules'.DS.'mod_jshopping_extended_filter'.DS.'helper.php');
				$moduleId = JRequest::getInt("moduleId");
				$moduleParams = modJShopExtendedFilterHelper::getModuleParams($moduleId);			
				
				if (!defined('JPATH_ROOT')) {
				   define('JPATH_ROOT', JPath::clean(JPATH_SITE));
				}
	
				$pluginPath = JPATH_BASE.DS.'plugins'.DS.'system'.DS.'jsfilter'.DS.'jsfilter';
	
				require_once($pluginPath.DS.'models'.DS.'search.php');
				
				// JShopping worksheet
				
					require_once(JPATH_COMPONENT.DS.'lib'.DS.'functions.php');
					
					$results = ExtendedFilterModel::getResults(); 
					
					$results = listProductUpdateData($results);
					addLinkToProducts($results, 0, 1);
					
					// pagination
						jimport('joomla.html.pagination');
						
						$products_page = $jshopConfig->count_products_to_page;
						$context = "jshoping.alllist.front.product";
						
						$limit = JRequest::getInt("limit");
						if (!$limit) $limit = $products_page;
						$limitstart = JRequest::getInt('limitstart');
						
						$results_total = ExtendedFilterModel::getResults(true);
					   
						$pagination = new JPagination($results_total, $limitstart, $limit);
						$pagenav = $pagination->getPagesLinks();

					//
					
					// ordering & limits				
					
						$orderby = JRequest::getVar("orderby", "");
						if($orderby == "") {
							$orderby = $jshopConfig->product_sorting;
						}
						
						$orderto = JRequest::getVar("orderto", "");
						if($orderto == "") {
							$orderto = $jshopConfig->product_sorting_direction;
						}

						if($orderto == "1") {
							$order_to_img = 'arrow_down.gif';
						}
						else {
							$order_to_img = 'arrow_up.gif';
						}
						
						foreach ($jshopConfig->sorting_products_name_select as $key=>$value) {
							$sorts[] = JHTML::_('select.option', $key, $value, 'sort_id', 'sort_value');
						}
						$order_select = JHTML::_('select.genericlist', $sorts, '', 'class = "inputbox" size = "1" onchange = "document.ExtendedFilter'.$moduleId.'.orderby.value=this.value; submit_form_'.$moduleId.'()"','sort_id', 'sort_value', $orderby);
						
						insertValueInArray($jshopConfig->count_products_to_page, $jshopConfig->count_product_select); //insert category count
						foreach ($jshopConfig->count_product_select as $key=>$value) {
							$product_count[] = JHTML::_('select.option', $key, $value, 'count_id', 'count_value' );
						}
						$limit_select = JHTML::_('select.genericlist', $product_count, '', 'class = "inputbox" size = "1" onchange = "document.ExtendedFilter'.$moduleId.'.limit.value=this.value; submit_form_'.$moduleId.'()"','count_id', 'count_value', $limit );
					
					//
					
					$dispatcher->trigger('onBeforeDisplayProductList', array(&$results) );
					
					$this->assign('pagenav', $pagenav);
					$this->assign('results_total', $results_total);
					
					$this->assign('order_select', $order_select);
					$this->assign('order_to_img', $jshopConfig->live_path.'images/'.$order_to_img);
					$this->assign('orderto', $orderto);
					$this->assign('limit_select', $limit_select);
					
					$this->assign('results', $results);
					
				//
						
				$this->addTemplatePath($pluginPath.DS.'templates');
				$this->addTemplatePath($pluginPath.DS.'templates'.DS.$jshopConfig->template);
				
				// Look for template files in component folders
				$this->addTemplatePath(JPATH_COMPONENT.DS.'templates');
				$this->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$jshopConfig->template);

				// Look for overrides in template folder (Joomshopping template structure)
				$this->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jshopping'.DS.'templates');
				$this->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jshopping'.DS.'templates'.DS.$jshopConfig->template);

				// Look for overrides in template folder (Joomla! template structure)
				$this->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jshopping'.DS.$jshopConfig->template);
				$this->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_jshopping');
				
				$results_template = $moduleParams->results_template;
				
				if($results_template == "category") {
					$restmode = $moduleParams->restmode;
					if($restmode == 0) {
						$restcat = $moduleParams->restcat;
					}
					else {
						$restcat = JRequest::getVar("restcata", '');
					}
					if($restcat == '') {
						$restcat = JRequest::getVar("category");
						$restcat = $restcat[0];
					}
					if($restcat == '') {
						$restcat = JRequest::getVar("category_id");
					}
					
					$user = JFactory::getUser();
					$category_id = $restcat;
					$category = JTable::getInstance('category', 'jshop');
					$category->load($category_id);
					$category->getDescription();
					$dispatcher->trigger('onAfterLoadCategory', array(&$category, &$user));
					
					//category variables
					$display_list_products = count($results) > 0;

					//assignments
					$this->assign('results_template', $results_template);
					$this->assign('config', $jshopConfig);
					$this->assign('template_block_list_product', "list_products/list_products.php");
					$this->assign('template_block_form_filter', "list_products/form_filters.php");
					$this->assign('template_block_pagination', "list_products/block_pagination.php");
					$this->assign('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$order_to_img);
					$this->assign('filter_show', 1);
					$this->assign('filter_show_category', 0);
					$this->assign('filter_show_manufacturer', 1);
					$this->assign('pagination', $pagenav);
					$this->assign('pagination_obj', $pagination);
					$this->assign('display_pagination', $pagenav!="");
					$this->assign('rows', $results);
					$this->assign('count_product_to_row', $category->products_row);
					$this->assign('image_category_path', $jshopConfig->image_category_live_path);
					$this->assign('noimage', $jshopConfig->noimage);
					$this->assign('category', $category);
					$this->assign('product_count', $limit_select);
					$this->assign('sorting', $order_select);
					$this->assign('display_list_products', $display_list_products);
					$this->assign('shippinginfo', SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=shipping',1));
					///
					
					// extra code for fix ordering direction switcher
					$document = &JFactory::getDocument();
					$script = "
						function submitListProductFilterSortDirection() {
							return false;
						}
					
						jQuery('document').ready(function() {
							jQuery('.jshop_list_product .box_products_sorting img').click(function() {
								var orderto = jQuery('#ExtendedFilterContainer".$moduleId." input[name=orderto]');
								if(orderto.val() == undefined || orderto.val() == '') {
									orderto.val(".$jshopConfig->product_sorting_direction.");
								}
								orderto.val(orderto.val() ^ 1);
								submit_form_".$moduleId."();
							});
						});
					";
					$document->addScriptDeclaration($script);	
					//
					
					
					$dispatcher->trigger('onBeforeDisplayProductListView', array(&$this) );
					
					if ($category->category_template == "") { 
						$category->category_template = "default";
						$this->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$jshopConfig->template.DS.'category');
					}
					$this->setLayout("category_" . $category->category_template);
				}
				
				parent::display($tpl);

	}

}

?>