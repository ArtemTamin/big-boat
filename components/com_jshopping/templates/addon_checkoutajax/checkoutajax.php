<?php
    /**
    * @version      1.6.6 27.01.2019
    * @author       Garry
    * @copyright    Copyright (C) 2019 joom-shopping.com. All rights reserved.
    * @license      GNU GPL v3
    */
	$jshopConfig = JSFactory::getConfig();
?>
<script type="text/javascript">
    <?php if(file_exists(JPATH_COMPONENT.'/payments/pm_klarna')){?>
        <?php include_once JPATH_COMPONENT.'/payments/payment.php'?>
        <?php include_once JPATH_COMPONENT.'/payments/pm_klarna/pm_klarna.php'?>
        var klarna_config = <?php echo json_encode(pm_klarna::getPaymentConfig())?>;
    <?php }?>
    checkoutajax_registration_url='<?php echo JURI::root()?>index.php?option=com_jshopping&controller=user&task=register';	
</script>
<?php
	$task = JRequest::getVar('task');
    $controller = JRequest::getVar('controller');
    $user = JFactory::getUser();
    $application = JFactory::getApplication();
    $messages = $application->getMessageQueue();
    
    $login_enabled = ($user->id<=0 && $jshopConfig->shop_user_guest!=2);
    if ($this->usestandartlogin) $login_enabled = 0;

    $steps = array(
        'login' => array(
            'enabled' => $login_enabled, 
            'current' => in_array($task,array('login','register')) && $controller == 'user',
            'task' => 'controller=user&task=login',
            'layout' => 'user/'.$task
        ),
        'step2' => array(
            'enabled' => true,
            'current' => $task=='step2' && $controller == 'checkout',
            'task' => 'controller=checkout&task=step2',
            'layout' => 'checkout/adress'
        ),
        'step3' => array(
            'enabled' => !$jshopConfig->without_payment && !$jshopConfig->hide_payment_step,
            'current' => $task=='step3' && $controller == 'checkout',
            'task' => 'controller=checkout&task=step3',
            'layout' => 'checkout/payments'
        ),
        'step4' => array(
            'enabled' => !$jshopConfig->without_shipping && !$jshopConfig->hide_shipping_step,
            'current' => $task=='step4' && $controller == 'checkout',
            'task' => 'controller=checkout&task=step4',
            'layout' => 'checkout/shippings'
        ),
        'step5' => array(
            'enabled' => true,
            'current' => $task=='step5' && $controller == 'checkout',
            'task' => 'controller=checkout&task=step5',
            'layout' => 'checkout/previewfinish'
        )
    );
    
    if ($jshopConfig->step_4_3){
        $sortSteps = array(
            'login' => $steps['login'],
            'step2' => $steps['step2'],
            'step4' => $steps['step4'],
            'step3' => $steps['step3'],
            'step5' => $steps['step5']
        );
    } else {
        $sortSteps = array(
            'login' => $steps['login'],
            'step2' => $steps['step2'],
            'step3' => $steps['step3'],
            'step4' => $steps['step4'],
            'step5' => $steps['step5']
        );
    }
    
    foreach ($messages as $key => $message){
        if (array_key_exists('message', $message) && $message['message'] == ""){
            unset($messages[$key]);
        }
    }
?>

<div id="checkoutajax-wrapper">
    <h1><?php echo JText::_('CHECKOUTAJAX_TITLE')?></h1>
	<div id="checkoutajax_smallcart"></div>
    <div id="checkoutajax">
        <script type="text/javascript">jQuery.each(<?php echo json_encode($messages)?>, function(key, message){alert(message.message);});</script>
        <?php $active=true?>
        <?php foreach($sortSteps as $step_name => $step){?>
            <?php if ($step['enabled']){?>
                <span class="checkoutajax-title<?php if(!$active){?> checkoutajax-disabled<?php }?>">
                    <?php if($active){?>
                        <a href="<?php echo JURI::root()?>index.php?option=com_jshopping&<?php echo $step['task']?>">
                    <?php }?>
                        <img src="<?php echo JURI::root()?>components/com_jshopping/images/checkoutajax-<?php echo $active ? ($step['current'] ? 'refresh' : 'enter') : 'inactive'?>.png" />
                    <?php if($active){?>
                        </a>
                    <?php }?>
                    <span><?php echo JText::_('CHECKOUTAJAX_'.$step_name.'_TITLE')?></span>
                </span>
                <?php if ($step['current']){?>
                    <div class="checkoutajax-content checkoutajax-content-login">
                        <?php include JPATH_ROOT.'/components/com_jshopping/templates/'.$jshopConfig->template.'/'.$step['layout'].'.php'?>
                    </div>
                    <?php $active = false?>
                <?php }?>                  
            <?php }?>
        <?php }?>
    </div>
</div>