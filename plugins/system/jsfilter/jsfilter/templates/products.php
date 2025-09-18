<?php defined('_JEXEC') or die(); ?>
<?php

	$filterLang = JFactory::getLanguage();
	$filterLang->load("mod_jshopping_extended_filter");
	
	require_once (JPATH_SITE.DS.'modules'.DS.'mod_jshopping_extended_filter'.DS.'helper.php');
	$moduleId = JRequest::getVar("moduleId");
	$moduleParams = modJShopExtendedFilterHelper::getModuleParams($moduleId);

?>

<script type="text/javascript">

	function change_ordering_dir() {
		var dir = 0;
		var module_dir = jQuery("#ExtendedFilterContainer<?php echo $moduleId; ?> input[name=orderto]").val();
		if(module_dir != '') {
			if(module_dir == 0) {
				dir = 1;
			}
			else {
				die = 0;
			}
		}
		else {
			base_dir = <?php echo $this->config->product_sorting_direction; ?>;
			if(base_dir == 0) {
				dir = 1;
			}
			else {
				dir = 0;
			}
		}
		jQuery("#ExtendedFilterContainer<?php echo $moduleId; ?> input[name=orderto]").val(dir)
		submit_form_<?php echo $moduleId; ?>();		
	}

</script>

<div class="jshop">
	<p>&nbsp;</p>

	<?php if ($this->header) : ?>
	<h1 class="listproduct<?php echo $this->prefix; ?>">
		<?php echo $this->header; ?>
	</h1>
	<?php endif; ?>

	<?php if (count($this->results)) : ?>
		
		<div class="results_text" style="float: left;">
			<p><?php echo $moduleParams->search_results_text; ?> (<?php echo $this->results_total; ?>) :</p>
		</div>
		
		<?php if ($this->config->show_sort_product || $this->config->show_count_select_products){?>
					
			<div class="block_sorting_count_to_page" style="float: right;">
				<?php if ($this->config->show_sort_product){?>
					<span class="box_products_sorting">
						<?php print _JSHOP_ORDER_BY.": ".$this->order_select; ?>
						<img src="<?php print $this->order_to_img; ?>" alt="orderby" style="cursor: pointer;" onclick="change_ordering_dir();" />
					</span>
				<?php }?>
				<?php if ($this->config->show_count_select_products){?>
					<span class="box_products_count_to_page">
						<?php print _JSHOP_DISPLAY_NUMBER.": ".$this->limit_select; ?>
					</span>
				<?php }?>
			</div>
		
		<?php }?>
		
		<div class="clear"></div>
	
		<div class="jshop_list_product">
		<?php

			include(dirname(__FILE__)."/list_products.php");
			
			if ($this->pagenav) {
				include(dirname(__FILE__)."/block_pagination.php");
			}
			
		?>
		</div>

	<?php else : ?>
		
		<p><?php echo $moduleParams->text_no_results; ?></p>
	
	<?php endif; ?>

</div>