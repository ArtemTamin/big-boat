<?php 
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_bs');
?>
<div>

<div class="mini_cart_img"><a class="down-click" title="<?php print JText::_('MINI_CART_EXTERN') ?>" href = "#"><?php if ($type_view=="1") { print '<i class="'.$iclass_cart.'"></i>';} else {print '<i class="'.$iclass_wl.'"></i>';}?></a>
</div>

<div class="mycart_mini_txt extern externbootstrap <?php print str_replace("_:","",$layout); ?> <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>"  title="<?php if ($cart->count_product) print JText::_('MINI_CART_EXTERN') ?>">
<span class="externbootstrap_text"><?php if ($cart->count_product) {print $cart->count_product." ";} else { print $cart->count_product;}?></span>
</div>
<div class="clearfix"></div>
  
<!--Extern-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_extcontent');?>
<!--End Extern-->
</div>
</div>
<!--Modal-->
<?php require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_modal');?>
<!--End modal-->     
</div>