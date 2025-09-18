<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
class plgJshoppingProductsDetailtabs extends JPlugin
{
    public function __construct(&$subject, $config = array())
    {
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'plugins/jshoppingproducts/detailtabs/style.css');
        $this->loadLanguage('detailtabs', dirname(__FILE__));
        parent::__construct($subject, $config);
    }
    
    public function onBeforeDisplayProduct(&$product, &$view, &$product_images, &$product_videos, &$product_demofiles)
    {
        $view->addTemplatePath(JPATH_COMPONENT.'/templates/addons/detailtabs/');
        $view->setLayout('product_detailtabs');
    }
}
?>