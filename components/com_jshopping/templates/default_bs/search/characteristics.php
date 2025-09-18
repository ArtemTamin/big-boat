<?php defined( '_JEXEC' ) or die(); ?>
<?php
$characteristic_displayfields = $this->characteristic_displayfields;
$characteristic_fields = $this->characteristic_fields;
$characteristic_fieldvalues = $this->characteristic_fieldvalues;
$groupname = "";
?>
<?php print $this->tmp_ext_search_html_characteristic_start;?>
<?php if (is_array($characteristic_displayfields) && count($characteristic_displayfields)){?>

<div class="filter_characteristic">
  <?php foreach($characteristic_displayfields as $ch_id){?>
  <?php if ($characteristic_fields[$ch_id]->groupname!=$groupname){ $groupname = $characteristic_fields[$ch_id]->groupname;?>
  <div class="characteristic_group" style="margin-bottom:15px;"><?php echo $groupname;?></div>
  <?php }?>
  <div class="control-group">
    <div class="control-label"><?php echo $characteristic_fields[$ch_id]->name;?></div>
    
	<?php if ($characteristic_fields[$ch_id]->type==0){?>
    
    <input type="hidden" name="extra_fields[<?php echo $ch_id?>][]" value="0" />
    <div class="controls">
	<?php if (is_array($characteristic_fieldvalues[$ch_id])){?>
    <?php foreach($characteristic_fieldvalues[$ch_id] as $val_id=>$val_name){?>
    
      <input type="checkbox"  name="extra_fields[<?php echo $ch_id?>][]" value="<?php echo $val_id;?>" <?php if (is_array($extra_fields_active[$ch_id]) && in_array($val_id, $extra_fields_active[$ch_id])) echo "checked";?> />
      <label class="checkbox inline radiootstup"><?php echo $val_name;?></label>
    <?php }?>
    <?php }?>
    </div>
    <?php }else{?>
    <div class="controls">
      <input type="text" name="extra_fields[<?php echo $ch_id?>]" class="inputbox" />
    </div>
  
  <?php }?>
  </div>
  <?php }?>
  
</div>
<?php } ?>
<?php print $this->tmp_ext_search_html_characteristic_end;?>