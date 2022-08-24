<?
require_once $CONFIG['engine_path'].'include/advertise/advmgr.php';

static $error_code = 0;
define('ERR_L_JOB_MASK', 0x00610000);

define('ERR_L_JOB_FIRM_NAME', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_FIRM_NAME] = 'Наименование фирмы не верно';
define('ERR_L_JOB_FIRM_CITY', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_FIRM_CITY] = 'Город не указан';
define ('ERR_L_JOB_RUBRIC', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_RUBRIC] = 'Рубрика не указана';
define ('ERR_L_JOB_POSITION', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_POSITION] = 'Поле ДОЛЖНОСТЬ должно быть заполнено';
define ('ERR_L_JOB_SALARY', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_SALARY] = 'Уровень заработной платы должен быть указан';
define ('ERR_L_JOB_FIRSTNAME', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_FIRSTNAME] = 'Необходимо ввести имя';
define ('ERR_L_JOB_STAGE', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_STAGE] = 'Поле СТАЖ должно быть заполнено';
define ('ERR_L_JOB_EDUCATION', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_EDUCATION] = 'Необходимо указать образование';
define ('ERR_L_JOB_PHONE', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_PHONE] = 'Номер телефона не соответствует установленному формату';
define ('ERR_L_JOB_FAX', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_FAX] = 'Номер факса не соответствует установленному формату';
define ('ERR_L_JOB_HTTP', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_HTTP] = 'Адрес сайта указан неверно';
define ('ERR_L_JOB_EMAIL', ERR_L_JOB_MASK | $error_code++);
	UserError::$Errors[ERR_L_JOB_EMAIL] = 'E-mail указан неверно';


class AdvSheme_job extends AdvShemeBase
{
	public $WorkType = array(	// Перечисление типов работы
		0x0001 => 'Постоянная',
		0x0004 => 'По совместительству',
		0x0008 => 'Временная',
		0x0010 => 'Разовая',
		0x0020 => 'Надомная',
		0x0040 => 'Фрилансер (договорная)',
		0x0080 => 'На выезде',
		0x0100 => 'Почасовая',
	);
	public $WorkSchedule = array(	// Перечисление графиков работы
		0 => 'Любой',
		1 => 'Полный рабочий день',
		2 => 'Неполный рабочий день',
		3 => 'Свободный',
		4 => 'Вахтовый'
	);
	public $Education = array(	// Перечисление вариантов образования
		1 => 'Высшее',
		2 => 'Неоконченное высшее',
		3 => 'Среднее',
		4 => 'Среднее специальное',
		5 => 'Другое'
	);
	public $Sex = array( // Пол
		1 => 'Мужской',
		2 => 'Женский'
	);
	public $Ability = array(	// Степень ограничения трудоспособности
		0 => 'Отсутствует',
		1 => 'I степень',
		2 => 'II степень',
		3 => 'III степень'
	);
	public $Car = array(	// Наличие автомобиля

	);
	public $Children = array(
		0 => 'Нет',
		1 => 'Есть',
	);

	public $Travel = array(
		1 => 'Готов(а)',
		2 => 'Не готов(а)',
	);

	public $Marriad = array(
		1 => 'не замужем / не женат',
		2 => 'есть друг / есть подруга',
		3 => 'помолвлена / помолвлен',
		4 => 'замужем / женат',
		5 => 'все сложно',
		6 => 'в активном поиске',
		7 => 'свободен / свободна',
		8 => 'влюблен / влюблена',
		9 => 'в разводе',
		10 => 'гражданский брак',
	);

	public $Age = array(
		20 => 'До 20',
		30 => 'До 30',
		40 => 'До 40',
		50 => 'До 50',
		51 => 'Старше 50'
	);

	public $SalaryForm = array(
		1 => 'Оклад',
		2 => 'Оклад+%',
		3 => '%',
		4 => 'Подряд',
		5 => 'Почасовая',
		6 => 'Сдельная',
		7 => 'Другая'
	);
	public $Importance = array(
		1 => 'Срочно',
		2 => 'Не очень срочно',
		3 => 'Сейчас работаю, но интересный вариант готов рассмотреть');

	public $Status = array(
		1 => 'Абитуриент',
		2 => 'Студент (специалист)',
		3 => 'Студент (бакалавр)',
		4 => 'Студент (магистр)',
		5 => 'Выпускник (специалист)',
		6 => 'Выпускник (бакалавр)',
		7 => 'Выпускник (магистр)',
		8 => 'Аспирант',
		9 => 'Кандидат наук',
		10 => 'Доктор наук',
	);

	public $Course = array(
		1 => 'Дневная',
		2 => 'Вечерняя',
		3 => 'Заочная',
		4 => 'Очно-заочная'
	);

	public $Class = array(
		1 => "1",
		2 => "2",
		3 => "3",
		4 => "4",
		5 => "5",
		6 => "6",
		7 => "7",
		8 => "8",
		9 => "9",
		10 => "а",
		11 => "б",
		12 => "в",
		13 => "г",
		14 => "д",
		15 => "е",
		16 => "ж",
		17 => "з",
		18 => "и",
		19 => "к",
		20 => "л",
		21 => "м",
		22 => "н",
		23 => "о",
		24 => "п",
		25 => "р",
		26 => "с",
		27 => "т",
		28 => "у",
		29 => "ф",
		30 => "х",
		31 => "ц",
		32 => "ч",
		33 => "ш",
		34 => "щ",
		35 => "ы",
		36 => "э",
		37 => "ю",
		38 => "я",
		39 => "а2",
		40 => "б2",
		41 => "в2",
		42 => "г2",
		43 => "д2",
		44 => "е2",
		45 => "ж2",
		46 => "з2",
		47 => "и2",
		48 => "к2",
		49 => "л2",
		50 => "м2",
		51 => "н2",
		52 => "о2",
		53 => "п2",
		54 => "р2",
		55 => "с2",
		56 => "т2",
		57 => "у2",
		58 => "ф2",
		59 => "х2",
		60 => "ц2",
		61 => "ч2",
		62 => "ш2",
		63 => "щ2",
		64 => "ы2",
		65 => "э2",
		66 => "ю2",
		67 => "я2",
		68 => "а3",
		69 => "б3",
		70 => "в3",
		71 => "г3",
		72 => "д3",
		73 => "е3",
		74 => "ж3",
		75 => "з3",
		76 => "и3",
		77 => "к3",
		78 => "л3",
		79 => "м3",
		80 => "н3",
		81 => "о3",
		82 => "п3",
		83 => "р3",
		84 => "с3",
		85 => "т3",
		86 => "у3",
		87 => "ф3",
		88 => "х3",
		89 => "ц3",
		90 => "ч3",
		91 => "ш3",
		92 => "щ3",
		93 => "ы3",
		94 => "э3",
		95 => "ю3",
		96 => "я3",
	);

	public $RubricID = 0;

	protected $_redis = null;
	protected $_stats = array();
	protected $_last = array();

	public function __construct($path, $prefix = '')
	{
		// База данных формируется в зависимости от префикса региона
		$this->sheme['db'] = "r".$prefix."_job";

		// Описание скалярных полей, общих для разделов
		$this->sheme['scalar_fields']['AdvID']			= array( 'type' => 'int' );		// ИД объявления
		$this->sheme['scalar_fields']['UserID']			= array( 'type' => 'int' );		// ИД пользователя
		$this->sheme['scalar_fields']['Position']		= array( 'type' => 'char' );	// Должность
		$this->sheme['scalar_fields']['Location']		= array( 'type' => 'char' );	// Код города|улицы
		$this->sheme['scalar_fields']['Area']			= array( 'type' => 'char' );	// Район
		$this->sheme['scalar_fields']['House']			= array( 'type' => 'char' );	// Номер дома
		$this->sheme['scalar_fields']['WorkType']		= array( 'type' => 'int' );		// Тип работы
		$this->sheme['scalar_fields']['WorkSchedule']	= array( 'type' => 'int' );		// График работы
		$this->sheme['scalar_fields']['Stage']			= array( 'type' => 'int' );		// Стаж
		$this->sheme['scalar_fields']['Education']		= array( 'type' => 'int' );		// Образование
		$this->sheme['scalar_fields']['Sex']			= array( 'type' => 'int' );		// Пол
		$this->sheme['scalar_fields']['Ability']		= array( 'type' => 'int' );		// Трудоспособность
		$this->sheme['scalar_fields']['Phone']			= array( 'type' => 'char' );	// Номер телефона
		$this->sheme['scalar_fields']['Contacts']		= array( 'type' => 'char' );	// Контактное лицо
		$this->sheme['scalar_fields']['Email']			= array( 'type' => 'char' );	// Ё-майлы
		$this->sheme['scalar_fields']['Http']			= array( 'type' => 'char' );	// Адрес сайта
		$this->sheme['scalar_fields']['AllowIM']		= array( 'type' => 'int' );		// Получать личный сообщения

        $this->sheme['scalar_fields']['MapX']			= array( 'type' => 'float' );	// Широта
		$this->sheme['scalar_fields']['MapY']			= array( 'type' => 'float' );	// Долгота
		$this->sheme['scalar_fields']['SpanX']			= array( 'type' => 'float' );	// Ширина
		$this->sheme['scalar_fields']['SpanY']			= array( 'type' => 'float' );	// Высота
		$this->sheme['scalar_fields']['Cookie']			= array( 'type' => 'char' );	// Куки
		$this->sheme['scalar_fields']['IP']				= array( 'type' => 'char' );	// Айпи

		$this->sheme['scalar_fields']['GrabSource']		= array( 'type' => 'int' );		// Грабленное
		$this->sheme['scalar_fields']['Moderate']		= array( 'type' => 'int' );		// Отметак модератора
		$this->sheme['scalar_fields']['ReModerate']		= array( 'type' => 'int' );		// Сколько раз на модерации
		$this->sheme['scalar_fields']['IsNew']			= array( 'type' => 'int' );		// На модерацию или нет
		$this->sheme['scalar_fields']['opt_InState']	= array( 'type' => 'int' );		// Состояние объявления
		$this->sheme['scalar_fields']['opt_File']		= array( 'type' => 'int' );		// Есть вложенные файлы или нет
		$this->sheme['scalar_fields']['Important']		= array( 'type' => 'int' );		// Выделенное красным
		$this->sheme['scalar_fields']['ImportantTill']	= array( 'type' => 'date' );	// До какого выделенно

		$this->sheme['scalar_fields']['DateCreate']		= array( 'type' => 'date' );	// Дата добавления
		$this->sheme['scalar_fields']['DateUpdate']		= array( 'type' => 'date' );	// Дата обновления
		$this->sheme['scalar_fields']['DateValid']		= array( 'type' => 'date' );	// Дата валидности
		$this->sheme['scalar_fields']['Visible']		= array( 'type' => 'int');		// Видимость на сайте

		// векторные поля
		$this->sheme['vector_fields']['Favorite']		= array( 'type' => 'array', 'fields' => array('Favorite','Remark') );
		$this->sheme['vector_fields']['File']			= array( 'type' => 'array', 'fields' => array('Path','Remark'), 'order' => 'FileID' );
		$this->sheme['vector_fields']['RubricID']		= array( 'type' => 'int' );

		// ключевое поле
		$this->sheme['key'] = 'AdvID';

		// Поля, используемые в профеле работодателя
		$this->sheme['firm_fields']['FirmID']		= array( 'type' => 'int'	); // ИД фирмы
		$this->sheme['firm_fields']['Scope']		= array( 'type' => 'int'	); // Тип регистрации
		$this->sheme['firm_fields']['Name']			= array( 'type' => 'char'	); // ФИО руководителя
		$this->sheme['firm_fields']['Firm']			= array( 'type' => 'char'	); // Наименование фирмы
		$this->sheme['firm_fields']['Location']		= array( 'type' => 'char'	); // Адрес
		$this->sheme['firm_fields']['House']		= array( 'type' => 'char'	); // Номер здания
		$this->sheme['firm_fields']['Area']			= array( 'type' => 'char'	); // Район
		$this->sheme['firm_fields']['Contacts']		= array( 'type' => 'char'	); // Контакты
		$this->sheme['firm_fields']['LogoLarge']	= array( 'type' => 'char'	); // Большой логотип
		$this->sheme['firm_fields']['LogoSmall']	= array( 'type' => 'char'	); // Маленький логотип
		$this->sheme['firm_fields']['DateCreate']	= array( 'type' => 'date'	); // Дата создания
		$this->sheme['firm_fields']['DateUpdate']	= array( 'type' => 'date'	); // Дата последнего обновления
		$this->sheme['firm_fields']['About']		= array( 'type' => 'char'	); // О фирме
		$this->sheme['firm_fields']['Email']		= array( 'type' => 'char'	); // Майл
		$this->sheme['firm_fields']['Phone']		= array( 'type' => 'char'	); // Номера телефонов
		$this->sheme['firm_fields']['Fax']			= array( 'type' => 'char'	); // Номера факсов
		$this->sheme['firm_fields']['Http']			= array( 'type' => 'char'	); // Сайт фирмы
		$this->sheme['firm_fields']['Link']			= array( 'type' => 'char'	); // Ссылка с аннонса
		$this->sheme['firm_fields']['Important']	= array( 'type' => 'char'	); // Важность
		$this->sheme['firm_fields']['ManagerID']	= array( 'type' => 'int'	); // Манагер
		$this->sheme['firm_fields']['Tariff']		= array( 'type' => 'int'	); // Тариф
		$this->sheme['firm_fields']['TariffTill']	= array( 'type' => 'date'	); // До какого тариф
		$this->sheme['firm_fields']['Announce']		= array( 'type' => 'int'	); // Участие в анонсах

		parent::__construct($path, $prefix);
	}

	public function GetRubrics($nocache = false)
	{
		$key = "job:rubrics";
		$rubrics = array();

		$this->_redis = LibFactory::GetInstance('redis');
		try
		{
			$this->_redis->Init('advertise');
			$val = $this->_redis->Get($key);
			if ($val !== null)
				$rubrics = unserialize($val);
		}
		catch ( MyException $e ) {}

		if (!empty($rubrics) && $nocache)
			return $rubrics;

		$rubrics = array();
		$sql = "SELECT * FROM `rubrics` ORDER BY `Name` ASC";
		$_db = DBFactory::GetInstance("g_job");
		$res = $_db->query($sql);

		if ( $res === false )
			return false;

		while ( $row = $res->fetch_assoc() )
			$rubrics[] = $row;

		if ($this->_redis !== null)
			$this->_redis->Set($key, serialize($rubrics));

		$_db->close();
		return $rubrics;
	}

	/* Функция FirmGet
	 * Получение данных фирмы по ИД или по пользователю
	 * @FirmID (int) - ИД фирмы
	 * @UserID (int) - ИД пользователя
	 * @return mixed - данные фирмы или фолс, в случа ошибки
	 */
	public function FirmGet($UserID = 0, $FirmID = 0)
	{
		if ($FirmID == 0 && $UserID == 0)
			return false;

		$sql = "SELECT `f`.* FROM `". $this->sheme['tables']['prefix'] ."_firms` as `f`";
		if ($UserID > 0)
			$sql.= " LEFT JOIN `". $this->sheme['tables']['prefix'] ."_firms_ref` as `fr` ON `f`.`FirmID` = `fr`.`FirmID`";
		$sql.= " WHERE 1";
		if ($UserID > 0)
			$sql.= " AND `fr`.`UserID` = ".$UserID;
		if ($FirmID > 0)
			$sql.= " AND `f`.`FirmID` = ".$FirmID;

		$res = $this->db->query($sql);

		if ( $res === false || $res->num_rows == 0 )
			return false;

		if ( false === ($row = $res->fetch_assoc()) )
			return false;

		$firm = array();
		foreach ($this->sheme['firm_fields'] as $name => $field)
			$firm[$name] = $row[$name];
		return $firm;
	}

	public function FirmCheck($firm)
	{
		if (empty($firm['Firm']))
			UserError::AddError(ERR_L_JOB_FIRM_NAME);

		if ( !empty($firm['Phone']) && !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$firm['Phone'].',') )
			UserError::AddError(ERR_L_JOB_PHONE);

		if ( !empty($firm['Fax']) && !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$firm['Fax'].',') )
			UserError::AddError(ERR_L_JOB_FAX);

		if ( !empty($firm['Email']) && !preg_match('/[0-9a-z_]+@[0-9a-z_^.]+.[a-z]{2,3}/i',$firm['Email']) )
			UserError::AddError(ERR_L_JOB_EMAIL);
	}

	public function FirmStore($firm)
	{
		if (isset($firm['FirmID']) && is_numeric($firm['FirmID']))
			$sql = "UPDATE `". $this->sheme['tables']['prefix'] ."_firms` SET";
		else
			$sql = "INSERT INTO `". $this->sheme['tables']['prefix'] ."_firms` SET";

		$sql .= " `DateUpdate` = NOW()";
		foreach ($this->sheme['firm_fields'] as $name => $field)
			if (isset($firm[$name]))
				$sql.= " ,`".$name."` = '".addslashes($firm[$name])."'";

			trace::vardump($sql);
		$res = $this->db->query($sql);

		if ($res == false)
			return false;

		$FirmID = $this->db->insert_id;

		$sql = "REPLACE INTO `". $this->sheme['tables']['prefix'] ."_firms_ref` SET";
		$sql.= " `UserID` = ". App::$User->ID .",";
		$sql.= " `FirmID` = ". $FirmID;

		$this->db->query($sql);
	}

	public function UpdateState(){}
	public function UpdateTariffs(){}
	private function UpdateCounters(){}
	public function UserActionProlongAndUpdate( $AdvIds, $Period = 1, $limit = null )
	{
		global $OBJECTS;

		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;

		switch ($Period)
		{
			case 2:
				$add = "2 WEEK";
				break;
			case 3:
				$add = "1 MONTH";
				break;
			case 4:
				$add = "2 MONTH";
				break;
			default:
				$add = "1 WEEK";
		}

		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateUpdate` = NOW()";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `DateUpdate` < '". Datetime_my::DateOffset() ."'";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);

		$this->db->query($sql);
		//error_log($sql);

		$updated = intval($this->db->affected_rows);

		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateValid` = NOW() + INTERVAL ". $add .", ";
		$sql.= " `opt_InState` = 0";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `Visible` = 1";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);

		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);

		$prolonged = intval($this->db->affected_rows);

		return array($prolonged, $updated);
	}
}

class AdvIterator_job extends AdvIteratorBase
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'Visible', 'IsNew', 'RubricID', 'DateCreate', 'Important', 'DateUpdate', 'UserID',
		'Address', 'House', 'Phone', 'Favorite', 'ImportID',
	);

	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_job extends AdvBase
{
	public function IsValid()
	{
		global $OBJECTS;

		$is_valid = true;

		if (empty($this->data['Position']))
		{
			UserError::AddError(ERR_L_JOB_POSITION);
		}

		if ( empty($this->data['Phone']) || !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$this->data['Phone'].',') )
		{
			UserError::AddError(ERR_L_JOB_PHONE);
			$is_valid = false;
		}
		if ( !empty ($this->data['Fax']) && !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$this->data['Fax'].','))
		{
			UserError::AddError(ERR_L_JOB_FAX);
			$is_valid = false;
		}
		if ( is_null($this->data['SalaryMin']) )
		{
			UserError::AddError(ERR_L_JOB_SALARY);
			$is_valid = false;
		}
		if ( strlen($this->data['Location']) != 22 )
		{
			UserError::AddError(ERR_L_JOB_FIRM_CITY);
			$is_valid = false;
		}
		if ( !empty($this->data['Email']) && !preg_match('/[0-9a-z_а-я]+@[0-9a-z_а-я^.]+.[a-zа-я]{2,4}/i',$this->data['Email'].',') )
		{
			UserError::AddError(ERR_L_JOB_EMAIL);
			$is_valid = false;
		}
		if ( !empty($this->data['Http']) && !preg_match('/[0-9a-z_а-я^.]+.[a-zа-я]{2,4}/i',$this->data['Http'].',') )
		{
			UserError::AddError(ERR_L_JOB_HTTP);
			$is_valid = false;
		}
		return ( parent::IsValid() && $is_valid );
	}

	public function Remove()
	{
		return parent::Remove();
	}
}
?>