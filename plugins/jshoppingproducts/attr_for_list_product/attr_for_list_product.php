<?php

defined('_JEXEC') or die('Restricted access');
?>
<?php
jimport('joomla.application.component.controller');

class plgJshoppingProductsAttr_for_list_product extends JPlugin{

	function onBeforeDisplayProductListView(&$view){
		$include_css=$this->params->get('include_css',1);
		$doc=JFactory::getDocument();
		if ($include_css!="0"){
			$doc->addStyleSheet(JURI::base().'plugins/jshoppingproducts/attr_for_list_product/attrliststyle.min.css');
		}
		$doc->addScript(JURI::base().'plugins/jshoppingproducts/attr_for_list_product/attr_for_list.min.js');
		$js_config=JSFactory::getConfig();
		$empty_attr=$js_config->product_attribut_first_value_empty;
		$ident_attr_list=$this->params->get('ident_attr_list', '_tmp_var_top_buttons');
		$wrapclass=$this->params->get('wrapclass', '*[class*=\'productitem_\']:visible, *[class*=\'moditem_\']:visible, .owl-item, .modopprod_item');
		$first_empty=$this->params->get('first_empty',1);
		$calc_price=$this->params->get('calc_price',1);
		$event_buttonbuy=$this->params->get('event_buttonbuy',1);
		$autohide_empty=$this->params->get('autohide_empty',1);
		$prod_exclude_attr = explode(",",$this->params->get('prod_exclude_attr'));
		$categ_exclude_attr = explode(",",$this->params->get('categ_exclude_attr'));
		$recalc_onload = $this->params->get('recalc_onload',1);
		if ($first_empty!="2"){
			$fe="data-fe='1'";
		}
		if ($recalc_onload=="2") {
			$recalc_class = "recalc_attr";
		}
		$table_product = JTable::getInstance("product", "jshop");
		
		if (count($view->rows)){
			foreach($view->rows as $key => $product){
				if (in_array($product->category_id, $categ_exclude_attr) || in_array($product->product_id, $prod_exclude_attr)) continue;
				$view->rows[$key]->$ident_attr_list .='
				<div class="attrib '.$recalc_class.' noempty_'.$empty_attr.' attrforprodid_'.$product->product_id.'" data-uri-base="'.JURI::base().'" data-attrforprodid="'.$product->product_id.'" '.$fe.' data-wrapclass="'.$wrapclass.'" data-buttonbuy="'.$event_buttonbuy.'" data-autohide="'.$autohide_empty.'" data-text="'._JSHOP_PRODUCT_NOT_AVAILABLE_THIS_OPTION.'" data-textsel="'._JSHOP_SELECT.'" data-currency="'.$js_config->currency_code.'" data-decimal="'.$js_config->decimal_count.'" data-ths="'.$js_config->thousand_separator.'" data-calc="'.$calc_price.'">';
				$table_product->load($product->product_id);
				$attributesDatas = $table_product->getAttributesDatas($back_value["attr"]);
				$table_product->setAttributeActive($attributesDatas["attributeActive"]);
				$attributeValues=$attributesDatas["attributeValues"];
				$attributes=$table_product->getBuildSelectAttributes($attributeValues, $attributesDatas["attributeSelected"]);
				if (count($attributes)){
					$_attributevalue=JTable::getInstance("AttributValue", "jshop");
					$all_attr_values = $_attributevalue->getAllAttributeValues();
				} else {
					$all_attr_values = array();
				}
				if (count($attributes)) {
				$replace_radio = array(
				'name="jshop_attr_id' => 'name="productitem_'.$product->product_id.'-jshop_attr_id',
				'id="jshop_attr_id' => 'id="productitem_'.$product->product_id.'_jshop_attr_id',
				'for="jshop_attr_id' => 'for="productitem_'.$product->product_id.'_jshop_attr_id',
				'id="prod_attr_img_' => 'id="productitem_'.$product->product_id.'_prod_attr_img_',
				'onclick="setAttrValue(' =>'onclick="notUseAttrValue(',
				'onchange="setAttrValue(' =>'onchange="notUseAttrValue('
				);
				$view->rows[$key]->$ident_attr_list .=
				'<div class="jshop_prod_attributes">
				<div class="jshop">';
				foreach($attributes as $attribut) {
					$view->rows[$key]->$ident_attr_list .=
					'<div class="att_none">
					<div class="attributes_title"><span title="'.$attribut->attr_description.'" class="attributes_name '.$attr_help.'" '.$attr_descr.'>'.$attribut->attr_name.':</span></div>
					<div class="attributes_value"><span class="attr_arr" data-id="'.$attribut->attr_id.'" data-attrprefix="productitem_'.$product->product_id.'">'.str_replace(array_keys($replace_radio), $replace_radio, $attribut->selects).'</span></div>
					</div><div class="clear"></div>';
				}
				$view->rows[$key]->$ident_attr_list .=
				'</div>
				</div>';
				}
				$view->rows[$key]->$ident_attr_list	.=
				'</div>';
			}
		}
	}
}
?>