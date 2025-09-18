<?php

defined('_JEXEC') or die;

jimport('joomla.environment.browser');

class plgCaptchaKcaptcha extends JPlugin
{

	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Initialise the captcha
	 *
	 * @param	string	$id	The id of the field.
	 *
	 * @return	Boolean	True on success, false otherwise
	 *
	 * @since  2.5
	 */
	public function onInit($id)
	{
		
		require_once('lib.php');
		return true;
	}

	/**
	 * Gets the challenge HTML
	 *
	 * @return  string  The HTML to be embedded in the form.
	 *
	 * @since  2.5
	 */
	public function onDisplay($name, $id, $class)
	{
		return '<div style="display: flex;justify-content: flex-start;"><string style="width:115px">Введите код</string><input style="width:'.$this->params->get('width').'px; height: 20px;" class="required" type="text" name="kcaptcha_value" value=""/>&nbsp;&nbsp;<img src="'.JUri::base().'plugins/captcha/kcaptcha/img.php" alt="captcha" id="captchaimg" /><br/><a href="javascript:;" onclick="document.getElementById(\'captchaimg\').src=\''.JURI::base().'plugins/captcha/kcaptcha/img.php?\' + new String(Math.random());">'.JText::_('PLG_KCAPTCHA_REFRESH').'</a><br/></div>
			';
	}

	/**
	  * Calls an HTTP POST function to verify if the user's guess was correct
	  *
	  * @return  True if the answer is correct, false otherwise
	  *
	  * @since  2.5
	  */
	public function onCheckAnswer($code)
	{
		// Initialise variables
		$sess = JFactory::getSession();
		$value = $sess->get('captcha_keystring','empty_string');
		$sess->set('captcha_keystring','empty_string');
		$challenge	= JRequest::getString('kcaptcha_value', '');

		if (trim($challenge) === $value) {
				return true;
		}
		else
		{
			$this->_subject->setError(JText::_('PLG_KCAPTCHA_ERROR'));
			return false;
		}
	}
}
