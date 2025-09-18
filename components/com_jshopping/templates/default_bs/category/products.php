<?php defined( '_JEXEC' ) or die(); ?>
<?php if ($this->display_list_products){?>

<div class="jshop_list_product"> 
<?
		$url = $_SERVER['REQUEST_URI'];
		$url__filter = "dingh/";
		if(strpos($url, $url__filter)){
		?>	
<div class="left-column">
	
	{module Extended}
	</div>
	<?}?>
<div class="right-column <?if(strpos($url, $url__filter)){?>filter__column <?}?>">	   
<?php
	
		
	
    include(dirname(__FILE__)."/../".$this->template_block_form_filter);
	
    if (count($this->rows)){
        include(dirname(__FILE__)."/../".$this->template_block_list_product);
    }
    if ($this->display_pagination){
        include(dirname(__FILE__)."/../".$this->template_block_pagination);
    }
?>
<div class="div_show_more">
	<a id="show_more" class="show-more">Показать еще</a>
</div>

</div>
</div>
<?php }?>