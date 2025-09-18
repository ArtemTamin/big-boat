<?php defined( '_JEXEC' ) or die(); ?>

<div class="jshop">

 <div class="container-fluid" style="padding: 2%; ">
  <div class="row-fluid">
  <div class="span12" >
  
  <h1 style="margin-bottom:15px;"><?php echo _JSHOP_LOGIN ?></h1>
  
  <?php if ($this->config->shop_user_guest && $this->show_pay_without_reg) {?>
  
  <span class="text_pay_without_reg"><?php echo _JSHOP_ORDER_WITHOUT_REGISTER_CLICK ?> <a href="<?php print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',1,0, $this->config->use_ssl);?>"><?php echo _JSHOP_HERE ?></a></span>
  <?php } ?> 
  
  <div class="row-fluid">
   <div class="span6">
  
   
      <form class="form" method = "post" action = "<?php print SEFLink('index.php?option=com_jshopping&controller=user&task=loginsave', 0,0, $this->config->use_ssl)?>" name = "jlogin">
      
     
				<h3><u>
                
                <?php print _JSHOP_HAVE_ACCOUNT ?>
				</u></h3> <br />
        
        <div class="control-group">
          
         <!-- <label class="control-label" for="<?php print _JSHOP_USERNAME ?>"><?php print _JSHOP_USERNAME ?>  </label> -->
          
          <div class="controls input-prepend" >
            <span class="add-on"><i class="icon-user"></i></span><input type = "text" placeholder="<?php echo _JSHOP_USERNAME ?>" name = "username" class="span8" />
          </div>
        </div>
        
        <div class="control-group">
         <!-- <label class="control-label" for="<?php print _JSHOP_PASSWORT ?>"><?php print _JSHOP_PASSWORT ?>  </label> -->
          <div class="controls input-prepend" >
           <span class="add-on"><i class="icon-lock"></i></span><input type = "password" placeholder="<?php echo _JSHOP_PASSWORT ?>" name = "passwd" value = "" class="span8" />
          </div>
        </div>
        
        
        <div class="control-group">
          <div class="controls">
            <label class="checkbox" for="remember_me"><?php echo _JSHOP_REMEMBER_ME ?>
              <input type="checkbox" name="remember" id="remember_me" value="yes"   />
            </label>
            
            <input type="submit" class="btn" value="<?php echo _JSHOP_LOGIN ?>" />
            
            <br />
             <a href = "<?php print $this->href_lost_pass ?>"><?php echo _JSHOP_LOST_PASSWORD ?></a>
             
            <input type = "hidden" name = "return" value = "<?php print $this->return ?>" />
            <?php echo JHtml::_('form.token');?>
           
             </div>
        </div>
        
            
   
            
                    
        
      </form>
  
    
  </div>

  
 
  
   <div class="span6">
    
    
    
    <h3><u><?php echo _JSHOP_HAVE_NOT_ACCOUNT ?>? <?php echo _JSHOP_REGISTER ?></u></h3>

      <?php if (!$this->config->show_registerform_in_logintemplate){?>
      
        <input type="button" class="btn" value="<?php echo _JSHOP_REGISTRATION ?>" onclick="location.href='<?php print $this->href_register ?>';" />
      
      <?php }else{?>
      <?php $hideheaderh1 = 1; include(dirname(__FILE__)."/register.php"); ?>
      <?php }?>
    
  
   </div>
 </div>
 </div>
 </div>
 </div>
 
</div>
