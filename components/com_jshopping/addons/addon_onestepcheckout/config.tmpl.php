<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Garry
* @website https://joom-shopping.com
* @email info@joom-shopping.com
* @license Gnu Gpl v3
**/

defined('_JEXEC') or die;

$this->params = (object)$this->params;

JFactory::getLanguage()->load('addon_jshopping_onestepcheckout', JPATH_ADMINISTRATOR);
if (!$this->params->template) {
	$this->params->template = 'default';
}
$get = JFactory::getApplication()->input->getArray($_GET);
if (isset($get['template']) && $get['template'] != '') {
	$this->params->template = $get['template'];
}
unset($get['template']);
$uri = 'index.php?'.http_build_query($get);
JFactory::getLanguage()->load('addon_jshopping_onestepcheckout', JPATH_SITE.'/components/com_jshopping/templates/addons/onestepcheckout/'.$this->params->template);

$server_host = str_replace('www.','',JUri::getInstance()->toString(array('host')));

if (true) {
	$this->params->hash = md5($server_host.date('dmY').'onestepcheckout');

	$form = JForm::getInstance('onestepcheckout', __DIR__ . '/config.xml');
	$params = array();
	foreach ($this->params as $key=>$value) {
		$params['params['.$key.']'] = $value;
	}
	$form->bind($params);
} 


if (!isset($this->params->user_fields)) {
	$this->params->user_fields = array();
}

jimport('joomla.html.html.bootstrap');
JHtml::_('bootstrap.tooltip');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_jshopping/addons/addon_onestepcheckout/css/style.css');
$document->addScript(JURI::root().'components/com_jshopping/addons/addon_onestepcheckout/js/tablednd.jquery.js');

$jshopConfig = JSFactory::getConfig();

$tmp_fields = $jshopConfig->getListFieldsRegister();
$config_fields = $tmp_fields['address'];

$config = new stdClass();
include $jshopConfig->path.'lib/default_config.php';
$user_fields = array();
foreach ($this->params->user_fields as $v) {
	if (in_array($v, $fields_client['address'])) {
		$user_fields[] = $v;
	}
}
foreach ($fields_client['address'] as $v) {
	if (!in_array($v, $user_fields)) {
		$user_fields[] = $v;
	}
}
?>
<script type="text/javascript">
function changeOneStepCheckoutTemplate(el) {
	if (confirm('<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_TEMPLATE_CHANGE') ?>')){
		location.href='<?php echo $uri ?>&template='+el.value;
	} else {
		jQuery(el).val('<?php echo $this->params->template ?>');
	}
}
jQuery(function($){
	$("#table_user_fields").tableDnD({
		onDragClass: "onestepcheckoutselected"
		}
	)
});
</script>
<ul class="nav nav-tabs" id="tabsOneStepCheckoutSettings">
  <li class="active"><a data-toggle="tab" href="#tab1"><?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_GENERAL') ?></a></li>
  <li><a data-toggle="tab" href="#tab2"><?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS') ?></a></li>
  <li><a data-toggle="tab" href="#tab3"><?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_TEMPLATES') ?></a></li>
</ul>
<?php
echo JHtml::_('bootstrap.startPane', 'tabsOneStepCheckoutSettings', array('active' => 'tab1'));
echo JHtml::_('bootstrap.addPanel', 'tabsOneStepCheckoutSettings', 'tab1');
?>
<table border="0" cellpadding="0">
	<tr>
		<td valign="top" style="padding: 5px 10px">
			<table>
				<tr>
					<td>
						<?php echo $form->getLabel('params[enable]') ?>
					</td>
					<td style="padding: 5px 10px">
						<?php echo $form->getInput('params[enable]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[skip_cart]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[skip_cart]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[finish_order]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[finish_order]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[finish_register]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[finish_register]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[registration]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[registration]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[finish_extended]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[finish_extended]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[package]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[package]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[refresh]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[refresh]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[use_mask]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[use_mask]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[define_mask]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[define_mask]') ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $form->getLabel('params[template]') ?>
					</td>
					<td style="padding: 5px 10px">	
						<?php echo $form->getInput('params[template]') ?>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" style="padding: 5px 10px 5px 30px">
			<div>
				<?php echo $form->getLabel('params[user_fields_onchange]') ?>
			</div>
			<?php echo $form->getInput('params[user_fields_onchange]') ?>
			<div>
				<?php echo $form->getLabel('params[payment_onchange]') ?>
			</div>
			<?php echo $form->getInput('params[payment_onchange]') ?>
			<div>
				<?php echo $form->getLabel('params[shipping_onchange]') ?>
			</div>
			<?php echo $form->getInput('params[shipping_onchange]') ?>
			<?php echo $form->getInput('params[hash]') ?>
		</td>
	</tr>
</table>
<?php
echo JHtml::_('bootstrap.endPanel');
echo JHtml::_('bootstrap.addPanel', 'tabsOneStepCheckoutSettings', 'tab2');
?>
<div class="onestepcheckout-fieldsetts">
	<div class="onestepcheckout-fieldslegend">
		<i class="onestepcheckout-icon-home"></i> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_BASE') ?><br/><br/>
		<i class="onestepcheckout-icon-truck"></i> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_DELIVERY') ?><br/><br/>
		<span class="onestepcheckout-box-showrequire"> </span> <span> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_REQUIRE') ?></span><br/><br/>
		<span class="onestepcheckout-box-showcheck"> </span> <span> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_CHECK') ?></span><br/><br/>
		<span class="onestepcheckout-box-showsimple"> </span> <span> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_SIMPLE') ?></span><br/><br/><br/>
		<i class="onestepcheckout-icon-move"></i> - <?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_MOVE') ?><br/><br/>
		<br/><br/>
		<hr/>
		<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_SETTINGS_USER_FIELDS_ASTERICS').' '.JText::_('JSHOP_ONESTEPCHECKOUT_TEMPLATE_DEPENDED') ?>
	</div>
</div>
<table id="table_user_fields" class="1sc_fields_table table" style="width:400px; font-size:14px;padding-left:20px" cellspacing="0" cellpadding="2">
	<thead>
		<tr>
			<th style="text-align:center;"><?php echo _JSHOP_TITLE ?></th>
			<th style="text-align:center;"><span data-uk-tooltip title="<?php echo _JSHOP_DISPLAY ?>"><i class="onestepcheckout-icon-eye-open"></i>  /  <i class="onestepcheckout-icon-eye-close"></i></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($user_fields as $v) {
			if (substr($v, 0, 2)=='d_' || $v=='privacy_statement') {
				continue;
			}
			$class_home = $class_track = 'onestepcheckoutsetshow';
			if (isset($config_fields[$v]['display']) && $config_fields[$v]['display']) {
				$class_home .= '-check';
			}
			if (isset($config_fields[$v]['require']) && $config_fields[$v]['require']) {
				$class_home .= '-require';
			}
			if (isset($config_fields['d_'.$v]['display']) && $config_fields['d_'.$v]['display']) {
				$class_track .= '-check';
			}
			if (isset($config_fields['d_'.$v]['require']) && $config_fields['d_'.$v]['require']) {
				$class_track .= '-require';
			}
		?>
		<tr id="params<?php echo $v?>">
			<td>
				<i class="onestepcheckout-icon-sort"></i>
				<?php echo JText::_('JSHOP_ONESTEPCHECKOUT_USER_FIELD_'.$v)?>
				<input type="hidden" name="params[user_fields][]" value="<?php echo $v?>" />
			</td>
			<td>
				<div class="<?php echo $class_home ?>" ><i class="onestepcheckout-icon-home"  ></i></div>
				<div class="<?php echo $class_track ?>"><i class="onestepcheckout-icon-truck"></i></div>
			</td>
		</tr>
		<?php }	?>
	</tbody>
</table>
<?php
echo JHtml::_('bootstrap.endPanel');
echo JHtml::_('bootstrap.addPanel', 'tabsOneStepCheckoutSettings', 'tab3');

if (file_exists(JPATH_SITE.'/components/com_jshopping/templates/addons/onestepcheckout/'.$this->params->template.'/config.php')) {
	include JPATH_SITE.'/components/com_jshopping/templates/addons/onestepcheckout/'.$this->params->template.'/config.php';
}

echo JHtml::_('bootstrap.endPanel');
echo JHtml::_('bootstrap.endPane', 'tabsOneStepCheckoutSettings');
?>