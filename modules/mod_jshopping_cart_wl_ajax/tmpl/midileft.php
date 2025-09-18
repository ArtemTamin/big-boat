<?php
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_ext');
?>

<div>

 <div class="midileft_wrap">

 
<?php
if (($show_added_to_cart_icon == '1') || ($show_added_to_cart_icon_prod == '1')) {
?>
<div class="prod_data_id dnone">
<?php
    $countprod      = 0;
    $array_products = array();
    foreach ($cart->products as $key_id => $value) {
        $array_products[$countprod] = $value;
?> 
<span data-id="<?php
        print $array_products[$countprod]["product_id"];
?>" data-qtty-<?php print $array_products [$countprod]["product_id"]; ?>="<?php print $value["quantity"]; ?>" class="name"></span>
<?php
    }
?>
</div>
<?php
}
?>
 
  <span class="mycart_mini_txt <?php
print str_replace("_:", "", $layout);
?> <?php
if ($color == "1") {
    print "green";
}
if ($color == "2") {
    print "grey";
}
if ($color == "3") {
    print "dark";
}
if ($color == "4") {
    print "red";
}
if ($color == "5") {
    print "orange";
}
if ($color == "6") {
    print "blue";
}
?>" title=""><a href = "<?php
print $go_sef;
?>" target="_top"><?php
print $cart->count_product;
?></a></span>
  
 <?php
if (count($cart->products) >= 1) {
?> 
 
  <span class="midileft_text"><?php
    print JText::_('PRODUCTS_AT_' . $lang . '_MINI');
?> <?php
    print $cart->count_product;
?> <br/><?php
    print JText::_('PRODUCTS_SUMM_MINI');
?> <?php
    print formatprice($cart->getSum(0, 1));
?></span>
  
  <span class="gotocart"><a href = "<?php
    print $go_sef;
?>" target="_top"><?php
    print JText::_('GO_TO_' . $lang . '');
?></a>&nbsp;&nbsp;
 <!-- <?php
    if ($type_view == "1") {
?>
 <a href="<?php
        if ($jshopConfig->shop_user_guest == 1) {
            print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2&check_login=1', 1, 0, $jshopConfig->use_ssl);
        } else {
            print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2', 1, 0, $jshopConfig->use_ssl);
        }
?>"><?php
        print _JSHOP_CHECKOUT;
?></a>
    <?php
    }
?>-->
 </span>
 
 <?php
} else {
?>
 <span class="midileft_text empty_cart"><?php
    echo _JSHOP_CART_EMPTY;
?></span>
  
  <span class="gotocart empty_cart"><a href = "<?php
    print $go_sef;
?>" target="_top"><?php
    print JText::_('GO_TO_' . $lang . '');
?></a>&nbsp;&nbsp;
  <?php
    if ($type_view == "1") {
?>
 <a href="<?php
        if ($jshopConfig->shop_user_guest == 1) {
            print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2&check_login=1', 1, 0, $jshopConfig->use_ssl);
        } else {
            print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2', 1, 0, $jshopConfig->use_ssl);
        }
?>"><?php
        print _JSHOP_CHECKOUT;
?></a>
    <?php
    }
?>
 </span>
 <?php
}
?>
 
 </div>
  <div class="clear"></div>
         
</div>
</div>
<!--Modal-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_modal');?>
<!--End modal--> 
</div>