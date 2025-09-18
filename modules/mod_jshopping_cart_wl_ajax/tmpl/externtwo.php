<?php 
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_ext');
?>

<div>
  <span class="mycart_mini_txt extern <?php print str_replace("_:","",$layout); ?> <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>"  title="<?php if ($cart->count_product) print JText::_('MINI_'.$lang.'_EXTERN') ?>"><span class="externtwo_text"><?php if ($cart->count_product) { print JText::_('PRODUCTS_AT_'.$lang.'_MINI_EXT')." ";  print $cart->count_product." "; print JText::_('PRODUCTS_SUMM_MINI')." "; print formatprice($cart->getSum(0,1))." "; } else { print JText::_('MINI_'.$lang.'');}?></span></span>
  <span class="mini_cart_img"><a title="<?php print JText::_('GO_TO_'.$lang.'_MINI') ?>" href = "<?php print $go_sef; ?>" target="_top"><img src="/modules/mod_jshopping_cart_wl_ajax/img/<?php print $del_sef;?>_mini.png" /></a></span>
<div class="clear"></div>  
  
<!--Extern-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_extcontent');?>

<!--End Extern-->
</div>
</div>
<!--Modal-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_modal');?>

<!--End modal--> 
</div>