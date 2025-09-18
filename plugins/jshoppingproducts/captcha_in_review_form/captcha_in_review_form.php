<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Nevigen.com
* @website http://nevigen.com/
* @email support@nevigen.com
* @copyright Copyright © Nevigen.com. All rights reserved.
* @license Proprietary. Copyrighted Commercial Software
**/

defined('_JEXEC') or die;

class plgJshoppingProductsCaptcha_In_Review_Form extends JPlugin {

    function onBeforeDisplayProductView(&$view){
		if (JFactory::getUser()->id) {
			return;
		}
		$captcha_name = JFactory::getApplication()->getParams()->get('captcha', JFactory::getConfig()->get('captcha'));
		if ($captcha_name) {
			$captcha = JCaptcha::getInstance($captcha_name, array('namespace' => 'jshoppingreview'));
			if (!isset($view->_tmp_product_review_before_submit)) {
				$view->_tmp_product_review_before_submit = '';
			}
			$view->_tmp_product_review_before_submit .= '<tr>
					<td></td>
					<td>'.
						$captcha->display('jshoppingreview','jshoppingreview')
					.'</td>
				</tr>';
		}
	}

    function onBeforeSaveReview(&$review){
		if (JFactory::getUser()->id) {
			return;
		}
        $app = JFactory::getApplication();
		$captcha_name = $app->getParams()->get('captcha', JFactory::getConfig()->get('captcha'));
		if ($captcha_name) {
			$captcha = JCaptcha::getInstance($captcha_name, array('namespace' => 'jshoppingreview'));
			if (!$captcha->checkAnswer('')) {
				$app->redirect($app->input->getString('back_link'), 'Captcha error', 'error');
				die;
			}
		}
	}
}

