<?php 
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_ext');
?>

<div data>
  <span class="mycart_mini_txt <?php print str_replace("_:","",$layout); ?>" title="<?php print JText::_('PRODUCTS_AT_'.$lang.'_MINI') ?> <?php print $cart->count_product;?> <?php print JText::_('PRODUCTS_SUMM_MINI') ?> <?php print strip_tags(formatprice($cart->getSum(0,1)))?>"><a href = "<?php print $go_sef; ?>" target="_top"><?php print $cart->count_product;?></a></span>
 </div>
  
<?php
if (($show_added_to_cart_icon=='1') || ($show_added_to_cart_icon_prod=='1')){
?>
<div class="prod_data_id dnone">
<?php 
$countprod = 0;
$array_products = array();
foreach($cart->products as $key_id=>$value){
$array_products [$countprod] = $value;
?> 
<span data-id="<?php print $array_products [$countprod]["product_id"]?>" data-qtty-<?php print $array_products [$countprod]["product_id"]; ?>="<?php print $value["quantity"]; ?>" class="name"></span>
<?php } ?>
</div>
<?php } ?>

 </div>
 <!--Modal-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_modal');?>
<!--End modal-->
</div>