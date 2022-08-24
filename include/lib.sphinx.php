<?php

require_once ('sphinx/pluginiterator.php');
require_once ('sphinx/iplugin.php');

class Sphinx {

	const PT_NAMED = 0x0001; // Индекс с одним источником без привязки к разделам
	const PT_NAMED_REF = 0x0002; // Индекс с одним источником c привязкой к разделам
	const PT_SINGLE_REF = 0x0004; // Индекс с множеством источников с привязкой к разделам

	private static $_pluginsList = null;
	private static $_pluginsCache = array();

	/**
     * Возвращает список плагинов
     * @return array
     */
	public static function GetPluginsList() {
		global $CONFIG;

		if (self::$_pluginsList !== null)
			return self::$_pluginsList;

		self::$_pluginsList = array();

		foreach (glob(dirname(__FILE__)."/sphinx/plugins/*.php") as $plugin) {
			$plugin = basename($plugin, '.php');
			self::$_pluginsList[strtolower($plugin)] = strtolower($plugin);
		}

		return self::$_pluginsList;
	}

	/**
     * Возвращает итератор плагинов
     * @return PSphinxPluginIterator
     */
	public static function GetPluginsIterator() {
		if (self::$_pluginsList === null)
			self::GetPluginsList();

		return new PSphinxPluginIterator(self::$_pluginsList);
	}

	/**
     * Возвращает экземпляр плагина
	 * @param $name string
     * @return ISphinxPlugin
	 * @exception InvalidArgumentBTException
     */
	public static function GetPlugin($name) {
		$name = strtolower($name);

		if (isset(self::$_pluginsCache[$name]))
			return self::$_pluginsCache[$name];

		include_once 'sphinx/plugins/'.$name.'.php';

		$class = 'SphinxPlugin_'.$name;
		if (!class_exists($class))
			throw new InvalidArgumentBTException('Plugin "'.$name.'" not found');

		self::$_pluginsCache[$name] = new $class;
		return self::$_pluginsCache[$name];
	}

	/**
     * Возвращает конфигуратора для работы с кофигами sphinx
	 * @param $name string
     * @return SphinxConfigurator
	 * @exception InvalidArgumentBTException
     */
	public static function GetConfigurator() {

		include_once 'sphinx/configurator.php';

		if (!class_exists('SphinxConfigurator'))
			throw new InvalidArgumentBTException('Cant load sphinx configurator class: '.$err['message']);

		return SphinxConfigurator::getInstance();
	}
}

abstract class SphinxPluginTrait implements ISphinxPlugin{

	protected $_type = null;

	protected $_group = 0;

	protected $_rights = array();

	protected $_rules = array();

	private $_name = null;
	private $_indexList = null;

	function __construct() {
		
	}

	public function GetObjectData(array $attr) {
		return null;
	}

	final function __get($name) {

		$name = strtolower($name);
		switch($name) {
			case 'indexlist':
				if ($this->_indexList !== null)
					return $this->_indexList;

				$this->_indexList = array();
				if (is_array($this->Rules['index'])) {
					foreach($this->Rules['index'] as $index => $v) {
						list($index, ) = explode(':', $index);

						$this->_indexList[] = trim($index);
					}
				}

				return $this->_indexList;
			break;

			case 'name':
				if ($this->_name !== null)
					return $this->_name;

				$this->_name = strtolower(get_class($this));
				$this->_name = substr($this->_name, 13);

				return $this->_name;
			break;

			case 'rules':
				return $this->_rules;
			break;

			case 'type':
				return $this->_type;
			break;

			case 'group':
				return $this->_group;
			break;

			case 'module':
				return $this->_module;
			break;

			case 'rights':
				return $this->_rights;
			break;
		}

		return null;
	}

	function __desrtuct() {

	}
}