<?php defined( '_JEXEC' ) or die(); ?>

<h2 style="margin-bottom:15px;" >Выберите способ оплаты</h2>

<?php print $this->checkout_navigator?>
<?php print $this->small_cart?>

<script type="text/javascript">
var payment_type_check = {};
<?php foreach($this->payment_methods as  $payment){?>
    payment_type_check['<?php print $payment->payment_class;?>'] = '<?php print $payment->existentcheckform;?>';
<?php }?>
</script>

<div class="jshop payments">


<form class="thumbnail form-horizontal" style="padding: 10px 10px 15px 15px;" id = "payment_form" name = "payment_form" action = "<?php print $this->action ?>" method = "post">
<?php print $this->_tmp_ext_html_payment_start?>
<div id = "table_payments" cellspacing="0" cellpadding="0">
  <?php 
  $payment_class = "";
  foreach($this->payment_methods as  $payment){
  if ($this->active_payment==$payment->payment_id) $payment_class = $payment->payment_class;
  ?>
    <div class="control-group checkout_otstup">
      
      <label for = "payment_method_<?php print $payment->payment_id ?>">
	  
	  <input type = "radio" name = "payment_method" id = "payment_method_<?php print $payment->payment_id ?>" onclick = "showPaymentForm('<?php print $payment->payment_class ?>')" value = "<?php print $payment->payment_class ?>" <?php if ($this->active_payment==$payment->payment_id){?>checked<?php } ?> />
	  
	  <?php
      if ($payment->image){
        ?><span class="payment_image"><img src="<?php print $payment->image?>" alt="<?php print htmlspecialchars($payment->name)?>" /></span><?php
      }
      ?><?php print $payment->name;?>
        <?php if ($payment->price_add_text!=''){?>
            (<?php print $payment->price_add_text?>)
        <?php }?>
      </label>
    </div>
  <div id = "tr_payment_<?php print $payment->payment_class ?>" <?php if ($this->active_payment != $payment->payment_id){?>style = "display:none"<?php } ?>>
    <div class = "jshop_payment_method">
        <?php print $payment->payment_description?>
        <?php print $payment->form?>
    </div>
  </div>
  <?php } ?>
</div>
<br />
<?php print $this->_tmp_ext_html_payment_end?>
<p class="btn-checkout-otstup requiredtext"><input type = "button" id = "payment_submit" class = "btn btn-success" name = "payment_submit" value = "<?php echo _JSHOP_NEXT?>" onclick="checkPaymentForm();" /></p>
</form>
</div>

<?php if ($payment_class){ ?>
<script type="text/javascript">
    showPaymentForm('<?php print $payment_class;?>');
</script>
<?php } ?>