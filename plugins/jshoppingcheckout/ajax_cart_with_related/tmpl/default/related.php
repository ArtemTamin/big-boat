<?php

defined('_JEXEC') or die;
$in_row = $this->config->product_count_related_in_row;
if (!count($products_related)) {
	return;
}
?>
<h2 class="relatedincartheader"><?php echo JText::_('MOD_JSHOPPING_AJAX_CART_WITH_RELATED_MAYBE_NEED') ?></h2>
<div class="cart_related_general_list js-grid">
	<?php foreach ($products_related as $category_id=>$products_category) { ?>
		<div class="js-width-1-2">
		<h3>
			<?php if ($params->link_category) { ?>
			<a class="js_car_category_link" href="<?php echo SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$category_id, 1) ?>">
			<?php } ?>
			<?php echo $all_categorys[$category_id]->name ?>
			<?php if ($params->link_category) { ?>
			</a>
			<?php } ?>
		</h3>
		<div class="category_bloсk">
			<?php foreach ($products_category as $product) { ?>
			
				<div class="cart_related_product_wrapper row">

					<a href="<?php echo $product->product_link?>">
						<img class="jshop_img" src="<?php echo $product->image?>" alt="<?php echo htmlspecialchars($product->name);?>" />
					</a>
					<div class="name-price-wrapper">
						<div class="cart_related_product_name">
							<a class="js-normal" href="<?php echo $product->product_link ?> "><?php echo $product->name ?></a>
						</div>
						<div class="cart_related_product_price">
							<?php echo formatprice($product->product_price) ?></a>
						</div>
					</div>
					<div class="cart_related_product_link buttons">
					<form name="product" method="post" action="/component/jshopping/cart/add?Itemid=0" enctype="multipart/form-data" autocomplete="off">
						<input type="submit" class="buy btn btn-primary" value="Купить" onclick="jQuery('#to<?php echo $product->product_id?>').val('cart');"/>
						<input type="hidden" name="to" id='to<?php echo $product->product_id?>' value="cart" />
						<input type="hidden" name="product_id" id="product_id" value="<?php echo $product->product_id?>" />
						<input type="hidden" name="category_id" id="category_id" value="<?php echo $product->category_id?>" />
					</form>
					</div>
				</div>
			<?php } ?>
		</div>
		</div>
	<?php } ?>
</div>
<hr>
<style>
	.js-width-1-2 {
		width: 100%;
		margin: 0;
	}

	.category_bloсk {
		display: flex;
		flex-direction: row;
    	flex-wrap: wrap;
    	justify-content: flex-start;
	}

	.cart_related_product_wrapper {
		width: 19%;
		display: flex;
		flex-direction: column;
		align-items: center;
		border-bottom: 0px !important;
		margin-bottom: 10px;
		margin-left: 10px;

	}

	.cart_related_product_price {
		font-size: 12px;
	}
	.name-price-wrapper {
		width: 100%;
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		flex-grow: 1;
	}

	.cart_related_product_link {
		width: 100%;
	}

	.cart_related_product_link .btn {
		width: 100%;
		padding-bottom: 10px !important;
		padding-top: 10px !important;
	}

	.js-normal {
		font-size: 12px;
	}

	.cart_related_product_wrapper .jshop_img {
		transition: 0.4s;
	}

	.cart_related_product_wrapper .jshop_img:hover {
		transform: scale(1.05);
	}


	@media (max-width: 950px) {
		.cart_related_product_wrapper {
			width:24%;
		}

		.js-normal {
			font-size: 10px;
		}

		.cart_related_product_price {
			font-size: 10px;
		}
	}

	@media (max-width: 768px) {
		.cart_related_product_wrapper {
			width:30%;
		}
	}

	@media (max-width: 650px) {
		.cart_related_product_wrapper {
			width:47%;
		}
	}

	@media (max-width: 375px) {
		.cart_related_product_wrapper {
			width:98%;
		}
	}
</style>