<?php 
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_bs');
?>
<div>
<div class="span2 col-md-2 col-xs-12 mini_cart_img"><a title="<?php print JText::_('GO_TO_'.$lang.'_MINI');?>" href = "<?php print $go_sef; ?>" target="_top"><?php if ($type_view=="1") { print '<i class="'.$iclass_cart.'"></i>';} else {print '<i class="'.$iclass_wl.'"></i>';}?></a>
</div>

<div class="span9 col-md-9 mycart_mini_txt extern <?php print str_replace("_:","",$layout); ?> <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>"  title="<?php if ($cart->count_product) print JText::_('MINI_CART_EXTERN') ?>">

<span class="externbootstrap_text"><?php if ($cart->count_product) { print JText::_('PRODUCTS_AT_'.$lang.'_MINI_EXT')." ";  print $cart->count_product."<br/> "; print JText::_('PRODUCTS_SUMM_MINI')." "; print formatprice($cart->getSum(0,1))." "; } else { print JText::_('MINI_'.$lang.'');}?></span>
</div>
<i class="span1 col-md-1 down-click pull-right">&darr;</i>
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