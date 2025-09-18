<?php

define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../' )); 
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' ); 
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
			jimport('joomla.plugin.plugin');
			$plugin = & JPluginHelper::getPlugin('captcha', 'kcaptcha');

			// Load plugin params info
			$params = new JRegistry($plugin->params);
		$params->set('alphabet',"0123456789abcdefghijklmnopqrstuvwxyz"); # do not change without changing font files!

		# symbols used to draw CAPTCHA
		//$allowed_symbols = "0123456789"; #digits
		//$allowed_symbols = "23456789abcdegkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)
		$allowed_symbols = "23456789abcdegikpqsvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)

		# folder with fonts
		$params->set('fontsdir','fonts');	

		# CAPTCHA string length
		$params->set('length', mt_rand($params->get('min_length',5),$params->get('max_length',7))); # random 5 or 6 or 7
		//$length = 6;

		# CAPTCHA image size (you do not need to change it, this parameters is optimal)
		$width = 160;
		$height = 80;

		# symbol's vertical fluctuation amplitude
		$fluctuation_amplitude = 8;

		#noise
		//$white_noise_density=0; // no white noise
		$white_noise_density=1/6;
		//$black_noise_density=0; // no black noise
		$black_noise_density=1/30;

		# increase safety by prevention of spaces between symbols
		$no_spaces = true;

		# show credits
		$show_credits = true; # set to false to remove credits line. Credits adds 12 pixels to image height
		$credits = 'www.captcha.ru'; # if empty, HTTP_HOST will be shown

		# CAPTCHA image colors (RGB, 0-255)
		//$foreground_color = array(0, 0, 0);
		//$background_color = array(220, 230, 255);
		$params->set('foreground_color',array(mt_rand(0,80), mt_rand(0,80), mt_rand(0,80)));
		$params->set('background_color',array(mt_rand(220,255), mt_rand(220,255), mt_rand(220,255)));

		# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
		$params->set('jpeg_quality',90);

include('lib.php');
$captcha = new KCAPTCHA($params->toArray());
$sess = JFactory::getSession();
$sess->set('captcha_keystring',$captcha->getKeyString());



?>
