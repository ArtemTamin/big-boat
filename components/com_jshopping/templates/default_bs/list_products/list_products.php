<?php defined( '_JEXEC' ) or die(); ?>
<div class="jshop list_product">
<?php foreach ($this->rows as $k=>$product){?>
<?php if ($k%$this->count_product_to_row==0) echo "<div data='row' class='row-fluid list_product_row'>";?>
    <div class="block_product span<?php echo round(12/$this->count_product_to_row, 0)?>">
        <?php include(dirname(__FILE__)."/".$product->template_block_product);?>
    </div>
    <?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
    </div>
    <?php }?>
<?php }?>
<?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1) echo "</div>";?>
</div>