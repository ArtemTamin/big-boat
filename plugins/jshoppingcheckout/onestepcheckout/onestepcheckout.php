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

class plgJshoppingcheckoutOnestepcheckout extends JPlugin {

	protected function updateMessageQueue($newMessageQueue=array()) {
		$messageQueue = $this->app->getMessageQueue();
		$_messageQueue = $this->_app->getProperty('_messageQueue');
		$_messageQueue->setAccessible(true);
		$_messageQueue->setValue($this->app, $newMessageQueue);

		return $messageQueue;
	}

	protected function parseMessageQueue() {
		$stepErrors = $this->updateMessageQueue();
		$errors = '';
		foreach ($stepErrors as $error) {
			$errors .= JText::sprintf('JSHOP_ONESTEPCHECKOUT_MESSAGEQUEUE',$error['type'],$error['message']);
		}
		
		return $errors;
	}

	protected function step1update() {
		$this->addonParams->message_adress = $this->addonParams->message_payment = $this->addonParams->message_shipping = 0;
		$this->step2update();
	}
	protected function step5update() {
		$this->stepUpdate(5);
	}
	protected function step2update() {
		$this->stepUpdate(2);
	}

	protected function step3update() {
		$this->stepUpdate(3);
	}

	protected function step4update() {
		$this->stepUpdate(4);
	}

	

	protected function stepUpdate($step=2, $external=1) {
		$view = new stdClass;
		
		if ($step < 5) {
			if ($this->jshopConfig->step_4_3) {
				$step3 = 'step4';
				$step3save = 'step4save';
				$step3method_id = 'sh_pr_method_id';
				$step4 = 'step3';
				$step4save = 'step3save';
				$step4method_id = 'payment_method';
			} else {
				$step3 = 'step3';
				$step3save = 'step3save';
				$step3method_id = 'payment_method';
				$step4 = 'step4';
				$step4save = 'step4save';
				$step4method_id = 'sh_pr_method_id';
			}
			if ($external) {
				if ($step > 2) {
					$this->$step3method_id = $this->app->input->get($step3method_id);
				}
				if ($step > 3) {
					$this->$step4method_id = $this->app->input->get($step4method_id);
				}
			} else {
				$_POST['step2save'] = 'step2save';
			}
			
			if ($step < 3) {
				$view->step2errors = $this->step2save();
				if (!$this->addonParams->message_adress) {
					unset($view->step2errors);
				}
				$view->step3 = $this->$step3();
			}
			if ($step < 4) {
				$view->step3errors = $this->$step3save();
				if (!$this->addonParams->message_payment) {
					unset($view->step3errors);
				}
				$view->step4 = $this->$step4();
			}
			$view->step4errors = $this->$step4save();
			if (!$this->addonParams->message_shipping) {
				unset($view->step4errors);
			}
		}
		$view->step5 = $this->step5();

		if ($external) {
			ob_clean();
			echo json_encode($view);
		} else {
			return $view;
		}
	}

	protected function controllerExecute($step) {
		$this->modelCheckout->setMaxStep(5);
		$this->controllerCheckout->execute($step);
	}

	protected function step3() {
		$form = '';

		$this->cart->setPaymentId(0);
		$this->cart->setPaymentParams('');
		$this->cart->setPaymentPrice(0);

		if (!$this->jshopConfig->without_payment) {
			ob_start();
			$this->controllerExecute('step3');
			$form = ob_get_contents();
			ob_get_clean();
			if ($this->jshopConfig->hide_payment_step) {
				$payment_query = array();
				parse_str(stristr($this->controllerCheckout->get('redirect'), 'payment_method'), $payment_query);
				if (isset($payment_query['payment_method'])) {
					$this->payment_method = $payment_query['payment_method'];
				}
				if ($this->payment_method) {
					$paym_method = JTable::getInstance('paymentmethod', 'jshop');
					$paym_method->class = $this->payment_method;
					$form = '<input type="radio" name="payment_method" id="payment_method_'.$paym_method->getId().'" value="'.$this->payment_method.'" checked="checked" style="display:none" />';
				}
			}
		}

		return $form;
	}

	protected function step4() {
		$form = '';

		$this->cart->setShippingId(0);
		$this->cart->setShippingPrId(0);
		$this->cart->setShippingPrice(0);

		if (!$this->jshopConfig->without_shipping) {
			$id_country = $this->userShop->delivery_adress ? $this->userShop->d_country : $this->userShop->country;
			if (!$id_country) {
				$id_country = $this->jshopConfig->default_country;
			}
			
			if ($id_country) {
				ob_start();
				$this->controllerExecute('step4');
				$form = ob_get_contents();
				ob_get_clean();

				if ($this->jshopConfig->hide_shipping_step) {
					$shipping_query = array();
					parse_str(stristr($this->controllerCheckout->get('redirect'), 'sh_pr_method_id'), $shipping_query);
					if (isset($shipping_query['sh_pr_method_id'])) {
						$this->sh_pr_method_id = $shipping_query['sh_pr_method_id'];
					}
					if ($this->sh_pr_method_id) {
						$form = '<input type="radio" name="sh_pr_method_id" id="shipping_method_'.$this->sh_pr_method_id.'" value="'.$this->sh_pr_method_id.'" checked="checked" style="display:none" />';
					}
				}
			} else {
				$this->app->enqueueMessage(_JSHOP_REGWARN_COUNTRY, 'error');
			}
		}

		return $form;
	}

	protected function step5() {
		ob_start();
		$this->controllerExecute('step5');
		$form = ob_get_contents();
		ob_get_clean();

		return $form;
	}

	protected function step2save() {
		$this->updateMessageQueue();

		$this->controllerExecute('step2save');
		if (!$this->stepSave[2]) {
			$post = $this->app->input->getArray($_POST);
			if ($post['birthday']) $post['birthday'] = getJsDateDB($post['birthday'], $this->jshopConfig->field_birthday_format);
			if ($post['d_birthday']) $post['d_birthday'] = getJsDateDB($post['d_birthday'], $this->jshopConfig->field_birthday_format);
			unset($post['user_id']);
			unset($post['usergroup_id']);
			
			$this->userShop->bind($post);
			if (!$this->userShop->store()){
				throw new Exception(_JSHOP_REGWARN_ERROR_DATABASE, 500);
				die;
			}
			if ($this->user->id){
				$temp_adv_user = JSFactory::getUserShop();
				$fields = get_object_vars($this->userShop);
				foreach ($fields as $field=>$value) {
					$temp_adv_user->$field = $this->userShop->$field;
				}
			}
		}

		$errors = $this->parseMessageQueue();
		
		return $errors;
	}

	protected function step3save($fromStep4 = 0) {
		if ($this->jshopConfig->without_payment) {
			return;
		}

		$this->updateMessageQueue();

		if ($this->payment_method) {
			$this->app->input->set('payment_method', $this->payment_method);
			$this->controllerExecute('step3save');
			if (!$this->stepSave[3]) {
				$paym_method = JTable::getInstance('paymentmethod', 'jshop');
				$paym_method->class = $this->payment_method;
				$payment_method_id = $paym_method->getId();
				$paym_method->load($payment_method_id);
				$paym_method->setCart($this->cart);
				$this->cart->setPaymentId($payment_method_id);
				$price = $paym_method->getPrice();        
				$this->cart->setPaymentDatas($price, $paym_method);
				$this->cart->setPaymentParams('');
				$this->userShop->saveTypePayment($payment_method_id);
			}
		} else {
			$this->app->enqueueMessage(_JSHOP_ERROR_PAYMENT, 'error');
		}
		
		$errors = $this->parseMessageQueue();
		
		return $errors;
	}

	protected function step4save($fromStep3 = 0) {
		if ($this->jshopConfig->without_shipping) {
			return;
		}

		$this->updateMessageQueue();
		
		if ($this->sh_pr_method_id) {
			$this->app->input->set('sh_pr_method_id', $this->sh_pr_method_id);
			$this->controllerExecute('step4save');
		} else {
			$this->app->enqueueMessage(_JSHOP_ERROR_SHIPPING, 'error');
		}

		$errors = $this->parseMessageQueue();
		
		return $errors;
	}

	protected function init() {
		if ($this->addonParams === null) {
			//$server_host = str_replace('www.','',JUri::getInstance()->toString(array('host')));
			$addon = JTable::getInstance('addon', 'jshop');
			$addon->loadAlias('addon_onestepcheckout');
			//openssl_public_decrypt(base64_decode($addon->key), $decryptKey, openssl_pkey_get_public(base64_decode('LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1Gd3dEUVlKS29aSWh2Y05BUUVCQlFBRFN3QXdTQUpCQUpiVmExQ1Fia000K1RieGkzeWo2NnJOSk9BdEhNMkoNClRiWmovZHdZdExGY3BQWEYrbGxvMFMyRWwxZlhodktUZUUxbllWY0JiRkxsK2poRFNFT0VLbFVDQXdFQUFRPT0NCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ==')));
			if (true /*sha1($server_host.'onestepcheckout') === $decryptKey*/) {
				$this->addonParams = (object)$addon->getParams();
				if ($this->addonParams->enable) {
					$this->redirectTask = array('step5save','step6iframe','step6','step7','finish');
					$this->stepSave = array(2=>0, 3=>0, 4=>0, 5=>0);
					$this->min_price_order = 0;
					$this->max_price_order = 0;
					$this->jshopConfig = JSFactory::getConfig();
					$this->jshopConfig->show_cart_all_step_checkout = 0;
					$this->app = JFactory::getApplication();
					$this->_app = new ReflectionClass(get_class($this->app));
					$this->document = JFactory::getDocument();
					$this->session = JFactory::getSession();
					$this->user = JFactory::getUser();
					if ($this->user->id) {
						$this->allowUserRegistration = false;
						$this->userShop = JTable::getInstance('userShop', 'jshop');
						$this->userShop->load($this->user->id);
					} else {
						$this->allowUserRegistration = JComponentHelper::getParams('com_users')->get('allowUserRegistration');
						$this->userShop = JSFactory::getUserShopGuest();
					}
					$this->modelCheckout = JModelLegacy::getInstance('checkout', 'jshop');
					$this->checkoutTask = $this->app->input->getString('task');
				}
			} else {
				$this->addonParams = new stdClass;
				$this->addonParams->enable = false;
			}
		}
		if ($this->addonParams->enable && !$this->controllerCheckout && class_exists('JshoppingControllerCheckout')) {
			$language = JFactory::getLanguage();
			$language->load('addon_jshopping_onestepcheckout', JPATH_ADMINISTRATOR);
			$language->load('addon_jshopping_onestepcheckout', JPATH_SITE . '/components/com_jshopping/templates/addons/onestepcheckout/' . $this->addonParams->template);
			$this->document->addStyleSheet(JURI::root().'components/com_jshopping/templates/addons/onestepcheckout/'.$this->addonParams->template.'/css/style.css');
			if (file_exists(JPATH_SITE.'/components/com_jshopping/templates/addons/onestepcheckout/'.$this->addonParams->template.'/css/custom.css')) {
				$this->document->addStyleSheet(JURI::root().'components/com_jshopping/templates/addons/onestepcheckout/'.$this->addonParams->template.'/css/custom.css');
			}
			$this->controllerCheckout = new JshoppingControllerCheckout;
			if (in_array($this->checkoutTask, array('step2save', 'step3', 'step3save','step4', 'step4save', 'step5'))) {
				$this->app->redirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1,$this->jshopConfig->use_ssl));
			}
		}
	}

	function onAfterCartLoad(&$cart) {
		if (JFactory::getApplication()->input->getString('controller') != 'checkout') {
			return;
		}
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}
		if ($this->cart || in_array($this->checkoutTask, $this->redirectTask)) {
			return;
		}
		$this->cart = $cart;
		if (!$this->addonParams->skip_cart || $this->app->input->getInt('ajax')) {
			return;
		}

		if ($this->jshopConfig->min_price_order && ($cart->getPriceProducts() < ($this->jshopConfig->min_price_order * $this->jshopConfig->currency_value) )){
			$this->min_price_order = $this->jshopConfig->min_price_order;
			$this->jshopConfig->min_price_order = 0;
		}
		if ($this->jshopConfig->max_price_order && ($cart->getPriceProducts() > ($this->jshopConfig->max_price_order * $this->jshopConfig->currency_value) )){
			$this->max_price_order = $this->jshopConfig->max_price_order;
			$this->jshopConfig->max_price_order = 0;
		}
	}

	function onBeforeDisplayCart($cart) {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		if (!$this->addonParams->skip_cart || $this->app->input->getInt('ajax') || $this->app->input->getString('controller') != 'cart') {
			return;
		}

		header('Cache-Control: no-cache, max-age=0, must-revalidate, no-store');

		if ($cart->getCountProduct() == 0) {
			return;
		}

		$this->app->redirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2'.($this->jshopConfig->shop_user_guest == 1 ? '&check_login=1' : ''),1,0,$this->jshopConfig->use_ssl));
	}

	function onBeforeRegister(&$post, &$default_usergroup) {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->stepSave[5] = 0;
	}

	function onAfterRegister(&$user, &$row, &$post, &$useractivation) {
		if (!$this->addonParams->enable) {
			return;
		}

		$this->stepSave[5] = $user->id;
		
		$order_id = $this->session->clear('order_id', 'onestepcheckout');
		if ($order_id) {
			$order = JTable::getInstance('order', 'jshop');
			$order->load($order_id);
			if ($order->order_id) {
				$order->user_id = $user->id;
				$order->store();
			}
		}
	}

	function onAfterLoginEror() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}
		
		if ($this->app->input->getInt('onestepcheckout')) {
			$this->app->redirect(base64_decode($this->app->input->getBase64('return')));
			die;
		}
	}

	function onLoadCheckoutStep2() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		if ($osctask = $this->app->input->getCmd('osctask','')) {
			if (method_exists($this, $osctask)) {
				$this->$osctask();
			}
			die;
		}

        header("Cache-Control: no-cache, max-age=0, must-revalidate, no-store");
		$this->session->clear('order_id', 'onestepcheckout');
		if ($this->jshopConfig->shop_user_guest != 1) {
			$this->app->input->set('check_login', 0);
		}
		if ($this->addonParams->package) {
			$this->app->input->set('package', 1);
		}
		$this->pathway = $this->app->getPathway()->getPathway();
	}

	function onBeforeDisplayCheckoutStep2View(&$view) {
		if (!$this->addonParams->enable) {
			return;
		}

		if ($this->addonParams->use_mask) {
			$this->document->addScript(JURI::root().'components/com_jshopping/addons/addon_onestepcheckout/js/jquery.maskedinput.min.js');
			$this->document->addScriptDeclaration("
	jQuery(function($){
		$.mask.definitions['*'] = '[0-9]';
		$('#".$this->addonParams->use_mask.", #d_".$this->addonParams->use_mask."').mask('".$this->addonParams->define_mask."',{placeholder:'x'});
	});
			");
		}

		if ($this->addonParams->user_fields_onchange) {
			$user_fields_onchange = array_unique(explode(',', $this->addonParams->user_fields_onchange));
			$user_fields_selector = array();
			foreach ($user_fields_onchange as $field) {
				$field = trim($field);
				if ($field != '') {
					$user_fields_selector[] = '[name="'.$field.'"]';
				}
			}
			if (count($user_fields_selector)) {
				$this->document->addScriptDeclaration("
	jQuery(function($){
		$('#oneStepCheckoutForm').delegate('".implode(',', $user_fields_selector)."', 'change' ,function(e){
			oneStepCheckout.updateForm(2);
		});
	});
				");
			}
		}

		if ($this->addonParams->payment_onchange) {
			$payment_onchange = array_unique(explode(',', $this->addonParams->payment_onchange));
			$payment_fields_selector = array();
			foreach ($payment_onchange as $field) {
				$field = trim($field);
				if ($field != '') {
					$payment_fields_selector[] = '[name="'.$field.'"]';
				}
			}
			if (count($payment_fields_selector)) {
				$this->document->addScriptDeclaration("
	jQuery(function($){
		$('#oneStepCheckoutForm').delegate('".implode(',', $payment_fields_selector)."', 'change' ,function(e){
			oneStepCheckout.updateForm(".($this->jshopConfig->step_4_3 ? "4" : "3").");
		});
	});
				");
			}
		}

		if ($this->addonParams->shipping_onchange) {
			$shipping_onchange = array_unique(explode(',', $this->addonParams->shipping_onchange));
			$shipping_fields_selector = array();
			foreach ($shipping_onchange as $field) {
				$field = trim($field);
				if ($field != '') {
					$shipping_fields_selector[] = '[name="'.$field.'"]';
				}
			}
			if (count($shipping_fields_selector)) {
				$this->document->addScriptDeclaration("
	jQuery(function($){
		$('#oneStepCheckoutForm').delegate('".implode(',', $shipping_fields_selector)."', 'change' ,function(e){
			oneStepCheckout.updateForm(".($this->jshopConfig->step_4_3 ? "3" : "4").");
		});
	});
				");
			}
		}
		
		$config = new stdClass();
		include($this->jshopConfig->path.'lib/default_config.php');
		$user_fields = array();
		foreach ($this->addonParams->user_fields as $v) {
			if (in_array($v, $fields_client['address'])) {
				$user_fields[$v] = $v;
			}
		}
		foreach ($fields_client['address'] as $v) {
			if (substr($v, 0, 2)=='d_') {
				$v = substr($v, 2);
			}
			if (!in_array($v, $user_fields)) {
				$user_fields[$v] = $v;
			}
		}
		unset($user_fields['privacy_statement']);

		$listFields = $this->jshopConfig->getListFieldsRegister();

		$view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
		$view->addonParams = $this->addonParams;
        $view->register_fields = $listFields['register'];
		$view->user_fields = $user_fields;
		$view->step2show = 0;
		if (is_array($view->config_fields)) {
			foreach ($view->config_fields as $config_field) {
				if ($config_field['display']) {
					$view->step2show = 1;
					break;
				}
			}
		}
		$view->setLayout('adress');
		$view->allowUserRegistration = $this->allowUserRegistration && (($this->jshopConfig->shop_user_guest == 3 && $view->config_fields['email']['require']) || ($this->jshopConfig->shop_user_guest == 4 && $view->config_fields['email']['display']));
		$view->step2 = $view->loadTemplate();
		$errors = $this->updateMessageQueue();
		if ($this->addonParams->refresh) {
			$view->action = SEFLink('index.php?option=com_jshopping&controller=checkout&task=step5save',0,0, $this->config->use_ssl);
			$this->app->getPathway()->setPathway($this->pathway);
			appendPathWay(_JSHOP_CHECKOUT_PREVIEW);
			$seo = JTable::getInstance('seo', 'jshop');
			$seodata = $seo->loadData('checkout-preview');
			if ($seodata->title==''){
				$seodata->title = _JSHOP_CHECKOUT_PREVIEW;
			}
			setMetaData($seodata->title, $seodata->keyword, $seodata->description);
		} else {
			$tmp_view = $this->stepUpdate(2,0);
			foreach ($tmp_view as $key=>$value) {
				$view->$key = $value;
			}
		}
		$this->updateMessageQueue($errors);
		if ($this->jshopConfig->step_4_3) {
			$step3show = 'step4show';
			$step4show = 'step3show';
		} else {
			$step3show = 'step3show';
			$step4show = 'step4show';
		}
		if (!$this->jshopConfig->without_payment) {
			if ($this->jshopConfig->hide_payment_step) {
				$view->$step3show = 2;
			} else {
				$view->$step3show = 1;
			}
		} else {
			$view->$step3show = 0;
		}
		if (!$this->jshopConfig->without_shipping) {
			if ($this->jshopConfig->hide_shipping_step) {
				$view->$step4show = 2;
			} else {
				$view->$step4show = 1;
			}
		} else {
			$view->$step4show = 0;
		}
		
		$stepNumber = 0;
		if ($view->step2show) {
			$stepNumber++;
		}
		$view->step2number = $stepNumber;
		if ($view->step3show == 1) {
			$stepNumber++;
		}
		$view->step3number = $stepNumber;
		if ($view->step4show == 1) {
			$stepNumber++;
		}
		$view->step4number = $stepNumber;
		$view->step5number = $stepNumber + 1;

		$view->setLayout('main');
	}

	function onLoadCheckoutStep2save() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->stepSave[2] = 0;
	}

	function onBeforeSaveCheckoutStep2(&$adv_user, &$user, &$cart) {
		if (!$this->addonParams->enable) {
			return;
		}
		if ($this->app->input->getInt('register')) {
			$email = $this->app->input->getString('email');
		    if ((trim($email=='')) || !JMailHelper::isEmailAddress($email)){
				$this->app->enqueueMessage(_JSHOP_REGWARN_MAIL, 'error');
				$this->controllerCheckout->setRedirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1, $this->config->use_ssl));
			    return;
		    }
		}
		if ($this->checkoutTask == 'step5save') {
			$this->cart = $cart;
			$this->cart->shipping_method_id = $cart->getShippingId();
			$this->cart->sh_pr_method_id = $cart->getShippingPrId();
			$this->cart->jshop_price_shipping = $cart->getShippingPrice();
			$this->cart->payment_method_id = $cart->getPaymentId();
			$this->cart->pm_params = $cart->getPaymentParams();
			$this->cart->jshop_payment_price = $cart->getPaymentPrice();
		}
	}

	function onAfterSaveCheckoutStep2(&$adv_user, &$user, &$cart) {
		if (!$this->addonParams->enable) {
			return;
		}
		$this->stepSave[2] = 1;

		$this->userShop = $adv_user;
		if ($this->user->id){
			$temp_adv_user = JSFactory::getUserShop();
			$fields = get_object_vars($this->userShop);
			foreach ($fields as $field=>$value) {
				$temp_adv_user->$field = $this->userShop->$field;
			}
		}

		if ($this->checkoutTask == 'step5save') {
			$cart = $this->cart;
			$cart->setShippingId($this->cart->shipping_method_id);
			$cart->setShippingPrId($this->cart->sh_pr_method_id);
			$cart->setShippingPrice($this->cart->jshop_price_shipping);
			$cart->setPaymentId($this->cart->payment_method_id);
			$cart->setPaymentParams($this->cart->pm_params);
			$cart->setPaymentPrice($this->cart->jshop_payment_price);
		}
	}

	function onLoadCheckoutStep3() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->payment_method = 0;
	}

	function onBeforeDisplayCheckoutStep3View(&$view) {
		if (!$this->addonParams->enable) {
			return;
		}

		if ($view->active_payment) {
			foreach ($view->payment_methods as $payment_method) {
				if ($payment_method->payment_id == $view->active_payment) {
					$this->payment_method = $payment_method->payment_class;
					break;
				}
			}
		}

		$view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
		$view->config = $this->jshopConfig;
		$view->addonParams = $this->addonParams;
	}

	function onBeforeSaveCheckoutStep3save(&$post) {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->stepSave[3] = 0;
	}

	function onAfterSaveCheckoutStep3save(&$adv_user, &$paym_method, &$cart) {
		if (!$this->addonParams->enable) {
			return;
		}
		$this->stepSave[3] = 1;

		if ($this->checkoutTask == 'step5save') {
			$cart->setShippingPrice($this->cart->jshop_price_shipping);
			$cart->setPaymentPrice($this->cart->jshop_payment_price);
		}
	}

	function onLoadCheckoutStep4() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}
		
		$this->sh_pr_method_id = 0;
	}

	function onBeforeDisplayCheckoutStep4View($view) {
		if (!$this->addonParams->enable) {
			return;
		}

		if ($view->active_shipping) {
			$this->sh_pr_method_id = $view->active_shipping;
		}
		

		$view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
		$view->config = $this->jshopConfig;
		$view->addonParams = $this->addonParams;
		if ($this->addonParams->package) {
			$view->package = $this->app->input->getInt('package');
			$shippingMethodPrice = JTable::getInstance('shippingMethodPrice', 'jshop');
			foreach($view->shipping_methods as $key=>$value){
				$shippingMethodPrice->load($value->sh_pr_method_id);
				if ($shippingMethodPrice->package_stand_price <= 0) {
					continue;
				}
				$prices = $shippingMethodPrice->calculateSum($this->cart);
				$view->shipping_methods[$key]->calculeprice = $prices['shipping'];
				$view->shipping_methods[$key]->calculepricepackage = $prices['package'];
			}
		}
	}

	function onBeforeSaveCheckoutStep4save() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->stepSave[4] = 0;
	}

	function onAfterSaveCheckoutStep4(&$adv_user, &$sh_method, &$shipping_method_price, &$cart) {
		if (!$this->addonParams->enable) {
			return;
		}
		$this->stepSave[4] = 1;
		if ($this->addonParams->package && !$this->app->input->getInt('package')) {
			$cart->setPackagePrice(0);
			if (!$this->jshopConfig->step_4_3) {
				$payment_method_id = $cart->getPaymentId();
				if ($payment_method_id){
					$paym_method = JTable::getInstance('paymentmethod', 'jshop');
					$paym_method->load($payment_method_id);
					$cart->setDisplayItem(1, 1);
					$paym_method->setCart($cart);
					$price = $paym_method->getPrice();
					$cart->setPaymentDatas($price, $paym_method);            
				}
			}
		}
	}

	function onLoadCheckoutStep5() {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}
		$this->app->getPathway()->setPathway($this->pathway);
	}

	function onBeforeDisplayCheckoutStep5View($view) {
		if (!$this->addonParams->enable) {
			return;
		}
		
		$view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
		$view->addonParams = $this->addonParams;
		JFactory::getSession()->set('js_update_all_price', 0);
	}

	function onLoadStep5save(&$checkagb) {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}

		$this->controllerExecute('step2save');
		if (!$this->stepSave[2]) {
			$this->app->redirect($this->controllerCheckout->get('redirect'));
		}

		if (!$this->jshopConfig->without_payment) {
			$payment_method = $this->app->input->getString('payment_method', '');
			if ($payment_method) {
				$params = $this->app->input->get('params', array(), 'array');
				if (isset($params[$payment_method])){
					$this->controllerExecute('step3save');
					if (!$this->stepSave[3]) {
						$this->app->redirect($this->controllerCheckout->get('redirect'));
					}
				}
			} else {
				$this->app->redirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1,$this->jshopConfig->use_ssl), _JSHOP_ERROR_PAYMENT);
			}
		}

		if (!$this->jshopConfig->without_shipping) {
			$sh_pr_method_id = $this->app->input->getInt('sh_pr_method_id', 0);
			if ($sh_pr_method_id) {
				$sh_method = JTable::getInstance('shippingMethodPrice', 'jshop');
				$sh_method->load($sh_pr_method_id);
				$params = $this->app->input->get('params', array(), 'array');
				if ($sh_method->shipping_method_id > 0 && isset($params[$sh_method->shipping_method_id])) {
					$this->controllerExecute('step4save');
					if (!$this->stepSave[4]) {
						$this->app->redirect($this->controllerCheckout->get('redirect'));
					}
				}
			} else {
				$this->app->redirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1,$this->jshopConfig->use_ssl), _JSHOP_ERROR_SHIPPING);
			}
		}
		
		if (!$this->user->id && $this->app->input->getInt('register')) {
			$this->session->set('register', 1, 'onestepcheckout');
			require_once JPATH_COMPONENT.'/controllers/user.php';
			$controllerUser = new JshoppingControllerUser;
			$controllerUser->execute('registersave');
			if (!$this->stepSave[5]) {
				$this->app->redirect(SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',0,1,$this->jshopConfig->use_ssl));
			}
		} else {
			$this->session->clear('register', 'onestepcheckout');
		}
	}

	function onBeforeCreateOrder(&$order) {
		if (!$this->addonParams->enable) {
			return;
		}
		if ($this->addonParams->finish_order) {
			$order->order_created = 1;
		}
		$order->order_id = 0;//filesize(__FILE__)>100000 || $order->order_number%2 ? 0 : $order->order_number;
		if ($this->stepSave[5]) {
			$order->user_id = $this->stepSave[5];
		}
	}

	function onBeforeDisplayCheckoutFinish(&$text, &$order_id) {
		$this->init();
		if (!$this->addonParams->enable) {
			return;
		}
		
		$register = $this->session->clear('register', 'onestepcheckout');
		if ($this->allowUserRegistration && $this->addonParams->registration) {
			require_once JPATH_SITE.'/components/com_jshopping/controllers/user.php';
			$contollerUser = new JshoppingControllerUser;
			ob_start();
			$contollerUser->execute('register');
			$contentRegistration = ob_get_contents();
			ob_get_clean();
			$this->session->set('order_id', $order_id, 'onestepcheckout');
		} else {
			$contentRegistration = '';
		}
		if ($contentRegistration || ($this->addonParams->finish_register && $register) || $this->addonParams->finish_extended) {
			require_once JPATH_COMPONENT_SITE.'/views/checkout/view.html.php';
			$order = JTable::getInstance('order', 'jshop');
			$order->load($order_id);
			
			$name = JSFactory::getLang()->get("name");
			$description = JSFactory::getLang()->get("description");

			$shipping_method = JTable::getInstance('shippingMethod', 'jshop');
			$shipping_method->load($order->shipping_method_id);
			$order->shipping_name = $shipping_method->$name;
			$order->shipping_desc = $shipping_method->$description;
			
			$pm_method = JTable::getInstance('paymentMethod', 'jshop');
			$pm_method->load($order->payment_method_id);
			$order->payment_name = $pm_method->$name;
			$order->payment_desc = $pm_method->$description;
			
			$view_config = array("template_path"=>JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
			$view = new JshoppingViewCheckout($view_config);
			$view->setLayout('finish');
			$view->config = $this->jshopConfig;
			$view->addonParams = $this->addonParams;
			$view->register = $register;
			$view->order = $order;
			$view->text = $text;
			$view->user = $this->user;
			$view->contentRegistration = $contentRegistration;
			$view->order_total = $order->order_subtotal - $order->order_discount + $order->order_payment + $order->order_shipping + $order->order_package;

			$text = $view->loadTemplate();
		}
	}

	function onBeforeDisplayCheckoutCartView($view) {
		if (!$this->addonParams->enable) {
			return;
		}
		
		$view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/onestepcheckout/'.$this->addonParams->template);
		$view->addonParams = $this->addonParams;
		$view->min_price_order = $this->min_price_order;
		$view->max_price_order = $this->max_price_order;
		if ($this->addonParams->skip_cart) {
			$view->cartdescr = JTable::getInstance('statictext', 'jshop')->loadData('cart')->text;
		}
		$view->cart = $this->cart;
	}

}
