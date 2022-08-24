<?php
require_once ($CONFIG['engine_path'].'include/conference/conference.php');
require_once ($CONFIG['engine_path'].'include/conference/conferenceiterator.php');

/**
 * @author Овчинников Евгений
 * @version 1.0
 * @created 09-апр-2009 11:21:18
 * по всем изменениям и дополнениям к автору
 */

class ConferenceMgr {

	public static $images_dir = '/common_fs/i/conference/1/';
	public static $images_url = '/_CDN/_i/conference/1/';

	public static $db;
	private $_tables = null;
	private $_cache = null;

	function __construct()
	{
		LibFactory::GetStatic('heavy_data');
		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('filestore');

		$this->_cache = new Cache();
		$this->_cache->Init('memcache', 'conference');
		
		self::$db = DBFactory::GetInstance('conference');
	}

	/**
	 * синглтон
	 *
	 * @return ConferenceMgr
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

	public function getConference($filter) {
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
				if ( !in_array($v, array('Title','Date', 'DateEnd')) )
					unset($filter['field'][$k], $filter['dir'][$k]);
				elseif ($v == 'Date')
					$filter['field'][$k] = 'r.Date';
				elseif ($v == 'DateEnd')
					$filter['field'][$k] = 'r.DateEnd';
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
			
		if(!isset($filter['isnow']) || !is_array($filter['isnow']))
			$filter['isnow'] = array();
		
		if(isset($filter['addmaterial']) && $filter['addmaterial'] !== null)
			$filter['addmaterial'] = (int) $filter['addmaterial'];
		else
			$filter['addmaterial'] = null;

		$sql= 'SELECT SQL_CALC_FOUND_ROWS a.*, r.SectionID, r.RefID ';
		$sql.= ' FROM conference_ref AS r, conference as  a ';
		$sql.= ' WHERE r.`opt_inState` = 1 ';
		
		if ( !empty($filter['regions']) )
			$sql.= ' AND r.RegionID IN('.implode(',', $filter['regions']).') ';
		
		if ( !empty($filter['sections']) )
			$sql.= ' AND r.SectionID IN('.implode(',', $filter['sections']).') ';

		if ( $filter['addmaterial'] !== null )
			$sql.= ' AND a.AddMaterial = '.$filter['addmaterial'].' ';
			
		if ( !empty($filter['isnow']) )
			$sql.= ' AND a.isNow IN('.implode(',', $filter['isnow']).') ';
			
		$sql.= ' AND a.ConferenceID = r.ConferenceID';

		if ( !empty($filter['skip']) )
			$sql .= ' AND a.ConferenceID NOT IN('.implode(',', $filter['skip']).') ';

		if ( $filter['limit'] > 1 && (sizeof($filter['sections']) > 1 || !empty($filter['regions'])))
			$sql.= ' GROUP by a.ConferenceID ';
			
		$sqlo = array();
		foreach( $filter['field'] as $k => $v )
			$sqlo[] = ' '.$filter['field'][$k].' '.$filter['dir'][$k];
			
		$sql .= ' ORDER by '.implode(', ', $sqlo);
		
		if ( $filter['limit'] ) 
			$sql .= ' LIMIT '.$filter['offset'].', '.$filter['limit'];

		$res = self::$db->query($sql);
		
		$conference = array();
		while ($row = $res->fetch_assoc()) {
			$conference[] = $row;
		}
		$count = 0;
		$res1 = self::$db->query('SELECT found_rows()');
		if ( $res1 && $res1->num_rows )
			list($count) = $res1->fetch_row();

		return new PConferenceIterator($conference, $count);
	}
}


?>
