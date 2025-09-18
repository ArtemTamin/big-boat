<?php defined( '_JEXEC' ) or die(); ?>
<ul class="inline jshop thumbnail order_menu headingcart" id="jshop_menu_order">
	<?php $i=0; ?>
	<?php foreach($this->steps as $key => $step){?>
		<li class="jshop_order_step">
			<div class="num_step_<?php echo $i?>">
				<?php echo $step;?>
			</div>
		</li>
	<?php $i++; ?>
	<?php }?>
</ul>
