<?php defined( '_JEXEC' ) or die(); ?>

<h2 class="headingcart" ><?php echo _JSHOP_FINISH ?></h2>
<?php if (!empty($this->text)){?>
<?php echo $this->text;?>
<?php }else{?>
<div class="thanksfinish"><?php echo _JSHOP_THANK_YOU_ORDER ?></div>
<?php }?>
