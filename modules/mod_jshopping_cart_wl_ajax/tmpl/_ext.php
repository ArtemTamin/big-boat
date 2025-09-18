<?php
defined('_JEXEC') or die('Restricted access');
if ($layout=="_:externtwo"){
	$layot_mark="externtwo_wrapp";
}
?>
<div style="height:30px" id="jshop_module_cart_mini_<?php print $module->id; ?>" class="<?php if (!count($cart->products)) print "emptycart"; ?>  mycart_wrapp <?php print $layot_mark;?> <?php if($jshopConfig->product_attribut_first_value_empty=="0") print "attr_noempty";?> <?php if ($color=="1"){print "green";} if ($color=="2"){print "grey";} if ($color=="3"){print "dark";} if ($color=="4"){print "red";} if ($color=="5"){print "orange";} if ($color=="6"){print "blue";}?>">