<?php
defined('_JEXEC') or die('Restricted access');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_header');
require JModuleHelper::getLayoutPath('mod_jshopping_cart_wl_ajax', '_ext');
?>

<div>
  <span class="mycart_mini_txt extern <?php print str_replace("_:","",$layout); ?> <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>"><a href = "<?php print $go_sef;?>" target="_top" title="<?php print JText::_('GO_TO_'.$lang.'_MINI') ?>"><?php print $cart->count_product;?></a><span class="arrow_down">&darr;</span></span>
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