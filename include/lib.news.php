<?

class News {

	const T_NEWS = 'news';
	const T_NEWSLINE = 'newsline';

	private $_db = null;
	private $_tables = null;
	private $_cache = null;

	function __construct()
	{
		mail('codemaker@info74.ru','include lib', 'lib.news.php');
		
		LibFactory::GetStatic('heavy_data');
		LibFactory::GetStatic('cache');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'news_magic');
	}

	public function Init($db, $tables)
	{
		if ( is_object($db) )
			$this->_db = $db;
		else
			$this->_db = DBFactory::GetInstance($db);

		$this->_tables = $_tables;
	}

	public function getMainNews($region, $type = null, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 1;

		$sections = $this->getSectionList($region, $type);
		if ( empty($sections) )
			return null;

		return $this->_getMainNews($sections, $limit);
	}
	
	public function getMainNewsBySectionID($sections, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 1;

		if ( is_numeric($sections) )
			$sections = (array) $sections;
			
		if ( !is_array($sections) || !sizeof($sections) )
			return null;

		return $this->_getMainNews($sections, $limit);
	}

	private function _getMainNews($sections, $limit) {
		$sql = 'SELECT news.NewsID FROM news_ref ';
		$sql.= ' INNER JOIN news ON (news.NewsID = news_ref.NewsID) ';
		$sql.= ' WHERE ';
		$sql.= ' news_ref.SectionID IN('.implode(',', $sections).') AND ';
		$sql.= ' news.isMain = 1';
		$sql.= ' ORDER by Date DESC LIMIT '.$limit;

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$news = array();
		while(false != ($row = $res->fetch_row()))
			$news[] = $row[0];

		return $news;
	}
	
	public function getImportantNews($region, $type = null, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 0;

		$sections = $this->getSectionList($region, $type);
		if ( empty($sections) )
			return null;

		return $this->_getImportantNews($sections, $limit);
	}
	
	public function getImportantNewsBySectionID(&$sections, $limit = 1) {

		if ( !is_numeric($limit) || $limit <= 0 )
			$limit = 0;

		if ( is_numeric($sections) )
			$sections = (array) $sections;
			
		if ( !is_array($sections) || !sizeof($sections) )
			return null;

		return $this->_getImportantNews($sections, $limit);
	}
	
	private function _getImportantNews(&$sections, $limit) {
		$sql = 'SELECT news.NewsID FROM news_ref ';
		$sql.= ' INNER JOIN news ON (news.NewsID = news_ref.NewsID) ';
		$sql.= ' WHERE ';
		$sql.= ' news_ref.SectionID IN('.implode(',', $sections).') AND ';
		$sql.= ' news.Order > 0';
		$sql.= ' ORDER by Date DESC, `Order` DESC ';
		
		if ( $limit )
			$sql.= ' LIMIT '.$limit;

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;

		$news = array();
		while(false != ($row = $res->fetch_row()))
			$news[] = $row[0];

		return $news;
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

			$this->_cache->set($key, $sections, 3600*12);
		}
		return $sections;
	}
}


?>