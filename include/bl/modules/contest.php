<?

/**
* Бизнес-логика для конкурсов contest
*
* @author Шайтанова Валентина
* @version 1.0
* @created xx-окт-2009
*/

class BL_modules_contest
{
	// типы полей формы
	const TYPE_LOGIC	= 0;	// логический блок
	const TYPE_TEXT		= 1;	// текстовое поле text
	const TYPE_TEXTAREA	= 2;	// текстовое поле textarea
	const TYPE_SELECT	= 3;	// select
	const TYPE_CHECKBOX	= 4;	// чеки
	const TYPE_RADIO	= 5;	// радио-кнопки
	const TYPE_PHOTO	= 6;	// изображения
	
	// типы модерации
	const MODERATE_PRED = 1;	// предмодерация
	const MODERATE_POST = 2;	// постмодерация
	
	// типы данных
	const DTYPE_TEXT	= 1;	// текстовое поле
	const DTYPE_INTEGER	= 2;	// целое число
	const DTYPE_FLOAT	= 3;	// вещественное число
	const DTYPE_PHONE	= 4;	// телефон
	const DTYPE_URL		= 5;	// URL
	const DTYPE_EMAIL	= 6;	// E-mail
	const DTYPE_AGE		= 7;	// возраст
	
	// другие
	const GetLastAnketa_Min = 1; // мин. кол-во анкет для GetLastAnketa()
	const GetLastAnketa_Max = 50; // макс. кол-во анкет для GetLastAnketa()

	const AnketsCountByOne_Min = 0; // мин. кол-во анкет, которые может добавить один пользователь (0 - без ограничений)
	const AnketsCountByOne_Max = 50; // макс. кол-во анкет -//-

	const LinkText = 'Разместить заявку'; // текст по умолчанию для ссылки в шаблонах (в админке можно менять)
	
	const VoteAfterRegistrationLimit = 60; // голосовать после регистрации можно только спустя 1 час (указано в минутах)
	
	public $title_separator = '. ';
	
	private $_db		= null;
	
	private $tables	= array();
	
	// типы полей формы
	public $form_types = array(
			self::TYPE_LOGIC => array(
				'type' => 'logic'
			),
			self::TYPE_TEXT => array(
				'type' => 'text',
				'field_table' => 'field_texts', // ключ в таблицах для взятия названия таблицы
				'title' => 'Строка',
				'HasVariants' => 0
			),
			self::TYPE_TEXTAREA => array(
				'type' => 'textarea',
				'field_table' => 'field_textareas',
				'title' => 'Текст',
				'HasVariants' => 0
			),
			self::TYPE_SELECT => array(
				'type' => 'select',
				'form_table' => 'form_selects',
				'field_table' => 'field_selects',
				'title' => 'Выпадающий список',
				'HasVariants' => 1
			),
			self::TYPE_CHECKBOX => array(
				'type' => 'checkbox',
				'form_table' => 'form_selects',
				'field_table' => 'field_selects',
				'title' => 'Чекбоксы',
				'HasVariants' => 1
			),
			self::TYPE_RADIO => array(
				'type' => 'radio',
				'form_table' => 'form_selects',
				'field_table' => 'field_selects',
				'title' => 'Радио-кнопки',
				'HasVariants' => 1
			),
			self::TYPE_PHOTO => array(
				'type' => 'photo',
				'title' => 'Фото',
				'HasVariants' => 0
			)
		);
		
	public $moderate = array(
		self::MODERATE_PRED => array(
			'type' => 'predmoderate',
			'title' => 'Предмодерация'
		),
		self::MODERATE_POST => array(
			'type' => 'postmoderate',
			'title' => 'Постмодерация'
		)
	);
	
	// типы данных
	public $data_types = array(
		self::DTYPE_TEXT => array(
			'type' => 'text',
			'title' => 'Текстовое поле'
		),
		self::DTYPE_EMAIL => array(
			'type' => 'email',
			'title' => 'E-mail'
		),
		self::DTYPE_PHONE => array(
			'type' => 'phone',
			'title' => 'Телефон',
			'regexp' => '@^([+]{0,1}[0-9-\(\), ])+$@'
		),
		self::DTYPE_URL => array(
			'type' => 'url',
			'title' => 'URL',
			'regexp' => '@^(http:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9_\.\-\\]+\.[a-zA-Z0-9\-\.]+$@'
		),
		self::DTYPE_INTEGER => array(
			'type' => 'integer',
			'title' => 'Целое число'
		),
		self::DTYPE_FLOAT => array(
			'type' => 'float',
			'title' => 'Вещественное число'
		),
		self::DTYPE_AGE => array(
			'type' => 'age',
			'title' => 'Возраст',
			'regexp' => '@^([1-9]{1}[0-9]{0,1})$@'
		)
	);
		
	private $item_col_pp = 20;
	private $ankets_col_pp = 20;
	private $photo_count = 0;
	private $photo = null;	// параметры для сохранения фото
	private $vote_types = array();
	private $can_edit_vote_counts = false;
	private $can_edit_view_counts = false;
	private $p = 1;
	
	private $sectionid = 0;
	
	private $admin_mode = false;		// работа в режиме админки (т.е. не используется slave)
	
	protected $contests = null;			 // список конкурсов
	protected $contest = null;			 // конкретный конкурс
	
	protected $ankets = null;		 	 // анкеты конкурса
	protected $anketa = null;		 	 // конкретная анкета
	
	protected $categories = array();	 // категории конкурсов, { ConID => { CategoryID => {...} } }
	protected $CategoryID = 0;			 // ID выбранной категории
	
	
	function __construct()
	{
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
	}

	function Init($params)
	{
		if(isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);

		if(isset($params['sectionid']) && Data::Is_Number($params['sectionid']))
			$this->sectionid = (int) $params['sectionid'];
		
		if(isset($params['tables']) && is_array($params['tables']))
			$this->tables = $params['tables'];
			
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
		
		if(isset($params['title_separator']))
			$this->title_separator = $params['title_separator'];
			
		if(isset($params['vote_types']))
			$this->vote_types = $params['vote_types'];
			
		if(isset($params['can_edit_vote_counts']))
			$this->can_edit_vote_counts = $params['can_edit_vote_counts'];
			
		if(isset($params['can_edit_view_counts']))
			$this->can_edit_view_counts = $params['can_edit_view_counts'];
			
		if(isset($params['photo']))
			$this->photo = $params['photo'];
			
		if(isset($params['photo_count']))
			$this->photo_count = $params['photo_count'];
		
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
	
/************************ Категории ************************/
	/**
	* Получение списка категорий конкурса - или данных о конкретной категории
	*
	* @return array
	* @param ConID integer - ID конкурса
	* @param CategoryID integer - ID категории
	* @param IsCache boolean - учитывать кэш (true)
	*/
	public function GetCategoriesList($ConID = 0, $CategoryID = 0, $IsCache = true)
	{
		$data = array();
	
		if( !Data::Is_Number($ConID) || !$ConID || !Data::Is_Number($CategoryID) )
			return $data;
		
		$sql = 'SELECT `CategoryID`, `Name`, `CountAnkets`, `Order` FROM ' . $this->tables['category'];
		$sql .= ' WHERE ';
		
		if($CategoryID)
		{
			// конкретная категория конкурса
			if ( $IsCache && isset($this->categories[$ConID][$CategoryID]) )
				return $this->categories[$ConID][$CategoryID];
			
			$sql .= ' `CategoryID` = ' . (int) $CategoryID;
			
			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
			
			if( false !== $res )
				$this->categories[$ConID][$CategoryID] = $data = $res->fetch_assoc();
				
			$this->CategoryID = $CategoryID;
		}
		else
		{
			// категории конкурса
			if ( $IsCache && isset($this->categories[$ConID]) )
				return $this->categories[$ConID];
			
			$sql .= ' `ConID` = ' . (int) $ConID;
			$sql .= ' ORDER BY `Order`, `CategoryID`';
		
			$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
			
			if( false !== $res )
			{
				while ($row = $res->fetch_assoc())
					$data[$row['CategoryID']] = $row;
					
				$this->categories[$ConID] = $data;
			}
		}
		
		return $data;
	}
	
	/**
	* Добавить категорию
	*
	* @return boolean
	* @param field array - параметры категории
	*/
	public function AddCategory($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql = 'INSERT INTO ' . $this->tables['category'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`Name` = "' . addslashes(trim($field['Name'])) . '",
					`Order` = ' . ( isset($field['Order']) ? (int) $field['Order'] : 0 );
		
		if( $this->_db->query($sql) )
			return $this->_db->insert_id;
			
		return 0;
	}
	
	/**
	* Редактировать категорию
	* Для админки
	*
	* @return boolean
	* @param field array - параметры категории
	*/
	public function UpdateCategory($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql  = 'UPDATE ' . $this->tables['category'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`Name` = "' . addslashes(trim($field['Name'])) . '",
					`Order` = ' . ( isset($field['Order']) && Data::Is_Number($field['Order']) ? $field['Order'] : 0 );
		$sql.= ' WHERE `CategoryID` = ' . (int) $field['CategoryID'];
		
		return $this->_db->query($sql);
	}
	
	/**
	* Изменить количество заявок в категории конкурса
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	* @param CategoryID integer - ID категории
	* @param Count integer - кол-во заявок в категории
	*/
	public function UpdateCategoryAnketsCount($ConID = 0, $CategoryID = 0, $Count)
	{
		if( !Data::Is_Number($ConID) || !$ConID || !Data::Is_Number($CategoryID) || !$CategoryID || !Data::Is_Number($Count) )
			return false;
			
		$sql = 'UPDATE ' . $this->tables['category'];
		$sql.= ' SET `CountAnkets` = ' . (int) $Count;
		$sql.= ' WHERE `ConID` = ' . (int) $ConID;
		$sql.= ' AND `CategoryID` = ' . (int) $CategoryID;
		
		return (bool) $this->_db->query($sql);
	}
	
	/**
	* Удалить категорию(и)
	*
	* @return boolean
	* @param CategoryID integer || array - ID(ы) категории(й)
	*/
	public function DeleteCategory($CategoryID = null)
	{
		if ( empty($CategoryID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['category'] . ' WHERE `CategoryID` IN (' . implode(',', (array) $CategoryID) . ')' );
	}
	
	/**
	* Удалить категорию(и) по ConID
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	*/
	public function DeleteCategoryByConID($ConID = null)
	{
		if ( empty($ConID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['category'] . ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')' );
	}
	
	/**
	* Удалить все категории конкурса
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	*/
	public function DeleteAllCategories($ConID = 0)
	{
		if( !Data::Is_Number($ConID) || !$ConID )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['category'] . ' WHERE `ConID` = ' . (int) $ConID );
	}
	
	
/************************ Конкурсы ************************/
	/**
	* Проверка, можно ли голосовать в этом конкурсе
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	*/
	public function CanContestVote($ConID = 0)
	{
		if ( !Data::Is_Number($ConID) )
			return false;
	
		// получить конкурс
		$this->GetContestDetails($ConID);
		
		if ( null === $this->contest )
			return false;
			
		return (bool) ($this->contest['IsAnkets'] && $this->contest['IsVote']);
	}
	
	/**
	* Проверка, можно ли голосовать в конкурсе по датам голосования
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	*/
	public function CanVoteByDate($ConID = 0)
	{
		if ( !Data::Is_Number($ConID) || !$this->CanContestVote($ConID) )
			return false;
	
		$date_now = Datetime_my::NowOffset();
		
		if( $this->contest['VoteDateStart'] == 0 )
			$isStarted = true;
		else
			$isStarted = $date_now >= Datetime_my::NowOffset(null, strtotime($this->contest['VoteDateStart']));


		if( $this->contest['VoteDateEnd'] == 0 )
			$isEnded = false;
		else
			$isEnded = $date_now > Datetime_my::NowOffset(null, strtotime($this->contest['VoteDateEnd']));

		return (bool) ($isStarted && !$isEnded);
	}
	
	/**
	* Сколько времени прошло с момента регистрации пользователя, в минутах
	*
	* @return array (
	*	integer - сколько прошло часов
	*	boolean - разница меньше установленного времени? (да - true; нет - false)
	* )
	*/
	public function DifferenceTimeFromRegistered()
	{
		global $OBJECTS;
		
		$date_reg = Datetime_my::NowOffset(null, strtotime($OBJECTS['user']->Registered)); // когда юзер зарегистрировался
		$date_now = Datetime_my::NowOffset();
		
		$difference = floor((strtotime($date_now) - strtotime($date_reg)) / 60); // в минутах
		
		if( $difference < self::VoteAfterRegistrationLimit ) // меньше положенного
			return array(self::VoteAfterRegistrationLimit - $difference, true); // сколько осталось
			
		return array(0, false);
	}
	
	/**
	* Получить состояние конкурса
	*
	* @return array (
	*	boolean - начался
	*	boolean - завершился
	*	boolean - идёт
	* )
	* @param ConID integer - ID конкурса
	* @param IsVisible integer - видимый конкурс (1) или нет(0); -1 - не важно
	*/
	public function ContestState($ConID = 0, $IsVisible = 1)
	{
		$result = array(false, false, false);
	
		if ( !Data::Is_Number($ConID) )
			return $result;
			
		// получить конкурс
		$this->GetContestDetails($ConID, $IsVisible, true);
		
		if ( null === $this->contest )
			return $result;

		$date_now = Datetime_my::NowOffset();
	
		if( $this->contest['DateStart'] == 0 )
			$isStarted = true;
		else
			$isStarted = $date_now >= Datetime_my::NowOffset(null, strtotime($this->contest['DateStart']));

		if( $this->contest['DateEnd'] == 0 )
			$isEnded = false;
		else
			$isEnded = $date_now > Datetime_my::NowOffset(null, strtotime($this->contest['DateEnd']));
			
		return array( (bool) $isStarted, (bool) $isEnded, (bool) ($isStarted && !$isEnded) );
	}

	/**
	* Получить количество конкурсов
	*
	* @return integer
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param UseDates boolean - использовать ограничение по датам (true) или нет (false)
	*/
	public function GetContestCount($IsVisible = 1, $UseDates = true)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tables['item'] . ' AS c';
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ConID = c.UniqueID';
		
		$where = array('r.SectionID = ' . $this->sectionid);
		
		/*if( !$this->admin_mode )
			$where[] = 'r.SiteID = ' . $this->sectionid;*/
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( $UseDates )
		{
			$where[] = '(c.DateStart = 0 OR c.DateStart < NOW())';
			$where[] = '(c.DateEnd = 0 OR c.DateEnd > NOW())';
		}
		
		if( null !== $this->year && intval($this->year) > 0 )
		{
			$date = $this->year;
			if( null !== $this->month && intval($this->month) > 0 )
				$date .= '-' . $this->month;
			if( null !== $this->day && intval($this->day) > 0 )
				$date .= '-' . $this->day;
			$where[] = 'c.DateStart LIKE "' . $date . '%"';
		}
		
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		if( $res === false )
			return 0;
			
		list($CountContests) = $res->fetch_row();
		
		return $CountContests;
	}
	
	/**
	* Получить список конкурсов
	*
	* @return array
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param UseDates boolean - использовать ограничение по датам (true) или нет (false)
	* @param IsFullInfo bool - выводить всю информацию (true), сокращённо (false)
	* @param IsGetAll boolean - выводить без учёта sectionid (true), только конкретные (false)
	* @param ConID integer || array - ID(ы) конкурса, который(е) выбирать
	* @param filter array - фильтр (для ORDER BY)
	* @param UseCache bool - использовать закешированные данные (true) или нет (false)
	* @param SectionIDs array - sectionid'ы разделов конкурсов, которые должны попадать в выборку
	*/
	public function GetContestList($IsVisible = 1, $UseDates = true, $IsFullInfo = false, $IsGetAll = false, $ConID = null, $filter = null, $UseCache = true, $SectionIDs = null)
	{
		$list = array();

		if( $UseCache && null !== $this->contests )
			return $this->contests;
			
		// можно выводить конкурсы по указанным
		if( !sizeof($SectionIDs) )
			$SectionIDs = (array) $this->sectionid;
		else
			array_unshift($SectionIDs, $this->sectionid);
			
		if(!sizeof($filter))
			$filter = array(
				'sort' => array(
					array('field' => 'c.Order', 'dir' => 'DESC'),
					array('field' => 'c.DateStart', 'dir' => 'DESC')
				)
			);
	
		$sql = 'SELECT c.UniqueID AS ConID, r.SectionID, c.Name, c.ThumbImg';
		
		if( $IsFullInfo )
		{
			$sql .= ', c.DateStart, c.DateEnd, c.IsComments, c.IsVisible, c.IsCategories, c.CuratorEmail, c.Order';
		}
		
		$sql.= ' FROM ' . $this->tables['item'] . ' AS c';
		$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
		$sql.= ' ON r.ConID = c.UniqueID';
		
		$where = array();
		
		if( !$IsGetAll )
			$where[] = 'r.SectionID IN (' . implode(',', $SectionIDs) . ') ';
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( null !== $ConID )
		{
			$where[] = 'c.UniqueID IN (' . implode(',', (array) $ConID) . ')';
		}
			
		if( $UseDates )
		{
			$where[] = '(c.DateStart = 0 OR c.DateStart < NOW())';
			$where[] = '(c.DateEnd = 0 OR c.DateEnd > NOW())';
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
		
		if( false !== $res )
		{
			while($row = $res->fetch_assoc())
			{
				if( $IsFullInfo )
					list($row['isStarted'], $row['isEnded'], $row['isGo']) = $this->ContestState($row['ConID'], $IsVisible); // состояние конкурса
			
				$row['ThumbImg'] = $this->GetPhotoInfo($row['ThumbImg'], false);
			
				// домен
				$n = STreeMgr::GetNodeByID($row['SectionID']);
				$row['domain'] = $n->Parent->Name;
				
				// url
				$row['url'] = ModuleFactory::GetLinkBySectionId($row['SectionID']);
			
				$list[$row['ConID']] = $row;
			}
		}
		
		return $this->contests = $list;
	}
	
	/**
	* Получить данные конкурса
	*
	* @return array
	* @param ConID integer - ID конкурса
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param IsGetAll boolean - выводить без учёта sectionid (true), только конкретные (false)
	*/
	public function GetContestDetails($ConID = 0, $IsVisible = 1, $IsGetAll = false)
	{
		if(!Data::Is_Number($ConID) || !$ConID)
			return array();
		
		if ( null !== $this->contest && $this->contest['ConID'] == $ConID )
			return $this->contest;
		
		$sql = 'SELECT
					c.UniqueID AS ConID,
					c.DateStart,
					c.DateEnd,
					c.Name,
					c.ThumbImg,
					c.EntryText,
					c.ResultText,
					c.LinkText,
					"' . self::LinkText . '" AS LinkTextByDefault,
					c.VoteDateStart,
					c.VoteDateEnd,
					c.VoteType,
					c.ModerateType,
					c.MaxAnketsCountByOne,
					c.CuratorEmail,
					c.IsVisible,
					c.IsResultInstead,
					c.IsAuthorizeOnly,
					c.IsCategories,
					c.IsRegAnkets,
					c.IsVote,
					c.IsVoteAuthorizeOnly,
					c.IsShowVotes,
					c.IsShowViews,
					c.IsShowGallery,
					c.IsLogosInGallery,
					c.IsComments,
					c.IsAnkets,
					c.IsCountAnkets,
					c.IsTextInAnketsList,
					c.HasPhotos,
					c.Order
				FROM ' . $this->tables['item'] . ' AS c';
		
		$where = array();
		
		if( !$IsGetAll )
		{
			$sql.= ' INNER JOIN ' . $this->tables['ref'] . ' AS r';
			$sql.= ' ON r.ConID = c.UniqueID';
			
			$where[] = 'r.SectionID = ' . $this->sectionid;
		}
			
		$where[] = 'c.UniqueID = ' . (int) $ConID;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$where[] = 'c.IsVisible = ' . (int) $IsVisible;
			
		if( sizeof($where) )
			$sql .= ' WHERE ' . implode(' AND ', $where);
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if(false !== $res && $row = $res->fetch_assoc())
		{
			if( empty($row['ThumbImg']) )
				$row['NoImg'] = true;
			$row['ThumbImg'] = $this->GetPhotoInfo($row['ThumbImg']);
			
			$this->contest = $row;
		}
		else
			$this->contest = null;

		return $row;
	}
	
	/**
	* Добавить конкурс
	*
	* @return boolean
	* @param data array - параметры анкеты
	*/
	public function AddContest($data = null)
	{
		if( empty($data) || !is_array($data) )
			return false;
	
		if($data['MaxAnketsCountByOne'] < self::AnketsCountByOne_Min)
			$data['MaxAnketsCountByOne'] = self::AnketsCountByOne_Min;
		elseif($data['MaxAnketsCountByOne'] > self::AnketsCountByOne_Max)
			$data['MaxAnketsCountByOne'] = self::AnketsCountByOne_Max;
	
		$sql  = 'INSERT INTO ' . $this->tables['item'];
		$sql.= ' SET
					`DateStart` = "' . $data['DateStart'] . '",
					`DateEnd` = "' . $data['DateEnd'] . '",
					`Name` = "' . addslashes($data['Name']) . '",
					`ThumbImg` = "",
					`EntryText` = "' . addslashes($data['EntryText']) . '",
					`ResultText` = "' . addslashes($data['ResultText']) . '",
					`LinkText` = "' . addslashes(empty($data['LinkText']) ? self::LinkText : $data['LinkText']) . '",
					`VoteDateStart` = "' . $data['VoteDateStart'] . '",
					`VoteDateEnd` = "' . $data['VoteDateEnd'] . '",
					`VoteType` = ' . $data['VoteType'] . ',
					`ModerateType` = ' . $data['ModerateType'] . ',
					`MaxAnketsCountByOne` = ' . $data['MaxAnketsCountByOne'] . ',
					`CuratorEmail` = "' . addslashes($data['CuratorEmail']) . '",
					`IsVisible` = ' . ( isset($data['IsVisible']) ? $data['IsVisible'] : 0 ) . ',
					`IsResultInstead` = ' . ( isset($data['IsResultInstead']) ? $data['IsResultInstead'] : 0 ) . ',
					`IsAuthorizeOnly` = ' . ( isset($data['IsAuthorizeOnly']) ? $data['IsAuthorizeOnly'] : 0 ) . ',
					`IsCategories` = ' . ( isset($data['IsCategories']) ? $data['IsCategories'] : 0 ) . ',
					`IsRegAnkets` = ' . ( isset($data['IsRegAnkets']) ? $data['IsRegAnkets'] : 0 ) . ',
					`IsVote` = ' . ( isset($data['IsVote']) ? $data['IsVote'] : 0 ) . ',
					`IsVoteAuthorizeOnly` = ' . ( isset($data['IsVoteAuthorizeOnly']) ? $data['IsVoteAuthorizeOnly'] : 0 ) . ',
					`IsShowVotes` = ' . ( isset($data['IsShowVotes']) ? $data['IsShowVotes'] : 0 ) . ',
					`IsShowViews` = ' . ( isset($data['IsShowViews']) ? $data['IsShowViews'] : 0 ) . ',
					`IsShowGallery` = ' . ( isset($data['IsShowGallery']) ? $data['IsShowGallery'] : 0 ) . ',
					`IsLogosInGallery` = ' . ( isset($data['IsLogosInGallery']) ? $data['IsLogosInGallery'] : 0 ) . ',
					`IsComments` = ' . ( isset($data['IsComments']) ? $data['IsComments'] : 0 ) . ',
					`IsAnkets` = ' . ( isset($data['IsAnkets']) ? $data['IsAnkets'] : 0 ) . ',
					`IsCountAnkets` = ' . ( isset($data['IsCountAnkets']) ? $data['IsCountAnkets'] : 0 ) . ',
					`IsTextInAnketsList` = ' . ( isset($data['IsTextInAnketsList']) ? $data['IsTextInAnketsList'] : 0 ) . ',
					`Order` = ' . ( isset($data['Order']) && Data::Is_Number($data['Order']) ? $data['Order'] : 0 );

		$this->_db->query($sql);
		
		return $this->_db->insert_id;
	}
	
	/**
	* Загрузка мелкого фото для конкурса
	*
	* @return string
	* @param ConID integer - ID конкурса, к которому добавляется фотка
	* @param key string - ключ в массиве $_FILES
	* @exception InvalidArgumentMyException
	* @exception RuntimeBTException
	*/
	public function UploadContestPhoto($ConID = 0, $key = '')
	{
		if( !Data::Is_Number($ConID) || !$ConID || empty($key) || empty($_FILES[$key]['tmp_name']) || !is_file($_FILES[$key]['tmp_name']) )
			return '';
		
		if ( null === $this->photo )
			throw new InvalidArgumentMyException('No config photo parameters.');
			
		$fname = '';
		
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		
		$prefix = (int) $ConID . '_' . $this->photo['contest_img']['prefix'];
			
		// загрузка файла
		return FileStore::Upload_NEW(
			$key,
			$this->photo['path'],
			$prefix,
			FileMagic::MT_WIMAGE,
			$this->photo['contest_img']['max_size'],
			$this->photo['contest_img']['params']
		);
	}
	
	/**
	* Обновить метаданные мелкого фото конкурса
	*
	* @return boolean
	* @param ConID integer - ID конкурса, к которому добавляется фотка
	* @param photo string - метаданные
	*/
	public function UpdateContestPhoto($ConID = 0, $photo = '')
	{
		if( !Data::Is_Number($ConID) || !$ConID || empty($photo) )
			return false;
			
		$fname_tmp = FileStore::GetPath_NEW($photo);
		$fname_tmp = Images::PrepareImageToObject($fname_tmp, $this->photo['path'], $this->photo['url']);
		$photo = FileStore::ObjectToString($fname_tmp);
			
		$sql = 'UPDATE ' . $this->tables['item'];
		$sql.= " SET `ThumbImg` = '" . addslashes($photo) . "'";
		$sql.= " WHERE `UniqueID` = " . (int) $ConID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Залить новую фотку-превьюшку конкурса, старую удалить
	*
	* @return array(
	*	string - метаданные изображения
	*	boolean - было загружено изображение или нет
	* )
	* @param ConID integer - ID конкурса
	* @param ToDeleteImg boolean - удалить фото?
	* @exception RuntimeMyException
	*/
	protected function ReloadContestPhoto($ConID = 0, $ToDeleteImg = false)
	{
		if( !Data::Is_Number($ConID) || !$ConID )
			return array('', false);
			
		$fl_changed = false;
	
		// удалить или заменить фото
		if( $ToDeleteImg || (!empty($_FILES['img']['tmp_name']) && is_file($_FILES['img']['tmp_name'])) )
		{
			// получить данные конкурса
			$contest = $this->GetContestDetails($ConID, -1);

			if( !$contest['NoImg'] && isset($contest['ThumbImg']) && sizeof($contest['ThumbImg']) && !empty($contest['ThumbImg']['path']) )
			{
				LibFactory::GetStatic('filestore');
				
				// удалить файл
				try
				{
					FileStore::Delete_NEW($contest['ThumbImg']['path']);
				}
				catch( MyException $e )
				{
					return array('', false);
				}
				
				$fl_changed = true;
			}
		}

		// добавить новую фотку
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

		$fname = '';
		
		try
		{
			$fname_tmp = $this->UploadContestPhoto($ConID, 'img');
		}
		catch( BTException $e ) {}
		
		if( !empty($fname_tmp) )
		{
			$fname_tmp = FileStore::GetPath_NEW($fname_tmp);
			$fname_tmp = Images::PrepareImageToObject($fname_tmp, $this->photo['path'], $this->photo['url']);
			$fname = FileStore::ObjectToString($fname_tmp);
			$fl_changed = true;
		}
		
		return array($fname, $fl_changed);
	}
	
	/**
	* Редактировать конкурс
	*
	* @return boolean
	* @param data array - параметры анкеты
	* @exception BTException
	*/
	public function UpdateContest($data = null)
	{
		if( empty($data) || !is_array($data) )
			return false;
			
		// обновить фотку
		// Если стоит галочка на удаление картинки, то нужно удалить
		$fl_changed = false;
		try
		{
			list($fname, $fl_changed) = $this->ReloadContestPhoto($data['ConID'], ( isset($data['ToDeleteImg']) ? true : false ) );
		}
		catch ( BTException $e )
		{
			throw $e;
		}

		$sql  = 'UPDATE ' . $this->tables['item'];
		$sql.= ' SET
					`DateStart` = "' . $data['DateStart'] . '",
					`DateEnd` = "' . $data['DateEnd'] . '",
					`Name` = "' . addslashes($data['Name']) . '",';
					
		if( $fl_changed )
			$sql .= '`ThumbImg` = "' . addslashes($fname) . '",';
			
		$sql .= '	`EntryText` = "' . addslashes($data['EntryText']) . '",
					`ResultText` = "' . addslashes($data['ResultText']) . '",
					`LinkText` = "' . addslashes(empty($data['LinkText']) ? self::LinkText : $data['LinkText']) . '",
					`VoteDateStart` = "' . $data['VoteDateStart'] . '",
					`VoteDateEnd` = "' . $data['VoteDateEnd'] . '",
					`VoteType` = ' . $data['VoteType'] . ',
					`ModerateType` = ' . $data['ModerateType'] . ',
					`MaxAnketsCountByOne` = ' . $data['MaxAnketsCountByOne'] . ',
					`CuratorEmail` = "' . addslashes($data['CuratorEmail']) . '",
					`IsVisible` = ' . ( isset($data['IsVisible']) ? $data['IsVisible'] : 0 ) . ',
					`IsResultInstead` = ' . ( isset($data['IsResultInstead']) ? $data['IsResultInstead'] : 0 ) . ',
					`IsAuthorizeOnly` = ' . ( isset($data['IsAuthorizeOnly']) ? $data['IsAuthorizeOnly'] : 0 ) . ',
					`IsCategories` = ' . ( isset($data['IsCategories']) ? $data['IsCategories'] : 0 ) . ',
					`IsRegAnkets` = ' . ( isset($data['IsRegAnkets']) ? $data['IsRegAnkets'] : 0 ) . ',
					`IsVote` = ' . ( isset($data['IsVote']) ? $data['IsVote'] : 0 ) . ',
					`IsVoteAuthorizeOnly` = ' . ( isset($data['IsVoteAuthorizeOnly']) ? $data['IsVoteAuthorizeOnly'] : 0 ) . ',
					`IsShowVotes` = ' . ( isset($data['IsShowVotes']) ? $data['IsShowVotes'] : 0 ) . ',
					`IsShowViews` = ' . ( isset($data['IsShowViews']) ? $data['IsShowViews'] : 0 ) . ',
					`IsShowGallery` = ' . ( isset($data['IsShowGallery']) ? $data['IsShowGallery'] : 0 ) . ',
					`IsLogosInGallery` = ' . ( isset($data['IsLogosInGallery']) ? $data['IsLogosInGallery'] : 0 ) . ',
					`IsComments` = ' . ( isset($data['IsComments']) ? $data['IsComments'] : 0 ) . ',
					`IsAnkets` = ' . ( isset($data['IsAnkets']) ? $data['IsAnkets'] : 0 ) . ',
					`IsCountAnkets` = ' . ( isset($data['IsCountAnkets']) ? $data['IsCountAnkets'] : 0 ) . ',
					`IsTextInAnketsList` = ' . ( isset($data['IsTextInAnketsList']) ? $data['IsTextInAnketsList'] : 0 ) . ',
					`Order` = ' . ( isset($data['Order']) && Data::Is_Number($data['Order']) ? $data['Order'] : 0 );
		$sql.= ' WHERE `UniqueID` = ' . $data['ConID'];

		return $this->_db->query($sql);
	}
	
	/**
	* Обновить состояние флага HasPhotos
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	* @param HasPhotos boolean - есть фото (true) или нет (false)
	*/
	public function UpdateContestHasPhotos($ConID = 0, $HasPhotos = false)
	{
		if( !Data::Is_Number($ConID) || !$ConID )
			return false;
			
		$HasPhotos = (bool) $HasPhotos;
			
		return $this->_db->query('UPDATE ' . $this->tables['item'] . ' SET `HasPhotos` = ' . (int) $HasPhotos . ' WHERE `UniqueID` = ' . (int) $ConID);
	}
	
	/**
	* Изменить видимость конкурса
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	*/
	public function ToggleContestVisible($ConID = 0)
	{
		if(!Data::Is_Number($ConID) || !$ConID)
			return false;
			
		$sql  = 'UPDATE ' . $this->tables['item'];
		$sql.= ' SET `IsVisible` = 1 - `IsVisible`';
		$sql.= ' WHERE `UniqueID` = ' . (int) $ConID;
		
		return $this->_db->query($sql);
	}
	
	
	/**
	* Удалить конкурс
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	* @exception MyException
	*/
	public function DeleteContest($ConID = null)
	{
		if( empty($ConID) )
			return false;
			
		$ConIDs = (array) $ConID;
		$photos = array();
		
		foreach( $ConIDs as $c )
		{
			// получить детали конкурса (используются далее)
			$contest = $this->GetContestDetails($c, -1);
			$photos[] = $contest['ThumbImg'];
		}
			
		// удалить конкурс(ы)
		if( !$this->_db->query( 'DELETE FROM ' . $this->tables['item'] . ' WHERE `UniqueID` IN (' . implode(',', $ConIDs) . ')' ) )
			return false;
			
		LibFactory::GetStatic('filestore');
			
		// [B] удалить фотки-превьюшки
		foreach($photos as $p)
		{
			if( !isset($p['ThumbImg']) || !sizeof($p['ThumbImg']) || empty($p['ThumbImg']['path']) )
				continue;

			// удалить файл
			try
			{
				FileStore::Delete_NEW($p['ThumbImg']['path']);
			}
			catch( MyException $e ) {}
		}
		// [E] удалить фотки-превьюшки
			
		return true;
	}
	
	/**
	* Получить список регионов и сайтов, на которых есть конкурс
	* Для почтовой рассылки по крону
	*
	* @param ConID integer - ID конкурса
	*/
	public function GetContestRefs($ConID = 0)
	{
		if( !Data::Is_Number($ConID) || !$ConID )
			return null;
	
		$sql = 'SELECT `ConID`, `RegionID`, `SiteID`, `Date`';
		$sql.= ' FROM ' . $this->tables['ref'];
		$sql.= ' WHERE `ConID` = ' . (int) $ConID;
			
		$res = $this->_db->query($sql);
		if( $res === false )
			return null;
			
		$refs = array();
		
		if( false !== $res )
		{
			while($row = $res->fetch_assoc())
				$refs[$row['SiteID']] = $row;
		}
			
		return $refs;
	}
	
	/**
	* Добавить связь в таблицу связи конкурса и раздела
	*
	* @return boolean
	* @param data array - параметры
	*/
	public function AddContestRef($data = null)
	{
		if( empty($data) || !is_array($data) || !isset($data['ConID']) || !Data::Is_Number($data['ConID']) )
			return false;
			
		$sql = 'INSERT INTO ' . $this->tables['ref'];
		$sql.= ' SET ';
		$sql.= ' `ConID` = ' . (int) $data['ConID'] . ',';
		$sql.= ' `RegionID` = ' . (int) $data['RegionID'] . ',';
		$sql.= ' `SiteID` = ' . (int) $data['SiteID'] . ',';
		$sql.= ' `SectionID` = ' . (int) $data['SectionID'] . ',';
		$sql.= ' `Date` = "' . $data['Date'] . '"';
			
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить связь из таблицы связи конкурса и раздела
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	*/
	public function DeleteContestRef($ConID = null)
	{
		if( empty($ConID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['ref'] . ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')' );
	}
	
	/**
	* Проверяет, можно ли добавлять анкеты в конкурсе
	*
	* @return array(
	* 	integer - сколько заявок можно добавлять одному пользователю
	* 	integer - сколько заявок пользователь уже добавил
	* 	boolean - можно ли данному пользователю добавлять ещё заявки
	* )
	* @param ConID integer ID конкурса
	* @param UserID integer ID пользователя в паспорте
	*/
	public function CanContestAddAnkets($ConID = 0, $UserID = 0)
	{
		if(!Data::Is_Number($ConID) || !$ConID)
			return array(0, 0, false);

		list($MaxAnketsCountByOne, $AnketsCountUserAlreadyAdded, $flCanUserAddAnkets) = $this->CanUserAddAnkets($ConID, $UserID);
			
		if ( null !== $this->contest && $this->contest['ConID'] == $ConID )
			return array(
				$MaxAnketsCountByOne, // сколько заявок можно добавлять одному пользователю
				$AnketsCountUserAlreadyAdded, // сколько заявок пользователь уже добавил
				(bool) ($this->contest['IsRegAnkets'] && $flCanUserAddAnkets)
			);
			
		$res = $this->_db->query('SELECT `IsRegAnkets` FROM ' . $this->tables['item'] . ' WHERE `UniqueID` = ' . (int) $ConID);
		
		if( false !== $res )
			list($IsRegAnkets) = $res->fetch_row();
		else
			$IsRegAnkets = false;
	
		return array(
			$MaxAnketsCountByOne, // сколько заявок можно добавлять одному пользователю
			$AnketsCountUserAlreadyAdded, // сколько заявок пользователь уже добавил
			(bool) ($IsRegAnkets && $flCanUserAddAnkets) // можно ли добавлять заявки
		);
	}
	
	/**
	* Подсчёт количества анкет в категории конкурса
	*
	* @return boolean
	* @param ConID integer - ID конкурса
	* @param CategoryID integer - ID категории конкурса
	*/
	public function CalcCountContestAnkets($ConID = 0, $CategoryID = 0)
	{
		if( !Data::Is_Number($ConID) || !$ConID || !Data::Is_Number($CategoryID) || !$CategoryID )
			return false;
	
		// пересчитать кол-во анкет категории
		$count = $this->GetAnketsCount($ConID, $CategoryID, 1, false);
		
		// обновить кол-во анкет категории
		$this->UpdateCategoryAnketsCount($ConID, $CategoryID, $count);
		
		return true;
	}
	
/************************ Анкеты ************************/
	/**
	* Получение количества анкет конкурса с учётом категории
	*
	* @return integer
	* @param ConID integer - ID конкурса
	* @param CategoryID integer - ID категории
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param IsCache boolean - учитывать кэш (true)
	*/
	public function GetAnketsCount($ConID = 0, $CategoryID = 0, $IsVisible = 1, $IsCache = true)
	{
		if ( !Data::Is_Number($ConID) || !$ConID || !Data::Is_Number($CategoryID) )
			return 0;
		
		if($CategoryID)
		{
			if( $IsCache && null !== $this->contests && isset($this->contests[$ConID]) && isset($this->contests[$ConID]['CountAnkets']) )
				return $this->contests[$ConID]['CountAnkets'];
				
			$sql_ = ' AND `CategoryID` = ' . (int) $CategoryID;
		}
		else {
			if( $IsCache && null !== $this->contests && isset($this->contests[$ConID]) && isset($this->contests[$ConID]['CountTotalAnkets']) )
				return $this->contests[$ConID]['CountTotalAnkets'];
				
			$sql_ = '';
		}
			
		$sql = 'SELECT COUNT(*) FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `ConID` = ' . (int) $ConID;
		if( Data::Is_Number($IsVisible) && $IsVisible != -1 )
			$sql .= ' AND `IsVisible` = ' . (int) $IsVisible;
		$sql.= $sql_;
			
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);

		if( false !== $res )
			list($count) = $res->fetch_row();
		else
			$count = 0;
		
		if($CategoryID)
		{
			if( null !== $this->contests && isset($this->contests[$ConID]) )
				$this->contests[$ConID]['CountAnkets'] = $count;
		}
		else {
			if( null !== $this->contests && isset($this->contests[$ConID]) )
				$this->contests[$ConID]['CountTotalAnkets'] = $count;
		}
		
		return $count;
	}
	
	/**
	* Получение списка заявок конкурса
	*
	* @return array - список заявок
	* @param ConID integer - ID конкурса
	* @param CategoryID integer - ID категории
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param IsFullInfo boolean - выводить всю информацию (true), сокращённо (false)
	* @param filter array - фильтр (для ORDER BY)
	*/
	public function GetContestAnketsList($ConID = 0, $CategoryID = 0, $IsVisible = 1, $IsFullInfo = false, $filter = null)
	{
		$list = array();
	
		if( !Data::Is_Number($ConID) || !$ConID || !Data::Is_Number($CategoryID) )
			return $list;
	
		$CategoryID = (int) $CategoryID;
	
		if( !$this->admin_mode && null !== $this->ankets && $this->CategoryID == $CategoryID )
			return $this->ankets;
			
		if(!sizeof($filter))
			$filter = array(
				'sort' => array(
					array('field' => 'Order', 'dir' => 'DESC'),
					array('field' => 'Date', 'dir' => 'DESC')
				)
			);
	
		$sql = 'SELECT `AnkID`, `ConID`, `CategoryID`, `Date`, `Name`, `Announce`, `UserID`, `IsVisible`';
		
		if( $IsFullInfo )
			$sql .= ', `IP`, `Cookie`, `Views`, `Votes`, `Order`';
		
		$sql.= ' FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `ConID` = ' . (int) $ConID;
		if( Data::Is_Number($IsVisible) && $IsVisible != -1 )
			$sql .= ' AND `IsVisible` = ' . (int) $IsVisible;
		if($CategoryID)
			$sql .= ' AND `CategoryID` = ' . $CategoryID;
			
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= ' ORDER BY ';
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ( !in_array(strtolower($f['dir']), array('asc', 'desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = ' `' . $f['field'] . '` ' . $f['dir'] . ' ';
			}
			
			$sql.= implode(',', $sqlt);
		}
			
		$sql .= ' LIMIT ' . ( $this->ankets_col_pp * ($this->p - 1) ) . ', ' . $this->ankets_col_pp;

		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $list;
		
		while ($row = $res->fetch_assoc())
			$list[$row['AnkID']] = $row;
			
		$count = count($list);
		
		if($CategoryID)
		{
			if( null !== $this->contests && isset($this->contests[$ConID]) )
				$this->contests[$ConID]['CountAnkets'] = $count;
		}
		else {
			if( null !== $this->contests && isset($this->contests[$ConID]) )
				$this->contests[$ConID]['CountTotalAnkets'] = $count;
		}
		
		$this->CategoryID = $CategoryID;
			
		return $this->ankets = $list;
	}
	
	/**
	* Получить детали анкеты
	*
	* @return array
	* @param AnkID integer - ID анкеты
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	*/
	public function GetAnketaDetails($AnkID = 0, $IsVisible = 1)
	{
		$data = array();
		
		if ( !Data::Is_Number($AnkID) || !$AnkID )
			return $data;
			
		if ( null !== $this->anketa && $this->anketa['AnkID'] == $AnkID )
			return $this->anketa;

		$sql = 'SELECT
					`AnkID`,
					`ConID`,
					`CategoryID`,
					`Date`,
					`Name`,
					`Announce`,
					`UserID`,
					`IP`,
					`Cookie`,
					`Views`,
					`Votes`,
					`IsVisible`,
					`IsNew`,
					`Order`
				FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$sql .= ' AND `IsVisible` = ' . (int) $IsVisible;
			
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $data;
			
		$data = $res->fetch_assoc();
		
		return $this->anketa = $data;
	}
	
	/**
	* Получить данные о предыдущей и следующей анкетах
	*
	* @return integer
	* @param AnkID integer - ID анкеты
	* @param CategoryID integer - ID категории анкеты
	* @param NavigateKey string - ключ: предыдущая анкета (prev) или следующая (next)
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	* @param filter array - фильтр (для ORDER BY)
	*/
	public function GetAnketsNear($AnkID = 0, $CategoryID = 0, $NavigateKey = '', $IsVisible = 1, $filter = null)
	{
		$data = array();
		
		if ( !Data::Is_Number($AnkID) || !$AnkID || !Data::Is_Number($CategoryID) || !in_array($NavigateKey, array('prev', 'next')) )
			return $data;
			
		// получить ID конкурса по ID анкеты
		$ConID = $this->GetConID_by_AnkID($AnkID);
		
		if(!sizeof($filter))
		{
			if($NavigateKey == 'prev')
				$filter = array(
					'sort' => array(
						array('field' => 'Date', 'dir' => 'DESC'),
						array('field' => 'Order', 'dir' => 'ASC')
					)
				);
			else
				$filter = array(
					'sort' => array(
						array('field' => 'Order', 'dir' => 'ASC')
					)
				);
		}
			
		$sql = 'SELECT
					`AnkID`
				FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `ConID` = ' . $ConID;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$sql .= ' AND `IsVisible` = ' . (int) $IsVisible;
			
		if($CategoryID)
			$sql .= ' AND `CategoryID` = ' . (int) $CategoryID;
			
		$sql.= ' AND `AnkID` ' . ( $NavigateKey == 'prev' ? '<' : '>' ) . ' ' . (int) $AnkID;
			
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= ' ORDER BY ';
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ( !in_array(strtolower($f['dir']), array('asc', 'desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = ' `' . $f['field'] . '` ' . $f['dir'] . ' ';
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		$sql.= ' LIMIT 1';
			
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $data;
			
		$data = $res->fetch_row();
		
		return $data[0];
	}
	
	/**
	* Получить данные о последней анкете
	*
	* @param SiteID integer - ID сайта (из tree)
	* @param ConID integer - ID анкеты (если указать принудительно, то выйдет последняя анкета конкретного конкурса)
	* @param AnketsLimit integer - количество выводимых анкет
	*/
	public function GetLastAnketa($SiteID = 0, $ConID = 0, $AnketsLimit = 1)
	{
		$data = array();
	
		if ( !Data::Is_Number($SiteID) || !$SiteID || !Data::Is_Number($ConID) || !Data::Is_Number($AnketsLimit) )
			return $data;
			
		if( $AnketsLimit < self::GetLastAnketa_Min )
			$AnketsLimit = self::GetLastAnketa_Min;
		elseif( $AnketsLimit > self::GetLastAnketa_Max )
			$AnketsLimit = self::GetLastAnketa_Max;
	
		$sql = 'SELECT
					a.AnkID,
					a.ConID,
					a.CategoryID,
					a.Date,
					a.Name,
					a.Announce,
					a.Order';
		$sql.= ' FROM ' . $this->tables['anketa'] . ' AS a';
		$sql.= ' RIGHT JOIN ' . $this->tables['ref'] . ' AS r ON r.ConID = a.ConID';
		$sql.= ' LEFT JOIN ' . $this->tables['item'] . ' AS ct ON ct.UniqueID = a.ConID';
		$sql.= ' WHERE r.SiteID = ' . (int) $SiteID;
		
		if( $ConID )
			$sql .= ' AND r.ConID = ' . (int) $ConID;
		
		$sql.= ' AND ct.IsVisible = 1';
		$sql.= ' AND a.IsVisible = 1';
		$sql.= ' ORDER BY a.Date DESC, a.Order';
		$sql.= ' LIMIT ' . (int) $AnketsLimit;
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
			$data[$row['AnkID']] = $row;
		
		return $data;
	}
	
	/**
	* Получить ID конкурса по ID анкеты
	*
	* @return int
	* @param AnkID - ID анкеты
	*/
	public function GetConID_by_AnkID($AnkID = 0)
	{
		if ( !Data::Is_Number($AnkID) || !$AnkID )
			return 0;

		if( null !== $this->ankets && isset($this->ankets[$AnkID]) )
			return $this->ankets[$AnkID]['ConID'];
			
		$sql = 'SELECT `ConID` FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return 0;
		
		list($ConID) = $res->fetch_row();
		
		return $ConID;
	}
	
	/**
	* Выбрать все анкеты конкурса, у которых IsNew = 1
	* Сейчас не используется (предполагалось использовать для крона)
	*
	* @return array
	* @param ConID integer - ID конкурса
	*/
	public function GetContestNewAnkets($ConID = 0)
	{
		$data = array();
	
		if ( !Data::Is_Number($ConID) || !$ConID )
			return $data;
		
		$sql = 'SELECT
					`AnkID`,
					`ConID`,
					`CategoryID`,
					`Date`,
					`Name`,
					`Announce`,
					`UserID`,
					`IP`,
					`Cookie`';
		$sql.= ' FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `ConID` = ' . (int) $ConID;
		$sql.= ' AND `IsNew` = 1';
		$sql.= ' ORDER BY `Order`';
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
			$data[$row['AnkID']] = $row;
			
		return $data;
	}
	
	/**
	* Добавить анкету
	*
	* @return int
	* @param field array - параметры анкеты
	*/
	public function AddAnketa($field = null)
	{
		if( empty($field) || !is_array($field) )
			return 0;
			
		$ip 	= (isset($field['IP']) ? addslashes($field['IP']) : getenv("REMOTE_ADDR"));
		$ip_fw 	= (isset($field['IP_FW']) ? addslashes($field['IP_FW']) : getenv("HTTP_X_FORWARDED_FOR"));
		$cookie = (isset($field['cookie']) ? addslashes($field['cookie']) : Request::GetUID());
	
		$sql  = 'INSERT INTO ' . $this->tables['anketa'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`CategoryID` = ' . (int) $field['CategoryID'] . ',
					`Date` = ' . (isset($field['Date']) ? '"'.$field['Date'].'"' : 'NOW()') . ',
					`UserID` = ' . (int) $field['UserID'] . ',
					`Name` = "' . addslashes($field['Name']) . '",
					`Announce` = "' . addslashes($field['Announce']) . '",
					`IP` = "' . addslashes($ip.'->'.$ip_fw) . '",
					`Cookie` = "' . addslashes($cookie) . '"';
		if( isset($field['IsVisible']) && Data::Is_Number($field['IsVisible']) )
			$sql .= ', `IsVisible` = ' . (int) $field['IsVisible'];
		
		if( isset($field['Votes']) && Data::Is_Number($field['Votes']) )
			$sql .= ', `Votes` = ' . (int) $field['Votes'];
			
		if( isset($field['Views']) && Data::Is_Number($field['Views']) )
			$sql .= ', `Views` = ' . (int) $field['Views'];
			
		if( isset($field['Order']) && Data::Is_Number($field['Order']) )
			$sql .= ', `Order` = ' . (int) $field['Order'];
			
		// для переводимых конкурсов, сохранение старого id'а анкеты
		if( isset($field['old_id']) && Data::Is_Number($field['old_id']) )
			$sql .= ', `old_id` = ' . (int) $field['old_id'];

		$this->_db->query($sql);
		
		return $this->_db->insert_id;
	}
	
	/**
	* Редактировать анкету
	*
	* @return boolean
	* @param field array - параметры анкеты
	*/
	public function UpdateAnketa($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
			
		$ip 	= getenv("REMOTE_ADDR");
		$ip_fw 	= getenv("HTTP_X_FORWARDED_FOR");
		$cookie = Request::GetUID();
	
		$field['AnkID'] = (int) $field['AnkID'];
	
		$sql  = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`CategoryID` = ' . (int) $field['CategoryID'] . ',
					`Date` = "' . $field['Date'] . '",
					`UserID` = ' . (int) $field['UserID'] . ',
					`Name` = "' . addslashes($field['Name']) . '",
					`Announce` = "' . addslashes($field['Announce']) . '",
					`IP` = "' . addslashes($ip.'->'.$ip_fw) . '",
					`Cookie` = "' . addslashes($cookie) . '",
					`IsVisible` = ' . (int) $field['IsVisible'] . ',
					`Order` = ' . ( isset($field['Order']) ? (int) $field['Order'] : 0 );
		$sql.= ' WHERE `AnkID` = ' . $field['AnkID'];
		
		// проставить IsNew в 0
		$this->UpdateAnketaIsNew($field['AnkID']);
		
		return $this->_db->query($sql);
	}
	
	/**
	* Назначить конкретную категорию анкете(ам)
	*
	* @return boolean
	* @param CategoryID integer - ID категории конкурса
	* @param filter array - фильтр
	*/
	public function UpdateAnketaCategory($CategoryID = 0, $filter = null)
	{
		if( !Data::Is_Number($CategoryID) )
			return false;
	
		$sql = 'UPDATE ' . $this->tables['anketa'] . ' SET `CategoryID` = ' . (int) $CategoryID;
	
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= ' WHERE ';
			$sqlt = array();
			
			if (isset($filter['fields']['conid']) && Data::Is_Number($filter['fields']['conid']))
				$sqlt[] = ' `ConID` = "' . (int) $filter['fields']['conid'] . '" ';
				
			if (isset($filter['fields']['ankid']))
				$sqlt[] = ' `AnkID` IN (' . implode(',', (array) $filter['fields']['ankid']) . ') ';
				
			if (isset($filter['fields']['categoryid']))
				$sqlt[] = ' `CategoryID` IN (' . implode(',', (array) $filter['fields']['categoryid']) . ') ';
			
			$sql.= implode(' AND ', $sqlt);
		}
			
		return $this->_db->query($sql);
	}
	
	/**
	* Обновить флаг IsNew у анкет(ы)
	*
	* @return boolean
	* @param AnkID integer - ID(ы) анкет(ы)
	*/
	public function UpdateAnketaIsNew($AnkID = null)
	{
		if( null === $AnkID || empty($AnkID) )
			return false;
			
		return $this->_db->query('UPDATE ' . $this->tables['anketa'] . ' SET `IsNew` = 0 WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')');
	}
	
	/**
	* Изменить видимость анкеты
	*
	* @return boolean
	* @param AnkID integer - ID анкеты
	*/
	public function ToggleAnketaVisible($AnkID = 0)
	{
		if(!Data::Is_Number($AnkID) || !$AnkID)
			return false;
			
		$sql  = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET `IsVisible` = 1 - `IsVisible`, `IsNew` = 0';
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить анкету(ы) по AnkID
	*
	* @return boolean
	* @param AnkID integer || array - ID(ы) анкет(ы)
	*/
	public function DeleteAnketa($AnkID = null)
	{
		if( empty($AnkID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['anketa'] . ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')' );
	}
	
	/**
	* Удалить анкету(ы) по ConID
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурсов(ы)
	*/
	public function DeleteAnketaByConID($ConID = null)
	{
		if( empty($ConID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['anketa'] . ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')' );
	}
	
	/**
	* Удалить анкету полностью (все поля, варианты, фото)
	*
	* @return boolean
	* @param AnkID integer - ID анкеты
	*
	* @exception InvalidArgumentMyException
	* @exception MyException
	*/
	public function DeleteFullAnketa($AnkID = 0)
	{
		if( !Data::Is_Number($AnkID) || !$AnkID )
			return false;
			
		// удалить саму анкету
		if( !$this->DeleteAnketa($AnkID) )
			return false;
			
		// получить id'ы полей анкеты
		$fields = $this->GetFieldIDs($AnkID);
		
		if( sizeof($fields) )
		{
			// удалить все варианты полей
			$this->DeleteFieldValue($this->tables['field_selects'], $fields);
			$this->DeleteFieldValue($this->tables['field_texts'], $fields);
			$this->DeleteFieldValue($this->tables['field_textareas'], $fields);
			
			// удалить все поля анкеты
			$this->DeleteFieldByAnkID($AnkID);

			// получить данные обо всех фотках
			$photos = $this->GetPhotosDetailsByAnkID($AnkID);
			
			if( sizeof($photos) )
			{
				// удалить все файлы фоток
				$this->DeletePhotoFiles($photos);

				// удалить все фото из БД
				$this->DeletePhotoByAnkID($AnkID);
			}
		}
		
		return true;
	}
	
	/**
	* Проверка - может ли пользователь добавлять анкеты
	* Зависит от типа MaxAnketsCountByOne: без ограничений (0) || N раз
	* Если IsAuthorizeOnly, то проверять по UserID
	* Если нет, то по IP и Cookie
	*
	* @return array(
	* 	integer - сколько заявок можно добавлять одному пользователю
	* 	integer - сколько заявок пользователь уже добавил
	* 	boolean - можно ли данному пользователю добавлять ещё заявки
	* )
	* @param ConID integer - ID конкурса
	* @param UserID integer - ID пользователя в паспорте
	*/
	public function CanUserAddAnkets($ConID = 0, $UserID = 0)
	{
		if( !Data::Is_Number($ConID) || !$ConID )
			return array(0, 0, false);
			
		// получить конкурс
		$this->GetContestDetails($ConID);

		if( null === $this->contest )
			return array(0, 0, false);
	
		if ( !$this->contest['MaxAnketsCountByOne'] ) // == 0 => без ограничений
			return array(0, 0, true);
			
		// Если IsAuthorizeOnly, то проверять по UserID 
		if( $this->contest['IsAuthorizeOnly'] )
		{
			if( !Data::Is_Number($UserID) || !$UserID )
				return array(
					$this->contest['MaxAnketsCountByOne'], // сколько можно добавлять одному юзеру
					0,
					false
				);
			
			$sql = 'SELECT COUNT(*) AS cnt FROM ' . $this->tables['anketa'];
			$sql.= ' WHERE `ConID` = ' . (int) $ConID;
			$sql.= ' AND `UserID` = ' . (int) $UserID;
		}
		else
		{
			$ip 	= getenv("REMOTE_ADDR");
			$ip_fw 	= getenv("HTTP_X_FORWARDED_FOR");
			$cookie = Request::GetUID();
			
			$sql = 'SELECT COUNT(*) AS cnt FROM ' . $this->tables['anketa'];
			$sql.= ' WHERE `ConID` = ' . (int) $ConID;
			$sql.= ' AND `IP` = "' . addslashes($ip.'->'.$ip_fw) . '"';
			$sql.= ' AND `Cookie` = "' . addslashes($cookie) . '"';
		}
		
		$res = $this->_db->query($sql);
			
		if( false === $res )
			return array(
				$this->contest['MaxAnketsCountByOne'], // сколько можно добавлять одному юзеру
				0,
				false
			);
			
		list($count) = $res->fetch_row();

		return array(
			$this->contest['MaxAnketsCountByOne'], // сколько можно добавлять одному юзеру
			$count, // сколько юзер уже добавил
			($this->contest['MaxAnketsCountByOne'] - $count) > 0 ? true : false // флаг: можно ли ещё добавлять
		);
	}
	
	/**
	* Добавить голос к анкете
	*
	* @param AnkID integer - ID анкеты
	* @param ConID integer - ID конкурса
	* @param UserID integer - ID пользователя в паспорте (если голосовать могут только авторизованные пользователи)
	*
	* @exception InvalidArgumentMyException
	* @exception MyException
	*	1 - Cannot insert vote into db.
	*	2 - Cannot update votes count.
	*/
	public function AddVote($AnkID = 0, $ConID = 0, $UserID = 0)
	{
		if (!Data::Is_Number($AnkID) || !$AnkID || !Data::Is_Number($ConID))
			throw new InvalidArgumentMyException('Wrong anketa parameters.');
	
		$ip 	= getenv("REMOTE_ADDR");
		$ip_fw 	= getenv("HTTP_X_FORWARDED_FOR");
		$cookie = Request::GetUID();
		
		$AnkID = (int) $AnkID;
		
		if(!$ConID)
			$ConID = $this->GetConID_by_AnkID($AnkID);
		
		$sql = 'INSERT INTO ' . $this->tables['votes'];
		$sql.= ' SET
					`AnkID` = ' . $AnkID . ',
					`ConID` = ' . $ConID . ',
					`IP` = "' . addslashes($ip.'->'.$ip_fw) . '",
					`Cookie` = "' . addslashes($cookie) . '"';
					
		if( Data::Is_Number($UserID) && $UserID )
			$sql .= ', `UserID` = ' . (int) $UserID;
		
		$res = $this->_db->query($sql);
		
		$VoteID = $this->_db->insert_id; // добавленный голос
	
		if(!$VoteID)
			throw new MyException('Cannot insert vote into db.', 1);
		
		// обновить кол-во голосов анкеты
		$sql = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET `Votes` = `Votes` + 1';
		$sql.= ' WHERE `AnkID` = ' . $AnkID;
		
		if (!$this->_db->query($sql))
		{
			$this->_db->query('DELETE FROM ' . $this->tables['votes'] . ' WHERE `VoteID` = ' . $VoteID);
			$res = false;
		}

		if(false === $res)
			throw new MyException('Cannot update votes count.', 2);
			
		return;
	}
	
	/**
	* Можно ли менять кол-во голосов?
	* Это для админки
	*
	*/
	public function CanUpdateVote()
	{
		if ( null === $this->can_edit_vote_counts )
			return false;
			
		return $this->can_edit_vote_counts;
	}
	
	/**
	* Изменить количество голосов анкеты -- для админки
	* (Только тут не изменяется в vote-таблице.)
	*
	* @return boolean
	* @param AnkID integer - ID анкеты
	* @param Votes integer - новое кол-во голосов
	*/
	public function UpdateVote($AnkID = 0, $Votes = 0)
	{
		if(!Data::Is_Number($AnkID) || !$AnkID || !Data::Is_Number($Votes))
			return false;
	
		$sql = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET `Votes` = ' . (int) $Votes;
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить голос из таблицы vote по ID
	* Для админки
	*
	* @return boolean
	* @param VoteID integer || array - ID(ы) голоса(ов)
	*/
	public function DeleteVote($VoteID = null)
	{
		if ( empty($VoteID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['votes'] . ' WHERE `VoteID` IN (' . implode(',', (array) $VoteID) . ')' );
	}
	
	/**
	* Удалить голос из таблицы vote по ConID
	* Для админки
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	*/
	public function DeleteVoteByConID($ConID = null)
	{
		if ( empty($ConID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['votes'] . ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')' );
	}
	
	/**
	* Проверка - может ли голосовать пользователь за данную анкету
	* Кол-во пустое => может; нет => не может
	*
	* @return boolean (можно || уже голосовал) || null (нет данных)
	* @param AnkID integer - ID анкеты
	* @param ConID integer - ID конкурса
	* @param UserID integer - ID пользователя в паспорте (если голосовать могут только авторизованные пользователи)
	*/
	public function CanUserVote($AnkID = 0, $ConID = 0, $UserID = 0)
	{
		global $OBJECTS;
	
		if( !Data::Is_Number($AnkID) || !$AnkID || !Data::Is_Number($ConID) )
			return false;
			
		$AnkID = (int) $AnkID;
		$ConID = (int) $ConID;
			
		// получить конкурс
		if(!$ConID)
			$ConID = $this->GetConID_by_AnkID($AnkID);

		$this->GetContestDetails($ConID);

		if( null === $this->contest )
			return false;
	
		if (!$this->contest['VoteType']) // неограниченное голосование => за любую анкету сколько угодно раз
			return true;
		
		$where = '';
		
		if ( $this->contest['VoteType'] && array_key_exists( $this->contest['VoteType'], $this->vote_types ) && isset($this->vote_types[$this->contest['VoteType']]['sql']) )
		{
			if( isset($this->vote_types[$this->contest['VoteType']]['params']) )
			{
				$params = array();
				foreach($this->vote_types[$this->contest['VoteType']]['params'] as $k => $p)
				{
					$link = &$p;
					if( null !== ($val = @$$link) )
						$params[] = $val;
				}
				
				$where = vsprintf($this->vote_types[$this->contest['VoteType']]['sql'], $params);
			}
			else
				$where = $this->vote_types[$this->contest['VoteType']]['sql'];
		}

		$sql = 'SELECT COUNT(*) AS cnt FROM ' . $this->tables['votes'];
		$sql.= ' WHERE ' . $where;
		$sql.= (empty($where) ? '' : ' AND ');
		
		if( Data::Is_Number($UserID) && $UserID ) // голосовать может только авторизованный юзер
		{
			$sql.= '`UserID` = ' . (int) $UserID;
		}
		else
		{
			$ip 	= getenv("REMOTE_ADDR");
			$ip_fw 	= getenv("HTTP_X_FORWARDED_FOR");
			$cookie = Request::GetUID();
		
			$sql.= '((`IP` = "' . addslashes($ip.'->'.$ip_fw) . '"';
			$sql.= ' AND `Cookie` = "' . addslashes($cookie) . '")';
			$sql.= ' OR `Cookie` = "' . addslashes($cookie) . '")';
		}
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return false;
		
		list($count) = $res->fetch_row();
		
		return !( (bool) $count );
	}
	
	
	/**
	* Количество голосов анкеты
	*
	* @return integer
	* @param AnkID integer - ID анкеты
	*/
	public function GetAnketaVote($AnkID = 0)
	{
		if(!Data::Is_Number($AnkID) || !$AnkID)
			return 0;
			
		$AnkID = (int) $AnkID;
			
		if ( null !== $this->anketa && $this->anketa['AnkID'] == $AnkID )
			return $this->anketa['Votes'];
		
		$sql = 'SELECT `Votes` FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `AnkID` = ' . $AnkID;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return 0;
		
		list($AnketaVotes) = $res->fetch_row();
		
		return $AnketaVotes;
	}
	
	/**
	* Добавить количество просмотров к анкете
	*
	* @return boolean
	* @param AnkID integer - ID анкеты
	*/
	public function AddViews($AnkID = 0)
	{
		if( !Data::Is_Number($AnkID) || !$AnkID )
			return false;
	
		$sql = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET `Views` = `Views` + 1';
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Можно ли менять кол-во просмотров?
	* Для админки
	*
	*/
	public function CanUpdateView()
	{
		if ( null === $this->can_edit_view_counts )
			return false;
			
		return $this->can_edit_view_counts;
	}
	
	/**
	* Изменить количество просмотров анкеты
	*
	* @return boolean
	* @param AnkID integer - ID анкеты
	* @param Views integer - новое кол-во просмотров
	*/
	public function UpdateViews($AnkID = 0, $Views = 0)
	{
		if ( !Data::Is_Number($AnkID) || !$AnkID || !Data::Is_Number($Views) )
			return false;
	
		$sql = 'UPDATE ' . $this->tables['anketa'];
		$sql.= ' SET `Views` = ' . (int) $Views;
		$sql.= ' WHERE `AnkID` = ' . (int) $AnkID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Количество просмотров анкеты
	*
	* @return integer
	* @param AnkID integer - ID анкеты
	*/
	public function GetAnketaView($AnkID = 0)
	{
		if(!Data::Is_Number($AnkID) || !$AnkID)
			return 0;
		
		$AnkID = (int) $AnkID;
		
		if ( null !== $this->anketa && $this->anketa['AnkID'] == $AnkID )
			return $this->anketa['Views'];
		
		$sql = 'SELECT `Views` FROM ' . $this->tables['anketa'];
		$sql.= ' WHERE `AnkID` = ' . $AnkID;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return 0;
		
		list($AnketaViews) = $res->fetch_row();
		
		return $AnketaViews;
	}
	
	/**
	* Отправка анкеты куратору(ам) на почту
	*
	* @return boolean
	* @param ConID int - ID конкурса
	* @param AnkID int - ID анкеты
	*/
	public function SendAnketaByMail($ConID = 0, $AnkID = 0)
	{
		$template = 'modules/contest/sendmail_new_anketa';
	
		if( !Data::Is_Number($AnkID) || !$AnkID || !STPL::IsTemplate($template) )
			return false;
	
		if( !Data::Is_Number($ConID) || !$ConID )
			$ConID = $this->GetConID_by_AnkID($AnkID); // получить ConID по AnkID

		$this->GetContestDetails($ConID);

		if( null === $this->contest )
			return false;
		
		LibFactory::GetStatic('gpassport');
		$passport = new PUsersMgr();
		
		LibFactory::GetStatic('mailsender');
		$mail = new MailSender();

		if(empty($this->contest['CuratorEmail']))
			return true;
		
		// получить детали анкеты
		$anketa = $this->GetAnketaDetails($AnkID, -1);
		
		if( !sizeof($anketa) )
			return false;

		// получить список сайтов, на которых проводится конкурс
		$contest_refs = $this->GetContestRefs($ConID);

		// категории конкурса
		$categories = $this->GetCategoriesList($ConID);
		
		// поля формы и значения
		$form = $this->FormBuild($ConID);
		$fields = $this->GetFields($AnkID);
			
		// [B] генерация письма для конкурса
		$mail->AddAddress('to', $this->contest['CuratorEmail']);
		$mail->AddAddress('from', 'mailer@rugion.ru');
		
		$subj = 'Уведомление о новых анкетах конкурса /' . $this->contest['Name'] . '/';
		$mail->AddHeader('Subject', $subj, false);

		$msg = STPL::Fetch(
			$template,
			array(
				'Name' => $this->contest['Name'],
				'anketa' => $anketa,
				'form' => $form,
				'fields' => $fields,
				'form_types' => $this->GetTypes(),
				'contest_refs' => $contest_refs,
				'categories' => $categories,
				'passport' => $passport
			)
		);

		if(empty($msg))
			return false;
		
		$mail->AddBody('html', $msg, MailSender::BT_HTML);
		$mail->body_type = MailSender::BT_HTML;

		//if( $mail->SendImmediate() )
		if( $mail->Send() )
			$this->UpdateAnketaIsNew($AnkID); // у анкеты сделать IsNew = 0
		
		return true;
	}
	
	/**
	* Заменить названия анкет(ы) [конкурса] на значения указанных полей формы
	* Для админки
	*
	* @return boolean
	* @param FormIDs array - ID'ы полей, из которых нужно составить название
	* @param AnkID int || array - ID(ы) анкет(ы)
	*/
	public function ChangeAnketsTitles($FormIDs = null, $AnkID = 0)
	{
		if( !sizeof($FormIDs) )
			return false;
			
		$sql = 'SELECT t.Value, f.AnkID, fr.Order';
		$sql.= ' FROM ' . $this->tables['field_texts'] . ' AS t';
		$sql.= ' LEFT JOIN ' . $this->tables['fields'] . ' AS f ON f.FieldID = t.FieldID';
		$sql.= ' LEFT JOIN ' . $this->tables['forms'] . ' AS fr ON fr.FormID = f.FormID';
		$sql.= ' WHERE f.FormID IN (' . implode(',', (array) $FormIDs) . ')';
		
		if( is_array($AnkID) && sizeof($AnkID) )
			$sql .= ' AND f.AnkID IN (' . implode(',', $AnkID) . ')';
		elseif( Data::Is_Number($AnkID) && $AnkID )
			$sql .= ' AND f.AnkID = ' . (int) $AnkID;
			
		$sql.= ' ORDER BY fr.Order';
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return false;
		
		$titles = array();
		
		// собрать названия, ключи - ID'ы заявок
		while($row = $res->fetch_assoc())
		{
			if(!empty($row['Value']))
				$titles[$row['AnkID']][] = $row['Value'];
		}
			
		if( !sizeof($titles) )
			return false;
			
		// обновить названия заявок
		foreach($titles as $a => $t)
		{
			$sql_upd = 'UPDATE ' . $this->tables['anketa'];
			$sql_upd.= ' SET `Name` = "' . addslashes(implode($this->title_separator, $t)) . '"';
			$sql_upd.= ' WHERE AnkID=' . $a;
			
			$this->_db->query($sql_upd);
		}
		
		return true;
	}
	
/************************ Формы ************************/
	/**
	* Получение данных о поле
	*
	* @return array
	* @param field array - поле (запись из forms)
	*/
	public function GetFormDetails($field = null)
	{
		$data = array();
	
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type']) )
			return array($field, $data);
			
		$meta = $this->form_types[$field['Type']];
	
		if(!isset($meta['form_table']))
			return array($field, $data);
		
		$sql = 'SELECT `ID`, `FormID`, `Value`, `Order`';
		$sql .= ' FROM ' . $this->tables[$meta['form_table']];
		$sql .= ' WHERE `FormID` = ' . (int) $field['FormID'];
		$sql .= ' ORDER BY `Order`';

		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return array($field, $data);
		
		while($row = $res->fetch_assoc())
			$data[$row['ID']] = $row;
		
		return array($field, $data);
	}
	
	/**
	* Получение данных о поле по id'у
	*
	* @return array
	* @param FormID int - ID поля
	*/
	public function GetFormDetailsByID($FormID = 0)
	{
		$data = array();
	
		if ( !Data::Is_Number($FormID) || !$FormID )
			return $data;
		
		$sql = 'SELECT
					`FormID`,
					`ConID`,
					`ParentID`,
					`Name`,
					`Type`,
					`DataType`,
					`IsVisible`,
					`IsShow`,
					`IsTitle`,
					`IsRequired`,
					`IsAnnounce`,
					`Order`';
		$sql .= ' FROM ' . $this->tables['forms'];
		$sql .= ' WHERE `FormID` = ' . (int) $FormID;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		$data = $res->fetch_assoc();
		
		return $data;
	}
	
	/**
	* Получение полей формы для конкурса
	* С логическими блоками (один уровень)
	*
	* @return array
	* @param ConID integer - ID конкурса
	* @param isSendForm boolean - для заполнения формы отправки анкеты (true) или для деталей анкеты (false)
	* @param AnkID integer - ID анкеты
	* @param IsVisible integer - только видимые (1), невидимые (0), все (-1)
	*/
	public function FormBuild($ConID = 0, $isSendForm = false, $AnkID = 0, $IsVisible = 1)
	{
		$form = array();
	
		if(!Data::Is_Number($ConID) || !$ConID)
			return $form;
			
		if(!Data::Is_Number($AnkID))
			$AnkID = 0;
			
		$title = array();
		
		// выборка полей формы
		$sql = 'SELECT
					`FormID`,
					`ConID`,
					`ParentID`,
					`Name`,
					`Type`,
					`DataType`,
					`IsTitle`,
					`IsVisible`,
					`IsShow`,
					`IsRequired`,
					`IsAnnounce`,
					`Order`
				FROM ' . $this->tables['forms'];
		$sql .= ' WHERE `ConID` = ' . (int) $ConID;
		
		if(Data::Is_Number($IsVisible) && $IsVisible != -1)
			$sql .= ' AND `IsVisible` = ' . (int) $IsVisible;
			
		$sql .= ' ORDER BY `Order`';
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $form;
		
		$form['HasPhotos'] = false;
		$form['HasRequired'] = false;
		$form['title_fields'] = array();
		$form['announce'] = '';
		
		$form['data'] = array();
		
		// заполнение с учётом логических блоков
		while ($row = $res->fetch_assoc())
		{
			if($AnkID)
				$row['AnkID'] = (int) $AnkID;
		
			if($row['Type'] == 0) // логический блок (область)
			{
				if(!isset($form['data'][$row['FormID']]))
				{
					$form['data'][$row['FormID']] = $row;
					$form['data'][$row['FormID']]['blocks'] = array();
				}
				else
					$form['data'][$row['FormID']] = array_merge($form['data'][$row['FormID']], $row);
			}
			else {
			
				$f = array();
				
				list($f['field'], $f['variants']) = $this->GetFormDetails($row);
				
				if(!$isSendForm) // для деталей анкеты
				{
					list(, $f['data']) = $this->GetFieldDetails($row);
					
					if($row['IsTitle'])
						$title[] = $f['data']['Value'];
				}

				if(!isset($form['data'][$row['ParentID']]))
					$form['data'][$row['ParentID']] = array();
				if(!isset($form['data'][$row['ParentID']]['blocks']))
					$form['data'][$row['ParentID']]['blocks'] = array();

				$form['data'][$row['ParentID']]['blocks'][$row['FormID']] = $f;
				
				if( $row['Type'] == self::TYPE_PHOTO )
					$form['HasPhotos'] = true;
					
				if( $row['IsRequired'] )
					$form['HasRequired'] = true;
					
				if( $row['IsTitle'] )
					$form['title_fields'][] = $row['FormID'];
					
				if( $row['IsAnnounce'] )
					$form['announce'] = $row['FormID'];
			}
		}
		
		$form['title'] = implode($this->title_separator, $title); // название анкеты
		
		return $form;
	}
	
	/**
	* Получение списка фото-полей формы по ConID
	* Для админки
	*
	* @param ConID integer - ID конкурса
	*/
	public function GetPhotoFieldsByConID($ConID = 0)
	{
		$photos = array();
	
		if(!Data::Is_Number($ConID) || !$ConID)
			return $photos;
			
		// выборка полей формы
		$sql = 'SELECT
					`FormID`,
					`ConID`,
					`Name`,
					`IsVisible`,
					`IsRequired`,
					`Order`
				FROM ' . $this->tables['forms'];
		$sql .= ' WHERE `ConID` = ' . (int) $ConID;
		$sql .= ' AND `Type` = ' . self::TYPE_PHOTO;
		$sql .= ' ORDER BY `Order`';
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $photos;
		
		while($row = $res->fetch_assoc())
			$photos[$row['FormID']] = $row;
			
		return $photos;
	}
	

	/**
	* Добавить поле формы
	* Вложенность полей не поддерживает (уровень 1). Только логические блоки могут быть parent'ами для полей
	*
	* @return boolean
	* @param field array - параметры поля
	*/
	public function AddForm($field = null)
	{
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type']) )
			return false;
	
		$sql  = 'INSERT INTO ' . $this->tables['forms'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',';
					
		if( isset($field['ParentID']) )
			$sql .= '`ParentID` = ' . (int) $field['ParentID'] . ',';

		if( isset($field['IsTitle']) )
			$sql .= '`IsTitle` = ' . (int) $field['IsTitle'] . ',';
		
		if( isset($field['IsAnnounce']) )
			$sql .= '`IsAnnounce` = ' . (int) $field['IsAnnounce'] . ',';
		
		if( isset($field['IsShow']) )
			$sql .= '`IsShow` = ' . (int) $field['IsShow'] . ',';
			
		$sql .= '`Name` = "' . addslashes($field['Name']) . '",';
		$sql .= '`Type` = ' . (int) $field['Type'] . ',';
		$sql .= '`DataType` = ' . (int) $field['DataType'] . ',';
		$sql .= '`IsVisible` = ' . (int) $field['IsVisible'] . ',';
		$sql .= '`IsRequired` = ' . (int) $field['IsRequired'] . ',';
		$sql .= '`Order` = ' . (int) $field['Order'];

		$ins_id = 0;
		if ($this->_db->query($sql))
			$ins_id = $this->_db->insert_id;
		
		return $ins_id;
	}
	
	/**
	* Редактировать поле формы
	* Пока что вложенных полей не поддерживает (уровень 1). Только для логических блоков (которые могут быть parent'ами для полей)
	* Для админки
	*
	* @return boolean
	* @param field array - параметры поля
	*/
	public function UpdateForm($field = null)
	{
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type']) )
			return false;
	
		$sql  = 'UPDATE ' . $this->tables['forms'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`ParentID` = ' . (int) $field['ParentID'] . ',
					`Name` = "' . addslashes($field['Name']) . '",
					`Type` = ' . (int) $field['Type'] . ',
					`DataType` = ' . (isset($field['DataType']) ? (int) $field['DataType'] : 0) . ',
					`IsVisible` = ' . (isset($field['IsVisible']) ? (int) $field['IsVisible'] : 0) . ',
					`IsShow` = ' . (isset($field['IsShow']) ? (int) $field['IsShow'] : 0) . ',
					`IsTitle` = ' . (isset($field['IsTitle']) ? (int) $field['IsTitle'] : 0) . ',
					`IsRequired` = ' . (isset($field['IsRequired']) ? (int) $field['IsRequired'] : 0). ',
					`IsAnnounce` = ' . (isset($field['IsAnnounce']) ? (int) $field['IsAnnounce'] : 0). ',
					`Order` = ' . (isset($field['Order']) ? (int) $field['Order'] : 0);
		$sql.= ' WHERE `FormID` = ' . (int) $field['FormID'];
		
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить поле(я) формы, учитывая области
	* Для админки
	*
	* @return boolean
	* @param FormID integer || array - ID(ы) поля(ей)
	*/
	public function DeleteForm($FormID = null)
	{
		if ( empty($FormID) )
			return false;

		$FormIDs = implode(',', (array) $FormID);
			
		// [B] сперва удалять вложенные поля (если это область)
			// варианты значений
			$sql_del = 'DELETE FROM ' . $this->tables['form_selects'];
			$sql_del.= ' WHERE `FormID` IN (';
			$sql_del.= 	' SELECT `FormID` FROM ' . $this->tables['forms'] . ' WHERE `ParentID` IN (' . $FormIDs . ')';
			$sql_del.= ')';
			$res = $this->_db->query($sql_del);
			
			// сами поля
			if($res)
				$this->_db->query( 'DELETE FROM ' . $this->tables['forms'] . ' WHERE `ParentID` IN (' . $FormIDs . ')' );
		// [E] сперва удалять вложенные поля (если это область)
		
		// [B] саму область/поле
			// варианты значений
			$res1 = $this->_db->query( 'DELETE FROM ' . $this->tables['form_selects'] . ' WHERE `FormID` IN (' . $FormIDs . ')' );
				
			// само поле
			if($res1)
				$res = $this->_db->query( 'DELETE FROM ' . $this->tables['forms'] . ' WHERE `FormID` IN (' . $FormIDs . ')' );
		// [E] саму область/поле
			
		return $res;
	}
	
	/**
	* Удалить поле(я) формы по ConID
	* Для админки
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	*/
	public function DeleteFormByConID($ConID = null)
	{
		if ( empty($ConID) )
			return false;
			
		$ConIDs = implode(',', (array) $ConID);

		// выбрать все поля по ConID
		$sql = 'SELECT `FormID` FROM ' . $this->tables['forms'] . ' WHERE `ConID` IN (' . $ConIDs . ')';
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return false;
		
		// удалить для каждого варианты
		while($row = $res->fetch_row())
			$this->_db->query( 'DELETE FROM ' . $this->tables['form_selects'] . ' WHERE `FormID` = ' . $row[0] );
		
		// удалить скопом все поля
		return $this->_db->query( 'DELETE FROM ' . $this->tables['forms'] . ' WHERE `ConID` IN (' . $ConIDs . ')' );
	}
	
	/**
	* Получение типов полей
	* для использования в шаблонах
	*
	*/
	public function GetTypes()
	{
		$types = array();
		
		foreach($this->form_types as $k => $t)
			$types[$t['type']] = $k;
	
		return $types;
	}
	
	/**
	* Получение типов модерации
	*
	*/
	public function GetModerate()
	{
		$moderate = array();
		
		foreach($this->moderate as $k => $m)
			$moderate[$m['type']] = $k;
	
		return $moderate;
	}
	
	/**
	* Получение типов данных
	*
	*/
	public function GetDataTypes()
	{
		$dtypes = array();
		
		foreach($this->data_types as $k => $d)
			$dtypes[$d['type']] = $k;
	
		return $dtypes;
	}
	
	
	/**
	* Проверка валидности типа поля
	*
	* @param Type integer - тип поля
	*/
	protected function _CheckFieldType_Valid($Type)
	{
		if( null === $Type )
			return false;
	
		return array_key_exists((int) $Type, $this->form_types);
	}
	
	/**
	* Добавить вариант значения поля
	* Для админки
	*
	* @return boolean
	* @param field array - параметры
	*/
	public function AddFormSelector($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql  = 'INSERT INTO ' . $this->tables['form_selects'];
		$sql.= ' SET
					`FormID` = ' . (int) $field['FormID'] . ',
					`Value` = "' . addslashes($field['Value']) . '",
					`Order` = ' . (int) $field['Order'];
		
		return $this->_db->query($sql);
	}
	
	/**
	* Редактировать вариант значения поля
	* Для админки
	*
	* @return boolean
	* @param field array - параметры
	*/
	public function UpdateFormSelector($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql  = 'UPDATE ' . $this->tables['form_selects'];
		$sql.= ' SET
					`FormID` = ' . (int) $field['FormID'] . ',
					`Value` = "' . addslashes($field['Value']) . '",
					`Order` = ' . (int) $field['Order'];
		$sql.= ' WHERE `ID` = ' . (int) $field['ID'];
		
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить вариант поля
	* Для админки
	*
	* @return boolean
	* @param ID integer || array - ID(ы) варианта(ов)
	*/
	public function DeleteFormSelector($ID = 0)
	{
		if ( empty($ID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['form_selects'] . ' WHERE `ID` IN (' . implode(',', (array) $ID) . ')' );
	}
	
	/**
	* Удалить варианты поля по FormID
	* Для админки
	*
	* @return boolean
	* @param FormID integer || array - ID(ы) поля(ей)
	*/
	public function DeleteFormSelectorByFormID($FormID = 0)
	{
		if ( empty($FormID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['form_selects'] . ' WHERE `FormID` IN (' . implode(',', (array) $FormID) . ')' );
	}
	
	/**
	* Заполнить поле анкеты
	*
	* @param field array - параметры поля формы
	* @param value void - значение(я) поля
	* @param AnkID integer - ID анкеты
	* @param Order integer - порядок
	*
	* @exception InvalidArgumentMyException
	* @exception RuntimeMyException
	* @exception MyException
	*/
	public function PutField($field = null, $value = null, $AnkID = 0, $Order = 0)
	{
		global $OBJECTS;
	
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type'])
			|| ( $field['Type'] != self::TYPE_PHOTO && !isset($this->tables[$this->form_types[$field['Type']]['field_table']]) )
			|| !Data::Is_Number($AnkID) || !$AnkID
			|| ( $field['IsRequired'] && empty($value) )
		)
			throw new InvalidArgumentMyException('Wrong field parameters.');
			
		if(empty($value))
			return;
			
		if($field['Type'] == self::TYPE_PHOTO) // file
		{
			try
			{
				$fnames = $this->UploadPhoto($AnkID, 'f'.$field['FormID']);
			}
			catch (MyException $e)
			{
				throw $e;
			}
			
			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('images');
			
			foreach(array('large', 'small') as $pr)
			{
				$fnames[$pr] = FileStore::GetPath_NEW($fnames[$pr]);
				$fnames[$pr] = Images::PrepareImageToObject($fnames[$pr], $this->photo['path'], $this->photo['url']);
				$fnames[$pr] = FileStore::ObjectToString($fnames[$pr]);
			}
			
			$res = $this->AddPhoto(
				array(
					'ConID'		=> $field['ConID'],
					'AnkID'		=> $AnkID,
					'FormID'	=> $field['FormID'],
					'Title'		=> '', // временно #todo: добавить к фото название и описание
					'Descr'		=> '',
					'Photo'		=> $fnames['large'],
					'Thumb'		=> $fnames['small'],
					'IsNew'		=> 0,
					'IsVisible'	=> 1,
					'Order'		=> (Data::Is_Number($Order) ? (int) $Order : 0)
				)
			);
		}
		else
		{
			// добавить в таблицу связи
			$sql = 'INSERT INTO ' . $this->tables['fields'];
			$sql.= ' SET 
						`FormID` = ' . (int) $field['FormID'] . ',
						`AnkID` = ' . (int) $AnkID;
			
			$res = $this->_db->query($sql);
			
			if($res)
			{
				$FieldID = $this->_db->insert_id;
			
				$table = $this->tables[$this->form_types[$field['Type']]['field_table']];
			
				// добавить в таблицу значений
				if(is_array($value))
				{
					foreach(array_keys($value) as $v)
					{
						if( false == ($res = $this->AddFieldValue($table, $FieldID, $v)) )
							break;
					}
				}
				else
					$res = $this->AddFieldValue($table, $FieldID, $value);
				
				if(!$res)
					$this->_db->query('DELETE FROM ' . $table . ' WHERE `FieldID` = ' . $FieldID);
			}
		}
		
		if( false === $res )
			throw new RuntimeMyException('Was not added.');
			
		return;
	}
	
	/**
	* Получение полей анкеты
	*
	* @return array
	* @param AnkID integer - ID анкеты
	*/
	public function GetFields($AnkID = 0)
	{
		$data = array();
		
		if( !Data::Is_Number($AnkID) || !$AnkID )
			return $data;
	
		// получение полей
		$sql = 'SELECT fl.FieldID, fl.FormID, fl.AnkID, fr.Type';
		$sql.= ' FROM ' . $this->tables['fields'] . ' AS fl';
		$sql.= ' RIGHT JOIN ' . $this->tables['forms'] . ' AS fr ON fr.FormID = fl.FormID';
		$sql .= ' WHERE fl.AnkID = ' . (int) $AnkID;
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
		{
			$data[$row['FormID']] = array();
			list($data[$row['FormID']]['field'], $data[$row['FormID']]['data']) = $this->GetFieldDetails($row);
		}
		
		return $data;
	}
	
	/**
	* Получить все поля анкеты (FieldId'ы)
	*
	* @return array
	* @param AnkID integer - ID анкеты
	*/
	public function GetFieldIDs($AnkID = 0)
	{
		$data = array();
		
		if( !Data::Is_Number($AnkID) || !$AnkID )
			return $data;
			
		// получение полей
		$sql = 'SELECT fl.FieldID, fl.FormID, fl.AnkID, fr.Type';
		$sql.= ' FROM ' . $this->tables['fields'] . ' AS fl';
		$sql.= ' RIGHT JOIN ' . $this->tables['forms'] . ' AS fr ON fr.FormID = fl.FormID';
		$sql .= ' WHERE fl.AnkID = ' . (int) $AnkID;
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
			$data[] = $row['FieldID'];
			
		return $data;
	}
	
	/**
	* Получение данных о поле анкеты
	*
	* @return array
	* @param field array - поле (запись из forms)
	*/
	public function GetFieldDetails($field = null)
	{
		$data = array();
	
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type'])
			|| !isset($this->form_types[$field['Type']]['field_table'])
			|| !isset($this->tables[$this->form_types[$field['Type']]['field_table']])
		)
			return array($field, $data);
		
		// получение данных поля
		$sql = 'SELECT `ID`, `FieldID`, `Value`';
		$sql .= ' FROM ' . $this->tables[$this->form_types[$field['Type']]['field_table']];
		$sql .= ' WHERE `FieldID` = ' . (int) $field['FieldID'];

		$res = $this->_db->query($sql);
		
		if( false === $res )
			return array($field, $data);
		
		if( $field['Type'] == self::TYPE_TEXT || $field['Type'] == self::TYPE_TEXTAREA )
			$data = $res->fetch_assoc();
		else
		{
			while($row = $res->fetch_assoc())
				$data[$row['ID']] = $row;
		}
		
		return array($field, $data);
	}
	
	/**
	* Получение данных о поле анкеты по id'у
	*
	* @return array
	* @param FieldID int - ID поля
	*/
	public function GetFieldDetailsByID($FieldID = 0)
	{
		$data = array();
	
		if ( !Data::Is_Number($FieldID) || !$FieldID )
			return $data;
		
		$sql = 'SELECT
					`FieldID`,
					`FormID`,
					`AnkID`';
		$sql .= ' FROM ' . $this->tables['fields'];
		$sql .= ' WHERE `FieldID` = ' . (int) $FieldID;
		$sql .= ' LIMIT 1';
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		$field = $res->fetch_assoc();
		
		// тип поля
		if(!$this->_CheckFieldType_Valid($field['Type']) || !isset($this->vote_types[$field['Type']]['field_table']))
			return array();
		
		// выбор значения поля
		$sql = 'SELECT `Value` FROM ' . $this->tables[$this->vote_types[$field['Type']]['field_table']];
		$sql.= ' WHERE `FieldID` = ' . $field['FieldID'];
		$sql.= ' LIMIT 1';
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		$data = $res->fetch_assoc();
		
		return array_merge($field, $data);
	}
	
	/**
	* Добавить значение поля
	*
	* @return boolean
	* @param table string - имя таблицы
	* @param value array || string - значение поля
	*/
	public function AddFieldValue($table = '', $FieldID = 0, $value = null)
	{
		global $OBJECTS;
	
		if( empty($table) || !Data::Is_Number($FieldID) || !$FieldID || empty($value) )
			return false;
			
		$sql  = 'INSERT INTO ' . $table;
		$sql.= ' SET
					`FieldID` = ' . $FieldID . ',
					`Value` = "' . addslashes($value) . '"';
					
		return (bool) $this->_db->query($sql);
	}
	
	/**
	* Редактировать поле анкеты
	* Для админки
	*
	* @return boolean - отредактирована запись или нет
	*
	* @param field array - параметры поля формы
	* @param value void - значение(я) поля
	* @param AnkID integer - ID анкеты
	* @param Order integer - порядок
	*
	* @exception InvalidArgumentMyException
	* @exception RuntimeMyException
	*/
	public function EditField($field = null, $value = null, $AnkID = 0, $Order = 0)
	{
		if( empty($field) || !is_array($field) || !$this->_CheckFieldType_Valid($field['Type'])
			|| !isset($field['FieldID']) || !Data::Is_Number($field['FieldID'])
			|| ( $field['Type'] != self::TYPE_PHOTO && !isset($this->tables[$this->form_types[$field['Type']]['field_table']]) )
			|| !Data::Is_Number($AnkID) || !$AnkID
			|| ( $field['IsRequired'] && empty($value) )
		)
			throw new InvalidArgumentMyException('Wrong field parameters.');
			
		if(empty($value))
			return;

		if($field['Type'] != self::TYPE_PHOTO) // не file
		{
			$table = $this->tables[$this->form_types[$field['Type']]['field_table']];
		
			switch($field['Type'])
			{
				case self::TYPE_CHECKBOX:
					// удалить старые
					if(!$this->DeleteFieldValue($this->form_types[$field['Type']]['field_table'], $field['FieldID']))
						break;
						
					// добавить новые
					if(is_array($value))
					{
						foreach(array_keys($value) as $v)
						{
							if( false == ($res = $this->AddFieldValue($table, $field['FieldID'], $v)) )
								break;
						}
					}
				break;
				
				default: // заменить
					if(!is_array($value))
						$res = $this->UpdateFieldValue($table, $field, $value);
			}
		}
		
		if(false === $res)
			throw new RuntimeMyException('Was not edited.');
		
		return;
	}
	
	/**
	* Редактировать значение поля
	* Для админки
	*
	* @return boolean
	* @param table string - таблица
	* @param field array - параметры
	* @param value string - значение поля
	*/
	public function UpdateFieldValue($table = null, $field = null, $value = '')
	{
		if( empty($table) || empty($field) || !is_array($field) || null === $value
			|| ( (!isset($field['FieldID']) || !Data::Is_Number($field['FieldID'])) && (!isset($field['ID']) || !Data::Is_Number($field['ID'])) ) )
			return false;
	
		$sql  = 'UPDATE ' . $table;
		$sql.= ' SET
					`Value` = "' . addslashes($value) . '"';
		
		$where = array();
		if(isset($field['ID']))
			$where[] = '`ID` = ' . (int) $field['ID'];
			
		if(isset($field['FieldID']))
			$where[] = '`FieldID` = ' . (int) $field['FieldID'];
		
		$sql.= ' WHERE ' . implode(' AND ', $where);
		
		return $this->_db->query($sql);
	}
	
	/**
	* Удалить поле по AnkID
	* Для админки
	*
	* @return boolean
	* @param AnkID integer || array - ID(ы) анкет(ы)
	*/
	public function DeleteFieldByAnkID($AnkID = null)
	{
		if ( empty($AnkID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables['fields'] . ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')' );
	}
	
	/**
	* Удалить поле по FormID
	* Для админки
	*
	* @return boolean
	* @param FormID integer || array - ID(ы) полей формы
	*/
	public function DeleteFieldByFormID($FormID = null)
	{
		if ( empty($FormID) )
			return false;
			
		$FormIDs = implode(',', (array) $FormID);
			
		// выбрать все варианты полей по FormID
		$sql = 'SELECT `FieldID` FROM ' . $this->tables['fields'];
		$sql.= ' WHERE `FormID` IN (' . $FormIDs . ')';
		
		$res = $this->_db->query($sql);
		
		if( false === $res )
			return false;
		
		$field_ids = array();
		while($row = $res->fetch_row())
		{
			// удалить все варианты полей
			$field_ids[] = $row[0];
		}
		
		if( sizeof($field_ids) )
		{
			// удалить все варианты полей
			$this->DeleteFieldValue($this->tables['field_selects'], $field_ids);
			$this->DeleteFieldValue($this->tables['field_texts'], $field_ids);
			$this->DeleteFieldValue($this->tables['field_textareas'], $field_ids);
		}
			
		// удалить само значение поля
		return $this->_db->query( 'DELETE FROM ' . $this->tables['fields'] . ' WHERE `FormID` IN (' . $FormIDs . ')' );
	}
	
	/**
	* Удалить вариант поля
	* Для админки
	*
	* @return boolean
	* @param table string - ключ таблицы
	* @param FieldID integer || array - ID(ы) значения(й)
	*/
	public function DeleteFieldValue($table = null, $FieldID = null)
	{
		if ( empty($table) || !isset($this->tables[$table]) || empty($FieldID) )
			return false;
			
		return $this->_db->query( 'DELETE FROM ' . $this->tables[$table] . ' WHERE `FieldID` IN (' . implode(',', (array) $FieldID) . ')' );
	}
	
/************************ Фото ************************/

	/**
	* Загрузка фотографии
	*
	* @return array (
	*	boolean - успешно или нет,
	*	string - имя загруженного файла или строка ошибки
	*)
	* @param AnkID integer - ID анкеты
	* @param k string - название поля фото
	* @param HasSecurityImage boolean - наложить логотип сайта
	* @exception InvalidArgumentMyException
	* @exception RuntimeMyException
	*	3 - Cannot upload photos.
	* @exception MyException
	*/
	public function UploadPhoto($AnkID = 0, $k = '', $HasSecurityImage = true)
	{
		if ( null === $this->photo )
			throw new InvalidArgumentMyException('No config photo parameters.');
		
		if( !Data::Is_Number($AnkID) || !$AnkID )
			throw new InvalidArgumentMyException('Wrong AnkID.');
			
		if( empty($k) )
			throw new InvalidArgumentMyException('No photo field name.');
			
		if ( !is_file($_FILES[$k]['tmp_name']) )
			throw new InvalidArgumentMyException('No file.');
			
		$fnames = array();
		
		if( $HasSecurityImage )
		{
			$this->photo['large']['params']['security'] = array(
				'file' => null,
				'position' => 'br'
			);
		}
		
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('filemagic');
		
		foreach(array('large', 'small') as $pr)
		{
			$prefix = (int) $AnkID . '_' . $k . $this->photo[$pr]['prefix'];
			
			try
			{
				// загрузка файла
				$fname = FileStore::Upload_NEW(
					$k,
					$this->photo['path'],
					$prefix,
					FileMagic::MT_WIMAGE,
					$this->photo[$pr]['max_size'],
					$this->photo[$pr]['params']
				);
			}
			catch ( MyException $e )
			{
				// ошибка => удалить уже загруженные
				foreach(array('large', 'small') as $pr)
				{
					if( isset($fnames[$pr]) && !empty($fnames[$pr]) )
					{
						try
						{
							FileStore::Delete_NEW($this->photo[$pr]['path'] . FileStore::GetPath_NEW($fnames[$pr]));
						}
						catch ( MyException $e1 ) {}
					}
				}
				
				if ( $e->getCode() > 0 )
					throw new RuntimeMyException('Cannot upload photos.', 3);
			}
			
			$fnames[$pr] = $fname;
		}
		
		return $fnames;
	}
	
	/**
	* Добавить фото
	*
	* @return boolean || integer
	* @param field array - данные поля
	*/
	public function AddPhoto($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql = 'INSERT INTO ' . $this->tables['photos'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`AnkID` = ' . (int) $field['AnkID'] . ',
					`FormID` = ' . (int) $field['FormID'] . ',
					`Created` = NOW(),
					`Title` = "' . addslashes($field['Title']) . '",
					`Descr` = "' . addslashes($field['Descr']) . '",
					`Thumb` = "' . addslashes($field['Thumb']) . '",
					`Photo` = "' . addslashes($field['Photo']) . '",
					`Order` = ' . (int) $field['Order'];
		if( isset($field['IsVisible']) && Data::Is_Number($field['IsVisible']) )
			$sql .= ', `IsVisible` = ' . (int) $field['IsVisible'];
		
		$this->_db->query($sql);
		
		return $this->_db->insert_id;
	}
	
	/**
	* Обновить данные фото
	*
	* @return boolean
	* @param field array - данные поля
	*/
	public function UpdatePhoto($field = null)
	{
		if( empty($field) || !is_array($field) )
			return false;
	
		$sql = 'UPDATE ' . $this->tables['photos'];
		$sql.= ' SET
					`ConID` = ' . (int) $field['ConID'] . ',
					`AnkID` = ' . (int) $field['AnkID'] . ',
					`FormID` = ' . (int) $field['FormID'] . ',
					`Created` = "' . $field['Created'] . '",
					`Title` = "' . addslashes($field['Title']) . '",
					`Descr` = "' . addslashes($field['Descr']) . '",';
		if( isset($field['Thumb']) )
			$sql .= '`Thumb` = "' . addslashes($field['Thumb']) . '",';
			
		if( isset($field['Photo']) )	
			$sql .= '`Photo` = "' . addslashes($field['Photo']) . '",';
			
		$sql.='`IsVisible` = ' . (int) $field['IsVisible'] . ',
					`Order` = ' . (int) $field['Order'];
		$sql.= ' WHERE `PhotoID` = ' . (int) $field['PhotoID'];
		
		return $this->_db->query($sql);
	}
	
	/**
	* Изменить видимость фото
	*
	* @return boolean
	* @param PhotoID integer - ID фото
	*/
	public function TogglePhotoVisible($PhotoID = 0)
	{
		if(!Data::Is_Number($PhotoID) || !$PhotoID)
			return false;
			
		$sql  = 'UPDATE ' . $this->tables['photos'];
		$sql.= ' SET `IsVisible` = 1 - `IsVisible`';
		$sql.= ' WHERE `PhotoID` = ' . (int) $PhotoID;
		
		return $this->_db->query($sql);
	}
	
	/**
	* Получить все фото анкеты
	*
	* @return array
	* @param ConID integer - ID конкурса
	* @param AnkID integer - ID анкеты
	* @param limit integer - сколько фотографий получить
	* @param IsVisible integer - видимое
	* @param filter array - фильтр (для ORDER BY)
	*/
	public function GetPhotoList($ConID = 0, $AnkID = 0, $limit = 0, $IsVisible = 1, $filter = null)
	{
		$data = array();
	
		if ( !Data::Is_Number($AnkID) || !Data::Is_Number($ConID) || (!$ConID && !$AnkID) )
			return $data;
			
		if(!sizeof($filter))
			$filter = array(
				'sort' => array(
					array('field' => 'Order', 'dir' => 'DESC'),
					array('field' => 'Created', 'dir' => 'DESC')
				)
			);
		
		$sql = 'SELECT
					`PhotoID`,
					`ConID`, `AnkID`, `FormID`,
					`Created`,
					`Title`,
					`Descr`,
					`Thumb`,
					`Photo`,
					`IsVisible`,
					`Order`
				FROM ' . $this->tables['photos'];
		$sql.= ' WHERE ';
		
		$where = array();
		if( !empty($ConID) )
			$where[] = '`ConID` = ' . (int) $ConID;

		if( !empty($AnkID) )
			$where[] = '`AnkID` = ' . (int) $AnkID;
		
		if( Data::Is_Number($IsVisible) && $IsVisible != -1 )
			$where[] = '`IsVisible` = ' . (int) $IsVisible;
			
		$sql.= implode(' AND ', $where);
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= ' ORDER BY ';
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ( !in_array(strtolower($f['dir']), array('asc', 'desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = ' `' . $f['field'] . '` ' . $f['dir'] . ' ';
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		$lim = 0;
		if( Data::Is_Number($limit) && $limit )
			$lim = (int) $limit;

		if( !empty($this->photo_count) )
		{
			if( !$lim || ($lim && $lim > $this->photo_count) )
				$lim = $this->photo_count;
				
			$sql.= ' LIMIT ' . $lim;
		}
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
		{
			$row['ThumbImg'] = $this->GetPhotoInfo($row['Thumb']);
			$row['PhotoImg'] = $this->GetPhotoInfo($row['Photo']);
				
			$data[] = $row;
		}
		
		if( empty($data) )
			$data = array(
				array(
					'PhotoType' => 'special',
					'ThumbImg' => $this->GetPhotoInfo(''),
					'PhotoImg' => $this->GetPhotoInfo('')
				)
			);
		
		return $data;
	}
	
	/**
	* Получить детали фото
	*
	* @return array
	* @param PhotoID integer - ID фото
	*/
	public function GetPhotoDetails($PhotoID = 0)
	{
		$data = array();
		
		if ( !Data::Is_Number($PhotoID) || !$PhotoID )
			return $data;

		$sql = 'SELECT
					`PhotoID`,
					`ConID`, `AnkID`, `FormID`,
					`Created`,
					`Title`,
					`Descr`,
					`Thumb`,
					`Photo`,
					`IsVisible`,
					`Order`
				FROM ' . $this->tables['photos'];
		$sql.= ' WHERE `PhotoID` = ' . (int) $PhotoID;

		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		$data = $res->fetch_assoc();
		
		// получение данных об изображениях
		$data['ThumbImg'] = $this->GetPhotoInfo($data['Thumb']);
		$data['PhotoImg'] = $this->GetPhotoInfo($data['Photo']);
		
		return $data;
	}
	
	/**
	* Получить детали фото по ConID
	* Для админки
	*
	* @return array
	* @param ConID integer || array - ID(ы) конкурса
	*/
	public function GetPhotosDetailsByConID($ConID = null)
	{
		$data = array();
		
		if ( empty($ConID) )
			return $data;

		$sql = 'SELECT
					`PhotoID`,
					`Thumb`,
					`Photo`
				FROM ' . $this->tables['photos'];
		$sql.= ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')';

		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
		{
			// получение данных об изображениях
			$row['ThumbImg'] = $this->GetPhotoInfo($row['Thumb']);
			$row['PhotoImg'] = $this->GetPhotoInfo($row['Photo']);
			
			$data = $row;
		}
		
		return $data;
	}
	
	/**
	* Получить детали фото по FormID
	* Для админки
	*
	* @return array
	* @param FormID integer || array - ID(ы) полей формы
	*/
	public function GetPhotosDetailsByFormID($FormID = null)
	{
		$data = array();
		
		if ( empty($FormID) )
			return $data;

		$sql = 'SELECT
					`PhotoID`,
					`Thumb`,
					`Photo`
				FROM ' . $this->tables['photos'];
		$sql.= ' WHERE `FormID` IN (' . implode(',', (array) $FormID) . ')';

		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
		{
			// получение данных об изображениях
			$row['ThumbImg'] = $this->GetPhotoInfo($row['Thumb']);
			$row['PhotoImg'] = $this->GetPhotoInfo($row['Photo']);
			
			$data = $row;
		}
		
		return $data;
	}
	
	/**
	* Получить детали фото по AnkID
	* Для админки
	*
	* @return array
	* @param AnkID integer - ID анкеты
	*/
	public function GetPhotosDetailsByAnkID($AnkID = null)
	{
		$data = array();
		
		if ( empty($AnkID) )
			return $data;

		$sql = 'SELECT
					`PhotoID`,
					`Thumb`,
					`Photo`
				FROM ' . $this->tables['photos'];
		$sql.= ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')';

		$res = $this->_db->query($sql);
		
		if( false === $res )
			return $data;
		
		while($row = $res->fetch_assoc())
		{
			// получение данных об изображениях
			$data[$row['PhotoID']] = array(
				'ThumbImg' => $this->GetPhotoInfo($row['Thumb']),
				'PhotoImg' => $this->GetPhotoInfo($row['Photo'])
			);
		}
		
		return $data;
	}
	
	/**
	* Получение данных фото
	*
	* @return array
	* @param photo string - название фото
	* @param NeedEmptyImg boolean - отдавать пустое изображение?
	*
	* @exception MyException
	*/
	protected function GetPhotoInfo($photo = '', $NeedEmptyImg = true)
	{
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');
		
		if ( !empty($photo) )
		{
			try
			{
				$img_obj = FileStore::ObjectFromString($photo);
				$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
				$image = Images::PrepareImageFromObject($img_obj, $this->photo['path'], $this->photo['url']);
				unset($img_obj);
			}
			catch (MyException $e)
			{
				if( !$NeedEmptyImg )
					return null;
			
				// пустая картинка
				$image = Images::PrepareImageFromObject($this->photo['empty_img']['meta'], '', $this->photo['empty_img']['url']);
			}
		}
		else
		{
			if( !$NeedEmptyImg )
				return null;
				
			$image = Images::PrepareImageFromObject($this->photo['empty_img']['meta'], '', $this->photo['empty_img']['url']);
		}
		
		return $image;
	}
	
	/**
	* Удалить фотографию(и)
	*
	* @return boolean
	* @param PhotoID integer || array - ID(ы) фотографии(й)
	*/
	public function DeletePhoto($PhotoID = null)
	{
		if ( empty($PhotoID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['photos'] . ' WHERE `PhotoID` IN (' . implode(',', (array) $PhotoID) . ')' );
	}
	
	/**
	* Удалить фотографию(и) по ConID
	*
	* @return boolean
	* @param ConID integer || array - ID(ы) конкурса(ов)
	*/
	public function DeletePhotoByConID($ConID = null)
	{
		if ( empty($ConID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['photos'] . ' WHERE `ConID` IN (' . implode(',', (array) $ConID) . ')' );
	}
	
	/**
	* Удалить фотографию(и) по FormID
	*
	* @return boolean
	* @param FormID integer || array - ID(ы) полей формы
	*/
	public function DeletePhotoByFormID($FormID = null)
	{
		if ( empty($FormID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['photos'] . ' WHERE `FormID` IN (' . implode(',', (array) $FormID) . ')' );
	}
	
	/**
	* Удалить фотографию(и) по AnkID
	*
	* @return boolean
	* @param AnkID integer || array - ID(ы) анкет(ы)
	*/
	public function DeletePhotoByAnkID($AnkID = null)
	{
		if ( empty($AnkID) )
			return false;

		return $this->_db->query( 'DELETE FROM ' . $this->tables['photos'] . ' WHERE `AnkID` IN (' . implode(',', (array) $AnkID) . ')' );
	}
	
	/**
	* Удалить конкретные фото с диска
	*
	* @return boolean
	* @param photos array - фотки
	*
	* @exception InvalidArgumentMyException
	* @exception MyException
	*/
	public function DeletePhotoFiles($photos = null)
	{
		if( !sizeof($photos) )
			return false;
		
		// удалить все файлы фоток
		foreach($photos as $photo)
			$this->DeleteOnePhotoFile($photo);
		
		return true;
	}
	
	/**
	* Удалить одно фото
	*
	* @exception InvalidArgumentMyException
	* @exception MyException
	*/
	public function DeleteOnePhotoFile($photo = null)
	{
		if( !sizeof($photo) )
			throw new InvalidArgumentMyException('No photo.');
			
		LibFactory::GetStatic('filestore');
		
		// фотка и превьюшка
		foreach( array('PhotoImg', 'ThumbImg') as $p )
		{
			if( !isset($photo[$p]) || !isset($photo[$p]['path']) || empty($photo[$p]['path']) )
				break; // нет фотки => нет и превьюшки

			// исключение ловится уровнем выше (где метод вызывается)
			// удаляем файл
			FileStore::Delete_NEW($photo[$p]['path']);
		}
	}
	
/************************ Остальные ************************/
	
	public function __get($name)
	{
		$name = strtolower($name);

		switch($name)
		{
			case 'anketscountbyone_min';
				return self::AnketsCountByOne_Min;
			break;
			
			case 'anketscountbyone_max':
				return self::AnketsCountByOne_Max;
			break;
			
			case 'page':
				return $this->p;
			break;
		}
	}
	
	public function __set($name, $value)
	{
		$name = strtolower($name);
	
		switch($name)
		{
			case 'page':
				if(Data::Is_Number($value))
					$this->p = (int) $value;
			break;
		}
	}
}

?>