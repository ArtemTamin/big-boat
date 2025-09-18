<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
	
	<div class="filter-field-price">
		<h3>
			<?php echo JText::_('MOD_JSHOP_EFILTER_FIELDS_PRODUCT_PRICE_TITLE'); ?>
		</h3>
		
		<input class="inputbox" style="width: 40%; max-width: 100px;" name="price-from" type="text" <?php if (JRequest::getVar('price-from')) echo ' value="'.JRequest::getVar('price-from').'"'; ?> /> - 
		
		<input class="inputbox" style="width: 40%; max-width: 100px;" name="price-to" type="text" <?php if (JRequest::getVar('price-to')) echo ' value="'.JRequest::getVar('price-to').'"'; ?> />
	</div>