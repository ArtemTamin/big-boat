<?php defined( '_JEXEC' ) or die(); ?>
<?php echo $product->_tmp_var_start?>
<?$table_product = JTable::getInstance('product', 'jshop');
	 $t = $table_product->load($product);
    $table_product->load($product->product_id);
    $table_attributes;

    $attributesDatas = $table_product->getAttributesDatas($back_value['attr']);
    	  $table_product->setAttributeActive($attributesDatas['attributeActive']);
        $attributeValues = $attributesDatas['attributeValues'];

?>
<div data-product class="<?php if ($this->count_product_to_row == 1) echo "one_in_row "; ?>cart productitem_<?php echo $product->product_id?>">

    <?php if ($this->count_product_to_row == 1) echo "<div class='row-fluid'>"; ?>

    <div data-image class="cart__image <?php if ($this->count_product_to_row == 1) echo "span4"; ?> image">
        <?php if ($product->image){?>
        
		<?php print $product->_tmp_var_image_block;?>
            <?php if ($product->label_id){?>
                <div class="product_label">
                    <?php if ($product->_label_image){?>
						<a href="<?php echo $product->product_link?>"> 
						<img class="jshop_img" src="<?php echo $product->_label_image?>" alt="<?php echo htmlspecialchars($product->_label_name)?>" />
					</a>
                    <?php }else{?>
                        <span class="label_name jshop_img"><?php echo $product->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?>
			<a href="<?php echo $product->product_link?>"> 
                <img class="jshop_img" src="<?php echo $product->image?>" alt="<?php echo htmlspecialchars($product->name);?>" />
          
				</a>
        <?php }?>
        <?php echo $product->_tmp_var_bottom_foto;?>
    </div>

    <div class="<?php if ($this->count_product_to_row == 1) echo "span6"; ?> mainblock cart__description">
      
        <?php if ($this->count_product_to_row == 1){ ?>
            <h2 class="product_title">
                <a href="<?php echo $product->product_link?>"><?php echo $product->name?></a>
                <?php if ($this->config->product_list_show_product_code){?>
                <span class="jshop_code_prod">(<?php echo _JSHOP_EAN?>: <span><?php echo $product->product_ean;?></span>)</span>
                <?php }?>
            </h2>
        <?php } ?>

        <?php if ($this->allow_review){?>
            <!-- звезды -->
        <div class="cart__star">
            <?php echo showMarkStar($product->average_rating);?>
            <!-- <div class="count_commentar">
                <?php //echo sprintf(_JSHOP_X_COMENTAR, $product->reviews_count);?>
            </div> -->
        </div>
        <?php }?>
        <!-- название товара -->
        <div class="cart__name">
			<span class="<?php if ($this->count_product_to_row == 1) echo "hidden"; ?>">
            <a href="<?php echo $product->product_link?>"><?php echo $product->name?></a>
            <?php if ($this->config->product_list_show_product_code){?>
            <span class="jshop_code_prod">(<?php echo _JSHOP_EAN?>: <span><?php echo $product->product_ean;?></span>)</span>
            <?php }?>
            </span>
        </div>
        <!-- цена -->
        <div class="jshop_price_block cart__price">
            <?php if ($product->_display_price){?>
               <?php if ($this->config->product_list_show_price_description) echo _JSHOP_PRICE.": ";?>
                    <?php if ($product->show_price_from) echo _JSHOP_FROM." ";?>
                    <div class="jshop_price">
						<span><?php echo formatprice($product->product_price);?></span>
					</div>
                
            <?php }?>
            <?php echo $product->_tmp_var_bottom_price;?>
            <?php if ($product->product_old_price > 0){?>
                <div class="old_price"><?php if ($this->config->product_list_show_price_description) echo _JSHOP_OLD_PRICE.": ";?>
                    <span><?php echo formatprice($product->product_old_price)?></span>
                </div>
            <?php }?>
            <?php print $product->_tmp_var_bottom_old_price;?>
        </div>
		<div class="buttons but cart__buy">
                    <!-- <?//php if ($product->buy_link){?>
                        <div class="cart__button button">
						<a class="btn btn-success button_buy" href="<?php echo $product->buy_link?>">В корзину</a>
						</div>
                    <?php// }?> -->
					<div class="cart__button button">
                        <!--<a class="btn btn-info button_detail" href="<?php //echo $product->product_link?>">Купить</a>-->
                        <a class="btn btn-info button_detail" href="<?php echo $product->product_link?>">Узнать подробнее</a>
						</div>
                    <?php echo $product->_tmp_var_buttons;?>
                </div>
        <!-- эксперементальный блок -->
            <div>
            	<?
                 $attributes = $table_product->getBuildSelectAttributes($attributeValues, $attributesDatas['attributeSelected']);
			        if (count($attributes)){
			            $_attributevalue = JTable::getInstance('AttributValue', 'jshop');
			            $all_attr_values = $_attributevalue->getAllAttributeValues();
			        }else{
			            $all_attr_values = array();
			        }
			        ?>
              
            </div>
           
            <div <? if (count($product->extra_field) > 0) { ?> class="product__description" <? }else{?> style="display: none" <?}?>>
                <?php if (is_array($product->extra_field)){?>
					<div style="width: 100%; text-align: right;"><span class="cart__close">X</span></div>
                    <ul class="unstyled extra_fields">
                    <?php foreach($product->extra_field as $extra_field){?>
                        <li>
                            <span class="text-right extra_fields_name"><?php echo $extra_field['name'];?>:</span>
                            <span class="text-left extra_fields_value">&nbsp;&nbsp;<?php echo $extra_field['value']; ?></span>
                        </li>
                    <?php }?>
                    </ul>
                <?php }?>
                <?php echo $product->_tmp_var_top_buttons;?>
               
                <?php echo $product->_tmp_var_bottom_buttons;?>
            </div>

        <?php if ($product->manufacturer->name){?>
            <div class="manufacturer_name"><?php echo _JSHOP_MANUFACTURER?>: <span><?php echo $product->manufacturer->name?></span></div>
        <?php }?>

       

            <!-- chek 1 -->
        <?php if ($product->product_quantity <=0 && !$this->config->hide_text_product_not_available){?>
            <!-- <div class="not_available"><?php echo _JSHOP_PRODUCT_NOT_AVAILABLE?></div> -->
        <?php }?>
            <!-- chek 2 -->
        <?php if ($product->product_price_default > 0 && $this->config->product_list_show_price_default){?>
            <!-- <div class="default_price"><?php echo _JSHOP_DEFAULT_PRICE.": ";?><span><?php echo formatprice($product->product_price_default)?></span></div> -->
        <?php }?>
            <!-- chek 3 -->
        <?php if ($this->config->show_tax_in_product && $product->tax > 0){?>
          <!--  <span class="taxinfo"><?php echo productTaxInfo($product->tax);?></span>-->
        <?php }?>
        <!-- chek 4 -->
        <?php if ($this->config->show_plus_shipping_in_product){?>
           <!-- <span class="plusshippinginfo"><?php echo sprintf(_JSHOP_PLUS_SHIPPING, $this->shippinginfo);?></span>-->
        <?php }?>
        <?php if ($product->basic_price_info['price_show']){?>
           <!-- <div class="base_price">--><?php echo _JSHOP_BASIC_PRICE?>: <?php if ($product->show_price_from) echo _JSHOP_FROM;?> <span><?php echo formatprice($product->basic_price_info['basic_price'])?> / <?php echo $product->basic_price_info['name'];?></span></div>
        <?php }?>
        <?php if ($this->config->product_list_show_weight && $product->product_weight > 0){?>
           <!-- <div class="productweight"><?php echo _JSHOP_WEIGHT?>.: <span><?php echo formatweight($product->product_weight)?></span></div>-->
        <?php }?>
        <?php if ($product->delivery_time != ''){?>
          <!--  <div class="deliverytime"><?php echo _JSHOP_DELIVERY_TIME?>: <span><?php echo $product->delivery_time?></span></div>-->
        <?php }?>

        <?php if ($product->vendor){?>
           <!-- <div class="vendorinfo"><?php echo _JSHOP_VENDOR?>: <a href="<?php echo $product->vendor->products?>"><?php echo $product->vendor->shop_name?></a></div>-->
        <?php }?>
        <?php if ($this->config->product_list_show_qty_stock){?>
          <!--  <div class="qty_in_stock"><?php echo _JSHOP_QTY_IN_STOCK?>: <span><?php echo sprintQtyInStock($product->qty_in_stock)?></span></div>-->
        <?php }?> 

      
    </div>
	
        <? if (count($product->extra_field) == 0) { ?>
        <!-- <div class="buttons but">
            <?php if ($product->buy_link){?>
                <a class="btn btn-success button_buy" href="<?php echo $product->buy_link?>">В корзину</a>
            <?php }?>
                
                <a class="btn btn-info button_detail" href="<?php echo $product->product_link?>">Узнать подробнее</a>
            <?php echo $product->_tmp_var_buttons;?>
        </div> -->
        <?php echo $product->_tmp_var_bottom_buttons;?>
<?}?>	
    <?php if ($this->count_product_to_row == 1) echo "</div>"; ?>
</div>
<?php echo $product->_tmp_var_end?>

