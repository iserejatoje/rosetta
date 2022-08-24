<?

include_once $CONFIG['engine_path']."include/lib.stpl.php";

class Handler_direct extends IHandler
{
	private $json;
	private $source;
	private $_params;
	private $_db;
	private $_tree;
	private $_root;

	public function Init($params) {
		$this->_db = DBFactory::GetInstance('dpsearch');
		$this->_params = $params['params'];
	}

	public function Run()
	{
		global $OBJECTS, $CONFIG;

		Response::NoCache();

		switch($this->_params['State']) {
			case 'show':

				$result = $this->_searchBanners();
				if ($result === null || $result['count'] == 0) {
					exit ;
				}

				$this->_incStatShow($result);
				STPL::Display('service/direct/_states/common', $result);
			break ;
			
			case 'click':

				$id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
				
				$sql = 'SELECT * FROM direct_banner ';
				$sql.= ' WHERE id = '.$id.' AND url != \'\'';

				$res = $this->_db->query($sql);
				if (!$res || !$res->num_rows)
					Response::Status(404, RS_SENDPAGE | RS_EXIT);
				
				$banner = $res->fetch_assoc();
				if (trim($banner['url']) == '')
					Response::Status(404, RS_SENDPAGE | RS_EXIT);
				
				$this->_incStatClick($id);
				Response::Redirect($banner['url']);
			break ;
		}

		exit ;
	}

	private function _searchBanners() {
		global $CONFIG;
		
		$Query = App::$Request->Get['q']->Value(Request::OUT_HTML);
		$RegID = App::$Request->Get['rid']->Int(0, Request::UNSIGNED_NUM);
		if (empty($Query))
			return null;

		$list = array(
			'count' => 0,
			'type' => 1,
			'list' => array(),
		);

		$sql = 'SELECT banner.* FROM direct_words as words';
		$sql.= ' INNER JOIN direct_banner as banner ON (banner.id = words.b_id)';
		$sql.= ' WHERE words.value=\''.addslashes($Query).'\'';
		$sql.= ' AND banner.visible = 1';
		$sql.= ' AND banner.type = 1';
		$sql.= ' AND banner.regid = '.$RegID;
		$sql.= ' GROUP BY words.b_id';

		$res = $this->_db->query($sql);
		while(false != ($row = $res->fetch_assoc())) {
			$list['list'][$row['id']] = $row;
		}

		$list['count'] = sizeof($list['list']);

		return $list;
	}

	function _incStatShow($list) {

		if ($list['count'] <= 0)
			return false;

		$banners = array_keys($list['list']);

		$subData = array();
		foreach($list['list'] as $v) {
			$subData[] = 'CURRENT_DATE(), '.$v['id'].', 1, 0';
		}

		$sql = 'INSERT INTO direct_stat_banner (date, b_id, view, click) VALUES ';
		$sql.= ' ('.implode('), (', $subData).') ';
		$sql.= ' ON DUPLICATE KEY UPDATE `view` = `view` + 1';

		$this->_db->query($sql);
	}
	
	function _incStatClick($id) {

		//$banners = array_keys($list['list']);

		$sql = 'INSERT INTO direct_stat_banner (date, b_id, view, click) VALUES ';
		$sql.= ' (CURRENT_DATE(), '.$id.', 0, 1) ';
		$sql.= ' ON DUPLICATE KEY UPDATE `click` = `click` + 1';

		$this->_db->query($sql);
	}

	public function IsLast() {
		return true;
	}

	public function Dispose() { }
}
?>