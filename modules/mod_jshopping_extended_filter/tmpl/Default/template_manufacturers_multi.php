<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$checked = JRequest::getVar("manufacturer");
if(!$checked) {
	if(JRequest::getVar("controller") == "manufacturer") {
		$checked = JRequest::getInt("manufacturer_id");
	}
}
if(!is_array($checked)) {
	$checked = Array($checked);
}

?>
	
	<div class="filter-field-manufacturer-multi multiple-select">
		<h3>
			<?php echo JText::_('MOD_JSHOP_EFILTER_FIELDS_PRODUCT_MANUFACTURER_TITLE'); ?>
		</h3>
		
		<select name="manufacturer[]" multiple="multiple">		
		<?php
			if($manufacturers) {
				foreach($manufacturers as $manufacturer) {
					$selected = '';
					if($checked) {
						foreach ($checked as $check) {
							if ($check == $manufacturer->manufacturer_id) $selected = ' selected="selected"';
						}
					}
					echo "<option value='".$manufacturer->manufacturer_id."'".$selected.">".$manufacturer->name."</option>";
				}
			}
		?>		
		</select>		
	</div>