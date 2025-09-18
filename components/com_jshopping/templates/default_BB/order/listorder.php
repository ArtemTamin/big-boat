<?php defined( '_JEXEC' ) or die(); ?>
<div class="jshop">
    <h1><?php echo _JSHOP_MY_ORDERS ?></h1>
    <br />
    <?php if (count($this->orders)) {?>
      <?php foreach ($this->orders as $order){?>
		<div class = "thumbnail" style="padding:2%;">
		<div>
            <div class="radiootstup" style="float:left">
              	<span class="label label-success" style="margin-right:3%;"><?php echo _JSHOP_ORDER_NUMBER?>: <?php echo $order->order_number ?></span>
            </div> 
            
            <div class="radiootstup" style="float:left;">
						<span class="label" style="margin-right:3%;"><?php echo _JSHOP_ORDER_DATE?>:  
						<?php echo formatdate($order->order_date, 0)?></span>
					</div>
            
            <div class="radiootstup">
              	<span class="label"><?php echo _JSHOP_ORDER_STATUS?>: <?php echo $order->status_name ?></span>
                
			</div> 
		</div>
		<div class="clear"> </div>
		<div >
			<div >
				<div >
					
					<div style="margin-top:2%">
						<span class="jshop_name" ><?php echo _JSHOP_PRODUCTS?>:</span>
						<span ><?php echo $order->count_products ?></span>
					</div>
					<div ><span class="jshop_name"><?php echo _JSHOP_SUBTOTAL ?>:</span> <?php echo formatprice($order->order_total, $order->currency_code)?></div><?php echo $order->_ext_price_html?>


				</div>
				<div >
					<div>
						<span class="jshop_name"><?php echo _JSHOP_EMAIL_BILL_TO?>:</span> 
						<span><?php echo $order->f_name ?> <?php echo $order->l_name ?></span>
					</div>
					<div>
						<span class="jshop_name"><?php echo _JSHOP_EMAIL_SHIP_TO?>:</span>
						<span><?php echo $order->d_f_name ?> <?php echo $order->d_l_name ?></span>
					</div>
				</div>
				<div class="clear"> </div>
				
				<div class="botom" style="margin-top:2%">
					
					<a  class="btn" href = "<?php echo $order->order_href ?>"><?php echo _JSHOP_DETAILS?></a> 			
				</div>
			</div>
		</div>
		</div>
		<div class="clear"> </div>
      <?php } ?>
    <?php }else{ ?>
      <div class="order_info_noorders"><?php echo _JSHOP_NO_ORDERS?> </div>
    <?php } ?>
</div>