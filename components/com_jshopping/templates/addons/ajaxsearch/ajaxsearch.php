<table class="ajaxsearch">
<?php foreach($this->rows as $p){?>
<tr class="itemsearch">
	<td class="aj_img"><a class="itemlink" href="<?php echo $p->product_link?>"><span class="img-block"><img src="<?php echo $p->image;?>" height="28px"></span></a></td>
	<td class="aj_det">
		<a class="itemlink" href="<?php echo $p->product_link?>">
			<span class="detailsearch">
				<span class="titlesearch"><?php echo $p->name;?></span><br/>
				<?php $display_price = getDisplayPriceForProduct($p->product_price);
					if($display_price){?>
					<span class="pricesearch">
						<?php if($p->show_price_from) print _JSHOP_FROM." ";?>
						<?php echo formatprice($p->product_price);?>
					</span>
				<?php }?>
			</span>
		</a>
	</td>
</tr>
<?php }?>
<?php if(isset($this->moreResults) && $this->moreResults == 1):?>
<tr>
	<td colspan="2" style="text-align:center;">
		<a href="<?php echo $this->moreResultsLink;?>" class="ajax-search-more-results"><?php echo JText::_('SHOW_MORE_RESULTS');?></a>
	</td>
</tr>
<?php endif;?>
</table>