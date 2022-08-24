<?php

global $CONFIG;

require_once ($CONFIG['engine_path'].'include/tree_articles/article.php');
require_once ($CONFIG['engine_path'].'include/tree_articles/photo.php');

class TreeArticleMgr
{
	public $articles = array();

	public $_db			= null;
	public $_tables		= array(
		'articles'		=> 'tree_articles',
		'photos'		=> 'tree_articles_photos',
	);

	private $_cache		= null;

	public function __construct()
	{
		LibFactory::GetStatic('places');
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$this->_db = DBFactory::GetInstance('sovetnik');
		if($this->_db == false)
			throw new RuntimeBTException('ERR_L_PLACE_CANT_CONNECT_TODB', ERR_L_PLACE_CANT_CONNECT_TODB);

		$this->_cache = $this->getCache();
	}

	public function getCache()
	{
		LibFactory::GetStatic('cache');

		$cache = new Cache();
		$cache->Init('memcache', 'treearticlemgr');

		return $cache;
	}

	static function &getInstance ()
	{
        static $instance;

        if (!isset($instance)) {
            $cl = __CLASS__;
            $instance = new $cl($caching);
        }

        return $instance;
    }


	/**
	 * Получить место по идентификатору
	 *
	 * @param int $id - id'шник фирмы
	 * @param int $section - id'шник раздела
	 * @param bool $as_array - возвращать как массив
	 * @return Place (если as_array=false), и array, если as_array=true. В случае ошибки вернет null
	 */

	private function _articleObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$article = new TArticle($info);
		if (isset($info['articleid']))
			$this->articles[ $info['articleid'] ] = $article;

		return $article;
	}

	private function _PhotoObject(array $info)
	{
		$info = array_change_key_case($info, CASE_LOWER);

		$Photo = new TreeArticlePhoto($info);
		if (isset($info['PhotoID']))
			$this->_Photos[ $info['PhotoID'] ] = $Photo;

		return $Photo;
	}

	public function Add(array $info)
	{
		unset($info['ArticleID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['articles'].' SET Created = NOW(), ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	public function Remove($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		try
		{
			if ($this->articles[$id])
			{
				$this->articles[$id]->Thumb = null;

				foreach ($this->articles[$id]->Photos as $photo)
					$photo->Remove();
			}
		}
		catch(MyException $e) {}



		$sql = 'DELETE FROM '.$this->_tables['articles'].' WHERE ArticleID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('article_'.$id);

			unset($this->articles[$id]);
			return true;
		}

		return false;
	}

	public function Update(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['ArticleID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'UPDATE '.$this->_tables['articles'].' SET LastUpdated = NOW(), ' . implode(', ', $fields);
		$sql .= ' WHERE ArticleID = '.$info['ArticleID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('article_'.$info['ArticleID']);
			$cache->Remove('article_nameid_'.$info['NameID']."_".$info['ParentID']);

			return true;
		}

		return false;
	}

	public function UpdateViews($id)
	{
		$sql = "UPDATE ".$this->_tables['articles']." SET";
		$sql.= " Views = Views + 1";
		$sql.= " WHERE ArticleID = ".$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();

			$cacheid = 'article_'.$id;
			$info = $cache->get($cacheid);
			if ($info !== false)
			{
				$info['Views']++;

				$cache->set($cacheid, $info, 3600);
			}
		}
	}

	public function UpdateCountComments($plus_minus, $id)
	{
		$sql = "UPDATE ".$this->_tables['articles']." SET";
		if ($plus_minus == 'plus')
			$sql.= " CountComments = CountComments + 1";
		else
			$sql.= "CountComments = CountComments - 1";
		$sql.= " WHERE ArticleID = ".$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();

			$cacheid = 'article_'.$id;
			$info = $cache->get($cacheid);
			if ($info !== false)
			{
				if ($plus_minus == 'plus')
					$info['CountComments']++;
				else
					if ($info['CountComments'] > 0)
						$info['CountComments']--;


				$cache->set($cacheid, $info, 3600);
			}
		}
	}

	public function GetArticle($id)
	{
		$id = intval($id);
		if ($id <= 0)
			return null;

		if ( $section !== null && !Data::Is_Number($section) )
			return null;

		if ( isset($this->articles[$id]) )
			return $this->articles[$id];

		$info = false;

		$cacheid = 'article_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$sql = 'SELECT * FROM '.$this->_tables['articles'].' WHERE ArticleID = '.$id;

			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600 * 24);
		}

		$news = $this->_articleObject($info);
		return $news;
	}

	public function GetArticleByNameID($nameid, $parent = 0)
	{
		if (empty($nameid))
			return null;

		if ( isset($this->articles[$nameid]) )
			return $this->articles[$nameid];

		$info = false;

		$cacheid = 'article_nameid_'.$nameid."_".$parent;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$info = array();

			$sql = "SELECT * FROM ".$this->_tables['articles'];
			$sql.= " WHERE NameID = '".addslashes($nameid)."'";
			$sql.= " AND ParentID = ".intval($parent);
			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600);
		}

		$article = $this->_articleObject($info);
		return $article;
	}

	public function GetLastArticleID($sectionid)
	{
		$sql = "SELECT ArticleID FROM ".$this->_tables['articles']." WHERE";
		$sql.= " SectionID=".$sectionid;
		$sql.= " AND IsVisible=1";
		$sql.= " ORDER BY Created DESC";

		if ( false === ($res = $this->_db->query($sql)))
				return 0;
		if (!$res->num_rows )
				return 0;

		$row = $res->fetch_row();
		return $row[0];
	}

	public function GetArticles($filter)
	{
		global $OBJECTS;
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Name','ShortName', 'Created', 'LastUpdated', 'Date', 'IsImportant', 'Views')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}

		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Created');
			$filter['dir'] = array('ASC');
		}

		// Видимые
		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] != -1 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		elseif (!isset($filter['flags']['IsVisible']))
			$filter['flags']['IsVisible'] = 1;

		if ( isset($filter['flags']['SectionID']) && $filter['flags']['SectionID'] != -1 )
			$filter['flags']['SectionID'] = (int) $filter['flags']['SectionID'];
		elseif (!isset($filter['flags']['SectionID']))
			$filter['flags']['SectionID'] = -1;

		if ( isset($filter['flags']['ParentID']) && $filter['flags']['ParentID'] != -1 )
			$filter['flags']['ParentID'] = (int) $filter['flags']['ParentID'];
		elseif (!isset($filter['flags']['ParentID']))
			$filter['flags']['ParentID'] = -1;

		if ( isset($filter['flags']['IsMain']) && $filter['flags']['IsMain'] != -1 )
			$filter['flags']['IsMain'] = (int) $filter['flags']['IsMain'];
		elseif (!isset($filter['flags']['IsMain']))
			$filter['flags']['IsMain'] = -1;

		if ( isset($filter['flags']['skip']) && $filter['flags']['skip'] != -1 )
			$filter['flags']['skip'] = (int) $filter['flags']['skip'];
		elseif (!isset($filter['flags']['skip']))
			$filter['flags']['skip'] = -1;



		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
		else
			$sql = 'SELECT * ';

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields']))
			$sql.= ', COUNT(*) as GroupingCount ';

		$sql.= ' FROM '.$this->_tables['articles'].' ';

		$where = array();

		if ( !empty($filter['flags']['NameStart']) )
			$where[] = ' '.$this->_tables['articles'].'.Name LIKE \''.$filter['flags']['NameStart'].'%\'';
		else if ( !empty($filter['flags']['NameContains']) )
			$where[] = ' '.$this->_tables['articles'].'.Name LIKE \'%'.$filter['flags']['NameContains'].'%\'';

		if ( $filter['flags']['SectionID'] != -1 )
			$where[] = ' '.$this->_tables['articles'].'.SectionID = '.$filter['flags']['SectionID'];

		if ( $filter['flags']['ParentID'] != -1 )
			$where[] = ' '.$this->_tables['articles'].'.ParentID = '.$filter['flags']['ParentID'];

		if ( $filter['flags']['IsMain'] != -1 )
			$where[] = ' '.$this->_tables['articles'].'.IsMain = '.$filter['flags']['IsMain'];

		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['articles'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['skip'] != -1 )
			$where[] = ' '.$this->_tables['articles'].'.ArticleID != '.$filter['flags']['skip'];

		if (isset($filter['flags']['Period']) && is_array($filter['flags']['Period']))
		{
			$date = array(
				'year' 	=> $filter['flags']['Period']['year'],
				'month' => $filter['flags']['Period']['month'] != 0 ? $filter['flags']['Period']['month'] : '01',
				'day' 	=> $filter['flags']['Period']['day'] != 0 ? $filter['flags']['Period']['day'] : '01',
			);

			$d = implode('-', $date);
			$where[] = " ".$this->_tables['articles'].".Created >= '".$d."'";

			if ( $filter['flags']['Period']['day'] )
				$where[] = " ".$this->_tables['articles'].".Created < DATE_ADD('".$d."', INTERVAL 1 DAY)";
			elseif ( $filter['flags']['Period']['month'] )
				$where[] = " ".$this->_tables['articles'].".Created < DATE_ADD('".$d."', INTERVAL 1 MONTH)";
			else
				$where[] = " ".$this->_tables['articles'].".Created < DATE_ADD('".$d."', INTERVAL 1 YEAR)";
		}
		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['places'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['places'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		if (isset($filter['group']) && is_array($filter['group']['fields']) && sizeof($filter['group']['fields'])) {
			$group = array();
			foreach($filter['group']['fields'] as $v) {
				$group[] = ' '.$this->_tables['places'].'.`'.$v.'`';
			}

			$sql .= ' GROUP by '.implode(', ', $group);
		}

		if (isset($filter['having']) && $filter['having'])
			$sql .= 'HAVING COUNT(*) > '.(int) $filter['having'];

		$sql.= ' ORDER by ';

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $this->_db->query($sql)->fetch_row();
		}

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ($filter['flags']['objects'] === true)
			{
				if ( isset($this->articles[$row['ArticleID']]) )
					$row = $this->articles[$row['ArticleID']];
				else
					$row = $this->_articleObject($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}

	public function Dispose()
	{
		if(!empty($this->articles)) {
			foreach($this->articles as $k => $v) {
				$this->articles[$k] = null;
			}
		}

		$this->articles = null;
		$this->articles = array();
	}

public function AddPhoto(array $info)
	{
		unset($info['PhotoID']);
		if ( !sizeof($info) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
			$fields[] = "`$k` = '".addslashes($v)."'";

		$sql = 'INSERT INTO '.$this->_tables['photos'].' SET ' . implode(', ', $fields);

		if ( false !== $this->_db->query($sql) )
			return $this->_db->insert_id;

		return false;
	}

	public function UpdatePhoto(array $info)
	{
		if ( !sizeof($info) || !Data::Is_Number($info['PhotoID']) )
			return false;

		$fields = array();
		foreach( $info as $k => $v)
		{
			if (in_array($k, array('LastUpdated', 'PhotoID')))
				continue;
			$fields[] = "`$k` = '".addslashes($v)."'";
		}

		$sql = 'UPDATE '.$this->_tables['photos'].' SET ' . implode(', ', $fields);
		$sql .= ' WHERE PhotoID = '.$info['PhotoID'];

		if ( false !== $this->_db->query($sql) ) {
			$cache = $this->getCache();
			$cache->Remove('Photo_'.$info['PhotoID']);

			return true;
		}

		return false;
	}

	public function RemovePhoto($id)
	{
		if ( !Data::Is_Number($id) )
			return false;

		$photo = $this->GetPhoto($id);
		$photo->PhotoSmall = null;
		$photo->PhotoMiddle = null;
		$photo->PhotoMedium = null;
		$photo->PhotoLarge = null;

		$sql = 'DELETE FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
		if ( false !== $this->_db->query($sql) )
		{
			$cache = $this->getCache();
			$cache->Remove('Photo_'.$id);

			unset($this->_Photos[$id]);
			return true;
		}

		return false;
	}

	public function GetPhoto($id)
	{
		if ( !Data::Is_Number($id) )
			return null;

		if ( isset($this->_Photos[$id]) )
			return $this->_Photos[$id];

		$info = false;

		$cacheid = 'Photo_'.$id;

		if ($this->_cache !== null)
			$info = $this->_cache->get($cacheid);

		if ($_GET['nocache']>12)
			$info = false;

		if ($info === false)
		{
			$info = array();

			$sql = 'SELECT * FROM '.$this->_tables['photos'].' WHERE PhotoID = '.$id;
			if ( false === ($res = $this->_db->query($sql)))
				return null;

			if (!$res->num_rows )
				return null;

			$info = $res->fetch_assoc();

			if ($this->_cache !== null)
				$this->_cache->set($cacheid, $info, 3600);
		}

		$Photo = $this->_PhotoObject($info);
		return $Photo;
	}

	public function GetPhotos($filter)
	{
		if ( isset($filter['field']) ) {
			$filter['field'] = (array) $filter['field'];
			$filter['dir'] = (array) $filter['dir'];

			foreach($filter['field'] as $k => $v) {
				if ( !in_array($v, array('Ord', "RAND")) )
					unset($filter['field'][$k], $filter['dir'][$k]);
			}

			foreach($filter['dir'] as $k => $v) {
				$v = strtoupper($v);
				if ( $v != 'ASC' && $v != 'DESC' )
					$filter['dir'][$k] = 'ASC';
			}
		}

		if (!isset($filter['field']) || !sizeof($filter['field']) || !sizeof($filter['dir'])) {
			$filter['field'] = array('Ord');
			$filter['dir'] = array('DESC');
		}

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		if ( isset($filter['flags']['Ord']) && $filter['flags']['Ord'] > 0 )
			$filter['flags']['Ord'] = (int) $filter['flags']['Ord'];
		else
			$filter['flags']['Ord'] = -1;

		if ( isset($filter['flags']['IsVisible']) && $filter['flags']['IsVisible'] > 0 )
			$filter['flags']['IsVisible'] = (int) $filter['flags']['IsVisible'];
		else
			$filter['flags']['IsVisible'] = -1;

		if ( isset($filter['flags']['ArticleID']) && $filter['flags']['ArticleID'] > 0 )
			$filter['flags']['ArticleID'] = (int) $filter['flags']['ArticleID'];
		else
			$filter['flags']['ArticleID'] = -1;

		if ($filter['calc'] === true)
			$sql = 'SELECT SQL_CALC_FOUND_ROWS * ';
		else
			$sql = 'SELECT * ';

		$sql.= ' FROM '.$this->_tables['photos'].' ';

		$where = array();


		if ( $filter['flags']['IsVisible'] != -1 )
			$where[] = ' '.$this->_tables['photos'].'.IsVisible = '.$filter['flags']['IsVisible'];

		if ( $filter['flags']['ArticleID'] != -1 )
			$where[] = ' '.$this->_tables['photos'].'.ArticleID = '.$filter['flags']['ArticleID'];

		if (isset($filter['filter']) && is_array($filter['filter']['fields']) && sizeof($filter['filter']['fields'])) {
			$like = array();
			foreach($filter['filter']['fields'] as $k => $v) {
				if (!isset($filter['filter']['values'][$k]))
					$like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['query']).'\'';
				else
					$like[] = ' '.$this->_tables['photos'].'.`'.$v.'` LIKE \''.addslashes($filter['filter']['values'][$k]).'\'';
			}

			if ($filter['filter']['cond'])
				$where[] = implode(' AND ', $like);
			else
				$where[] = '('.implode(' OR ', $like).')';
		}

		if ( sizeof($where) )
			$sql .= ' WHERE '.implode(' AND ', $where);

		$sql.= ' ORDER BY ';

			$sqlo = array();
			foreach( $filter['field'] as $k => $v )
				$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];

			$sql .= implode(', ', $sqlo);

		if ( $filter['limit'] ) {
			$sql .= ' LIMIT ';
			if ( $filter['offset'] )
				$sql .= $filter['offset'].', ';

			$sql .= $filter['limit'];
		}

		if($filter['dbg'] == 1)
			echo $sql."<br>";
		$res = $this->_db->query($sql);
		if ( !$res || !$res->num_rows )
			return false;

		if ( $filter['calc'] === true )
		{
			$sql = "SELECT FOUND_ROWS()";
			list($count) = $this->_db->query($sql)->fetch_row();
		}

		$result = array();
		while ($row = $res->fetch_assoc())
		{
			if ($filter['flags']['objects'] === true)
			{
				$row = new TreeArticlePhoto($row);
			}
			$result[] = $row;
		}

		if ( $filter['calc'] === true )
			return array($result, $count);

		return $result;
	}
}