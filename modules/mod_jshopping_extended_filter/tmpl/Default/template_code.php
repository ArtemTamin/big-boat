<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
	
	<div class="filter-field-code">
		<h3>
			<?php echo JText::_('MOD_JSHOP_EFILTER_FIELDS_PRODUCT_CODE_TITLE'); ?>
		</h3>
		
		<input class="inputbox" style="width: 200px; text-align: left;" name="code" type="text" <?php if (JRequest::getVar('code')) echo ' value="'.JRequest::getVar('code').'"'; ?> />
	</div>