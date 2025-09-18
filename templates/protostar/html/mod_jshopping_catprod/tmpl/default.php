<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument ();
if ($params->get('add_css') == 1) {
	$doc->addStyleSheet('modules/mod_jshopping_catprod/assets/css/style.css');
}
if ($params->get('accordion') == 1) {
	$doc->addScript('modules/mod_jshopping_catprod/assets/js/script.js');
	$style = '
		.mod_jshopping_catprod.accordion .category .category-content,
		.mod_jshopping_catprod.accordion .subcategory .subcategory-content {
			display: none;
		}
	';
	$doc->addStyleDeclaration($style);
}
?>

<div class="mod_jshopping_catprod <?php echo $params->get('moduleclass_sfx'); ?> <?php if ($params->get('accordion') == 1) { echo 'accordion'; } ?>">
	<div class="list_category">
	<?php if (count($list)) { ?>
		<?php if ($params->get('root_product_show') == 1 && count($list['products'])) { ?>
			<div class="products">
				<?php modJshoppingCatprodHelper::productsTemplate($list['products'], $params); ?>
				<div class="clear"></div>
			</div>
		<?php } ?>
		<?php if (count($list['categories'])) { ?>
			<?php foreach($list['categories'] as $id) { ?>
				<div class="category <?php echo $params->get('category_class_sfx'); ?>">
					<div class="category-title">
						<a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id=' . $id->category_id, 1); ?>"><?php echo $id->name; ?></a>
					</div>
					<div data class="category-content">
						<?php if ($params->get('category_show_image') == 1) { ?>
							<?php if ($id->category_image != '') { ?>
								<div class="image"><img src="components/com_jshopping/files/img_categories/<?php echo $id->category_image; ?>" /></div>
							<?php } else { ?>
								<div class="image"><img src="components/com_jshopping/files/img_categories/noimage.gif" /></div>
							<?php } ?>
						<?php } ?>
						<?php if ($params->get('category_show_short_desc') == 1 && $id->short_description != '') { ?>
							<div class="short-description"><?php echo $id->short_description; ?></div>
						<?php } ?>
						<?php if ($params->get('category_show_desc') == 1 && $id->description != '') { ?>
							<div class="description"><?php echo $id->description; ?></div>
						<?php } ?>
						
						<?php if ($params->get('subcategory_show') == 1 && count($id->subcategories)) { ?>
							<div class="subcategories">
								<?php modJshoppingCatprodHelper::subCategoriesTemplate($id->subcategories, $params); ?>
							</div>
						<?php } ?>
						<?php if ($params->get('product_show') == 1 && count($id->products)) { ?>
							<div data2 class="products" style="display: flex; flex-wrap: wrap;">
								<?php modJshoppingCatprodHelper::productsTemplate($id->products, $params); ?>
								
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>
		<div class="notlist"><?php echo JText::_('MOD_JSHOPPING_CATPROD_NOT_LIST'); ?></div>
	<?php } ?>
	</div>
</div>