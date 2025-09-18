<?php defined( '_JEXEC' ) or die(); ?>

<div class="jshop">
<h1 style="margin-bottom:15px;" >Список желаний</h1>
<!-- Table markup-->


<div class="hidden-phone">
<table class="table table-bordered">

<!-- Table header -->

	<thead>
		<tr>
        <th scope="col" class="width10" id="remove" style="text-align:center; width:16px;"></th>
			<th scope="col" class="width20" id="image" style="text-align:center"><?php echo _JSHOP_IMAGE ?></th>
			<th scope="col" class="width20" id="item" style="text-align:center"><?php echo _JSHOP_ITEM ?></th>  
    		<th scope="col" class="width15" id="singleprice" style="text-align:center"><?php echo _JSHOP_SINGLEPRICE ?></th>
    		<th scope="col" class="width15" id="number" style="text-align:center"><span><?php echo _JSHOP_NUMBER ?></span></th>
    		<th scope="col" class="width10" id="price_total" style="text-align:center"><?php echo _JSHOP_PRICE_TOTAL ?></th>
    		<th scope="col" class="width10" id="to_cart" style="text-align:center"><?php echo _JSHOP_REMOVE_TO_CART ?></th>
						
		</tr>
	</thead>

<!-- Table footer -->

	<!-- <tfoot>
		<tr>
			<td class="tfoot" colspan="7"></td>
		</tr>
	</tfoot> -->

<!-- Table body -->

	<tbody>  
  
	<?php $i=1; $countprod = count($this->products);
  	foreach($this->products as $key_id=>$prod){?> 
  	<tr class = "jshop_prod_cart <?php if ($i%2==0) print "even"; else print "odd"?>">
  		
        <td class="remove" headers="remove" style="text-align:center" >
      		<a href="<?php print $prod['href_delete'] ?>" onclick="return confirm('<?php echo _JSHOP_REMOVE?>')"><img src = "<?php print $this->image_path ?>images/bs/remove.png" alt = "<?php echo _JSHOP_DELETE?>" title = "<?php echo _JSHOP_DELETE?>" />
            
              </a>
    	</td>
        
        <td class = "jshop_img_description_center" headers="image" style="text-align:center">
      		<a href = "<?php print $prod['href']; ?>">
        		<img src = "<?php print $this->image_product_path ?>/<?php if ($prod['thumb_image']) print $prod['thumb_image']; else print $this->no_image; ?>" alt = "<?php print htmlspecialchars($prod['product_name']);?>"  />
      		</a>
    	</td>
    	<td class="product_name" headers="item">
        	<a href="<?php print $prod['href']?>"><?php print $prod['product_name']?></a>
        	<?php if ($this->config->show_product_code_in_cart){?>
        	<span class="jshop_code_prod">(<?php print $prod['ean']?>)</span>
        	<?php }?>
        	<?php if ($prod['manufacturer']!=''){?>
        	<div class="manufacturer"><?php echo _JSHOP_MANUFACTURER ?>: <span><?php print $prod['manufacturer']?></span></div>
        	<?php }?>
        	<?php print sprintAtributeInCart($prod['attributes_value']);?>
        	<?php print sprintFreeAtributeInCart($prod['free_attributes_value']);?>
        	<?php print sprintFreeExtraFiledsInCart($prod['extra_fields']);?>
        	<?php print $prod['_ext_attribute_html']?>        
    	</td>    
    	<td class="price" headers="singleprice" style="text-align:center">
      	<?php print formatprice($prod['price'])?>
      	<?php print $prod['_ext_price_html']?>
      	<?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
        	<span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
        <?php }?>
		<?php if ($this->config->cart_basic_price_show && $prod['basicprice']>0){?>
			<div class="basic_price"><?php print _JSHOP_BASIC_PRICE?>: <span><?php print sprintBasicPrice($prod);?></span></div>
		<?php }?>
    	</td>
    	<td class="qty" headers="number" style="text-align:center">
      		<?php print $prod['quantity']?><?php print $prod['_qty_unit'];?>
    	</td>
    	<td class="price_summ" headers="price_total" style="text-align:center">
      		<?php print formatprice($prod['price']*$prod['quantity']);?>
      		<?php print $prod['_ext_price_total_html']?>
      		<?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
            <span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
        	<?php }?>
    	</td>
    	<td class="to_cart" headers="to_cart" style="text-align:center">
      		<a href="<?php print $prod['remove_to_cart'] ?>" ><img src="<?php print $this->image_path ?>images/bs/cart_put.png" alt = "<?php echo _JSHOP_REMOVE_TO_CART?>" title = "<?php echo _JSHOP_REMOVE_TO_CART?>" /></a>
    	</td>
     
  	</tr>
	<?php $i++; } ?>
</table>
</div>


<div class="visible-phone">
      <table class="table table-bordered table-striped">
        <?php 
        $i=1;   
        foreach($this->products as $key_id=>$prod){
        ?> 
        <tr class="jshop_prod_cart <?php if ($i%2==0) print "even"; else print "odd"?>">
          <td>
            <a class="jshop_cart_product_name" href="<?php print $prod['href']?>"><?php print $prod['product_name']?></a>
            <div class="jshop_cart_img">
              <a href="<?php print $prod['href']?>">
                <img src="<?php print $this->image_product_path ?>/<?php if ($prod['thumb_image']) print $prod['thumb_image']; else print $this->no_image; ?>" alt="<?php print htmlspecialchars($prod['product_name']);?>" class="jshop_img" />
              </a>
            </div>
            <?php if ($this->config->show_product_code_in_cart){?>
            <span class="jshop_code_prod">(<?php print $prod['ean']?>)</span>
            <?php }?>

            <?php if ($prod['manufacturer']!=''){?>
            <div class="manufacturer"><?php print _JSHOP_MANUFACTURER?>: <span><?php print $prod['manufacturer']?></span></div>
            <?php }?>

            <?php print sprintAtributeInCart($prod['attributes_value']);?>
            <?php print sprintFreeAtributeInCart($prod['free_attributes_value']);?>
            <?php print sprintFreeExtraFiledsInCart($prod['extra_fields']);?>
            <?php print $prod['_ext_attribute_html']?>
			<br /><br />
			 <div class="jshop_cart_prod_delete">
              <a href="<?php print $prod['href_delete']?>" onclick="return confirm('<?php print _JSHOP_CONFIRM_REMOVE?>')"><img src = "<?php print $this->image_path ?>images/remove.png" alt = "<?php print _JSHOP_DELETE?>" title = "<?php print _JSHOP_DELETE?>" /><?php print _JSHOP_REMOVE?></a>
              
			
			
			</div>
          </td>
          <td class="cart_order_info">
            <div class="jshop_cart_price">
              <div class="cart_label"><?php print _JSHOP_SINGLEPRICE?></div>
              <?php print formatprice($prod['price'])?>
              <?php print $prod['_ext_price_html']?>
              <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
                  <span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
              <?php }?>
              <?php if ($this->config->cart_basic_price_show && $prod['basicprice']>0){?>
                  <div class="basic_price"><?php print _JSHOP_BASIC_PRICE?>: <span><?php print sprintBasicPrice($prod);?></span></div>
              <?php }?>
            </div>

            <? /* <div class="jshop_cart_prod_qty">
              <div class="cart_label"><?php print _JSHOP_NUMBER?></div>
              <span class="cart_value">
              <input type="text" name="quantity[<?php print $key_id ?>]" value="<?php print $prod['quantity'] ?>" class="inputbox" style="width: 25px" />
              <?php print $prod['_qty_unit'];?>
              <span class = "cart_reload"><img style="cursor:pointer; vertical-align:middle;" src="<?php print $this->image_path ?>/images/bs/reload.png" title="<?php print _JSHOP_UPDATE_CART ?>" alt = "<?php print _JSHOP_UPDATE_CART ?>" onclick="document.updateCart.submit();" /></span>
              </span>
            </div> */ ?>

            <div class="jshop_cart_price_total">
              <div class="cart_label"><?php print _JSHOP_PRICE_TOTAL?></div>
              <?php print formatprice($prod['price']*$prod['quantity']); ?>
              <?php print $prod['_ext_price_total_html']?>
              <?php if ($this->config->show_tax_product_in_cart && $prod['tax']>0){?>
                  <span class="taxinfo"><?php print productTaxInfo($prod['tax']);?></span>
              <?php }?>
            </div>

            <div class="jshop_cart_prod_delete">
             
              <a href="<?php print $prod['remove_to_cart'] ?>" ><img src="<?php print $this->image_path ?>images/bs/cart_put.png" alt = "<?php echo _JSHOP_REMOVE_TO_CART?>" title = "<?php echo _JSHOP_REMOVE_TO_CART?>" /><?php echo _JSHOP_REMOVE_TO_CART?></a>
			
			
			</div>              
          </td>
        </tr>
        <?php 
        $i++;
        } 
        ?>
      </table>
    </div>




<div class="checkout" id="checkout">
      <div class="btn-group">
        <a class="btn" href="<?php echo $this->href_shop ?>">
        <i class="icon-arrow-left"></i>
        <?php print _JSHOP_BACK_TO_SHOP ?>
        </a>

        <?php if ($countprod>0){?>
        <a class="btn btn-success" href="<?php print $this->href_checkout ?>&Itemid=153">
        <?php print _JSHOP_CHECKOUT ?>
        <i class="icon-arrow-right"></i>
        </a>
        <?php }?>
      </div>




</div></div>