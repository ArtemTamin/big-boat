<?php
defined('_JEXEC') or die('Restricted access');
if ($bs_version=="1"){
	$bs_mark="collapse";
} else {
	$bs_mark="out";
}
if ($modal_type=="2"){
	$close_button='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
}
?>
<?php if ($show_added_to_cart=='2'){ ?>
<div id="inlineContent_minicart_<?php if ($type_view=="1") {print "cart_view";} else {print "wishlist_view";}?>" class="defaultDOMWindow modal dop fade <?php print $bs_mark;?>" tabindex="-1" role="dialog" aria-labelledby="inlineContent_minicart_<?php if ($type_view=="1") {print "cart_view";} else {print "wishlist_view";}?>" aria-hidden="true"> 

<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<?php print $close_button ;?>

<div class="modal-top"></div>
<p class="modal_header" data-header="<?php print JText::_('PRODUCT_AT_'.$lang.'_MINI') ?>"></p> 
<p class="modal_anchor <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>">
<span class="modal_to_cart">
<a href = "<?php print $go_sef; ?>" target="_top"><?php print JText::_('GO_TO_'.$lang.'_MINI') ?></a></span>
<?php if ($type_view=="1"){?>
<span class="modal_checkout"><a href="<?php if ($jshopConfig->shop_user_guest==1){print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2&check_login=1',1, 0, $jshopConfig->use_ssl);
}else{
print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',1, 0, $jshopConfig->use_ssl);
} ?>" target="_top"><?php print _JSHOP_CHECKOUT ?></a>
</span>
<?php } ?>
</p>
<p><a href="#" class="closeDOMWindow" target="_top" data-dismiss="modal" aria-hidden="true" data-modal-close-btn="<?php print _JSHOP_BACK_TO_SHOP ?>"></a></p>
<p class="modal_text"><span class="modal_pretext" data-modal-text="<?php print JText::_('PRODUCTS_AT_'.$lang.'_MINI') ?>"></span> <span class="modal_quantity"></span> <span class="modal_summ_text" data-modal-summ-text="<?php print JText::_('PRODUCTS_SUMM_MINI') ?>"></span> <span class="modal_summ"></span></p>
<?php if ($modal_type=='2' && $modal_dop=='1') {?>
		<div class="modal-bottom"></div>
<?php } ?>
</div>
</div>
</div>

</div>

<div id="error_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" class="errorDOMWindow modal fade <?php print $bs_mark;?>" tabindex="-1" role="dialog" aria-labelledby="error_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" aria-hidden="true">

<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body"> 
<?php print $close_button ;?>

<span class="modal_err"></span>
<p><a href="#" class="closeDOMWindow" target="_top" data-dismiss="modal" data-modal-close-btn="<?php print _JSHOP_BACK_TO_SHOP ?>" aria-hidden="true"></a></p>

</div>
</div>
</div>

</div>
<?php } ?>
<?php if ($show_added_to_cart=='1' || $show_added_to_cart=='3'){ ?>
<div id="error_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" class="errorDOMWindow modal fade <?php print $bs_mark;?>" tabindex="-1" role="dialog" aria-labelledby="error_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" aria-hidden="true">

<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body"> 
<?php print $close_button ;?>

<span class="modal_err"></span>
<p><a href="#" class="closeDOMWindow" target="_top" data-dismiss="modal" data-modal-close-btn="<?php print _JSHOP_BACK_TO_SHOP ?>" aria-hidden="true"></a></p>
</div>
</div>
</div>

</div>
<?php } ?>
<div id="delete_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" class="deleteDOMWindow modal fade <?php print $bs_mark;?>" tabindex="-1" role="dialog" aria-labelledby="delete_inlineContent_minicart_<?php if ($type_view=="1"){print "cart_view";} else {print "wishlist_view";}?>" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">    
<?php print $close_button ;?>
   
<span class="modal_delete" data-modal-delete="<?php print JText::_('PRODUCT_REMOVE_FROM_'.$lang.'_MINI') ?>"></span>
<p><a href="#" class="closeDOMWindow" target="_top" data-dismiss="modal" data-modal-close-btn="<?php print _JSHOP_BACK_TO_SHOP ?>" aria-hidden="true"></a></p>
</div>
</div>
</div>

</div>