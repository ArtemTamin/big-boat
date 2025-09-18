<?php
/**
 * @package         ReReplacer
 * @version         7.2.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once JPATH_LIBRARIES . '/regularlabs/helpers/functions.php';
require_once JPATH_LIBRARIES . '/regularlabs/helpers/parameters.php';
require_once JPATH_LIBRARIES . '/regularlabs/helpers/text.php';

class PlgSystemReReplacerHelperItems
{
	var $helpers       = array();
	var $items         = array();
	var $sourcerer_tag = '';

	public function __construct()
	{
		$sourcerer_params = RLParameters::getInstance()->getPluginParams('sourcerer');
		if (!empty($sourcerer_params) && isset($sourcerer_params->syntax_word))
		{
			$this->sourcerer_tag = trim($sourcerer_params->syntax_word);
		}

	}

	public function getItemList($area = 'articles')
	{
		if (isset($this->items[$area]))
		{
			return $this->items[$area];
		}

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('r.*')
			->from('#__rereplacer AS r')
			->where('r.published = 1');
		$where = 'r.area = ' . $db->quote($area);
		$query->where('(' . $where . ')')
			->order('r.ordering, r.id');
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		$items = array();

		if (empty($rows))
		{
			$this->items[$area] = $items;

			return $this->items[$area];
		}

		foreach ($rows as $row)
		{
			if (!$item = $this->getItem($row, $area))
			{
				continue;
			}

			if (is_array($item))
			{
				$items = array_merge($items, $item);
				continue;
			}

			$items[] = $item;
		}

		if ($area != 'articles')
		{
			$this->filterItemList($items);
		}

		$this->items[$area] = $items;

		return $this->items[$area];
	}

	private function getItem($row, $area = 'articles')
	{
		if (!((substr($row->params, 0, 1) != '{') && (substr($row->params, -1, 1) != '}')))
		{
			$row->params = RLText::html_entity_decoder($row->params);
		}

		$item = RLParameters::getInstance()->getParams($row->params, JPATH_ADMINISTRATOR . '/components/com_rereplacer/item_params.xml');

		unset($row->params);
		foreach ($row as $key => $param)
		{
			$item->{$key} = $param;
		}


		if (!$this->itemPassChecks($item, $area))
		{
			return false;
		}

		if (strlen($item->search) < 3)
		{
			return false;
		}

		$this->prepareString($item->search);
		$this->prepareReplaceString($item->replace);

		return $item;
	}

	/* <<< [PRO] <<< */
	private function getItemsFromXml($item, $area)
	{
		if (empty($item->xml))
		{
			return false;
		}

		jimport('joomla.filesystem.file');

		$file = str_replace('//', '/', JPATH_SITE . '/' . str_replace('\\', '/', $item->xml));
		if (!JFile::exists($file))
		{
			return false;
		}

		$xml_data = file_get_contents($file);

		// prevent html tags in strings to mess up xml structure
		$xml_data = str_replace(
			array('<search>', '<replace>', '</search>', '</replace>'),
			array('<search><![CDATA[', '<replace><![CDATA[', ']]></search>', ']]></replace>'),
			$xml_data
		);

		if (strpos($xml_data, '<param name="other_replace">') !== false)
		{
			$xml_data = preg_replace('#(<param name="other_replace">)(.*?)(</param>)#si', '\1<![CDATA[\2]]>\3', $xml_data);
		}

		$xml_data = str_replace(
			array('<![CDATA[<![CDATA[', ']]>]]></'),
			array('<![CDATA[', ']]></'),
			$xml_data
		);

		$func = new RLFunctions;

		$xml = $func->xmlToObject($xml_data, 'items');
		if (!isset($xml->item))
		{
			return false;
		}

		if (!is_array($xml->item))
		{
			$xml->item = array($xml->item);
		}

		$items = array();

		foreach ($xml->item as $data)
		{
			$subitem = $this->getItemFromXmlData($item, $data, $area);

			if (empty($subitem))
			{
				continue;
			}

			$items[] = $subitem;
		}

		return $items;
	}

	private function getItemFromXmlData($item, $xml_data, $area)
	{
		if (!isset($xml_data->search))
		{
			return false;
		}

		$item = clone $item;

		$item->search  = $xml_data->search;
		$item->replace = isset($xml_data->replace) ? $xml_data->replace : '';

		$this->prepareString($item->search);
		$this->prepareReplaceString($item->replace);

		$xml_data->param = isset($xml_data->param) ? $xml_data->param : array();

		if (isset($xml_data->params->param))
		{
			$xml_data->param = $xml_data->params->param;
			unset($xml_data->params);
		}

		if (!is_array($xml_data->param))
		{
			$xml_data->param = array($xml_data->param);
		}

		foreach ($xml_data->param as $param)
		{
			if (isset($param->{"@attributes"}) && isset($param->{"@attributes"}->name) && isset($param->{"@attributes"}->value))
			{
				$param = $param->{"@attributes"};
			}

			if (!isset($param->name) || !isset($param->value))
			{
				continue;
			}

			$item->{$param->name} = $param->value;
		}

		if (!$this->itemPassChecks($item, $area))
		{
			return false;
		}

		return $item;
	}

	/* <<< [PRO] <<< */

	private function itemPassChecks($item, $area)
	{
		if ($item->area != $area)
		{
			return false;
		}

		if (empty($item->search))
		{
			return false;
		}

		if ((RLFunctions::isFeed() && !$item->enable_in_feeds)
			|| (JFactory::getDocument()->getType() != 'feed' && $item->enable_in_feeds == 2)
		)
		{
			return false;
		}

		return true;
	}

	private function prepareString(&$string)
	{
		if (!is_string($string))
		{
			$string = '';

			return;
		}
	}

	private function prepareReplaceString(&$string)
	{
		$this->prepareString($string);

		if (!$this->sourcerer_tag || $string == '' || strpos($string, '{' . $this->sourcerer_tag . '}') === false)
		{
			return;
		}

		// fix usage of non-protected {source} tags
		$string = str_replace('{' . $this->sourcerer_tag . '}', '{' . $this->sourcerer_tag . ' 0}', $string);
	}

	public function filterItemList(&$items, $article = 0)
	{
		foreach ($items as $key => &$item)
		{
			if (
				(JFactory::getApplication()->isAdmin() && $item->enable_in_admin == 0)
				|| (JFactory::getApplication()->isSite() && $item->enable_in_admin == 2)
			)
			{
				unset($items[$key]);
				continue;
			}


			if (!$item)
			{
				unset($items[$key]);
			}
		}
	}
}
