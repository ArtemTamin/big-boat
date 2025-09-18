<?php

/**
 * @copyright	Copyright (C) 2012 Cédric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Beautiful CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (dirname(__FILE__) . '/helper.php');

$moduleck = ModbeautifulckHelper::GetModule($params);
if (!$moduleck->html)
    return false;

// retrieve parameters from the module
$textvalue = $params->get('textvalue');
$theme = $params->get('theme', 'default') != '-1' ? $params->get('theme', 'default') : '';
$colorvariation = $params->get('colorvariation', 'pink');
$menuID = $params->get('tag_id', 'beautifulck' . $module->id);
$bannericon = $params->get('icon', '-1');

// get the main module title
if ($params->get('textfrom', 'textperso') == 'textmodule') {
    $textvalue = $moduleck->title;
}

// load the css in the page
$document = JFactory::getDocument();
if ($theme) $document->addStylesheet(JURI::base() . 'modules/mod_beautifulck/themes/' . $theme . '/mod_beautifulck.css');
if ($textvalue) {
    $gfonturl = str_replace(" ","+",$params->get('textgfont', 'Droid Sans'));
    $document->addStylesheet('http://fonts.googleapis.com/css?family='.$gfonturl);
}

if ($params->get('usestyles') == 1) {
    $modulecss = ModbeautifulckHelper::createCss($params, 'module');
    $document->addStyleDeclaration("#" . $menuID . " { " . implode('', $modulecss) . " } ");
}

$class_sfx = htmlspecialchars($params->get('class_sfx'));

if ($moduleck->html) {
    require JModuleHelper::getLayoutPath('mod_beautifulck', $params->get('layout', 'default'));
}