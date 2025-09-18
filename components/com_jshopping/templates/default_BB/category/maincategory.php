<?php defined( '_JEXEC' ) or die(); ?>
<?php if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) {?>    
<div class="jshop <?php print $this->params->get('pageclass_sfx');?> jshophead">
<h1><?php print $this->params->get('page_heading')?></h1>
<?php }?><?php echo $this->category->description?>

<div class="jshop_list_category">
<?php if (count($this->categories)){?>

<div class="jshop">
    <?php foreach($this->categories as $k=>$category){?>
        <?php if ($k%$this->count_category_to_row==0) echo '<div class="nvg_clear"></div><div class="row-fluid str_category">'; ?>
        <div class="span<?php echo round(12/$this->count_category_to_row, 0)?> jshop_categ">
          <div class="category">
            <div class="category_title"><a class = "product_link" href = "<?php echo $category->category_link?>"><?php echo $category->name?></a></div>
            <div class="image">
              <a href = "<?php echo $category->category_link;?>"><img class = "jshop_img" src = "<?php echo $this->image_category_path;?>/<?php if ($category->category_image) echo $category->category_image; else echo $this->noimage;?>" alt="<?php echo htmlspecialchars($category->name);?>" title="<?php echo htmlspecialchars($category->name);?>" /></a>
            </div>
              <p class = "category_short_description"><?php echo $category->short_description?></p>
           </div>
        </div>    
        <?php if ($k%$this->count_category_to_row==$this->count_category_to_row-1) echo '</div>'; ?>    
    <?php } ?>
        <?php if ($k%$this->count_category_to_row!=$this->count_category_to_row-1) echo '</div>'; ?>    
</div>


<?php } ?>
</div>
<script type="text/javascript">
  var hg = new Array();
  //вычисляю наибольшую высоту блока
  jQuery(".mainblock").each(function(){
    hg.push(parseInt(jQuery(this).css("height")));
  });
  //Делаю блоки одной высоты
  var max_hg = Math.max.apply(0, hg);
  jQuery(".mainblock").each(function(){
    jQuery(this).css("height", max_hg);
  });
    var hg2 = new Array();
  //вычисляю наибольшую высоту блока
  jQuery(".product_title").each(function(){
    hg2.push(parseInt(jQuery(this).css("height")));
  });
  //Делаю блоки одной высоты
  var max_hg2 = Math.max.apply(0, hg2);
  jQuery(".product_title").each(function(){
    jQuery(this).css("height", max_hg2);
  });
</script>