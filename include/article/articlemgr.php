<?php
require_once (ENGINE_PATH.'include/article/article.php');
require_once (ENGINE_PATH.'include/article/articleiterator.php');

class ArticleMgr {

	public static $images_dir = '/common_fs/i/article/';
	public static $images_url = '/resources/fs/i/article/';

	const T_NEWS = 'news';
	const T_NEWSLINE = 'newsline';

	public static $db;
	private $_tables = null;
	private $_cache = null;

	function __construct()
	{
		LibFactory::GetStatic('heavy_data');
		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('filestore');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'article');
		
		self::$db = DBFactory::GetInstance('news');
	}

	/**
	 * синглтон
	 *
	 * @return ArticleMgr
	 */
	static function &getInstance () 
	{
        static $instance;
		
        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl();
        }
		
        return $instance;
    }

	public function getArticles($filter) {
		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		
		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ( $filter['offset'] < 0 || $filter['limit'] < 0 )
			return null;
	
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];
		
			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Title','Date','AnnounceText')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
				elseif ($v == 'Date')
					$filter['field'][$k] = 'r.Date';
			}
			
			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);	
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('r.Date');
			$filter['dir'] = array('DESC');
		}
		
		if(!isset($filter['regions']) || !is_array($filter['regions']))
			$filter['regions'] = array();
			
		if(!isset($filter['sections']) || !is_array($filter['sections']))
			$filter['sections'] = array();
			
		if(!isset($filter['skip']) || !is_array($filter['skip']))
			$filter['skip'] = array();
		
		if(isset($filter['addmaterial']) && $filter['addmaterial'] !== null)
			$filter['addmaterial'] = (array) $filter['addmaterial'];
		else
			$filter['addmaterial'] = null;

		$sql= 'SELECT SQL_CALC_FOUND_ROWS a.*, r.SectionID, r.RefID ';
		$sql.= ' FROM news_ref AS r, news as  a ';
		$sql.= ' WHERE r.`opt_inState` = 1 ';
		
		if ( !empty($filter['regions']) )
			$sql.= ' AND r.RegionID IN('.implode(',', $filter['regions']).') ';
		
		if ( !empty($filter['sections']) )
			$sql.= ' AND r.SectionID IN('.implode(',', $filter['sections']).') ';

		if ( $filter['addmaterial'] !== null )
			$sql.= ' AND a.AddMaterial IN ('. implode(',', $filter['addmaterial']) .') ';
			
		$sql.= ' AND a.NewsID = r.NewsID';

		if ( !empty($filter['skip']) )
			$sql .= ' AND a.NewsID NOT IN('.implode(',', $filter['skip']).') ';
			
		if ( !empty($filter['newsid']) )
			$sql .= ' AND r.NewsID IN('.implode(',', (array) $filter['newsid']).') ';

		if ( !empty($filter['title']) && is_string($filter['title']) )
			$sql .= ' AND a.Title = \''. addslashes($filter['title']) .'\' ';

		if ( $filter['limit'] > 1 && (sizeof($filter['sections']) > 1 || !empty($filter['regions'])))
			$sql.= ' GROUP by a.NewsID ';
			
		$sqlo = array();
		foreach( $filter['field'] as $k => $v )
			$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];
			
		$sql .= ' ORDER by '.implode(', ', $sqlo);
		
		if ( $filter['limit'] ) 
			$sql .= ' LIMIT '.$filter['offset'].', '.$filter['limit'];

		$res = self::$db->query($sql);
		
		$news = array();
		while ($row = $res->fetch_assoc()) {
			$news[] = $row;
		}
		$count = 0;		
		$res1 = self::$db->query('SELECT found_rows()');
		if ( $res1 && $res1->num_rows )
			list($count) = $res1->fetch_row();

		return new ArticleIterator($news, $count);
	}
	
	public function getFirstDate($sections) {
		if ( !is_array($sections) )
			$sections = (array) $sections;
			
		if ( empty($sections) )
			return null;
		
		$sql = 'SELECT a.`Date` FROM news_ref as r ';
		$sql.= ' STRAIGHT_JOIN news as a ';
		$sql.= ' WHERE r.ArticleID = a.ArticleID';
		$sql.= ' AND r.`opt_inState` = 1';
		$sql.= ' AND r.SectionID IN('.implode(',', $sections).')';
		$sql.= ' ORDER by r.`Date` ASC LIMIT 1';

		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		list($date) = $res->fetch_row();		
		return strtotime($date);
	}
	
	public function getMainArticle($region, $type = null, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 1;

		$sections = $this->getSectionList($region, $type);
		if ( empty($sections) )
			return null;

		return $this->_getMainArticle($sections, $limit);
	}
	
	public function getMainArticleBySectionID($sections, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 1;

		if ( is_numeric($sections) )
			$sections = (array) $sections;
			
		if ( !is_array($sections) || !sizeof($sections) )
			return null;

		return $this->_getMainArticle($sections, $limit);
	}

	private function _getMainArticle($sections, $limit) {
	
		$sql = 'SELECT a.*, r.SectionID FROM news as a ';
		$sql.= ' STRAIGHT_JOIN news_ref as r';
		$sql.= ' WHERE a.`isMain`=1';
		$sql.= ' AND r.`ArticleID`=a.`ArticleID`';
		$sql.= ' AND r.`opt_inState` = 1';
		$sql.= ' AND r.SectionID IN('.implode(',', $sections).') ';

		if(count($sections) > 1)			
			$sql.= ' GROUP by a.ArticleID';
		$sql.= ' ORDER BY a.Date DESC LIMIT '.$limit;

		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$news = array();
		while(false != ($row = $res->fetch_assoc()))
			$news[] = $row;
			
		return new PArticleIterator($news);
	}
	
	public function getImportantArticle($region, $type = null, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 0;

		$sections = $this->getSectionList($region, $type);
		if ( empty($sections) )
			return null;

		return $this->_getImportantArticle($sections, $limit);
	}
	
	public function getImportantArticleBySectionID(&$sections, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 0;

		if ( is_numeric($sections) )
			$sections = (array) $sections;
			
		if ( !is_array($sections) || !sizeof($sections) )
			return null;

		return $this->_getImportantArticle($sections, $limit);
	}
	
	private function _getImportantArticle(&$sections, $limit) {
	
		$sql = 'SELECT a.*, r.SectionID FROM news as a ';
		$sql.= ' STRAIGHT_JOIN news_ref as r';
		$sql.= ' WHERE a.`isImportant`=1';
		$sql.= ' AND r.`ArticleID`=a.`ArticleID`';
		$sql.= ' AND r.`opt_inState` = 1';
		$sql.= ' AND r.SectionID IN('.implode(',', $sections).') ';

		if(count($sections) > 1)			
			$sql.= ' GROUP by a.ArticleID ';
		$sql.= ' ORDER BY a.Date DESC LIMIT '.$limit;

		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$news = array();
		while(false != ($row = $res->fetch_assoc()))
			$news[] = $row;

		return new PArticleIterator($news);
	}
	
	public function getSectionList($region, $type = null) {

		if ( $type === null ) {

			$result = array();

			$sections = $this->_getSectionList($region, self::T_NEWS);
			if ( $sections !== null )
				$result = $sections;

			$sections = $this->_getSectionList($region, self::T_NEWSLINE);
			if ( $sections !== null )
				$result = array_merge($result, $sections);

			if ( empty($result) )
				return null;

			return $result;
		}

		if ( self::T_NEWS != $type && self::T_NEWSLINE != $type )
			return null;

		return $this->_getSectionList($region, $type);
	}

	private function _getSectionList($region, $type) {

		$key = "{$type}_sectionids_{$region}";
		$sections = $this->_cache->get($key);

		if ( $sections === false ) {
			$sections = Heavy_Data::GetData($key);

			$this->_cache->set($key, $sections, 3600);
		}
		return $sections;
	}
	
	/**
	 * Получить новости по списку связей
	 *
	 * @param array refs - связи
	 * @return object PArticleIterator - итератор (в случае ошибки null)
	 */
	public function GetArticleByRef($refs)
	{
		if (!is_array($refs) || count($refs) == 0)
			return null;
		$sql = "SELECT n.*, r.SectionID FROM news n";
		$sql.= " INNER JOIN news_ref r ON (n.ArticleID=r.ArticleID)";
		$sql.= " WHERE RefID IN (".implode(',', $refs).")";
		
		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$news = array();
		while(false != ($row = $res->fetch_assoc()))
			$news[] = $row;

		return new PArticleIterator($news);
	}

	/**
	 * Вытягивает логотипы из news_data по id
	 *
	 * @param int $ArticleID - id'шник новости
	 * @return string - текст логотипов
	 */
	public function GetLogoTextById($ArticleID)
	{
		$LogoText = "";
		$ArticleID = intval($ArticleID);
		if ($ArticleID <= 0)
			return $LogoText;

		$sql = "SELECT LogoText FROM news_data";
		$sql.= " WHERE ArticleID = ".$ArticleID;
		$res = self::$db->query($sql);
		
		if (($row = $res->fetch_assoc()) !== false )
			$LogoText = $row['LogoText'];

			return $LogoText;
	}
}


?>
