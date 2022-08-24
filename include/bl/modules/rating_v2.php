<?

/**
* Бизнес-логика для рейтингов rating_v2
*
* @author Винникова Оксана
* @version 1.0
* @created xx-янв-2010
*/

class BL_modules_rating_v2
{
	public $title_separator = '. ';
	
	private $_db		= null;
	private $_nsTree 	= null;
	private $_placeMgr 	= null;
	
	private $tables	= array();
		
	private $item_col_pp = 20;
	private $comments_col_pp = 20;
	private $ankets_col_pp = 20;
	private $firms_sectionid = 0;

	private $p = 1;
	
	private $sectionid = 0;
	
	private $admin_mode = false;		// работа в режиме админки (т.е. не используется slave)
	
	protected $ratings = null;			 // список рейтингов
	protected $rating = null;			 // конкретный рейтинг
	
	protected $ankets = null;		 	 // анкеты
	protected $anketa = null;		 	 // конкретная анкета
	protected $scale_mark = 5;		 	 	// скольки балльная система, шкала
	protected $anonymousOn = 0;			//включена ли возможность писать и голосовать анонимно
	protected $protect_time = 0;		 	 	// интервал для голосования в часах: 0 - 1 раз только, 24 - 1 раз в 24 часа

	function __construct()
	{
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
	}

	function Init($params)
	{
		LibFactory::GetMStatic('place', 'placemgr');
		LibFactory::GetMStatic('tree', 'nstreemgr');

		if(isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);

		$this->_placeMgr = PlaceMgr::getInstance();
		$this->_nsTree = new NSTreeMgr($this->_db, $this->_placeMgr->_tables['tree']);

		if(isset($params['sectionid']) && Data::Is_Number($params['sectionid']))
			$this->sectionid = (int) $params['sectionid'];
		
		if(isset($params['tables']) && is_array($params['tables']))
			$this->tables = $params['tables'];

		if(isset($params['firms_sectionid']) && !empty($params['firms_sectionid']))
			$this->firms_sectionid = $params['firms_sectionid'];

		if( isset($params['admin_mode']) )
			$this->admin_mode = (bool) $params['admin_mode'];
			
		if(isset($params['year']))
		{
			$this->year = $params['year'];
			
			if(isset($params['month']))
				$this->month = $params['month'];
				
			if(isset($params['day']))
				$this->day = $params['day'];
		}
			
		if(isset($params['item_col_pp']))
			$this->item_col_pp = $params['item_col_pp'];

		if(isset($params['ankets_col_pp']))
			$this->ankets_col_pp = $params['ankets_col_pp'];
		
		if(isset($params['comments_col_pp']))
			$this->comments_col_pp = $params['comments_col_pp'];

		if(isset($params['scale_mark']))
			$this->scale_mark = $params['scale_mark'];

		if(isset($params['anonymousOn']))
			$this->anonymousOn = $params['anonymousOn'];

		if(isset($params['protect_time']))
			$this->protect_time = $params['protect_time'];
		
		if(isset($params['title_separator']))
			$this->title_separator = $params['title_separator'];
			
		if(isset($params['p']) && Data::Is_Number($params['p']))
			$this->p = (int) $params['p'];
	}
	
	/**
	* Изменить значение параметра
	*
	* @return boolean
	* @param param_name string - имя устанавливаемого параметра
	* @param param_value string - новое значение устанавливаемого параметра
	*/
	public function SetParameterValue($param_name = '', $param_value = '')
	{
		if( empty($param_name) )
			return false;
			
		switch( $param_name )
		{
			case 'item_col_pp':
				if( Data::Is_Number($param_value) )
					$this->item_col_pp = (int) $param_value;
			break;
		}
		
		return true;
	}
	
	
/************************ Рейтинги ************************/
	/**
	* Проверка, можно ли голосовать в этом рейтинге
	*
	* @return boolean
	* @param ItemID integer - ID рейтинга
	*/
	public function CanRatingVote($ItemID = 0)
	{
		if ( !Data::Is_Number($ItemID) )
			return false;
	
		// получить рейтинг
		$this->rating = $this->GetRatingDetails($ItemID);
		
		if ( null === $this->rating )
			return false;
			
		return (bool) (!$this->rating['IsClosed'] && $this->rating['IsVisible']);
	}
	
	/**
	* Проверка, можно ли голосовать в рейтинге по дате голосования
	*
	* @return boolean
	* @param ItemID integer - ID рейтинга
	*/
	public function CanVoteByDate($ItemID = 0)
	{
		if ( !Data::Is_Number($ItemID) || !$this->CanRatingVote($ItemID) )
			return false;
	
		$date_now = Datetime_my::NowOffset();
		
		if( $this->rating['Date'] == 0 )
			$isStarted = true;
		else
			$isStarted = $date_now >= Datetime_my::NowOffset(null, strtotime($this->rating['Date']));

		return (bool) ($isStarted);
	}

	/**
	* Сколько раз голосовал пользователь в интервале времени
	*
	* @return int
	* @param ItemID integer - ID рейтинга
	* @param PlaceID integer - ID органиазции
	* @param UserID integer - ID пользователя
	* @param cookies integer - кука пользователя
	*/
	public function CanUserVote($ItemID, $PlaceID, $UserID, $cookies) {

		$sql = 'SELECT COUNT(*) FROM ' . $this->tables['hosts'];
		$sql .= ' WHERE (`UserID`=' . $UserID . ' OR `Cookies`= "' . $cookies . '") AND `ItemID`=' . $ItemID . ' AND `PlaceID`=' . $PlaceID;
                if ($this->protect_time)
			$sql .= ' AND Created>=subdate(NOW(), INTERVAL '.$this->protect_time.' HOUR)';		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		list($count) = $res->fetch_row();
		
		return $count;		
	}
	

	/**
	* Состояние рейтинга
	*
	* @return array (не начался, идет, закончился)
	* @param ItemID integer - ID рейтинг
	* @param IsVisible integer - видимый рейтинг (1) или нет(0); -1 - не важно
	*/
	public function RatingState($ItemID = 0, $IsVisible = 1)
	{
		$result = array(false, false, false);
	
		if ( !Data::Is_Number($ItemID) )
			return $result;
			
		// получить рейтинг
		$this->rating = $this->GetRatingDetails($ItemID, $IsVisible);

		if ( null === $this->rating )
			return $result;

		$date_now = Datetime_my::NowOffset();
	
		if( $this->rating['Date'] == 0 )
			$isStarted = true;
		else
			$isStarted = $date_now >= Datetime_my::NowOffset(null, strtotime($this->rating['Date']));

		return array( (bool) ($isVisible && !$isStarted), (bool) ($isStarted && !$this->rating['IsClosed']), (bool) ($isStarted && $this->rating['IsClosed']) );
	}

	/**
	* Получить количество рейтингов
	*
	* @return integer
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param UseDates boolean - использовать ограничение по датам (true) или нет (false)
	*/
	public function GetRatingCount($IsVisible = 1, $UseDates = true)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tables['item'] . ' AS c';
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ItemID = c.ItemID';
		
		$where = array('r.SectionID = ' . $this->sectionid);
		
		/*if( !$this->admin_mode )
			$where[] = 'r.SiteID = ' . $this->sectionid;*/
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( $UseDates )
		{
			$where[] = '(c.Date = 0 OR c.Date < "' . Datetime_my::NowOffset() . '")';
		}
		
		if( null !== $this->year && intval($this->year) > 0 )
		{
			$date = $this->year;
			if( null !== $this->month && intval($this->month) > 0 )
				$date .= '-' . $this->month;
			if( null !== $this->day && intval($this->day) > 0 )
				$date .= '-' . $this->day;
			$where[] = 'c.Date LIKE "' . $date . '%"';
		}
		
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		if( $res === false )
			return 0;
			
		list($CountRatings) = $res->fetch_row();
		
		return $CountRatings;
	}
	
	/**
	* Получить список рейтингов
	*
	* @return array
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param UseDates boolean - использовать ограничение по датам (true) или нет (false)
	* @param IsFullInfo bool - выводить всю информацию (true), сокращённо (false)
	* @param IsGetAll boolean - выводить без учёта sectionid (true), только конкретные (false)
	* @param filter array - фильтр (для ORDER BY)
	* @param UseCache bool - использовать закешированные данные (true) или нет (false)
	*/
	public function GetRatingList($IsVisible = 1, $UseDates = true, $IsFullInfo = false, $IsGetAll = false, $ItemID = null, $filter = null, $UseCache = true)
	{
		$list = array();
		
		if( $UseCache && null !== $this->ratings )
			return $this->ratings;
			
		if(!sizeof($filter))
			$filter = array(
				'sort' => array(
					array('field' => 'c.Date', 'dir' => 'DESC'),
					array('field' => 'c.Name', 'dir' => 'ASC')
				)
			);
	
		$sql = 'SELECT c.ItemID AS ItemID, c.Name, c.NodeID, c.IsClosed';
		
		if( $IsFullInfo )
		{
			$sql .= ', c.Date, c.AnkID, c.IsComments, c.IsVisible';
		}
		
		$sql.= ' FROM ' . $this->tables['item'] . ' AS c';
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ItemID = c.ItemID';
		
		$where = array();
		
		if( !$IsGetAll )
			$where[] = 'r.SectionID = ' . $this->sectionid;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( null !== $ItemID )
		{
			$where[] = 'c.ItemID IN (' . implode(',', (array) $ItemID) . ')';
		}
			
		if( $UseDates )
		{
			$where[] = '(c.Date = 0 OR c.Date < "' . Datetime_my::NowOffset() . '")';
		}
		
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= ' ORDER BY ';
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ( !in_array(strtolower($f['dir']), array('asc', 'desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = ' ' . $f['field'] . ' ' . $f['dir'] . ' ';
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		$sql .= ' LIMIT ' . ($this->item_col_pp * ($this->p-1)) . ', ' . $this->item_col_pp;

		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while($row = $res->fetch_assoc())
		{
			if( $IsFullInfo )
				list($row['isStarted'], $row['isEnded'], $row['isGo']) = $this->RatingState($row['ItemID'], $IsVisible); // состояние рейтинга
		
			$list[$row['ItemID']] = $row;
		}
			
		return $this->ratings = $list;
	}

	/**
	* Получить данные рейтинга
	*
	* @return array
	* @param ItemID integer - ID рейтинга
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param IsGetAll boolean - выводить без учёта sectionid (true), только конкретные (false)
	*/
	public function GetRatingDetails($ItemID = 0, $IsVisible = 1, $IsGetAll = false)
	{
		if(!Data::Is_Number($ItemID) || !$ItemID)
			return array();
		
		if ( null !== $this->rating && $this->rating['ItemID'] == $ItemID )
			return $this->rating;
		
		$sql = 'SELECT
					c.ItemID,
					c.Date,
					c.Name,
					c.EntryText,
					c.NodeID,
					c.AnkID,
					c.IsVisible,
					c.IsClosed,
					c.IsComments
				FROM ' . $this->tables['item'] . ' AS c';
				
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ItemID = c.ItemID';
		
		$where = array();
		
		if( !$IsGetAll )
			$where[] = 'r.SectionID = ' . $this->sectionid;
			
		$where[] = 'c.ItemID = ' . (int) $ItemID;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if($row = $res->fetch_assoc())
			$this->rating = $row;
		else
			$this->rating = null;
		
		return $this->rating;
	}

	/**
	* Получить краткую информацию о рейтинге для поиска
	*
	* @return array
	* @param SectionID integer - sectionid раздела
	* @param Name varchar - часть имени для поиска
	* @param ItemID array - массив  с рейтингами
	*/
	public function GetRatingListSearch($SectionID = 0, $Name="", $ItemID = array())
	{
		if(!Data::Is_Number($SectionID) || !$SectionID)
			return array();

		$sql = 'SELECT
					c.ItemID as RatingID,
					c.Date,
					r.SectionID,
					c.Name
				FROM ' . $this->tables['item'] . ' AS c';
				
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ItemID = c.ItemID';

		$where = array();

		if (is_array($ItemID) && count($ItemID)) {
			$where[] = 'r.ItemID  IN (' . implode(",",$ItemID).")";
		} else {
			$where[] = 'r.SectionID = ' . $SectionID;
		}

		$where[] = 'c.IsVisible = 1';

		if (!empty($Name))			
			$where[] = 'c.Name LIKE  "' . $Name . '%"';
		
			
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);		

		$list = array();

		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);

		while ($row = $res->fetch_assoc())
			$list[] = $row;
		
		return $list;
	}


	/**
	* Добавить рейтинг
	*
	* @return boolean
	* @param data array - параметры анкеты
	*/
	public function AddRating($data = null)
	{
		if( empty($data) || !is_array($data) )
			return false;
	
		$sql  = 'INSERT INTO ' . $this->tables['item'];
		$sql.= ' SET
					`Date` = "' . $data['Date'] . '",
					`Name` = "' . addslashes($data['Name']) . '",
					`EntryText` = "' . addslashes($data['EntryText']) . '",
					`NodeID` = ' . ( isset($data['NodeID']) && Data::Is_Number($data['NodeID']) ? $data['NodeID'] : 0 ) . ',
					`IsVisible` = ' . ( isset($data['IsVisible']) ? $data['IsVisible'] : 0 ) . ',
					`IsClosed` = ' . ( isset($data['IsClosed']) ? $data['IsClosed'] : 0 ) . ',
					`IsComments` = ' . ( isset($data['IsComments']) ? $data['IsComments'] : 0 ) . ',
					`AnkID` = ' . ( isset($data['AnkID']) && Data::Is_Number($data['AnkID']) ? $data['AnkID'] : 0 );

		$this->_db->query($sql);
		
		return $this->_db->insert_id;
	}
	
	/**
	* Редактировать рейтинг
	*
	* @return boolean
	* @param data array - параметры анкеты
	*/
	public function UpdateRating($data = null)
	{
		if( empty($data) || !is_array($data) )
			return false;
	
		$sql  = 'UPDATE ' . $this->tables['item'];
		$sql.= ' SET
					`Date` = "' . $data['Date'] . '",
					`Name` = "' . addslashes($data['Name']) . '",
					`EntryText` = "' . addslashes($data['EntryText']) . '",
					`NodeID` = ' . ( isset($data['NodeID']) && Data::Is_Number($data['NodeID']) ? $data['NodeID'] : 0 ) . ',
					`IsVisible` = ' . ( isset($data['IsVisible']) ? $data['IsVisible'] : 0 ) . ',
					`IsClosed` = ' . ( isset($data['IsClosed']) ? $data['IsClosed'] : 0 ) . ',
					`IsComments` = ' . ( isset($data['IsComments']) ? $data['IsComments'] : 0 ) . ',
					`AnkID` = ' . ( isset($data['AnkID']) && Data::Is_Number($data['AnkID']) ? $data['AnkID'] : 0 );
		$sql.= ' WHERE `ItemID` = ' . $data['ItemID'];

		return $this->_db->query($sql);
	}

	/**
	* Изменить видимость рейтинга
	*
	* @return boolean
	* @param ItemID integer - ID рейтинга
	*/
	public function ToggleRatingVisible($ItemID = 0)
	{
		if(!Data::Is_Number($ItemID) || !$ItemID)
			return false;
			
		$sql  = 'UPDATE ' . $this->tables['item'];
		$sql.= ' SET `IsVisible` = 1 - `IsVisible`';
		$sql.= ' WHERE `ItemID` = ' . (int) $ItemID;
		
		return $this->_db->query($sql);
	}

	/**
	* Удалить голоса с комментариями
	*
	* @return boolean
	* @param HostID integer || array - ID(ы) комментов(ов)
	*/
	public function DeleteComments($HostID = null)
	{
		if( empty($HostID) )
			return false;

		$this->_db->query( 'DELETE FROM ' . $this->tables['answers'] . ' WHERE `HostID` IN (' . implode(',', (array) $HostID) . ')' );

		return $this->_db->query( 'DELETE FROM ' . $this->tables['hosts'] . ' WHERE `HostID` IN (' . implode(',', (array) $HostID) . ')' );
	}

	/**
	* Удалить рейтинг
	*
	* @return boolean
	* @param ItemID integer || array - ID(ы) рейтинга(ов)
	*/
	public function DeleteRating($ItemID = null)
	{
		if( empty($ItemID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['item'] . ' WHERE `ItemID` IN (' . implode(',', (array) $ItemID) . ')' );
	}

	/**
	* Добавить связь в REF-таблицу
	*
	* @return boolean
	* @param data array - параметры
	*/
	public function AddRatingRef($data = null)
	{
		if( empty($data) || !is_array($data) || !isset($data['ItemID']) || !Data::Is_Number($data['ItemID']) )
			return false;
			
		$sql = 'INSERT INTO ' . $this->tables['ref'];
		$sql.= ' SET ';
		$sql.= ' `ItemID` = ' . (int) $data['ItemID'] . ',';
		$sql.= ' `RegionID` = ' . (int) $data['RegionID'] . ',';
		$sql.= ' `SiteID` = ' . (int) $data['SiteID'] . ',';
		$sql.= ' `SectionID` = ' . (int) $data['SectionID'] . ',';
		$sql.= ' `Date` = "' . $data['Date'] . '"';
			
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить связь из REF-таблицы
	*
	* @return boolean
	* @param ItemID integer || array - ID(ы) рейтинга(ов)
	*/
	public function DeleteRatingRef($ItemID = null)
	{
		if( empty($ItemID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['ref'] . ' WHERE `ItemID` IN (' . implode(',', (array) $ItemID) . ')' );
	}


	/**
	* Получение списка составленных анкет 
	*
	*/
	public function GetAnketsList()
	{
		$list = array();
	
		$sql = 'SELECT `AnkID`, `Name`';
		$sql.= ' FROM ' . $this->tables['ankets'];
		$sql.= ' ORDER BY `Name` ASC';
//		$sql .= ' LIMIT ' . ( $this->ankets_col_pp * ($this->p - 1) ) . ', ' . $this->ankets_col_pp;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while ($row = $res->fetch_assoc())
			$list[$row['AnkID']] = $row;
			
		return $this->ankets = $list;
	}

	/**
	* Получение количества анкет
	*
	* @return integer
	*/
	public function GetAnketsCount()
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tables['ankets'];
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		list($count) = $res->fetch_row();
		
		return $count;
	}

	/**
	* Получить детали анкеты
	*
	* @return array
	* @param AnkID integer - ID анкеты
	*/
	public function GetAnketaDetails($AnkID = 0)
	{
		$data = array();
		
		if ( !Data::Is_Number($AnkID) || !$AnkID )
			return $data;
			
		if ( null !== $this->anketa && $this->anketa['AnkID'] == $AnkID )
			return $this->anketa;

		$sql = 'SELECT
					`AnkID`,
					`Name`
				FROM ' . $this->tables['ankets'];
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		$data = $res->fetch_assoc();
		$data["questions"] = $this->GetAnketaQuestions((int) $AnkID);
		$data["scale_mark"] = $this->scale_mark;
		$data["anonymousOn"] = $this->anonymousOn;
		
		return $this->anketa = $data;
	}

	/**
	* Получить вопросы анкеты
	*
	* @return array
	* @param AnkID integer - ID анкеты
	*/
	public function GetAnketaQuestions($AnkID = 0)
	{
		$data = array();
		
		if ( !Data::Is_Number($AnkID) || !$AnkID )
			return $data;
			
		$sql = 'SELECT
					`QuestID`,
					`Name`,
					`Ord`
				FROM ' . $this->tables['questions'];
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		$sql.= ' ORDER BY `Ord` ASC';
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while ($row = $res->fetch_assoc()) {
			$data[$row["QuestID"]] = $row;
		}
		
		return $data;
	}


	/**
	* Добавить/Редактировать анкету
	*
	* @return int - id анкеты, если добавили или удалось обновить
	* @param add boolean - добавить (true) / отредактировать (false) анкету
	* @param field array - параметры анкеты
	*/
	public function UpdateAnketa($add = true, $data = null)
	{
		if( empty($data) || !is_array($data) )
			return false;
			
		$data['AnkID'] = (int) $data['AnkID'];

		$exists_ids = array();
		if ($add === true) {
			$sql  = 'INSERT INTO ' . $this->tables['ankets'];
			$sql.= ' SET `Name` = "' . addslashes($data['Question']) . '"';

			$this->_db->query($sql);
			$data['AnkID'] = $this->_db->insert_id;			
		} else {
	
			$sql  = 'UPDATE ' . $this->tables['ankets'];
			$sql.= ' SET
					`Name` = "' . addslashes($data['Question']) . '"';
			$sql.= ' WHERE `AnkID` = ' . $data['AnkID'];
			$this->_db->query($sql);

			$exists_ids = array_keys($this->GetAnketaQuestions($data['AnkID']));
		}

		$del_ans = array();
		
		if (!empty($_POST['del_ans'])) {
		
			$del_ans = array_intersect($exists_ids, $_POST['del_ans']);
			
			$sql = "DELETE FROM {$this->tables['questions']}
				WHERE QuestID IN(".implode(',', $del_ans).")";
				
			$this->_db->query($sql);
		}

		foreach($data["Answers"] as $k => $v) {
		
			if (!in_array($k, $del_ans))
				if (in_array($k, $exists_ids))
					$sql = "UPDATE {$this->tables['questions']}
					SET Name='$v'
					WHERE QuestID=$k";
				else
					$sql = "INSERT INTO {$this->tables['questions']}
					SET AnkID=".$data['AnkID'].",
					Name='".$v."'";
			$this->_db->query($sql);
		}

		return $data['AnkID'];
	}

	/**
	* Удалить анкету(ы) по AnkID
	*
	* @return boolean
	* @param AnkID integer || array - ID(ы) анкет(ы)
	*/
	public function DeleteFullAnketa($AnkID = null)
	{
		if( empty($AnkID) )
			return false;

		$del_ans = array_keys($this->GetAnketaQuestions($AnkID));
		$this->_db->query( 'DELETE FROM ' . $this->tables['answers'] . ' WHERE `QuestID` IN (' . implode(',', $del_ans) . ')' );
		$this->_db->query( 'DELETE FROM ' . $this->tables['questions'] . ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')' );	
	
		return $this->_db->query( 'DELETE FROM ' . $this->tables['ankets'] . ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')' );
	}

	/**
	* Добавить голос
	*
	* @return int -  ID голоса
	* @param field array - массив параметров
	*/
	public function AddVote($field) {
		$ip 	= (isset($field['Ip']) ? addslashes($field['Ip']) : getenv("REMOTE_ADDR"));
		$ip_fw 	= (isset($field['Ip_fw']) ? addslashes($field['Ip_fw']) : getenv("HTTP_X_FORWARDED_FOR"));
		$cookies = (isset($field['Cookies']) ? addslashes($field['Cookies']) : Request::GetUID());	

		$sql  = 'INSERT INTO ' . $this->tables['hosts'];
		$sql.= ' SET
					`ItemID` = ' . (int) $field['ItemID'] . ',
					`PlaceID` = ' . (int) $field['PlaceID'] . ',
					`UserID` = ' . (int) $field['UserID'] . ',
					`SectionID` = ' . (int) $field['SectionID'] . ',
					`Created` = ' . (isset($field['Created']) ? '"'.$field['Created'].'"' : 'NOW()') . ',
					`Name` = "' . addslashes($field['Name']) . '",
					`Text` = "' . addslashes($field['Text']) . '",
					`Ip` = "' . addslashes($ip.'->'.$ip_fw) . '",
					`Cookies` = "' . addslashes($cookies) . '"';
		
		if( isset($field['Marks']) && is_array($field['Marks']) )
			$sql .= ', `Mark` = ' . (int) array_sum($field['Marks']);
			
		$this->_db->query($sql);
		$HostID = $this->_db->insert_id;
		
		if ($HostID && is_array($field['Marks'])) {
			$this->AddMarks($HostID,$field);	
		}
		
		return $HostID;			
	}

	/**
	* Добавить оценки
	*
	* @param HostID int - ID голоса
	* @param field array - массив параметров
	*/
	protected function AddMarks($HostID,$field) {

		foreach ($field['Marks'] as $k => $mark) {
			$sql = 'INSERT INTO '.$this->tables['answers'];
			$sql.= ' SET 
					`HostID` = ' . (int) $HostID . ',	
					`QuestID` = ' . (int) $k . ',	
					`Mark` = ' . (int) $mark . ',
					`ItemID` = ' . (int) $field['ItemID'] . ',
					`PlaceID` = ' . (int) $field['PlaceID'];
			$this->_db->query($sql);
		}

	}


	/**
	* Получить статистику в срезе по организациям-участникам рейтинга
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param qcount int - количество вопросов в рейтинге
	* @param limit int - кол-во организаций
	*/
	public function StatByPlace($ItemID,$qcount,$limit=0) {

		$data = array();
		$limit = (int) $limit;
		if ($ItemID) {
			$sql = 'SELECT `PlaceID`, count(*) as `Count`, sum(`Mark`) as `Summa`'; 
			$sql .= ' FROM ' .$this->tables['hosts']; 
			$sql .= ' WHERE `ItemID`=' . (int)$ItemID;
			$sql .= ' GROUP BY `PlaceID`'; 
			$sql .= ' ORDER BY `Summa` DESC, `Count` DESC';
			if ($limit>0)
				$sql .= ' LIMIT '. $limit;
			
			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
			while ($row = $res->fetch_assoc()) {
				$data[$row["PlaceID"]] = $row;
				if ($row["Count"]>0 && $qcount>0)
					$data[$row["PlaceID"]]["SMark"] = number_format($row["Summa"] / $row["Count"] / $qcount,"1","."," ");
				else
					$data[$row["PlaceID"]]["SMark"] = 0;
			}
		}
		return $data;
	}

	/**
	* Получить статистику в срезе по организациям-участникам и вопросу
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param QuestID int - ID вопроса
	*/
	public function StatByPlaceToQuest($ItemID,$QuestID) {

		$data = array();
		if ($ItemID && $QuestID) {
			$sql = 'SELECT `PlaceID`, count(*) as `Count`, sum(`Mark`) as `Summa`'; 
			$sql .= ' FROM ' .$this->tables['answers']; 
			$sql .= ' WHERE `ItemID`=' . (int)$ItemID . ' AND `QuestID`=' . (int)$QuestID;
			$sql .= ' GROUP BY `PlaceID`'; 
			$sql .= ' ORDER BY `Summa` DESC, `Count` DESC';
			
			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
			while ($row = $res->fetch_assoc()) {
				$data[$row["PlaceID"]] = $row;
				if ($row["Count"]>0)
					$data[$row["PlaceID"]]["SMark"] = number_format($row["Summa"] / $row["Count"],"1","."," ");
				else
					$data[$row["PlaceID"]]["SMark"] = 0;
			}
			
			// updated 2010.02.12, djoa
//			uasort($data, array($this, '_array_sort_desc'));
		}
		return $data;
	}
	
	/**
	* Сортировка массива "по качеству" - по итоговой оценке SMark
	*
	*/
	protected function _array_sort_desc ($a, $b)
	{
		if ($a['SMark'] == $b['SMark'])
		{
			if($a['Count'] == $b['Count'])
			return 0;

			return ($a['Count'] > $b['Count']) ? -1 : 1;
		}
		return ($a['SMark'] > $b['SMark']) ? -1 : 1;
	}

	/**
	* Получить статистику в срезе по вопросам и организации-участнице
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param PlaceID int - ID вопроса
	*/
	public function StatByQuestToPlace($ItemID,$PlaceID) {

		$data = array();
		if ($ItemID && $PlaceID) {
			$sql = 'SELECT `QuestID`, count(*) as `Count`, sum(`Mark`) as `Summa` ';
			$sql .=	' FROM ' .$this->tables['answers'];
			$sql .=	' WHERE `ItemID`=' . (int)$ItemID . ' AND `PlaceID`=' . (int)$PlaceID;
			$sql .=	' GROUP BY `QuestID`';

			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
			while ($row = $res->fetch_assoc()) {
				$data[$row["QuestID"]] = $row;
				if ($row["Count"]>0)
					$data[$row["QuestID"]]["SMark"] = number_format($row["Summa"] / $row["Count"],"1","."," ");
				else
					$data[$row["QuestID"]]["SMark"] = 0;
			}
		}
		return $data;
	}

	/**
	* Получить количество комментариев организации
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param PlaceID int - ID вопроса
	* @param WithUnVisible int - с учетом невидимых
	*/
	public function GetCountCommentToPlace($ItemID,$PlaceID=0,$WithUnVisible=0) {

		if ($ItemID) {
			$sql = 'SELECT count(*)';
			$sql .= ' FROM ' .$this->tables['hosts']; 
			$sql .= ' WHERE `ItemID`=' . $ItemID;
			if (!empty($PlaceID))
				$sql .= ' AND `PlaceID`=' . $PlaceID; 
			if (empty($WithUnVisible))
				$sql .= ' AND `IsVisible`=1';

			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
			if( $res === false )
				return 0;
			
			list($count) = $res->fetch_row();
		}
		
		return $count;
	}

	/**
	* Получить комментарии организации
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param PlaceID int - ID вопроса
	* @param WithUnVisible int - с учетом невидимых
	*/
	public function GetCommentToPlace($ItemID,$PlaceID=0,$WithUnVisible=0) {
		$data = array();
		if ($ItemID) {
			$sql = 'SELECT `HostID`,`UserId`,`Created`,`Name`,`Text`';
			$sql .= ' FROM ' .$this->tables['hosts']; 
			$sql .= ' WHERE `ItemID`=' . $ItemID;
			if (!empty($PlaceID))
				$sql .= ' AND `PlaceID`=' . $PlaceID; 
			if (empty($WithUnVisible))
				$sql .= ' AND `IsVisible`=1';
			$sql .= ' ORDER BY `Created` DESC';
			$sql .= ' LIMIT ' . ($this->comments_col_pp * ($this->p-1)) . ', ' . $this->comments_col_pp;

			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
			while ($row = $res->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;		
	}

	/**
	* Получить последний комментарий в рейтинге (возможно к конкретной организации)
	*
	* @return array
	* @param ItemID int - ID рейтинга
	* @param PlaceID int - ID вопроса
	*/
	public function GetLastCommentToItem($ItemID, $PlaceID=0) {
		$data = array();

		if ($ItemID) {
			$sql = 'SELECT `HostID`,`UserId`,`Created`,`Name`,`Text`,`PlaceID`';
			$sql .= ' FROM ' .$this->tables['hosts']; 
			$sql .= ' WHERE `ItemID`=' . (int)$ItemID . ' AND `IsVisible`=1';
			if ($PlaceID>0)
				$sql .= ' AND `PlaceID`='.$PlaceID;
			$sql .= ' ORDER BY `Created` DESC';
			$sql .= ' LIMIT 1';

			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
			$data = $res->fetch_assoc();
		}
		return $data;		
	}

	/**
	* Изменить комментарий
	*
	* @param data array - параметры комментария
	*/
	public function UpdateComment($data){
		if (isset($data) && is_array($data)) {
			$sql  = 'UPDATE ' . $this->tables['hosts'];
			$sql.= ' SET
					`Text` = "' . addslashes($data['Text']) . '"';
			$sql.= ' WHERE `HostID` = ' . $data['HostID'];

			$this->_db->query($sql);
		}
	}

	/**
	* Вернуть список организаций рубрики
	*
	* @return array
	* @param NodeID int - id конечной ветки в справочнике
	*/
	public function &GetPlaces($NodeID) {
		
		$filter = array(
			'flags' => array(
				'NodeID'    => $NodeID,                      
				'IsVisible'    => 1,
				'objects'	=> true,
			),

			'field'    => array(                
				'Name',
			),
			'dir'    => array(
				'ASC',                
			),				
		);

		$link = ModuleFactory::GetLinkBySectionId($this->firms_sectionid);
		$node = $this->_nsTree->getNode($NodeID);
		$this->_root = $this->_nsTree->setTreeId($node->treeid);
		if ($node->isLeaf()) {
			$path_list = $node->getPath(true);
			$pathList = rtrim($this->_getNamePath($path_list),'/');
		} 
		$places = $this->_placeMgr->GetPlaces($filter);

		$result = array();
		foreach($places as $id => $place)
		{
			$result[$place->ID] = array(
				'ID' => $place->ID,
				'Name' => $place->Name,
				'Location' => $place->Location,
				'House' => $place->House,
				'CommerceType' => $place->CommerceType,
				'Link' => $link.$pathList
			);			
		}		
		return $result;
	}

	protected function _getNamePath($path) {
	  $base = '';
	  foreach($path as $v) {	
	  
		   if ($v->level <= $this->_root->level)
				continue ;
		   
		   $base .= $v->NameID.'/';
	  }
	  return $base;
	}	

}
?>