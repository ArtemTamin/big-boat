<?php
defined('_JEXEC') or die('Restricted access');

class mod_jshopping_cart_wl_ajaxHelper{	 

public static	function sprintAtributeInCartMy($atribute){
    JPluginHelper::importPlugin('jshoppingproducts');
    $dispatcher =JDispatcher::getInstance();
    $html = "";
    if (count($atribute)) $html .= '<span class="minicart_attr_list">';
				if (count($atribute))
    foreach($atribute as $attr){
        $dispatcher->trigger('beforeSprintAtributeInCart', array(&$attr) );
        $html .= '<span class="minicart_attr_name">'.$attr->attr.'</span>: <span class="minicart_attr_value">'.$attr->value.'</span><br/>';
    }
    if (count($atribute)) $html .= '</span>';
return $html;
}

public static function sprintFreeExtraFiledsInCartMy($extra_fields){
    JPluginHelper::importPlugin('jshoppingproducts');
    $dispatcher =JDispatcher::getInstance();
    $html = "";
    if (count($extra_fields)) $html .= '<span class="minicart_ef_list">';
    foreach($extra_fields as $f){
        $dispatcher->trigger('beforeSprintExtraFieldsInCart', array(&$f) );
        $html .= '<span class="minicart_ef_name">'.$f['name'].'</span>: <span class="minicart_ef_value">'.$f['value'].'</span><br/>';
    }
    if (count($extra_fields)) $html .= '</span>';
return $html;
}

public static function ajaxDataInCArt($jshopConfig, $controller, $del_sef, $lang, $bsv, $dcount, $tseparator, $module, $document, $obj_postfix, $iclass_ok){
	$document->addScriptDeclaration('
	var mod_params_'.$obj_postfix.'='.$module->params.';
	var mod_ajax_data={
	"data_uri":"'.JURI::base().'",
	"data_controller":"'.$controller.'",
	"data_ilp":"'.$jshopConfig->image_product_live_path.'",
	"data_cc":"'.$jshopConfig->currency_code.'",
	"data_sp":"'.SEFLink('index.php?option=com_jshopping&controller=product&task=view',1).'",
	"data_bsv":"'.$bsv.'",
	"data_dcount":"'.$dcount.'",
	"data_tseparator":"'.$tseparator.'",
	"data_lps":"'.JText::_('PRODUCTS_SUMM_MINI').'",
	"data_dt":"'. _JSHOP_DELETE .'",
	"data_dtf":"'.JText::_('PRODUCT_REMOVE_FROM_'.$lang.'_MINI').'",
	"data_rel":"'._JSHOP_RELATED_PRODUCTS.' &dArr;",
	"data_rabattv":"'. _JSHOP_RABATT_VALUE. '",
	"data_rabatt":"'. _JSHOP_RABATT. '",
	"data_rabatta":"'. _JSHOP_RABATT_ACTIVE. '",
	"data_pp":"'.JText::_('PRODUCT_PARAMS_CART_MINI').'",
	"data_pef":"'.JText::_('PRODUCT_EF_CART_MINI').'"
	};
	mod_ajax_data_'.$obj_postfix.'={
	"data_ect":"'.JText::_('EMPTY_'.$lang.'').'",
	"data_et":"'.JText::_('MINI_'.$lang.'_EXTERN').'",
	"data_lp":"'.JText::_('PRODUCT_AT_'.$lang.'_MINI') .'",
	"data_lpwlv":"'.JText::_('PRODUCT_AT_WISHLIST_MINI') .'",
	"data_lpcv":"'.JText::_('PRODUCT_AT_CART_MINI') .'",
	"data_lpc":"'.JText::_('PRODUCTS_AT_'.$lang.'_MINI').'", 
	"data_lpm":"'.JText::_('PRODUCTS_AT_'.$lang.'_MINI_EXT').'", 
	"data_lpe":"'.JText::_('MINI_'.$lang.'').'", 
	"data_classok":"'.$iclass_ok.'",
	"data_sd":"'.SEFLink('index.php?option=com_jshopping&controller='.$del_sef.'&task=delete',1).'"
	};
');
}
}
?>