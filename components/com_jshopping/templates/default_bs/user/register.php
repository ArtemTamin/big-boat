<?php defined( '_JEXEC' ) or die(); ?>
<?php 
$config_fields=$this->config_fields;
include(dirname(__FILE__)."/register.js.php");
?>
<div class="jshop row-fluid">
<div class="span12">
    <?php if (!$hideheaderh1){?>
    <h1><?php echo _JSHOP_REGISTRATION; ?></h1>
    <?php } ?>
    
    <form class="form" action="<?php print SEFLink('index.php?option=com_jshopping&controller=user&task=registersave',1,0, $this->config->use_ssl)?>" method="post" name="loginForm" onsubmit="return validateRegistrationForm('<?php print $this->urlcheckdata ?>', this.name)" autocomplete="off">
    <?php echo $this->_tmpl_register_html_1?>
    <div data-test class="jshop_register user_info">
	
	<fieldset>
	
    	<?php if ($config_fields['title']['display']){?>
		<div class="control-group">
			<label class="control-label">
				<?php echo _JSHOP_REG_TITLE; ?><?php if ($config_fields['title']['require']){?><span>*</span><?php } ?>
			</label>
            <div class="controls controls-row">
			<span class="span10">
				<?php print $this->select_titles ?>
			</span>
            </div>
		</div>
	  	<?php } ?>
	  
    	<?php if ($config_fields['f_name']['display']){?>
		<div class="control-group">
			<label class="control-label">
				<?php echo _JSHOP_F_NAME; ?> <?php if ($config_fields['f_name']['require']){?><span>*</span><?php } ?>
			</label>
			
            <div class="controls">
				<input type="text" name="f_name" id="f_name" value="" class="span10" />
			</div>
		</div>
	  	<?php } ?>	  
	  
    	<?php if ($config_fields['l_name']['display']){?>
		<div class="control-group">
			<label class="control-label">
				<?php echo _JSHOP_L_NAME; ?> <?php if ($config_fields['l_name']['require']){?><span>*</span><?php } ?>
			</label>
			<div class="controls">
				<input type="text" name="l_name" id="l_name" value="" class="span10" />
			</div>
		</div>
	  	<?php } ?>		  
		
		<?php if ($config_fields['m_name']['display']){?>
        <div class="control-group">
			<label class="control-label">
				<?php print _JSHOP_M_NAME ?> <?php if ($config_fields['m_name']['require']){?><span>*</span><?php } ?>
			</label>
			<div class="controls">
				<input type = "text" name = "m_name" id = "m_name" value = "" class="span10" />
			</div>
		</div>
        <?php } ?>
		
        <?php if ($config_fields['firma_name']['display']){?>
		  <div class="control-group">
			<label class="control-label">
            	<?php echo _JSHOP_FIRMA_NAME;  ?> <?php if ($config_fields['firma_name']['require']){?><span>*</span><?php } ?>
			</label>
			<div class="controls">
            	<input type="text" name="firma_name" id="firma_name" value="" class="span10" />
			</div>
		</div>
        <?php } ?>

        <?php if ($config_fields['client_type']['display']){?>
		 <div class="control-group">
			<label class="control-label">
            	<?php echo _JSHOP_CLIENT_TYPE; ?> <?php if ($config_fields['client_type']['require']){?><span>*</span><?php } ?>
			</label>
			<div class="controls controls-row">
            	<span style="span10"><?php print $this->select_client_types;?></span>
			</div>
		</div>
        <?php } ?>
		
        <?php if ($config_fields['firma_code']['display']){?>
        <div class="control-group" id='tr_field_firma_code' <?php if ($config_fields['client_type']['display']){?>style="display:none;"<?php }?>>
        	<label class="control-label">
            	<?php echo _JSHOP_FIRMA_CODE; ?> <?php if ($config_fields['firma_code']['require']){?><span>*</span><?php } ?>
        	</label>
        	<div class="controls">
            	<input type="text" name="firma_code" id="firma_code" value="" class="span10" />
        	</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['tax_number']['display']){?>
        <div class="control-group" id='tr_field_tax_number' <?php if ($config_fields['client_type']['display']){?>style="display:none;"<?php }?>>
        	<label class="control-label">
            	<?php echo _JSHOP_VAT_NUMBER; ?> <?php if ($config_fields['tax_number']['require']){?><span>*</span><?php } ?>
        	</label>
        	<div class="controls">
            	<input type="text" name="tax_number" id="tax_number" value="" class="span10" />
        	</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['email']['display']){?>
        <div class="control-group">
        	<label class="control-label">
            	<?php echo _JSHOP_EMAIL; ?> <?php if ($config_fields['email']['require']){?><span>*</span><?php } ?>
        	</label>
          	<div class="controls">
            	<input type="text" name="email" id="email" value="" class="span10" />
          	</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['email2']['display']){?>
        <div class="control-group">
          <label class="control-label">
            <?php echo _JSHOP_EMAIL2; ?> <?php if ($config_fields['email2']['require']){?><span>*</span><?php } ?>
          </label>
          <div class="controls">
            <input type="text" name="email2" id="email2" value="" class="span10" />
          </div>
        </div>
        <?php } ?>
		
		<?php if ($config_fields['birthday']['display']){?>
        <div class="control-group">
			<label class="control-label">
				<?php print _JSHOP_BIRTHDAY?> <?php if ($config_fields['birthday']['require']){?><span>*</span><?php } ?>
			</label>
			<div class="controls">           
				<?php echo JHTML::_('calendar', '', 'birthday', 'birthday', $this->config->field_birthday_format, array('class'=>'span10', 'size'=>'25', 'maxlength'=>'19'));?>
			</div>
        </div>
        <?php } ?>
        
      </fieldset>
    </div>

    <?php echo $this->_tmpl_register_html_2?>

	
	<?php if ($config_fields['home']['display'] or $config_fields['apartment']['display'] or $config_fields['street']['display'] or $config_fields['zip']['display'] or $config_fields['city']['display'] or $config_fields['state']['display'] or $config_fields['country']['display']) {?>
    <div class="jshop_register user_address">
	
	  <fieldset>
	  
        <?php if ($config_fields['home']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_HOME; ?> <?php if ($config_fields['home']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
	            <input type="text" name="home" id="home" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['apartment']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_APARTMENT; ?> <?php if ($config_fields['apartment']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="apartment" id="apartment" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['street']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_STREET_NR; ?> <?php if ($config_fields['street']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="street" id="street" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['zip']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_ZIP ?> <?php if ($config_fields['zip']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="zip" id="zip" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['city']['display']){?>
         <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_CITY ?> <?php if ($config_fields['city']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="city" id="city" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['state']['display']){?>
         <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_STATE ?> <?php if ($config_fields['state']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="state" id="state" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['country']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_COUNTRY ?> <?php if ($config_fields['country']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<?php print $this->select_countries ?>
       		</div>
        </div>
        <?php } ?> 
		       
      </fieldset>
	  
    </div>
	<?php } ?>
    <?php echo $this->_tmpl_register_html_3?>
	
	
    <div class="jshop_register user_contact">

	  <fieldset>

        <?php if ($config_fields['phone']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_TELEFON ?> <?php if ($config_fields['phone']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="phone" id="phone" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['mobil_phone']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_MOBIL_PHONE ?> <?php if ($config_fields['mobil_phone']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="number" name="mobil_phone" id="mobil_phone" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['fax']['display']){?>
         <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_FAX ?> <?php if ($config_fields['fax']['require']){?><span>*</span><?php } ?>
          	</label>
          <div class="controls">
            	<input type="text" name="fax" id="fax" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
        
        <?php if ($config_fields['ext_field_1']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_EXT_FIELD_1 ?> <?php if ($config_fields['ext_field_1']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="ext_field_1" id="ext_field_1" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['ext_field_2']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_EXT_FIELD_2 ?> <?php if ($config_fields['ext_field_2']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="ext_field_2" id="ext_field_2" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['ext_field_3']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_EXT_FIELD_3 ?> <?php if ($config_fields['ext_field_3']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="ext_field_3" id="ext_field_3" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
        
      </fieldset>
    </div>
	
	
    <?php echo $this->_tmpl_register_html_4?>
	
	
    <div class="jshop_register user_login">
      
	  <fieldset>
	  
        <?php if ($config_fields['u_name']['display']){?>
       <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_USERNAME ?> <?php if ($config_fields['u_name']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="text" name="u_name" id="u_name" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['password']['display']){?>
        <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_PASSWORD ?> <?php if ($config_fields['password']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="password" name="password" id="password" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
		
        <?php if ($config_fields['password_2']['display']){?>
       <div class="control-group">
          	<label class="control-label">
            	<?php echo _JSHOP_PASSWORD_2 ?> <?php if ($config_fields['password_2']['require']){?><span>*</span><?php } ?>
          	</label>
          	<div class="controls">
            	<input type="password" name="password_2" id="password_2" value="" class="span10" />
       		</div>
        </div>
        <?php } ?>
        <?php if ($config_fields['privacy_statement']['display']){?>
        <div class="control-group">
          <label class="control-label">
            <a class="privacy_statement" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=privacy_statement&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;">
            <?php echo _JSHOP_PRIVACY_STATEMENT?> <?php if ($config_fields['privacy_statement']['require']){?><span>*</span><?php } ?>
            </a>            
          </label>
          <div class="controls">
            <input type="checkbox" name="privacy_statement" id="privacy_statement" value="1" />
          </div>
        </div>
        <?php } ?>             
		
      </fieldset>
	  
    </div>
	
    <?php echo $this->_tmpl_register_html_5?>
	
	
    <div class="requiredtext">* <?php echo _JSHOP_REQUIRED; ?></div>
	
    <?php echo $this->_tmpl_register_html_6?>
	
    <?php echo JHtml::_('form.token');?>
    <input type="submit" value="<?php echo _JSHOP_SEND_REGISTRATION; ?>" class="btn" />
	
    </form>
    </div>
</div>