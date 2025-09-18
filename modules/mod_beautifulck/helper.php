<?php

/**
 * @copyright	Copyright (C) 2012 Cédric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Beautiful CK
 * @license		GNU/GPL
 * */

// no direct access
defined('_JEXEC') or die('Restricted access');

class ModbeautifulckHelper {

    static function GetModule(&$params) {
        // Initialise variables.
        $list = array();
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        $moduleck = new stdClass();

        // If no active menu, use default
        $active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();

        $path = $active->tree;
        $start = (int) $params->get('startLevel');
        $end = (int) $params->get('endLevel');
        $showAll = 1;
        $maxdepth = $params->get('maxdepth');
		
		
		$moduleid = (int) $params->get('moduleid','0');
		
		$modulesList = self::CreateModulesList();
        $moduleck->title = $modulesList[$moduleid]->title;
        $moduleck->html = self::GenModuleById($moduleid, $params, $modulesList);
		return $moduleck;
    }

    static function GenModuleById($title, &$params, &$modulesList) {
        $attribs['style'] = 'none';

        if (!isset($modulesList[$title])) return "<p>No module found !</p>";
		$modtitle = $modulesList[$title]->title;
        $modname = $modulesList[$title]->module;

        // load the module
        if (JModuleHelper::isEnabled($modname)) {
            $module = JModuleHelper::getModule($modname, $modtitle);
            if ($module) {
				return JModuleHelper::renderModule($module, $attribs);
			} 
        }
		
		return "<p>No module found !</p>";
    }

    static function CreateModulesList() {
        $db = JFactory::getDBO();
        $query = "
			SELECT *
			FROM #__modules
			WHERE published=1
			ORDER BY id
			;";
        $db->setQuery($query);
        $modulesList = $db->loadObjectList('id');
        return $modulesList;
    }
	
	static function createCss($params, $prefix = 'menu') {

		$css = Array();
		$css['paddingtop'] = ($params->get($prefix.'paddingtop')) ? 'padding-top: ' . $params->get($prefix.'paddingtop', '0').'px;' : '';
                $css['paddingright'] = ($params->get($prefix.'paddingright')) ? 'padding-right: ' . $params->get($prefix.'paddingright', '0').'px;' : '';
                $css['paddingbottom'] = ($params->get($prefix.'paddingbottom') ) ? 'padding-bottom: ' . $params->get($prefix.'paddingbottom', '0').'px;' : '';
                $css['paddingleft'] = ($params->get($prefix.'paddingleft')) ? 'padding-left: ' . $params->get($prefix.'paddingleft', '0').'px;' : '';
                
		$css['margintop'] = ($params->get($prefix.'margintop')) ? 'margin-top: ' . $params->get($prefix.'margintop', '0').'px;' : '';
                $css['marginright'] = ($params->get($prefix.'marginright')) ? 'margin-right: ' . $params->get($prefix.'marginright', '0').'px;' : '';
                $css['marginbottom'] = ($params->get($prefix.'marginbottom')) ? 'margin-bottom: ' . $params->get($prefix.'marginbottom', '0').'px;' : '';
                $css['marginleft'] = ($params->get($prefix.'marginleft')) ? 'margin-left: ' . $params->get($prefix.'marginleft', '0').'px;' : '';
		$css['background'] = ($params->get($prefix.'bgcolor1') AND $params->get($prefix.'usebackground')) ? 'background-color: ' . $params->get($prefix.'bgcolor1').';' : '';
                $css['background'] .= ($params->get($prefix.'bgimage') AND $params->get($prefix.'usebackground')) ? 'background-image: url("' . JURI::ROOT() . $params->get($prefix.'bgimage').'");' : '';
		$css['background'] .= ($params->get($prefix.'bgimage') AND $params->get($prefix.'usebackground')) ? 'background-repeat: ' . $params->get($prefix.'bgimagerepeat').';' : '';
                $css['background'] .= ($params->get($prefix.'bgimage') AND $params->get($prefix.'usebackground')) ? 'background-position: ' . $params->get($prefix.'bgpositionx').' ' . $params->get($prefix.'bgpositiony').';' : '';
		$css['gradient'] = ($css['background'] AND $params->get($prefix.'bgcolor2') AND $params->get($prefix.'usegradient')) ? 
			"background: -moz-linear-gradient(top,  " . $params->get($prefix.'bgcolor1', '#f0f0f0') . " 0%, " . $params->get($prefix.'bgcolor2', '#e3e3e3') . " 100%);"
			. "background: -webkit-gradient(linear, left top, left bottom, color-stop(0%," . $params->get($prefix.'bgcolor1', '#f0f0f0') . "), color-stop(100%," . $params->get($prefix.'bgcolor2', '#e3e3e3') . ")); "
			. "background: -webkit-linear-gradient(top,  " . $params->get($prefix.'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix.'bgcolor2', '#e3e3e3') . " 100%);"
			. "background: -o-linear-gradient(top,  " . $params->get($prefix.'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix.'bgcolor2', '#e3e3e3') . " 100%);"
			. "background: -ms-linear-gradient(top,  " . $params->get($prefix.'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix.'bgcolor2', '#e3e3e3') . " 100%);"
			. "background: linear-gradient(top,  " . $params->get($prefix.'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix.'bgcolor2', '#e3e3e3') . " 100%); "
			. "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $params->get($prefix.'bgcolor1', '#f0f0f0') . "', endColorstr='" . $params->get($prefix.'bgcolor2', '#e3e3e3') . "',GradientType=0 );"
			: '';	
		$css['borderradius'] = ($params->get($prefix.'useroundedcorners')) ? 
			'-moz-border-radius: '.$params->get($prefix.'roundedcornerstl', '0').'px '.$params->get($prefix.'roundedcornerstr', '0').'px '.$params->get($prefix.'roundedcornersbr', '0').'px '.$params->get($prefix.'roundedcornersbl', '0').'px;'
			.'-webkit-border-radius: '.$params->get($prefix.'roundedcornerstl', '0').'px '.$params->get($prefix.'roundedcornerstr', '0').'px '.$params->get($prefix.'roundedcornersbr', '0').'px '.$params->get($prefix.'roundedcornersbl', '0').'px;'
			.'border-radius: '.$params->get($prefix.'roundedcornerstl', '0').'px '.$params->get($prefix.'roundedcornerstr', '0').'px '.$params->get($prefix.'roundedcornersbr', '0').'px '.$params->get($prefix.'roundedcornersbl', '0').'px;'
			: '' ;
		$shadowinset = $params->get($prefix.'shadowinset', 0) ? 'inset ' : '';
		$css['shadow'] = ($params->get($prefix.'shadowcolor') AND $params->get($prefix.'shadowblur') AND $params->get($prefix.'useshadow')) ?
			'-moz-box-shadow: '.$shadowinset.$params->get($prefix.'shadowoffsetx', '0').'px '.$params->get($prefix.'shadowoffsety', '0').'px '.$params->get($prefix.'shadowblur', '').'px '.$params->get($prefix.'shadowspread', '0').'px '.$params->get($prefix.'shadowcolor', '').';'
			.'-webkit-box-shadow: '.$shadowinset.$params->get($prefix.'shadowoffsetx', '0').'px '.$params->get($prefix.'shadowoffsety', '0').'px '.$params->get($prefix.'shadowblur', '').'px '.$params->get($prefix.'shadowspread', '0').'px '.$params->get($prefix.'shadowcolor', '').';'
			.'box-shadow: '.$shadowinset.$params->get($prefix.'shadowoffsetx', '0').'px '.$params->get($prefix.'shadowoffsety', '0').'px '.$params->get($prefix.'shadowblur', '').'px '.$params->get($prefix.'shadowspread', '0').'px '.$params->get($prefix.'shadowcolor', '').';'
			: '';
		$css['border'] = ($params->get($prefix.'bordercolor') AND $params->get($prefix.'borderwidth') AND $params->get($prefix.'useborder')) ?
			'border: '.$params->get($prefix.'bordercolor', '#efefef').' '.$params->get($prefix.'borderwidth', '1').'px solid;'
			: '';
		$css['fontsize'] = ($params->get($prefix.'usefont') AND $params->get($prefix.'fontsize')) ?
			'font-size: '.$params->get($prefix.'fontsize').';'
			: '';
		$css['fontcolor'] = ($params->get($prefix.'usefont') AND $params->get($prefix.'fontcolor')) ?
			'color: '.$params->get($prefix.'fontcolor').';'
			: '';
		return $css;
	}

}