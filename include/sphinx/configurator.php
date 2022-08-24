<?

class SphinxConfigurator {

	const VAR_DIR = '/var/lib/sphinx';
	const CONF_DIR = '/etc/sphinx';

	private $_db = null;
	private $_tables = array(
	);

	/**
	 *
     */
	public function __construct() {}

	/**
	 *
     */
	public function Init($db, array $tables) {

		$this->_db = $db;
		$this->_tables = $tables;
	}

	/*
	 * Возвращает экземпляр класса
	 * @exception RuntimeBTException
     * @return SphinxConfigurator
	 */
	static function &getInstance () {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }

        return $instance;
    }

	/*
	 * Возвращает список доступных индексов
	 * @param $params array
	 * @return array
	 */
	public function GetIndexList($params = array()) {

		$sql = 'SELECT `Index`, `SectionID` FROM '.$this->_tables['index_list'].' WHERE ';
		$sql.= ' RegionID != 0';

		if ( isset($params['RegionID']) && is_numeric($params['RegionID']) )
			$sql.= ' AND RegionID ='.(int) $params['RegionID'];

		if ( isset($params['SiteID']) && is_numeric($params['SiteID']) )
			$sql.= ' AND SiteID ='.(int) $params['SiteID'];

		if ( isset($params['SectionID']) && is_numeric($params['SectionID']) )
			$sql.= ' AND SectionID ='.(int) $params['SectionID'];

		if ( isset($params['Group']) && is_numeric($params['Group']) && $params['Group'] > 0 )
			$sql.= ' AND `Group` ='.(int) $params['Group'];

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return array();

		$indexList = array();
		while (false != ($row = $res->fetch_row())) {
			$n = STreeMgr::GetNodeByID($row[1]);
			if ($n === null || (is_array($params['denyModules']) && in_array($n->Module, $params['denyModules'])))
				continue ;

			$indexList[$row[0]] = '';
		}
		return array_keys($indexList);
	}

	/*
	 * Просматривает список индексов на предмет изменений
	 * @exception InvalidArgumentBTException
	 * @exception RuntimeBTException
     * @return array
	 */
	public function checkIndex() {

		$oldIndex = array(); // Список устаревших/удаленных индексов
		$newIndex = array(); // Список добавленых индексов
		$refIndex2Plugin = array(); // Связи индексов и плагина
		$refGroup2Plugin = array(); // Связи индекса с группой плагина
		$changeList = array(); // Список плагинов в индексах которых произошли изменения

		$pluginsList = Sphinx::GetPluginsIterator();
		foreach($pluginsList as $plugin) {
	
			if (!empty($plugin->indexList))
				continue ;

			$pluginIndex = array();
			$savedIndex = array();

			// Обработка индексов со смножественными связями
			if ($plugin->Type == Sphinx::PT_SINGLE_REF || $plugin->Type == Sphinx::PT_NAMED_REF) {
				
				$it = STreeMgr::Iterator(array(
					'type'		=> 2,
					'visible'	=> 1,
					'deleted'	=> 0,
					'module'	=> $plugin->Module
				));

				// Создание доступного (на текущий момент) списка индексов
				foreach($it as $node)  {

					if ($node->Regions <= 0)
						continue ;

					// Проверяем права на участие в поиске
					if ($this->_checkRights($node, $plugin->Rights) !== true)
						continue ;

					foreach($plugin->indexList as $index) {
						$pluginIndex[$index][] = $node->ID;
						$refIndex2Plugin[$index] = $plugin->Name;
						$refGroup2Plugin[$index] = $plugin->Group;
					}
				}

				// Загрузка рабочего списка индексов
				$sql = 'SELECT `SectionID`, `Index` FROM '.$this->_tables['index_list'];
				$sql.= ' WHERE `Plugin` = \''.$plugin->Name.'\'';
				$res = $this->_db->query($sql);
				while(false != ($row = $res->fetch_row())) {
					$savedIndex[$row[1]][] = $row[0];
					$refIndex2Plugin[$row[1]] = $plugin->Name;
					$refGroup2Plugin[$row[1]] = $plugin->Group;
				}

				// Поиск новых индексов
				foreach($pluginIndex as $index => $sections) {
					if (!isset($savedIndex[$index]))
						$newIndex[$index] = $sections;
					else {
						$diff = array_diff($sections, $savedIndex[$index]);
						if (is_array($diff) && sizeof($diff)) {
							$newIndex[$index] = $diff;
						}

						$diff = array_diff($savedIndex[$index], $sections);
						if (is_array($diff) && sizeof($diff)) {
							$oldIndex[$index] = $diff;
						}
					}
				}

				// Поиск устаревших индексов
				foreach($savedIndex as $index => $sections) {
					if (!isset($pluginIndex[$index]))
						$oldIndex[$index] = null;
				}
			} else 
			// Обработка индексов без связей
			if ($plugin->Type == Sphinx::PT_NAMED) {

				// Создание доступного (на текущий момент) списка индексов
				foreach($plugin->indexList as $index) {
					$pluginIndex[] = $index;
					$refIndex2Plugin[$index] = $plugin->Name;
					$refGroup2Plugin[$index] = $plugin->Group;
				}

				// Загрузка рабочего списка индексов
				$sql = 'SELECT `Index` FROM '.$this->_tables['index_list'];
				$sql.= ' WHERE `Plugin` = \''.$plugin->Name.'\'';
				$res = $this->_db->query($sql);
				while(false != ($row = $res->fetch_row())) {
					$savedIndex[] = $row[0];
					$refIndex2Plugin[$row[0]] = $plugin->Name;
					$refGroup2Plugin[$row[0]] = $plugin->Group;
				}

				// Поиск новых индексов
				$diff = array_diff($pluginIndex, $savedIndex);
				if (is_array($diff) && sizeof($diff)) {
					foreach($diff as $index)
						$newIndex[$index] = null;
				}

				// Поиск устаревших индексов
				$diff = array_diff($savedIndex, $pluginIndex);
				if (is_array($diff) && sizeof($diff)) {
					foreach($diff as $index)
						$oldIndex[$index] = null;
				}
			}
		}

		// Обновление списка доступных для использования индексов
		foreach($newIndex as $index => $sections) {
			$changeList[] = $refIndex2Plugin[$index];

			if (!is_array($sections)) {
				$sql = 'REPLACE INTO '.$this->_tables['index_list'];
				$sql.= ' SET `Index` = \''.$index.'\'';
				$sql.= ' ,`SectionID` = 0';
				$sql.= ' ,`RegionID` = 0';
				$sql.= ' ,`SiteID` = 0';
				$sql.= ' ,`Group` = \''.$refGroup2Plugin[$index].'\'';
				$sql.= ' ,`Plugin` = \''.$refIndex2Plugin[$index].'\'';

				$this->_db->query($sql);
			} else {
				foreach($sections as $section) {
					if (null === ($section = STreeMgr::GetNodeByID($section)))
						continue ;

					$sql = 'REPLACE INTO '.$this->_tables['index_list'];
					$sql.= ' SET `Index` = \''.$index.'\'';
					$sql.= ' ,`SectionID` = '.$section->ID;
					$sql.= ' ,`RegionID` = '.$section->Regions;
					$sql.= ' ,`SiteID` = '.$section->ParentID;
					$sql.= ' ,`Group` = \''.$refGroup2Plugin[$index].'\'';
					$sql.= ' ,`Plugin` = \''.$refIndex2Plugin[$index].'\'';

					$this->_db->query($sql);
				}
			}
		}

		foreach($oldIndex as $index => $sections) {
			$changeList[] = $refIndex2Plugin[$index];

			if (!is_array($sections)) {
				$sql = 'DELETE FROM '.$this->_tables['index_list'];
				$sql.= ' WHERE `Index` = \''.$index.'\'';

				$this->_db->query($sql);
			} else {
				foreach($sections as $section) {
					if ($section == 0) {
						$sql = 'DELETE FROM '.$this->_tables['index_list'];
						$sql.= ' WHERE `Index` = \''.$index.'\'';

						$this->_db->query($sql);
					} else {
						if (null === ($section = STreeMgr::GetNodeByID($section)))
							continue ;

						$sql = 'DELETE FROM '.$this->_tables['index_list'];
						$sql.= ' WHERE `Index` = \''.$index.'\'';
						$sql.= ' AND `SectionID` = '.$section->ID;
						$sql.= ' AND `RegionID` = '.$section->Regions;
						$sql.= ' AND `SiteID` = '.$section->ParentID;

						$this->_db->query($sql);
					}
				}
			}
		}

		return $changeList;
	}

	/*
	 * Подготавливает конфигурацию для sphinxd
	 * @exception RuntimeBTException
     * @return array
	 */
	public function PrepareConfig() {

		$tmp_config_path  = '/tmp/sphinx_configure';
		if ( !is_dir($tmp_config_path) )
			@mkdir($tmp_config_path);

		if ( !is_dir($tmp_config_path) || !is_writable($tmp_config_path) ) {
			throw new RuntimeBTException("Can't write configure \"{$tmp_config_path}\"");
		}

		$configFiles = array();
		$pluginsList = Sphinx::GetPluginsIterator();
		foreach($pluginsList as $plugin) {

			$config = "\n#############################################################################";
			$config.= "\n## ".get_class($plugin);
			$config.= "\n#############################################################################\n";

			if ($plugin->Type == Sphinx::PT_SINGLE_REF)
				$config.= $this->_prepareMultipleConfig($plugin);
			else if ($plugin->Type == Sphinx::PT_NAMED || $plugin->Type == Sphinx::PT_NAMED_REF)
				$config.= $this->_prepareSingleConfig($plugin);
			else
				continue ;

			$config = str_replace('%CONF_DIR%', self::CONF_DIR, $config);
			$tmpfname = tempnam($tmp_config_path, "conf");
			file_put_contents($tmpfname, $config);

			$configFiles[] = $tmpfname;
		}

		return $configFiles;
	}

	/*
	 * Подготавливает конфигурацию без связей с разделами (один источник => один индекс)
	 * @param $plugin ISphinxPlugin
	 * @exception RuntimeBTException
     * @return string
	 */
	private function & _prepareSingleConfig(ISphinxPlugin $plugin) {

		$sourceList = array();
		$configText = '';

		foreach(array('source', 'index') as $type) {
			if (!isset($plugin->Rules[$type]))
				throw new RuntimeBTException("Rules is not set [$type]");

			$list = $plugin->Rules[$type];

			foreach($list as $typeName => $params) {

				list($name) = explode(':', $typeName);
				$name = trim($name);

				if ($type == 'source' && !isset($sourceList[$name]))
					$sourceList[$name] = $name;
				else if ($type == 'index' && !isset($sourceList[$name]))
					continue ;

				$configText .= "$type $typeName\n";
				$configText .= $this->_prepareParams($params);
			}
		}

		return $configText;
	}

	/*
	 * Подготавливает конфигурацию с множеством источников в одном индексе
	 * @param $plugin ISphinxPlugin
     * @return string
	 */
	private function & _prepareMultipleConfig(ISphinxPlugin $plugin) {

		if (!is_array($plugin->Rules) || !sizeof($plugin->Rules))
			return '';

		$it = STreeMgr::Iterator(array(
			'type'		=> 2,
			'visible'	=> 1,
			'deleted'	=> 0,
			'module'	=> $plugin->Module
		));

		$sourceList = array();
		$configText = '';

		// Проходим по всем рабочим разделам указанного в плагине модуля
		foreach($it as $node)  {

			if ($node->Regions <= 0 || $node->ParentID <= 0)
				continue ;
		
			// Проверяем права на участие в поиске
			if ($this->_checkRights($node, $plugin->Rights) !== true)
				continue ;

			$sectionCfg = ModuleFactory::GetConfigById('section', $node->ID);

			// Собираем конфигурацию для источников (отдельно для каждого раздела)
			foreach($plugin->Rules['source'] as $source => $params) {
				$source = explode(':', $source);

				$sourceName = trim($source[0]);
				if (!isset($sourceList[ $sourceName ]))
					$sourceList[ $sourceName ] = array();

				foreach($source as &$v)
					$v = trim($v).'_'.$node->Regions.'_'.$node->ParentID.'_'.$node->ID;

				$sourceList[ $sourceName ][] = $source[0];
				$source = implode(' : ', $source);

				$configText .= "source $source\n";
				$configText .= $this->_prepareParams($params);
			}

			// Собираем параметры для подстановки
			$replaceFrom = array('%REGID%', '%SITEID%', '%SECTIONID%');
			$replaceTo = array(
				'%REGID%'		=> $node->Regions,
				'%SITEID%'		=> $node->ParentID,
				'%SECTIONID%'	=> $node->ID,
			);

			$matchs = array();
			preg_match_all('/%([^\'"%]+)%/', $configText, $matchs);

			if ( sizeof($matchs[1]) ) {
				foreach($matchs[1] as &$match ) {
					if (isset($replaceTo['%'.$match.'%']))
						continue ;

					// Подготовка обращения к массиву конфигурации раздела
					$replace = '[\''.implode('\'][\'', explode('/',$match)).'\']';
					eval('$replace = $sectionCfg'.$replace.';');

					$replaceFrom['%'.$match.'%'] = '%'.$match.'%';
					$replaceTo['%'.$match.'%'] = $replace;
				}
			}

			$configText = str_replace($replaceFrom, $replaceTo, $configText);
		}

		// Собираем конфигурацию индекса с множеством источников
		foreach($plugin->Rules['index'] as $index => $params) {
			list($sourceName) = explode(':', $index);

			$sourceName = trim($sourceName);
			if (!isset($sourceList[$sourceName]))
				continue ;

			// Записываем в индекс все источники
			$params['source'] = $sourceList[$sourceName];

			$configText .= "index $index\n";
			$configText .= $this->_prepareParams($params);
		}

		return $configText;
	}

	/*
	 * Проверяет права использования поиска по разделу
	 * @param $section STreeSection
	 * @param $right array
	 * @return bool
	 */
	private function _checkRights(STreeSection $section, array &$right) {

		if (isset($right['deny']) && is_array($right['deny'])) {
			foreach($right['deny'] as $type => $params)	{
				if ($type == 'regions' && in_array($section->Regions, $params) === true)
					return false;

				if ($type == 'sites' && $this->_checkSectionRightsByType(
						$section->Parent, $params, STreeSection::TSite) === true)
					return false;

				if ($type == 'sections' && $this->_checkSectionRightsByType(
						$section, $params, STreeSection::TSection) === true)
					return false;
			}
		}

		if (isset($right['allow']) && is_array($right['allow'])) {
			foreach($right['allow'] as $type => $params)	{
				if ($type == 'regions' && in_array($section->Regions, $params) === false)
					return false;

				if ($type == 'sites' && $this->_checkSectionRightsByType(
						$section->Parent, $params, STreeSection::TSite) === false)
					return false;

				if ($type == 'sections' && $this->_checkSectionRightsByType(
						$section, $params, STreeSection::TSection) === false)
					return false;
			}
		}

		return true;
	}

	/*
	 * Проверяет права использования поиска по разделу с дополнительной провркой типа раздела
	 * @param $section STreeSection
	 * @param $params array
	 * @param $type_int int
	 * @exception RuntimeBTException
	 * @return bool
	 */
	private function _checkSectionRightsByType(STreeSection $section, array &$params, $type_int) {

		if ($section->TypeInt != $type_int)
			throw new RuntimeBTException("Wrong section type [{$section->ID}]");

		if (in_array($section->ID, $params))
			return true;

		return false;
	}

	/*
	 * Собирает в строке все параметры правила
	 * @param $params array
	 * @return string
	 */
	private function & _prepareParams(array &$params) {
	
		$configText = '';
		foreach($params as $k => $v) {
			if ( !is_array($v) ) { 
				if ($k == 'path') {
					LibFactory::GetStatic('filestore');
					
					$v = str_replace('%VAR_DIR%', self::VAR_DIR, $v);
					if (!FileStore::IsDir(dirname($v))) {
						try {						
							FileStore::CreateDir_NEW(dirname($v));
						} catch(Exception $e) {
							error_log($e->getMessage());
						}
					}
				}
			
				$configText .= "\t$k = $v\n";
			} else foreach($v as $mv)
				$configText .= "\t$k = $mv\n";
		}

		return "{\n".$configText."}\n";
	}
}