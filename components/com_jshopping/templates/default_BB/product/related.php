<?php defined( '_JEXEC' ) or die(); ?>
<?php $in_row = $this->config->product_count_related_in_row;?>
<?php if (count($this->related_prod)){?>    
    <h2 style="text-align: left; width: 100%">Дополнительное оборудование</h2>
	<div class="jshop_list_product">
		
        <div class="row-fluid jshop list_related">
            <?php foreach($this->related_prod as $k=>$product){?>  
                <?php if ($k%$in_row==0) echo '';?>
                <div class="block_product span<?php echo round(12/$in_row); ?>">
                    <?php include(dirname(__FILE__)."/../".$this->folder_list_products."/".$product->template_block_product);?>
                </div>
                <?php if ($k%$in_row==$in_row-1) echo "";?>   
            <?php }?>
            <?php if ($k%$in_row!=$in_row-1) echo "";?>
        </div>
    </div> 
<?php }?>