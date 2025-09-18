<?php defined( '_JEXEC' ) or die(); ?>
<div class="jshop">
   <?php if ($this->params->get('show_page_title') && $this->params->get('page_title')) {?>    
   <div class="componentheading<?php echo $this->params->get('pageclass_sfx');?>">
      <?php echo $this->params->get('page_title')?>
   </div>
   <?php }?>

   <?php if (count($this->rows)){?>
   <div class="jshop_list_manufacturer">
      <div class="row-fluid jshop">
         <?php foreach($this->rows as $k=>$row){?>
            <?php //if ($k%$this->count_to_row==0) echo '<div class="clear">';?>
            <div class="span<?php echo (12/$this->count_to_row)?> jshop_categ">
               <div class="image">
                  <a class = "product_link" href="<?php echo $row->link?>">
                     <img class="jshop_img" src="<?php echo $row->logo;?>" alt="<?php echo htmlspecialchars($row->shop_name);?>" />
                  </a>                    
               </div>
               <div class="jshop_vendor_name">
                  <a class="product_link" href = "<?php echo $row->link?>"><?php echo $row->shop_name?></a><br />                   
               </div>
            </div>    
         <?php //if ($k%$this->count_to_row==$this->count_to_row-1) echo "</div>";?>
         <?php } ?>
         <?php //if ($k%$this->count_to_row!=$this->count_to_row-1) echo "</div>";?>
      </div>

      <?php if ($this->display_pagination){?>
      <div class="jshop_pagination">
         <div class="pagination"><?php echo $this->pagination?></div>
      </div>
      <?php }?>
   </div>
   <?php } ?>
</div>