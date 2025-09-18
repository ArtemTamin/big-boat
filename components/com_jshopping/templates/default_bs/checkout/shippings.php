<?php defined( '_JEXEC' ) or die(); ?>

<h2 style="margin-bottom:15px;" >Выберите способ доставки</h2>

<?php echo $this->checkout_navigator?>
<?php echo $this->small_cart?>

<div class="jshop">

<form class="thumbnail form-horizontal" style="padding: 5px 0px 15px 0px;" id="shipping_form" name="shipping_form" action="<?php echo $this->action ?>" method="post" onsubmit="return validateShippingMethods()">
<?php echo $this->_tmp_ext_html_shipping_start?>
<div id="table_shippings">
<?php foreach($this->shipping_methods as $shipping){?>
	<div class="control-group checkout_otstup">
		
            
		<label datatatat  class="radio" for="shipping_method_<?php echo $shipping->sh_pr_method_id ?>">
         <input type="radio" style="float:none; margin-left:0px;"  name="sh_pr_method_id" id="shipping_method_<?php echo $shipping->sh_pr_method_id?>" value="<?php echo $shipping->sh_pr_method_id ?>" <?php if ($shipping->sh_pr_method_id==$this->active_shipping){ ?>checked="checked"<?php } ?> />
        
			<?php if ($shipping->image){ ?>
			<span class="shipping_image"><img src="<?php echo $shipping->image?>" alt="<?php echo htmlspecialchars($shipping->name)?>" /></span>
			<?php } ?>
			<?php echo $shipping->name?> 
            
            	<?php if ($this->config->show_list_price_shipping_weight && count($shipping->shipping_price)){ ?>
          	<div class="shipping_weight_to_price">
          	<?php foreach($shipping->shipping_price as $price){?>
            	<div class="weight">
                	<?php if ($price->shipping_weight_to!=0){?>
                    	<?php echo formatweight($price->shipping_weight_from);?> - <?php echo formatweight($price->shipping_weight_to);?>
                    <?php }else{ ?>
                    	<?php echo _JSHOP_FROM." ".formatweight($price->shipping_weight_from);?>
                    <?php } ?>
                </div>
                <div class="price">
                    <?php echo formatprice($price->shipping_price); ?>
                </div>
          	<?php } ?>
          	</div>
      	<?php } ?>
      	<div class="shipping_descr"><small><?php echo $shipping->description?></small></div>
      	<?php if ($shipping->delivery){?>
      	<div class="shipping_delivery"><small><?php echo _JSHOP_DELIVERY_TIME.": ".$shipping->delivery?></small></div>
      	<?php }?>
	    <?php if ($shipping->delivery_date_f){?>
      	<div class="shipping_delivery_date"><?php echo _JSHOP_DELIVERY_DATE.": ".$shipping->delivery_date_f?></div>
      	<?php }?>  
            
            </label>
            
            
      	     	
	</div>
<?php } ?>
</div>
<?php echo $this->_tmp_ext_html_shipping_end?>
<p class="btn-checkout-otstup"><input type="submit" class="btn btn-success"  value="<?php echo _JSHOP_NEXT?>" /></p>
</form>
</div>