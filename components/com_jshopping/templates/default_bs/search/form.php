<?php defined( '_JEXEC' ) or die(); ?>
<script type="text/javascript">var liveurl = '<?php echo JURI::root()?>';</script>
<div class="jshop">
    <h1><?php echo  _JSHOP_SEARCH ?></h1>
    
    <form class="form-horizontal" action="<?php echo $this->action?>" name="form_ad_search" method="post" onsubmit="return validateFormAdvancedSearch('form_ad_search')">
    
    
    <input type="hidden" name="setsearchdata" value="1">
    <div class = "js_search_gen">
      <?php print $this->_tmp_ext_search_html_start;?>  
      <div class="control-group">
  	    
        
        <div class="control-label">
  		    <?php echo  _JSHOP_SEARCH_TEXT?>
           </div>
           
        <div class="controls">
        
          <input type = "text" name = "search" style = "width:300px" />
        
      </div>
      
      </div>
	  
      
      
      <div class="control-group">
         <div class="control-label">
              <?php echo  _JSHOP_SEARCH_FOR?>
        </div>
         <div class="controls">
          <input type="radio" name="search_type" value="any" id="search_type_any" checked="checked" /> <label class="radio inline radiootstup" for="search_type_any"><?php echo _JSHOP_ANY_WORDS?></label>
          <input type="radio" name="search_type" value="all" id="search_type_all" /> <label class="radio inline radiootstup" for="search_type_all"><?php echo _JSHOP_ALL_WORDS?></label>
          <input type="radio" name="search_type" value="exact" id="search_type_exact" /> <label class="radio inline radiootstup" for="search_type_exact"><?php echo _JSHOP_EXACT_WORDS?></label>
        </div>
      </div>
	  
      <div class="control-group">
        <div class="control-label">
          <?php echo _JSHOP_SEARCH_CATEGORIES?>
        </div>
         <div class="controls">
          <?php echo $this->list_categories ?><br />
          <input type = "checkbox" name = "include_subcat" id = "include_subcat" value = "1" />
          <label class="checkbox inline radiootstup" for = "include_subcat"><?php echo _JSHOP_SEARCH_INCLUDE_SUBCAT?></label>
        </div>
      </div>
	  
      <div class="control-group">
       <div class="control-label"> <?php echo _JSHOP_SEARCH_MANUFACTURERS?> </div>
        <div class="controls"><?php echo $this->list_manufacturers ?> </div>
      </div>
	  
      <?php if (getDisplayPriceShop()){?>
      <div class="control-group">
      <div class="control-label"> <?php echo _JSHOP_SEARCH_COINS?> </div>
      
      <div class="controls ">
        
         <div class="row-fluid">
        
        
        
        <div class="span6">
        <span class="input-prepend input-append">
		<span class="add-on"><?php echo _JSHOP_SEARCH_PRICE_FROM?>   </span>
       <input  type = "text" class="span6"  name = "price_from" id = "price_from" /> <span class="add-on"><?php echo $this->config->currency_code?></span>
       </span>
       </div>
       
       <div class="span6">
       <span class="input-prepend input-append">
       &nbsp;&nbsp;<span class="add-on"><?php echo _JSHOP_SEARCH_PRICE_TO?></span>
        <input  type = "text" class="span6" name = "price_to" id = "price_to" /> <span class="add-on"><?php echo $this->config->currency_code?></span>
       </span>
       </div>
       </div>
       
        </div>
      </div>
      <?php }?>
      
      <div class="control-group">
       <div class="control-label"> <?php echo _JSHOP_SEARCH_DATE?> </div>
       
        <div class="controls">
          <div class="row-fluid">
        <div class="span6">
        
        <span class="input-prepend">
			<span class="add-on"><?php echo _JSHOP_SEARCH_DATE_FROM ?> </span>      
			<span><?php echo JHTML::_('calendar','', 'date_from', 'date_from', '%Y-%m-%d', array('class'=>'span6', 'size'=>'14', 'maxlength'=>'19')); ?></span>
            
            </span>
            </div>
            
            
            <div class="span6">
            <span class="input-prepend">
			<span class="add-on"><?php echo _JSHOP_SEARCH_DATE_TO ?></span>
			<span><?php echo JHTML::_('calendar','', 'date_to', 'date_to', '%Y-%m-%d', array('class'=>'span6', 'size'=>'14', 'maxlength'=>'19')); ?></span>
            </span>
            </div>
            </div>
            
        </div>
     </div>
      <div>
        <div id="list_characteristics"><?php echo $this->characteristics?></div>
      </div>
      <?php echo $this->_tmp_ext_search_html_end;?>
    </div>
	<div class="clear"></div>
    <div class="nvg_padd">
    <input type = "submit" class="btn" value = "<?php echo _JSHOP_SEARCH ?>" />  
    </div>
    </form>
</div>