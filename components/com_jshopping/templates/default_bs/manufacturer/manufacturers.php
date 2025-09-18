<?php defined('_JEXEC') or die('Restricted access');?>
<?php if ($this->params->get('show_page_heading') && $this->params->get('page_heading')) : ?>    
    <div class="shophead<?php print $this->params->get('pageclass_sfx');?>"><h1><?php print $this->params->get('page_heading')?></h1></div>
<?php endif; ?>
<div class="jshop">
<?php print $this->manufacturer->description?>

<?php if (count($this->rows)) : ?>
<div class="jshop_list_manufacturer">
    <div class = "jshop">
        <?php foreach($this->rows as $k=>$row) : ?>
            <?php if ($k % $this->count_manufacturer_to_row == 0) : ?>
                <div class = "row-fluid">
            <?php endif; ?>
                <div class = "span<?php echo (($this->count_manufacturer_to_row > 0) ? 12 / $this->count_manufacturer_to_row : '1'); ?> jshop_categ manufacturer">
                    <div class = "image">
                        <a href = "<?php print $row->link;?>"><img class = "jshop_img" src = "<?php print $this->image_manufs_live_path;?>/<?php if ($row->manufacturer_logo) print $row->manufacturer_logo; else print $this->noimage;?>" alt="<?php print htmlspecialchars($row->name);?>" /></a>
                    </div>
                    <div>
                        <a class = "product_link" href = "<?php print $row->link?>"><?php print $row->name?></a>
                        <p class = "manufacturer_short_description"><?php print $row->short_description?></p>
                        <?php if ($row->manufacturer_url != "") : ?>
                            <div class="manufacturer_url">
                                <a target="_blank" href="<?php print $row->manufacturer_url?>"><?php print _JSHOP_MANUFACTURER_INFO?></a>
                            </div>
                        <?php endif; ?>
                    </div>                 
                </div>
            <?php if ($k % $this->count_manufacturer_to_row == $this->count_manufacturer_to_row - 1) : ?>
                </div>
            <?php endif; ?>
         <?php endforeach; ?>
         <?php if ($k % $this->count_manufacturer_to_row != $this->count_manufacturer_to_row - 1) : ?>
            <div class = "clearfix"></div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
</div>