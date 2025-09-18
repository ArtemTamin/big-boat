<?php defined( '_JEXEC' ) or die(); ?>
<div class="jshop">
    <h1><?php echo _JSHOP_LOGOUT ?></h1>
    <br />
    <input class="btn" type="button" value="<?php echo _JSHOP_LOGOUT ?>" onclick="location.href='<?php print SEFLink("index.php?option=com_jshopping&controller=user&task=logout"); ?>'" />
</div>