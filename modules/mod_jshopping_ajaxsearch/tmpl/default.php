<?php
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
$homepage = FALSE;
if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
	$homepage = TRUE;
}
?>

<div class="jshop_ajaxsearch">
	<form name="searchForm" method="post" action="<?php print SEFLink("index.php?option=com_jshopping&controller=search&task=result", 1);?>" onsubmit="return isEmptyValue(jQuery('#jshop_search').val());" autocomplete="off">
		<input type="hidden" name="setsearchdata" value="1"/>
		<input type="hidden" name="search_type" value="<?php print $params->get('searchtype');?>"/>
		<input type="hidden" name="category_id" id="ajaxcategory_id" value="<?php print $category_id?>"/>
		<input type="hidden" name="include_subcat" value="<?php print $include_subcat?>"/>
		<input type="text" class="inputbox" onkeyup="ajaxSearch();" onfocus="ajaxSearch();" name="search" id="jshop_search" placeholder="Поиск по сайту" value="<?php print htmlspecialchars($search, ENT_QUOTES)?>"/>
		<?php if($show_cat_filer):?>
			<?php echo JHTML::_('select.genericlist', $categories_select, 'acategory_id', 'class = "inputbox"', 'category_id', 'name', $category_id, 'show_categories_filter');?>
		<?php endif;?>
		<input class="button" type="submit" value="<?php print _JSHOP_GO?>"/>
		<?php if($adv_search){?>
			<br/><a href="<?php print $adv_search_link?>"><?php print _JSHOP_ADVANCED_SEARCH?></a>
		<?php }?>
	</form>
	<div id="search-result"></div>
</div>

<script type="text/javascript">
	var ajaxlink = "<?php print SEFLink("index.php?option=com_jshopping&controller=ajaxsearch&ajax=1", 1, 1);?>";
	var displaycount = "<?php print $params->get('displaycount');?>";
	var searchtype = "<?php print $params->get('searchtype');?>";
	var include_subcat = "<?php print $include_subcat; ?>";
</script>

<!--Sitelinks Search Box-->
<?php if ($homepage && $params->get('sitelinks')) { ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "url": "<?php print JUri::base(); ?>",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "<?php print JUri::base(); ?>index.php?option=com_jshopping&controller=search&task=result&setsearchdata=1&search_type=<?php print $params->get('searchtype'); ?>&category_id=<?php print $category_id; ?>&include_subcat=<?php print $include_subcat; ?>&search={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<?php } ?>