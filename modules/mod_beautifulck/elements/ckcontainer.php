<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldCkcontainer extends JFormField {

    protected $type = 'ckcontainer';

    protected function getInput() {
		$end = $this->element['end'];
		$styles = $this->element['styles'];
		$background = $this->element['background'] ? 'background-image: url('.$this->getPathToImages() . '/images/' . $this->element['background'].');' : '';
		$tag = $this->element['tag'];
		if ($end == '1') {
			$html = '</'.$tag.'></li>';
		} else {
			$html = '<'.$tag.' style="'.$background.$styles.'" >';
		}
		// var_dump($html);
        return $html;
    }

    protected function getLabel() {
        return '';
    }
	
	protected function getPathToImages() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoimages;
    }

}

