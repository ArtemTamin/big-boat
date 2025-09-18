<?php 

defined('_JEXEC') or die('Restricted access');
if ($layout=="_:externbootstrapdop-min"){
	$layot_mark="min_view";
}
?>
<div class="ajax_cart_wl <?php print $layot_mark;?> type_view  <?php if ($type_view=="1") {print "cart_view";} else {print "wishlist_view";}?>" data-cart-view="<?php if ($type_view=="1") {print "cart_view ";} else {print "wishlist_view ";} ?>">