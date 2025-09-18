<?php defined( '_JEXEC' ) or die(); ?>
<div data-product class="jshop list_product">
<?php foreach ($this->rows as $k=>$product){?>
<?php if ($k%$this->count_product_to_row==0) echo "<div data='row' class='row-fluid list_product_row'>";?>
   
        <?php include(dirname(__FILE__)."/".$product->template_block_product);?>

    <?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
    </div>
    <?php }?>
<?php }?>
<?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1) echo "</div>";?>
</div>