<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/tags/tag.php');
require_once ($CONFIG['engine_path'].'include/lib.sections.php');

/**
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:21
 */
class TagsMgr
{
	public $_db = null;
	public $_tables = array(
		'tags'			=> 'tags',
		'ref'			=> 'tags_ref',
		'ref_site'		=> 'tags_on_site',
		'ref_region'	=> 'tags_region_by_module',
	);
	private $_pluginsCache = array();


	function __construct($db = null)
	{
		if ($db === null)
			$this->_db = DBFactory::GetInstance('tags');
		else
			$this->_db = DBFactory::GetInstance($db);
	}

	/**
	 * Синглтон
	 *
	 * @param string db - имя базы (если не передать, то будет работать с базой tags)
	 * @return object TagsMgr
	 */
	static function &getInstance ($db = null) {
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($db);
        }

        return $instance;
    }

	/**
	 * Удалить связь по RefID. 
	 * При удалении триггером почистятся пересчитаются поля RefCount в таблицах tags, tags_on_site, tags_region_by_module
	 *
	 * @param int id - идентитфикатор связи
	 * @return bool
	 */
	public function removeRef($id) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = 'DELETE FROM '.$this->_tables['ref'];
		$sql.= ' WHERE `RefID` = '.intval($id);

		return $this->_db->query($sql);
	}
	
	/**
	 * Удалить связь по модулю, и идентификатору материала в этом модуле
	 * При удалении триггером почистятся пересчитаются поля RefCount в таблицах tags, tags_on_site, tags_region_by_module
	 *
	 * @param int id - идентификатору материала
	 * @param string module - название модуля
	 * @return bool
	 */
	public function removeRefByModule($id, $module) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$module = trim($module);
		if ($module === '')
			return false;

		$sql = 'DELETE FROM '.$this->_tables['ref'];
		$sql.= ' WHERE `UniqueID` = '.intval($id);
		$sql.= ' AND `Module` = \''.addslashes($module).'\'';

		if ($this->_db->query($sql)) {
			$this->log(881, 0, array(
				'Module' => $module
			));
			return true;
		}
		return false;
	}

	/**
	 * Обновить связи по модулю, и идентификатору материала в этом модуле
	 * При обновлении сработает триггер tags_ref_after_upd_tr
	 *
	 * @param int id - идентификатору материала
	 * @param string module - название модуля
	 * @param array fields - массив обновляемых полей:
	 * 						ключ - название поля в базе
	 * 						значение - новое значение поля
	 * @return bool
	 */
	public function updateRefByModule($id, $module, array $fields = array()) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$module = trim($module);
		if ($module === '')
			return false;

		if (empty($fields))
			return false;

		foreach($fields as $k => $v)
			$fields[$k] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE '.$this->_tables['ref'].' SET ';
		$sql.= implode(', ', $fields);
		$sql.= ' WHERE `UniqueID` = '.intval($id);
		$sql.= ' AND `Module` = \''.addslashes($module).'\'';

		if ($this->_db->query($sql)) {
			$this->log(882, intval($id), array(
				'Module' => $module
			));
			return true;
		}
		return false;
	}

	/**
	 * Получить объект Tag по имени.
	 * Можно вернуть тег за исключением тега с id'шником не id(второй параметр)
	 *
	 * @param string name - имя тега
	 * @param int id - идентификатор исключаемого тега (по умолчанию null)
	 * @return object Tag - объект Tag, в случае ошибки null
	 */
	public function getTagByName($name, $id = null) {

		$name = trim($name);
		if ($name === '')
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['tags'];
		$sql.= ' WHERE `Name` = \''.addslashes($name).'\'';

		if ($id !== null)
			$sql.= ' AND TagID != '.intval($id);

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		return new Tag($res->fetch_assoc(), $this);
	}

	/**
	 * Получить объект Tag по TagID
	 *
	 * @param int id - идентитфикатор тега
	 * @return object Tag - объект Tag, в случае ошибки null
	 */
	public function getTagByID($id) {

		if (!is_numeric($id) || $id <= 0)
			return null;

		$sql = 'SELECT * FROM '.$this->_tables['tags'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return null;

		return new Tag($res->fetch_assoc(), $this);
	}

	/**
	 * Создать/Обновить тег
	 *
	 * @param array info - массив обновляемых полей:
	 * 						ключ - название поля в базе
	 * 						значение - новое значение поля
	 * @return bool
	 */
	public function updateTag($info) {

		$info = array_change_key_case($info, CASE_LOWER);

		$tag = $this->getTagByName($name, $info['tagid']);
		if ($tag !== null)
			return false;

		$fields = array();
		foreach($info as $k => $v) {
			if (in_array($k, array('tagid')))
				continue ;

			$fields[] = "`$k` = '".addslashes($v)."'";
		}

		if ($info['tagid'] === null) {
			$sql = 'INSERT INTO '.$this->_tables['tags'].' SET ';
			$sql.= implode(', ', $fields);

			if ($this->_db->query($sql)) {
				$this->log(877, $this->_db->insert_id);
				return $this->_db->insert_id;
			}
		} else {
			$sql = 'UPDATE '.$this->_tables['tags'].' SET ';
			$sql.= implode(', ', $fields);
			$sql.= ' WHERE `TagID` = '.intval($info['tagid']);

			if ($this->_db->query($sql)) {
				$this->log(878, $info['tagid']);
				return true;
			}
		}

		return false;
	}

	/**
	 * Обновить количество связей в таблице с тегом
	 * Считает общее количетсво свящей по тегу, и обновляет RefCount
	 *
	 * @param int id - идентитфикатор тега
	 * @return int - количество связей. В случае ошибки вернет false
	 */
	public function updateRefCount($id) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = 'SELECT COUNT(0) FROM '.$this->_tables['ref'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		if (false == ($res = $this->_db->query($sql)))
			return false;

		$count = $res->fetch_row();
		$sql = 'UPDATE '.$this->_tables['tags'];
		$sql.= ' SET `RefCount` = '.$count[0];
		$sql.= ' WHERE `TagID` = '.intval($id);

		if ($this->_db->query($sql)) {
			$this->log(878, $id, array(
				'Count' =>  $count[0]
			));
			return $count[0];
		}

		return false;
	}
	
	/**
	 * Обновить видимость тега в админке (для отсмотренных меток)
	 * @param id int - идентификатор метки
	 * @param isnew boolean - если метка новая то true, иначе false
	 * @return boolean - В случае удачи true
	 */
	public function updateTagIsNew($id, $isnew = false) {
		if (!is_numeric($id) || $id <= 0)
			return false;
			
		if ($isnew === true)
			$isnew = 1;
		else
			$isnew = 0;

		$sql = 'UPDATE '.$this->_tables['tags'];
		$sql.= ' SET `IsNew` = '.$isnew;
		$sql.= ' WHERE `TagID` = '.intval($id);

		if ($this->_db->query($sql)) {
			$this->log(878, $id, array(
				'IsNew' => $isnew
			));
			return true;
		}

		return false;
	}

	/**
	 * Получить общее количество связей тега
	 *
	 * @param int id - идентитфикатор тега
	 * @return int - количетсво связей (в случае ошибки false)
	 */
	public function calcRefCount($id) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = 'SELECT COUNT(0) FROM '.$this->_tables['ref'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		if (false == ($res = $this->_db->query($sql)))
			return false;

		$count = $res->fetch_row();
		return $count[0];
	}

	/**
	 * Удалить тег по имени
	 *
	 * @param string name - имя тега
	 * @return bool
	 */
	public function removeTagByName($name) {
		$name = trim($name);
		if ($name === '')
			return false;

		$tag = $this->getTagByName($name);
		if ($tag === null)
			return false;

		return $tag->Remove();
	}

	/**
	 * Удалить тег по TagID
	 *
	 * @param int id - идентитфикатор тега
	 * @return bool
	 */
	public function removeTagByID($id) {
		if (!is_numeric($id) || $id <= 0)
			return false;

		$sql = 'DELETE FROM '.$this->_tables['ref_site'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		$this->_db->query($sql);

		$sql = 'DELETE FROM '.$this->_tables['ref'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		$this->_db->query($sql);

		$sql = 'DELETE FROM '.$this->_tables['tags'];
		$sql.= ' WHERE `TagID` = '.intval($id);

		if ($this->_db->query($sql)) {
			$this->log(879, $id);
			return true;
		}

		return false;
	}

	/**
	 * Получить количетсво тегов по фильтру
	 *
	 * @param array filter - фильтр с допустимыми ключами: Name,offset,limit,ExactName,field,dir
	 * @return int - Количество тегов
	 */
	public function getTagsCount(array $filter = array()) {
		if (null === ($filter = $this->_prepareFilter($filter)))
			return 0;
		
		$sql = 'SELECT COUNT(0) FROM '.$this->_tables['tags'];
		
		$where = $this->_prepareCondition($filter);

		if (sizeof($where))
			$sql .= ' WHERE '.implode(' AND ', $where);
		
		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return 0;

		list($count) = $res->fetch_row();
		return $count;
	}

	/**
	 * Установить размеры шрифтов для тегов в зависимости от количества связей (популярности)
	 *
	 * @param array tags - массив тегов (с обязательным ключом RefCount). Передаётся по ссылке
	 * @param int levels - количетсво размеров шрифта (по умолчанию 6)
	 * @param int max_size - максимальный размер шрифта в единицах $t (по умолчанию 220)
	 * @param int min_size - минимальный размер шрифта в единицах $t (по умолчанию 100)
	 * @param string t - css единица измерения ( по умолчанию процент)
	 * @return void
	 */
	public function setFontSize(array &$tags, $levels = 6, $max_size = 220, $min_size = 100, $t = '%') {
		if (!sizeof($tags))
			return false;

		//{{ максимум и минимум
		$counts = array();
		foreach($tags as $v) {
			$counts[] = log($v['RefCount']+1);
		}
		
		$min_total = min($counts);
		$max_total = max($counts);
		//}}

		$step = ($max_total - $min_total) / $levels; //шаг
		if ($step == 0)
			$step = 1;

		foreach($tags as &$v) {
			$val = log($v['RefCount']+1);

			$level = ($val - $min_total) / $step;
			$v['fontSize'] = intval($min_size + $level * ($max_size - $min_size) / $levels);
			$v['fontSize'].= $t;
		}
	}

	/**
	 * Получить популярные теги по сайту.
	 *
	 * @param int siteid - идентификатор сайта
	 * @param int limit - количетсво тегов
	 * @return array - теги с вычисленным css размером
	 */
	public function getPopBySite($siteid, $limit = 0) {
		if ( is_numeric($siteid) && $limit <= 0 )
			return array();

		$sql = 'SELECT *, '.$this->_tables['ref_site'].'.`RefCount` FROM '.$this->_tables['ref_site'];
		$sql.= ' STRAIGHT_JOIN '.$this->_tables['tags'];
		$sql.= ' ON ('.$this->_tables['tags'].'.TagID = '.$this->_tables['ref_site'].'.TagID) ';
		$sql.= ' WHERE `SiteID` = '.$siteid;
		$sql.= ' AND '.$this->_tables['ref_site'].'.`RefCount` != 0';
		$sql.= ' ORDER by '.$this->_tables['ref_site'].'.`RefCount` DESC ';

		if ( is_numeric($limit) && $limit > 0 )
			$sql .= ' LIMIT '.$limit;

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		$list = array();
		while(false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		$this->setFontSize($list);
		return $list;
	}
	
	/**
	 * Получить популярные теги по региону и модулю.
	 *
	 * @param int regionid - идентитфикатор региона
	 * @param string module - название модуля
	 * @param int limit - количетсво тегов
	 * @return array - теги с вычисленным css размером
	 */
	public function getPopByRegion($regionid, $module, $limit = 0) {
		
		if ( is_numeric($regionid) && $limit <= 0 )
			return array();

		$sql = 'SELECT *, '.$this->_tables['ref_region'].'.`RefCount` FROM '.$this->_tables['ref_region'];
		$sql.= ' STRAIGHT_JOIN '.$this->_tables['tags'];
		$sql.= ' ON ('.$this->_tables['tags'].'.TagID = '.$this->_tables['ref_region'].'.TagID) ';
		$sql.= ' WHERE `RegionID` = '.$regionid;
		$sql.= ' AND `Module` = \''.$module.'\'';
		$sql.= ' AND '.$this->_tables['ref_region'].'.`RefCount` != 0';
		$sql.= ' ORDER by '.$this->_tables['ref_region'].'.`RefCount` DESC ';

		if ( is_numeric($limit) && $limit > 0 )
			$sql .= ' LIMIT '.$limit;
		
		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		$list = array();
		while(false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		$this->setFontSize($list);
		return $list;
	}

	/**
	 * Получить количетсво тегов по фильтру
	 *
	 * @param array filter - массив фильтра с допустимыми ключами: 
	 *						UniqueID - массив идентификаторов материала модуля Module
	 *						SiteID - массив идентификаторов сайтов
	 *						Module - название модуля
	 *						TagID - массив тегов
	 *						isActive - активность тега
	 *						SectionID - массив идентификаторов разделов
	 * @return int - количество тегов
	 */
	public function getTagsRefCount(array $filter = array()) {

		$sql = 'SELECT COUNT(*) FROM '.$this->_tables['ref'];

		$where = array();
		if (isset($filter['UniqueID']))
			$where[] = '`UniqueID` IN ('.implode(',', (array) $filter['UniqueID']).')';

		if (isset($filter['SiteID']))
			$where[] = '`SiteID` IN ('.implode(',', (array) $filter['SiteID']).')';

		if (isset($filter['Module']) && !empty($filter['Module']))
			$where[] = '`Module` = \''.addslashes($filter['Module']).'\'';
			
		if (isset($filter['TagID']))
			$where[] = $this->_tables['ref'].'.`TagID` IN ('.implode(',', (array) $filter['TagID']).')';

		if (isset($filter['isActive']) && $filter['isActive'] != -1)
			$where[] = '`isActive` = '.($filter['isActive'] ? 1 : 0);

		if (isset($filter['SectionID']))
			$where[] = '`SectionID` IN ('.implode(',', (array) $filter['SectionID']).')';

		if (sizeof($where))
			$sql .= ' WHERE '.implode(' AND ', $where);

		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return 0;

		list($count) = $res->fetch_row();
		return $count;
	}

	/**
	 * Получить связи тегов по фильтру
	 *
	 * @param array filter - массив фильтра с допустимыми ключами: 
	 *						UniqueID - массив идентификаторов материала модуля Module
	 *						SiteID - массив идентификаторов сайтов
	 *						Module - название модуля
	 *						TagID - массив тегов
	 *						isActive - активность тега
	 *						SectionID - массив идентификаторов разделов
	 * @return array - массив связей
	 */
	public function getTagsRef(array $filter = array()) {

		$sql = 'SELECT * FROM '.$this->_tables['ref'];
		$sql.= ' STRAIGHT_JOIN '.$this->_tables['tags'];
		$sql.= ' ON ('.$this->_tables['tags'].'.TagID = '.$this->_tables['ref'].'.TagID) ';

		$where = array();
		if (isset($filter['UniqueID']))
			$where[] = '`UniqueID` IN ('.implode(',', (array) $filter['UniqueID']).')';

		if (isset($filter['SiteID']))
			$where[] = '`SiteID` IN ('.implode(',', (array) $filter['SiteID']).')';
			
		if (isset($filter['Module']) && !empty($filter['Module']))
			$where[] = '`Module` = \''.addslashes($filter['Module']).'\'';

		if (isset($filter['TagID']))
			$where[] = $this->_tables['ref'].'.`TagID` IN ('.implode(',', (array) $filter['TagID']).')';

		if (isset($filter['isActive']) && $filter['isActive'] != -1)
			$where[] = '`isActive` = '.($filter['isActive'] ? 1 : 0);

		if (isset($filter['SectionID']))
			$where[] = '`SectionID` IN ('.implode(',', (array) $filter['SectionID']).')';
			
		if (isset($filter['SectionID']) && trim(implode(',', (array) $filter['SectionID'])) == '') {

			mail('codemaker@info74.ru', 'error tags', print_r(debug_backtrace(), true));
		}

		if (sizeof($where))
			$sql .= ' WHERE '.implode(' AND ', $where);

		if (isset($filter['field'])) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('RefCount', 'Date')) )
					unset($filter['field'][$k], $filter['dir'][$k]);

				if ($v == 'RefCount')
					$filter['field'][$k] = $this->_tables['tags'].'.'.$v;
				else
					$filter['field'][$k] = $this->_tables['ref'].'.'.$v;
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (is_array($filter['field']) && sizeof($filter['field'])) {
			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql.= ' ORDER by '.implode(', ', $sqlo);
		}

		if (!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;

		if (!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ( $filter['limit'] )
			$sql .= ' LIMIT '.$filter['offset'].', '.$filter['limit'];
		//error_log($sql);
		
		$res = $this->_db->query($sql);
		
		/*if (!$res) {
			//mail('codemaker@info74.ru','error', print_r(debug_backtrace(), true));
		}*/
		
		if (!$res || !$res->num_rows) {		
			return array();
		}

		$list = array();
		while(false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Получить теги по фильтру
	 *
	 * @param array filter - фильтр с допустимыми ключами: Name,offset,limit,ExactName,field,dir
	 * @return array - массив тегов
	 */
	public function getTags(array $filter = array()) {

		if (null === ($filter = $this->_prepareFilter($filter)))
			return array();

		$sql = 'SELECT * FROM '.$this->_tables['tags'];
		$where = $this->_prepareCondition($filter);

		if (sizeof($where))
			$sql .= ' WHERE '.implode(' AND ', $where);

		$sqlo = array();
		foreach( $filter['field'] as $k => $v )
			$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

		$sql.= ' ORDER by '.implode(', ', $sqlo);

		if ( $filter['limit'] )
			$sql .= ' LIMIT '.$filter['offset'].', '.$filter['limit'];
		
		$res = $this->_db->query($sql);
		if (!$res || !$res->num_rows)
			return array();

		$list = array();
		while(false != ($row = $res->fetch_assoc())) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Подготовить массив условий
	 *
	 * @param array filter - массив с ключами:
	 * 						Name - имя тега
	 * 						ExactName - если true, то полное соответствие (=), если false, то like 'name%'
	 * @return array - подготовленный массив, который можно вставить в запрос как implode(',', $filter)
	 */
	protected function _prepareCondition($filter) {
		$where = array();

		if (isset($filter['Name'])) {
			if ($filter['ExactName'] === true)
				$where[] = '`Name` = \''.addslashes($filter['Name']).'\'';
			else
				$where[] = '`Name` LIKE \''.addslashes($filter['Name']).'%\'';
		}
		
		if (isset($filter['IsNew'])) {
			if ($filter['IsNew'] === true)
				$where[] = '`IsNew` = 1';
			else
				$where[] = '`IsNew` = 0';
		}

		return $where;
	}

	/**
	 * Подготовить фильтр для запроса по тегам
	 *
	 * @param array filter - фильтр с допустимыми ключами: Name,offset,limit,ExactName,field,dir
	 * @return array - подготовленный массив, который можно вставить в запрос как implode(',', $filter)
	 */
	protected function _prepareFilter($filter) {

		if (isset($filter['Name']) && trim($filter['Name']) === '')
			return null;
		
		if (!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;

		if (!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;
		

		if ($filter['offset'] < 0 || $filter['limit'] < 0)
			return null;
		
		if (!isset($filter['ExactName']) || $filter['ExactName'] !== true)
			$filter['ExactName'] = false;

		if (isset($filter['field'])) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Name','RefCount')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Name');
			$filter['dir'] = array('ASC');
		}

		return $filter;
	}

	/**
	 * Логирование действий связанный с изменений состояний тегов
	 *
	 * @param int action - идентификатор действия (ActionID)
	 * @param int id - идентификатор логируемого объекта
	 * @param array params - параметры для логирования (по умолчанию пустой массив)
	 * @return void
	 */
	public function log($action, $id, $params = array()) {
		global $OBJECTS;

		if (!isset($OBJECTS['log']))
			return false;

		$OBJECTS['log']->Log($action, $id, $params);
	}

	/**
	 * Получить экземпляр объекта плагина по имени
	 *
	 * @param srting $name - имя модуля
	 * @return object plugin
	 * @exception InvalidArgumentBTException
	 */
	public function GetPlugin($name)
	{
		$name = strtolower($name);

		if (isset($this->_pluginsCache[$name]))
			return $this->_pluginsCache[$name];
		
		include_once 'plugins/'.$name.'.php';

		$class = 'TagsPlugin_'.$name;
		if (!class_exists($class))
			throw new InvalidArgumentBTException('Plugin "'.$name.'" not found');

		$this->_pluginsCache[$name] = new $class;
		return $this->_pluginsCache[$name];
	}

	function __destruct()
	{
	}
}

abstract class TagsPluginTrait
{
	

	function __construct() {

	}

	public function GetData(array $items)
	{
		return array();
	}

	function __desrtuct() {

	}
}