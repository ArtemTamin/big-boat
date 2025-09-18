<?php defined( '_JEXEC' ) or die(); ?>

<div class="jshop checkout">

  <!-- desktop visible cart -->
  <div class="hidden-phone">
    <table class="table table-bordered table-striped jshop">
  		<tr>
  			<th scope="col" class="width20" id="image"><?php echo _JSHOP_IMAGE ?></th>
  			<th scope="col" class="width20" id="item"><?php echo _JSHOP_ITEM ?></th>  
      	<th scope="col" class="width15" id="singleprice"><?php echo _JSHOP_SINGLEPRICE ?></th>
      	<th scope="col" class="width15" id="number"><?php echo _JSHOP_NUMBER ?></th>
      	<th scope="col" class="width15" id="price_total"><?php echo _JSHOP_PRICE_TOTAL ?></th>
  		</tr>

    	<?php $i=1; $countprod=count($this->products);
    	foreach($this->products as $key_id=>$prod){?> 
  		<tr class="jshop_prod_cart <?php if ($i%2==0) echo "even"; else echo "odd"?>">
    		<td class="jshop_img_description_center" headers="image">
    			<a href="<?php echo $prod['href']; ?>">
      			<img src="<?php echo $this->image_product_path ?>/<?php if ($prod['thumb_image']) echo $prod['thumb_image']; else echo $this->no_image; ?>" alt="<?php echo htmlspecialchars($prod['product_name']);?>" class="jshop_img" />
    			</a>
    		</td>
    		<td class="product_name" headers="item">
      		<a href="<?php echo $prod['href']?>"><?php echo $prod['product_name']?></a>
      		<?php if ($this->config->show_product_code_in_cart){?>
      		<span class="jshop_code_prod">(<?php echo $prod['ean']?>)</span>
      		<?php }?>
      		<?php if ($prod['manufacturer']!=''){?>
      		<div class="manufacturer"><?php echo _JSHOP_MANUFACTURER ?>: <span><?php echo $prod['manufacturer']?></span></div>
      		<?php }?>
      		<?php echo sprintAtributeInCart($prod['attributes_value']);?>
      		<?php echo sprintFreeAtributeInCart($prod['free_attributes_value']);?>
      		<?php echo sprintFreeExtraFiledsInCart($prod['extra_fields']);?>
      		<?php echo $prod['_ext_attribute_html']?>
      		<?php if ($this->config->show_delivery_time_step5 && $this->step==5 && $prod['delivery_times_id']){?>
      		<div class="deliverytime"><?php echo _JSHOP_DELIVERY_TIME ?>: <?php echo $this->deliverytimes[$prod['delivery_times_id']]?></div>
      		<?php }?>
    		</td>    
    		<td class="price" headers="singleprice">
    			<?php echo formatprice($prod['price'])?>
    			<?php echo $prod['_ext_price_html']?>
    			<?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
        		<span class="taxinfo"><?php echo productTaxInfo($prod['tax']);?></span>
  	    	<?php }?>
  				<?php if ($this->config->cart_basic_price_show && $prod['basicprice']>0){?>
  				<div class="basic_price"><?php print _JSHOP_BASIC_PRICE?>: <span><?php print sprintBasicPrice($prod);?></span></div>
  				<?php }?>
    		</td>
    		<td class="qty" headers="number">
      		<?php echo $prod['quantity']?><?php echo $prod['_qty_unit'];?>
    		</td>
    		<td class="price_summ" headers="price_total">
      		<?php echo formatprice($prod['price']*$prod['quantity']);?>
  	  		<?php echo $prod['_ext_price_total_html']?>
    			<?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
          		<span class="taxinfo"><?php echo productTaxInfo($prod['tax']);?></span>
      		<?php }?>
    		</td>
  		</tr>
  	<?php $i++; } ?>
    </table>
  </div>
  <!-- /desktop visible cart -->

  <!-- phone visible cart -->
  <div style="display:none;" class="visible-phone">
    <table class="table table-bordered table-striped">
      <?php $i=1; $countprod=count($this->products);
      foreach($this->products as $key_id=>$prod){?> 
      <tr class="jshop_prod_cart <?php if ($i%2==0) echo "even"; else echo "odd"?>">

        <td>
          <a class="jshop_cart_product_name" href="<?php echo $prod['href']?>"><?php echo $prod['product_name']?></a>
          <div class="jshop_cart_img">
            <a href="<?php echo $prod['href']; ?>">
              <img src="<?php echo $this->image_product_path ?>/<?php if ($prod['thumb_image']) echo $prod['thumb_image']; else echo $this->no_image; ?>" alt="<?php echo htmlspecialchars($prod['product_name']);?>" class="jshop_img" />
            </a>
          </div>

          <?php if ($this->config->show_product_code_in_cart){?>
          <span class="jshop_code_prod">(<?php echo $prod['ean']?>)</span>
          <?php }?>

          <?php if ($prod['manufacturer']!=''){?>
          <div class="manufacturer"><?php echo _JSHOP_MANUFACTURER ?>: <span><?php echo $prod['manufacturer']?></span></div>
          <?php }?>

          <?php echo sprintAtributeInCart($prod['attributes_value']);?>
          <?php echo sprintFreeAtributeInCart($prod['free_attributes_value']);?>
          <?php echo sprintFreeExtraFiledsInCart($prod['extra_fields']);?>
          <?php echo $prod['_ext_attribute_html']?>
          <?php if ($this->config->show_delivery_time_step5 && $this->step==5 && $prod['delivery_times_id']){?>
          <div class="deliverytime"><?php echo _JSHOP_DELIVERY_TIME ?>: <?php echo $this->deliverytimes[$prod['delivery_times_id']]?></div>
          <?php }?>
        </td> 

        <td class="cart_order_info">
          <div class="jshop_cart_price">
            <div class="cart_label"><?php echo _JSHOP_SINGLEPRICE ?></div>
            <?php echo formatprice($prod['price'])?>
            <?php echo $prod['_ext_price_html']?>
            <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
              <span class="taxinfo"><?php echo productTaxInfo($prod['tax']);?></span>
            <?php }?>
            <?php if ($this->config->cart_basic_price_show && $prod['basicprice']>0){?>
            <div class="basic_price"><?php print _JSHOP_BASIC_PRICE?>: <span><?php print sprintBasicPrice($prod);?></span></div>
            <?php }?>
          </div>

          <div class="jshop_cart_prod_qty">
            <div class="cart_label"><?php echo _JSHOP_NUMBER ?></div>
            <?php echo $prod['quantity']?><?php echo $prod['_qty_unit'];?>
          </div>

          <div class="jshop_cart_price_total">
            <div class="cart_label"><?php echo _JSHOP_PRICE_TOTAL ?></div>
            <?php echo formatprice($prod['price']*$prod['quantity']);?>
            <?php echo $prod['_ext_price_total_html']?>
            <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
              <span class="taxinfo"><?php echo productTaxInfo($prod['tax']);?></span>
            <?php }?>
          </div>
        </td>
      </tr>
      <?php $i++; } ?>    

    </table>
  </div>
  <!-- /phone visible cart -->

  <?php if ($this->config->show_weight_order){?>  
  <div class="weightorder">
   	<?php echo _JSHOP_WEIGHT_PRODUCTS ?>: <span><?php echo formatweight($this->weight);?></span>
  </div>
  <?php }?>
  
  <ul class="unstyled jshop_subtotal">
  	<?php if (!$this->hide_subtotal){?>
    	<li class="subtotal">    
      	<span class="name"><?php echo _JSHOP_SUBTOTAL ?>:</span>
      	<span class="value"><?php echo formatprice($this->summ);?><?php echo $this->_tmp_ext_subtotal?></span>
    	</li>
    	<?php } ?>

    	<?php if ($this->discount > 0){ ?>
    	<li class="rabatt_value">
  		<span class="name"><?php echo _JSHOP_RABATT_VALUE ?>:</span>
      	<span class="value"><?php echo formatprice(-$this->discount);?><?php echo $this->_tmp_ext_discount?></span>
    	</li>
    	<?php } ?>

    	<?php if (isset($this->summ_delivery)){?>
    	<li class="shipping_price">
      	<span class="name"><?php echo _JSHOP_SHIPPING_PRICE ?>:</span>
      	<span class="value"><?php echo formatprice($this->summ_delivery);?><?php echo $this->_tmp_ext_shipping?></span>
    	</li>
    	<?php } ?>

    	<?php if (isset($this->summ_package)){?>
    	<li>
  	    <span class = "name"><?php echo _JSHOP_PACKAGE_PRICE ?>:</span>
      	<span class = "value"><?php print formatprice($this->summ_package);?><?php print $this->_tmp_ext_shipping_package?></span>
    	</li>
    	<?php } ?>

    	<?php if ($this->summ_payment != 0){ ?>
    	<li class="payment">
      	<span class="name"><?php echo $this->payment_name;?>:</span>
      	<span class="value"><?php echo formatprice($this->summ_payment);?><?php echo $this->_tmp_ext_payment?></span>
    	</li>
    	<?php } ?>

    	<?php if (!$this->config->hide_tax){ ?>
      	<?php foreach($this->tax_list as $percent=>$value){?>
      	<li class="tax">
        	<span class="name">
          		<?php echo displayTotalCartTaxName();?>
          		<?php if ($this->show_percent_tax) echo formattax($percent)."%"?>:
          </span>
        	<span class="value"><?php echo formatprice($value);?><?php echo $this->_tmp_ext_tax[$percent]?></span>
      	</li>
      	<?php } ?>
    	<?php } ?>

    	<li class="total">
      	<span class="name"><?php echo $this->text_total; ?>:</span>
      	<span class="value"><?php echo formatprice($this->fullsumm)?><?php echo $this->_tmp_ext_total?></span>
    	</li>

    	<?php if ($this->free_discount > 0){?>  
    	<li class="free_discount">
  	    <span class="text-right">
      	    <span class="free_discount"><?php echo _JSHOP_FREE_DISCOUNT ?>: <?php echo formatprice($this->free_discount); ?></span>
      	</span>
    	</li>
    	<?php }?>
  </ul>
</div> 
<!-- /checkout -->