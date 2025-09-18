<?php
defined('_JEXEC') or die;

class modJshoppingCatprodHelper
{
	public static $products = null;

	public static function getCatsArray($params)
	{
		$category = JTable::getInstance('category', 'jshop');
		switch ($params->get('type_category')) {
			case 'all': {
					$category_parent = 0;
					break;
				}
			case 'root': {
					$category_parent = $params->get('root_category');
					break;
				}
			case 'current': {
					if (isset($_REQUEST['category_id'])) {
						$category_parent = $_REQUEST['category_id'];
					} else {
						$category_parent = 0;
					}
					break;
				}
		}

		if (!$params->get('exclude_category') || !in_array($category_parent, $params->get('exclude_category'))) {
			$category->category_parent_id = $category_parent;

			$categories = $category->getSisterCategories($params->get('field_sort'), $params->get('sort_ordering'));
			foreach ($categories as $key => $value) {
				if ($params->get('subcategory_show') == 1) {
					$value->subcategories = self::getSubcategories($value->category_id, $params);
				}
				if ($params->get('product_show') == 1) {
					$value->products = self::getProducts($value->category_id, $params);
				}
			}
			foreach ($categories as $k => $category) {
				if ($params->get('exclude_category') && in_array($category->category_id, $params->get('exclude_category'))) {
					unset($categories[$k]);
				}
			}
			$categories['categories'] = $categories;
			if ($params->get('root_product_show') == 1) {
				$categories['products'] = self::getProducts($category_parent, $params);
			}
		}
		return $categories;
	}

	public static function getSubcategories($category_id, $params)
	{
		$category = JTable::getInstance('category', 'jshop');
		$category->load($category_id);
		$subcategories = $category->getChildCategories($params->get('field_sort'), $params->get('sort_ordering'));
		if (count($subcategories)) {
			foreach ($subcategories as $category) {
				if ($params->get('subcategory_show') == 1) {
					$category->subcategories = self::getSubcategories($category->category_id, $params);
				}
				if ($params->get('product_show') == 1) {
					$category->products = self::getProducts($category->category_id, $params);
				}
			}
		}
		foreach ($subcategories as $k => $subcategory) {
			if ($params->get('exclude_category') && in_array($subcategory->category_id, $params->get('exclude_category'))) {
				unset($subcategories[$k]);
			}
		}
		return $subcategories;
	}

	public static function getProducts($category_id = 0, $params)
	{
		$product = JTable::getInstance('product', 'jshop');
		$rows = array();
		$filters = array();
		$filters['categorys'] = array($category_id);
		$rows = $product->getAllProducts($filters, $params->get('field_sort_products'), $params->get('sort_ordering_products'), 0, $params->get('count_products'));

		if ($params->get('enable_addon') == 1) {
			JPluginHelper::importPlugin('jshoppingproducts');
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger('onBeforeDisplayProductList', array(&$rows));
			$view = new stdClass();
			$view->rows = $rows;
			$productlist = JSFactory::getModel('productList', 'jshop');
			$productlist->setModel($product);
			$productlist->load();
			$dispatcher->trigger('onBeforeDisplayProductListView', array(&$view, &$productlist));
			$rows = $view->rows;
		}

		return $rows;
	}

	public static function subCategoriesTemplate($categories, $params)
	{
		foreach ($categories as $id) {
?>
			<div class="subcategory <?php echo $params->get('subcategory_class_sfx'); ?>">
				<div class="subcategory-title">
					<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id=' . $id->category_id, 1); ?>"><?php echo $id->name; ?></a>
				</div>
				<div class="subcategory-content">
					<?php if ($params->get('subcategory_show_image') == 1) { ?>
						<?php if ($id->category_image != '') { ?>
							<div class="image"><img src="components/com_jshopping/files/img_categories/<?php echo $id->category_image; ?>" /></div>
						<?php } else { ?>
							<div class="image"><img src="components/com_jshopping/files/img_categories/noimage.gif" /></div>
						<?php } ?>
					<?php } ?>
					<?php if ($params->get('subcategory_show_short_desc') == 1 && $id->short_description != '') { ?>
						<div class="short-description"><?php echo $id->short_description; ?></div>
					<?php } ?>
					<?php if ($params->get('subcategory_show_desc') == 1 && $id->description != '') { ?>
						<div class="description"><?php echo $id->description; ?></div>
					<?php } ?>
					<div class="clear"></div>
					<?php if ($params->get('subcategory_show') == 1 && count($id->subcategories)) { ?>
						<div class="subcategories">
							<?php self::subCategoriesTemplate($id->subcategories, $params); ?>
						</div>
					<?php } ?>
					<?php if ($params->get('product_show') == 1 && count($id->products)) { ?>
						<div class="products">
							<?php self::productsTemplate($id->products, $params); ?>
							<div class="clear"></div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php
		}
	}

	public static function productsTemplate($products, $params)
	{
		foreach (array_slice($products, 0, 4) as $product) {
		?>
			<div mod-cartpod class="span3 <?php echo $params->get('products_class_sfx'); ?>" >
				<div class="cart">

					<?php if ($params->get('product_show_image') == 1) { ?>
						<?php echo $product->_tmp_var_image_block; ?>

						<?php if ($product->product_thumb_image != '') { ?>
							<div class="image cart__image">
							<?php if ($product->label_id){?>
								<div class="product_label hits-label">
									<?php if ($product->_label_image){?>
										<a href="<?php echo $product->product_link?>"> 
										<img class="jshop_img" src="<?php echo $product->_label_image?>" alt="<?php echo htmlspecialchars($product->_label_name)?>" />
									</a>
									<?php }else{?>
										<span class="label_name jshop_img"><?php echo $product->_label_name;?></span>
									<?php }?>
								</div>
							<?php }?>
									<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $product->category_id . '&product_id=' . $product->product_id, 1); ?>">
										<img class="jshop_img" src="components/com_jshopping/files/img_products/<?php echo $product->product_thumb_image; ?>" />
									</a>
								
							</div>
						<?php } else { ?>
							<div class="image cart__image">
								
									<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $product->category_id . '&product_id=' . $product->product_id, 1); ?>">
										<img class="jshop_img" src="components/com_jshopping/files/img_products/noimage.gif" />
									</a>
							
							</div>
						<?php } ?>

						<?php echo $product->_tmp_var_bottom_foto; ?>
					<?php } ?>

					<div class="mainblock cart__description">
						<!-- звезды -->
						<div class="cart__star">
							<?php echo showMarkStar($product->average_rating); ?>
						</div>

						<div class="cart__name">
							
								<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $product->category_id . '&product_id=' . $product->product_id, 1); ?>"><?php echo $product->name; ?></a><?php if ($params->get('product_show_ean') == 1) {
																																																																		echo ' / <span class="ean">' . $product->product_ean . '</span>';
																																																																	} ?>
							
																																																																</div>

						<div class="cart__content">
							<?php if ($params->get('product_show_short_desc') == 1 && $product->short_description != '') { ?>
								<div class="short-description"><?php echo $product->short_description; ?></div>
							<?php } ?>
						</div>

						<div class="cart__price">								
								<?php if ($product->product_old_price > 0){?>
									<span style="text-decoration: line-through;margin-right:15px;"><?php echo formatprice($product->product_old_price)?></span>
								<?}?>
								<span <?if ($product->product_old_price > 0){?>style="color:red"<?}?>><?php echo formatprice($product->product_price); ?></span>
						</div>

						<div <? if (count($product->extra_field) > 0) { ?> class="cart__hide" <? }else{?> style="display: none" <?}?>>
							<?php if (is_array($product->extra_field)) { ?>
								<ul class="unstyled extra_fields">
									<?php foreach ($product->extra_field as $extra_field) { ?>
										<li>
											<span style="color: #fff" class="text-right extra_fields_name"><?php echo $extra_field['name']; ?>:</span>
											<span style="color: #fff" class="text-left extra_fields_value">&nbsp;&nbsp;<?php echo $extra_field['value']; ?></span>
										</li>
									<?php } ?>
								</ul>
							<?php } ?>
							<?php if ($params->get('product_show_button_buy') == 1 || $params->get('product_show_button_readmore') == 1) { ?>
								<?php echo $product->_tmp_var_top_buttons; ?>

								<?php echo $product->_tmp_var_bottom_price; ?>
				
						<?php echo $product->_tmp_var_bottom_buttons; ?>
						</div>

					</div>
					<div class="buttons but cart__buy">
							<!-- <?/*php if ($product->buy_link) { -*/?>
								<div class="cart__button button">
									<a class="btn btn-success button_buy" href="<?php echo $product->buy_link ?>">В корзину
									</a>
								</div>
							<?/*php } */?> -->

							<div class="cart__button-hits button">
								<a class="btn btn-info button_detail" href="<?php echo $product->product_link ?>">Узнать подробнее
								</a>
							</div>
							<?php echo $product->_tmp_var_buttons; ?>
						</div>
					<? if (count($product->extra_field) == 0) { ?>
						<?php echo $product->_tmp_var_bottom_price; ?>
						<div class="buttons">
							<?php if ($product->buy_link) { ?>
								<a class="btn btn-success button_buy" href="<?php echo $product->buy_link ?>">В корзину</a>
							<?php } ?>

							<a class="btn btn-info button_detail" href="<?php echo $product->product_link ?>">Узнать подробнее</a>
							<?php echo $product->_tmp_var_buttons; ?>
						</div>
						<?php echo $product->_tmp_var_bottom_buttons; ?>
					<?}?>	

				<?php } ?>
				</div>
			</div>
<?php
		}
	}
}
?>