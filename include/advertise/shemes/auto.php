<?
//require_once $CONFIG['engine_path'].'include/source/db.auto.php';
require_once $CONFIG['engine_path'].'include/advertise/advmgr.php';

$error_code = 1;
define('ERR_L_AUTO_MASK', 0x00600000);

define('ERR_L_AUTO_BRAND', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_BRAND] = 'Марка указана неверно.';

define('ERR_L_AUTO_MODEL', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_MODEL] = 'Модель указана неверно.';

define('ERR_L_AUTO_DIAMETER', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_DIAMETER] = 'Диаметр указан неверно.';

define('ERR_L_AUTO_SEASONALITY', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_SEASONALITY] = 'Сезонность указана неверно.';

define('ERR_L_AUTO_WIDTH', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_WIDTH] = 'Ширина указана неверно.';

define('ERR_L_AUTO_HEIGHT', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_HEIGHT] = 'Высота указана неверно.';

define('ERR_L_AUTO_SPIKES', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_SPIKES] = 'Наличие шипов указано неверно.';

define('ERR_L_AUTO_PRICE', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_PRICE] = 'Цена указана неверно.';

define('ERR_L_AUTO_COUNT', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_COUNT] = 'Количество указано неверно.';

define('ERR_L_AUTO_COLOR', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_COLOR] = 'Цвет указан неверно.';

define('ERR_L_AUTO_TYPE', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_TYPE] = 'Тип указан неверно.';

define('ERR_L_AUTO_RUBRIC', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_RUBRIC] = 'Рубрика указана неверно.';

define('ERR_L_AUTO_NAME', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_NAME] = 'Наименование указано неверно.';

define('ERR_L_AUTO_YEAR', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_YEAR] = 'Год указан неверно.';

define('ERR_L_AUTO_STATUS', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_STATUS] = 'Состояние указано неверно.';

define('ERR_L_AUTO_FUEL', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_FUEL] = 'Топливо указано неверно.';

define('ERR_L_AUTO_ENGINECAPACITY', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_ENGINECAPACITY] = 'Объём двигателя указан неверно.';

define('ERR_L_AUTO_BODYTYPE', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_BODYTYPE] = 'Тип кузова указан неверно.';

define('ERR_L_AUTO_MILEAGE', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_MILEAGE] = 'Пробег указан неверно.';

define('ERR_L_AUTO_CONTACTS', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_CONTACTS] = 'Контакты не указаны.';

define('ERR_L_AUTO_PHONE', ERR_L_AUTO_MASK | $error_code++);
UserError::$Errors[ERR_L_AUTO_PHONE] = 'Телефон указан неверно.';


class AdvSheme_auto extends AdvShemeBase
{
	public $RubricID = 0;
	
	public $_debug = null;
	
	protected $_cache = null;
	protected $_stats = array();	
	protected $_tree = null;
	protected $_last = array();

	public $Config = array(
		 'rudder' => 
		  array (
			0 => 'Левый',
			1 => 'Правый',
		  ),
		  'gearbox' => 
		  array (
			0 => 'Автомат',
			1 => 'Вариатор',
			2 => 'Механическая',
			3 => 'Роботизированная',
		  ),
		  'drive' => 
		  array (
			0 => 'Передний',
			1 => 'Задний',
			2 => 'Полный',
		  ),
		  'bodytype' => 
		  array (
			0 => 'внедорожник',
			1 => 'кабриолет',
			2 => 'кроссовер',
			3 => 'купе',
			4 => 'лимузин',
			5 => 'минивэн',
			6 => 'пикап',
			7 => 'родстер',
			8 => 'седан',
			9 => 'хетчбэк',
			10 => 'универсал',
			11 => 'компактвэн',
			12 => 'фургон',
			13 => 'шасси'			
		  ),
		   'cabintype' => 
		  array (
			0 => '2-х местная без спального',
			1 => '2-х местная с 1 спальным',
			2 => '2-х местная с 2 спальными',
			3 => '3-х местная без спального',
			4 => '3-х местная с 1 спальным',
			5 => '7-и местная, двухрядная ',			
		  ),
		  'state' => 
		  array (
			0 => 'отличное',
			1 => 'хорошее',
			2 => 'среднее',
			3 => 'битый',
			4 => 'аварийный',
		  ),
		  'fuel' => 
		  array (
			1 => 'газ',
			2 => 'бензин',
			4 => 'дт',
			8 => 'электро',
			16 => 'гибрид',
		  ),
		  'enginecapacity' => 
		  array (
			'min' => '0.5',
			'max' => '8.0',
		  ),
		  'enginetype' =>
		  array(
			1 => 'карбюратор',
			2 => 'инжектор',
		  ),
		  
		  'chaffer' => 70, //торг, относится к options
		  
		  'options'	=> array(
			1 => array(		
				'title'	=> 'Экстерьер',
				'fields'	=>	array(
					1	=> 'Галогеновые фары',
					2	=> 'Дополнительный стоп-сигнал',
					3	=> 'Задние противотуманные фары',
					4	=> 'Задний спойлер',
					5	=> 'Ксеноновые фары',
					6	=> 'Литые колесные диски',
					7	=> 'Обогрев дворников',
					8	=> 'Обогрев зеркал',
					9	=> 'Омыватели фар',
					10	=> 'Очиститель заднего стекла (задний дворник)',
					11	=> 'Передние противотуманные фары',
					12	=> 'Стеклоомыватели с обогревом',
					13	=> 'Стеклянный люк на крыше',
					14	=> 'Тонированные стекла',
					15	=> 'Фаркоп (буксировочный крюк)',
				),
			),	
			
			2 => array(		
				'title'	=> 'Интерьер',
				'fields'	=>	array(
					16	=> 'Велюровый салон',
					17	=> 'Кожаная отделка рулевого колеса',
					18	=> 'Кожаный салон',
					19	=> 'Отделка под дерево',
					20	=> 'Отделка под металл',
					21	=> 'Подлокотник задний',
					22	=> 'Подлокотник передний',
					23	=> 'Тканевый салон',			
				),
			),
			
			3 => array(		
				'title'	=> 'Комфорт',
				'fields'	=>	array(
					24	=> 'Складывающееся заднее сиденье',
					25	=> 'Бортовой компьютер',
					26	=> 'Гидроусилитель руля',
					27	=> 'Датчик дождя',
					28	=> 'Климат-контроль',
					29	=> 'Кондиционер',
					30	=> 'Круиз-контроль',
					31	=> 'Обогрев сидений',		
					32	=> 'Парктроник',	
					33	=> 'Подогрев лобового стекла',				
					34	=> 'Подогрев заднего стекла',	
					35	=> 'Регулировка положения фар',				
					36	=> 'Регулировка руля по высоте',	
					37	=> 'Регулировка руля по углу наклона',	
					38	=> 'Регулируемое по высоте сиденье водителя',	
					39	=> 'Электрозеркала',	
					40	=> 'Электропривод водительского сиденья',	
					41	=> 'Электропривод пассажирского сиденья',	
					42	=> 'Электростеклоподъемники',	
					43	=> 'Электроусилитель руля',				
				),
			),
			
			4 => array(		
				'title'	=> 'Мультимедиа',
				'fields'	=>	array(
					44	=> 'CD Чейнджер',
					45=> 'CD проигрыватель',
					46	=> 'MP3 проигрыватель',
					47	=> 'Аудиоподготовка',
					48	=> 'Магнитола',				
				),
			),
			
			5 => array(		
				'title'	=> 'Противоугонные средства',
				'fields'	=>	array(
					49	=> 'Иммобилайзер',
					50	=> 'Сигнализация',
					51	=> 'Центральный замок',					
				),
			),
			
			6 => array(		
				'title'	=> 'Безопасность',
				'fields'	=>	array(
					52	=> 'ABS (антиблокировочная система)',
					53	=> 'ASC (динамическая система курсовой устойчивости)',
					54	=> 'ASR (противобуксовочная система)',
					55	=> 'Brake Assist (система экстренного торможения)',
					56	=> 'DSA (система динамической устойчивости)',
					57	=> 'DSC (динамическое управление стабилизацией)',
					58	=> 'EBD (электронная система распределения тормозных сил)',
					59	=> 'ESP (система курсовой устойчивости)',		
					60	=> 'SVSC (система курсовой устойчивости, интегрированная с рулевым управлением)',	
					61	=> 'TCS (система управления тягой)',				
					62	=> 'TRC (противобуксовочная система)',	
					63	=> 'VSC (система курсовой устойчивости)',				
					64	=> 'Боковые подушки безопасности водителя и переднего пассажира',	
					65	=> 'Боковые шторки безопасности',	
					66	=> 'Подушка безопасности водителя',	
					67	=> 'Подушка безопасности переднего пассажира',	
					68	=> 'Ремни безопасности для заднего сиденья',				
				),
			),
		),
		
		'colors'	=> array(
			
								193	=> 'Авантюрин',
								4	=> 'Адриатик',
								5	=> 'Аквамарин',
								195	=> 'Амулет',
								272	=> 'Амулет люкс',
								216	=> 'Антилопа',
								260	=> 'Атлантика',
								177	=> 'Афалина',
								6	=> 'Баклажан',
								183	=> 'Балтика',
								7	=> 'Бежевый',

								9	=> 'Белая лилия',
								10	=> 'Белая ночь',
								191	=> 'Бело-серый',
								11	=> 'Белый',
								242	=> 'Белый леденец',

								188	=> 'Белый соболь',
								13	=> 'Бирюза',

								15	=> 'Бордовый',

								205	=> 'Бордовый перламутр',
								189	=> 'Бриз',
								17	=> 'Валентина',
								214	=> 'Васильковый',
								176	=> 'Виктория',
								232	=> 'Вишневый перламутр',
								256	=> 'Вишневый сад',
								18	=> 'Вишня',

								21	=> 'Голубой',

								190	=> 'Гранат',
								201	=> 'Гранат-тюнинг',
								23	=> 'Гранатовый',

								265	=> 'Дипломат',
								262	=> 'Желто-зеленый',
								26	=> 'Желтый',

								28	=> 'Жемчуг',
								234	=> 'Зеленая яшма',
								29	=> 'Зеленый',

								199	=> 'Зеленый сад',
								219	=> 'Зеркально-серебристый',
								263	=> 'Золотисто-желтый',
								31	=> 'Золотой',
								283	=> 'Золотой лист',

								203	=> 'Ива',
								211	=> 'Ива серебристая',
								175	=> 'Игуана',
								33	=> 'Изумруд',

								34	=> 'Ирис',
								220	=> 'Испанский красный',
								217	=> 'Кармен',
								285	=> 'Кварц',
								181	=> 'Коралл',
								35	=> 'Коричневый',

								37	=> 'Коррида',
								245	=> 'Корсика',

								40	=> 'Красный',

								42	=> 'Кремовый',
								212	=> 'Лагуна',
								210	=> 'Магия',
								246	=> 'Майя',
								46	=> 'Малиновый',

								48	=> 'Медео',
								49	=> 'Металлик',
								50	=> 'Миндаль',
								187	=> 'Мираж',
								255	=> 'Млечный путь',
								276	=> 'Млечный путь люкс',
								51	=> 'Мокрый асфальт',

								54	=> 'Морская волна',

								248	=> 'Мулен Руж',
								56	=> 'Мурена',

								58	=> 'Нептун',
								281	=> 'Нефертити',
								280	=> 'Нефертити люкс',
								200	=> 'Ниагара',
								275	=> 'Ниагара люкс',
								184	=> 'Океан',
								259	=> 'Оливин',
								59	=> 'Оливковый',
								60	=> 'Опал',
								274	=> 'Опал люкс',
								61	=> 'Оранж',

								258	=> 'Осока',
								63	=> 'Охра',
								65	=> 'Папирус',
								273	=> 'Папирус люкс',
								213	=> 'Перламутрово-бежевый',
								66	=> 'Песочный',

								68	=> 'Пицунда',
								69	=> 'Приз',
								185	=> 'Приз-инж',
								70	=> 'Примула',
								71	=> 'Рапсодия',
								277	=> 'Рапсодия люкс',
								72	=> 'Розовый',

								74	=> 'Рубиновый',

								76	=> 'Салатовый',

								241	=> 'Сандал',
								78	=> 'Сафари',

								80	=> 'Светло-бежевый',

								85	=> 'Светло-голубой',

								87	=> 'Светло-гранатовый',
								88	=> 'Светло-желтый',

								90	=> 'Светло-зеленый',

								92	=> 'Светло-коричневый',

								94	=> 'Светло-красный',
								97	=> 'Светло-песочный',

								102	=> 'Светло-серебро',

								104	=> 'Светло-серый',
								105	=> 'Светло-синий',

								107	=> 'Светло-сиреневый',

								109	=> 'Светло-фиолетовый',
								194	=> 'Серебристая ива',
								218	=> 'Серебристо-голубой',
								204	=> 'Серебристый',

								224	=> 'Серебристый ярко-зеленый',
								112	=> 'Серебро',

								257	=> 'Серо-белый',
								254	=> 'Серо-голубой',

								244	=> 'Серо-зеленый',

								238	=> 'Серо-синий',

								225	=> 'Серо-стальной',
								114	=> 'Серый',

								227	=> 'Сине-зеленый',

								116	=> 'Синий',
								230	=> 'Синий деним',
								229	=> 'Синий кристал',

								249	=> 'Синий океан',
								223	=> 'Синяя королева',
								118	=> 'Синяя ночь',
								119	=> 'Сиреневый',

								180	=> 'Сливочно-белый',
								186	=> 'Снежная королева',
								252	=> 'Снежно-белый',
								222	=> 'Табак',
								126	=> 'Темно-бордовый',

								128	=> 'Темно-вишня',

								130	=> 'Темно-голубой',

								134	=> 'Темно-желтый',
								135	=> 'Темно-зеленый',

								179	=> 'Темно-зеленый перламутр',
								137	=> 'Темно-золотой',

								139	=> 'Темно-коричневый',

								141	=> 'Темно-кофейный',
								142	=> 'Темно-красный',

								144	=> 'Темно-лиловый',
								145	=> 'Темно-малиновый',
								146	=> 'Темно-оранжевый',

								148	=> 'Темно-песочный',

								150	=> 'Темно-розовый',

								152	=> 'Темно-рубиновый',

								154	=> 'Темно-серебро',

								156	=> 'Темно-серый',

								231	=> 'Темно-серый перламутр',
								158	=> 'Темно-синий',

								160	=> 'Темно-сиреневый',

								162	=> 'Темно-фиолетовый',

								166	=> 'Торнадо',
								167	=> 'Триумф',
								192	=> 'Фея',
								168	=> 'Фиолетовый',

								170	=> 'Хаки',
								171	=> 'Чайная роза',
								174	=> 'Чароит',
								172	=> 'Черный',

								228	=> 'Черный эбонит',
								182	=> 'Ярко-белый',
								278	=> 'Ярко-белый люкс',
								268	=> 'Ярко-зеленый',
								236	=> 'Ярко-красный',
								206	=> 'Ярко-синий',
								251	=> 'Ярко-фиолетовый',
		),
	);
	
	/**
		Уничтожение объекта
	*/
	public function Destroy()
	{
		if ( is_object($this->_cache) )
			$this->_cache->Destroy();
		parent::Destroy();
	}
	
	public function __construct($path, $prefix = '')
	{
		// база данных
		$this->sheme['db'] = 'adv_auto';		
		// скалярные поля
		$this->sheme['scalar_fields']['AdvID'] 				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['RubricID']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['UserID'] 			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['DateCreate']			= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['DateUpdate']			= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['DateValid']			= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['IsVisible']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['IsValid']			= array( 'type' => 'int' );	
		
		$this->sheme['scalar_fields']['Details']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Price']				= array( 'type' => 'int' );				
		$this->sheme['scalar_fields']['Contacts']			= array( 'type' => 'char' );		
		$this->sheme['scalar_fields']['Phone']				= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['CityCode']			= array( 'type' => 'char' );		
		$this->sheme['scalar_fields']['AllowIM']			= array( 'type' => 'int' );		
		
		$this->sheme['scalar_fields']['opt_InState']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['opt_Title']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['opt_Photo']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['old_AdvID']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Views']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['IsNew']				= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Moderate']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Remoderate']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Cookie']				= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['IP']					= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Important']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['ImportantTill']		= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['GrabSource']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['ImportID']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Rotated']			= array( 'type' => 'int' );
		
		// векторные поля		
		$this->sheme['vector_fields']['Options']			= array( 'type' => 'int', 'fields' => array('Options'));
		$this->sheme['vector_fields']['Photo']				= array( 'type' => 'array', 'fields' => array('Photo','PhotoSmall','Description'), 'order' => 'PhotoID' );		
		$this->sheme['vector_fields']['Favorite']			= array( 'type' => 'array', 'fields' => array('Favorite','Remark') );
		//$this->sheme['vector_fields']['Chaffer']			= array( 'type' => 'int' ); // торг
		
		// ключевое поле
		$this->sheme['key'] = 'AdvID';
		
		$this->sheme['tables'] = array(			
			'slaves' => array(
				'ref'	=> 'automarka_ref',
			),
		);
		
		LibFactory::GetStatic('datetime_my');
		
		parent::__construct($path, $prefix);
		
		// кэш
		LibFactory::GetStatic('cache');
        $this->_cache = new Cache();
        $this->_cache->Init('memcache', 'auto');
	}
	
	public function GetIterator($filter = array(), $load_vectors = false)
	{
		global $CONFIG;
		
		include_once $CONFIG['engine_path'].'include/advertise/shemes/'. $this->path .'.php';
		$cn = 'AdvIterator_'. str_replace('/', '_', strtolower($this->path));
		
		if ( !class_exists($cn) )
			throw new exception("Adv iterator class not found");

		return new $cn($this, $filter, $load_vectors);
	}
	
	public function GetTreeByRubricID($RubricID = null)
	{
		if(empty($RubricID))	
			$RubricID = $this->RubricID;
			
		$cacheid = 'tree|'. $this->sheme['tables']['prefix'] .'|'. $RubricID;
		$this->_tree = $this->_cache->Get($cacheid);
		
		if ( $this->_tree !== false && App::$Request->Get['nocache']->Int(0) < 12 )
			return $this->_tree;
	
		$sql = "SELECT `ID` FROM ".$this->sheme['tables']['slaves']['ref'];		
		$sql.= " WHERE";
		
		if(is_array($RubricID))
			$sql.= " `RubricID` IN (".implode(',', $RubricID).")";
		else		
			$sql.= " `RubricID` = ".intval($RubricID);

		$res = $this->db->query($sql);
		
		$params = array();
		while($row = $res->fetch_assoc()){
			$params[$row['ID']] = $row['ID'];
		}
		
		LibFactory::GetStatic('source');
		$tree = array();
		$tree = Source::GetData('db.auto', array());

		$this->_tree = array_intersect_key($tree, $params);
		$this->_cache->Set($cacheid, $this->_tree, 3600);
		return $this->_tree;
	}
	
	public function GetBrandsByRubricID($RubricID = null) {
		
		global $OBJECTS;
		
		if(empty($RubricID))	
			$RubricID = $this->RubricID;
			
		$cacheid = 'brands|'. $this->sheme['tables']['prefix'] .'|'. $RubricID;
		$brands = $this->_cache->Get($cacheid);
			
		if ( $brands !== false && App::$Request->Get['nocache']->Int(0) < 12 )
			return $brands;

		$brands = array();
		
		$sql = "SELECT `ID` FROM ".$this->sheme['tables']['slaves']['ref'];		
		$sql.= " WHERE `RubricID` =".intval($RubricID);
		
		$res = $this->db->query($sql);
		
		$params = array('type' => 1);
		while($row = $res->fetch_assoc()){
			$brands[$row['ID']] = $row['ID'];
		}
		
		//$brands = source_db_autotree($params);
		LibFactory::GetStatic('source');
		$source = Source::GetData('db.auto', $params);

		$brands = array_intersect_key($source, $brands);
		$this->_cache->Set($cacheid, $brands, 3600);
		return $brands;
	}
	
	public function GetModelsByBrandAndRubricID($Brand, $RubricID = null) {

		if(empty($RubricID))
			$RubricID = $this->RubricID;

		$cacheid = 'models|'. $this->sheme['tables']['prefix'] .'|'. $Brand.'|'.$RubricID;
		$models = $this->_cache->Get($cacheid);

		if ( $models !== false && App::$Request->Get['nocache']->Int(0) < 12 )
			return $models;

		$models = array();
		$sql = "SELECT `ID` FROM ".$this->sheme['tables']['slaves']['ref'];
		$sql.= " WHERE `RubricID` =".intval($RubricID);
		
		
		$res = $this->db->query($sql);

		$params = array('type' => 2, 'parent' => $Brand);
		while($row = $res->fetch_assoc()){
			$models[$row['ID']] = $row['ID'];
		}

		//$models = source_db_autotree($params);
		LibFactory::GetStatic('source');
		$source = Source::GetData('db.auto', $params);

		$models = array_intersect_key($source, $models);

		$this->_cache->Set($cacheid, $models, 3600);
		return $models;
	}
	
	
	public function GetStatistic($UserID = 0, $inState = 1, $ForWeek = 0, $Period = null, $CompanyOnly = null)
	{
		$inState = intval($inState);
						
		if ( !isset( $this->_stats[$UserID][$this->RubricID][$inState][$ForWeek] ) || !empty($Period) || !empty($CompanyOnly))
		{
			$cacheid = 'stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState;

			if(!empty($ForWeek))
				$cacheid.="|forweek";
				
			if(!empty($Period))
				$cacheid.="|".$Period;
				
			if(!empty($CompanyOnly))
				$cacheid.="|CompanyOnly";
			
			$this->_stats[$UserID][$this->RubricID][$inState][$ForWeek] = $this->_cache->Get($cacheid);
			
			if ($this->_stats[$UserID][$this->RubricID][$inState][$ForWeek] === false || $_GET['nocache'] > 12 )
			{				
				$sql = "SELECT count(*) FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
				if ( $inState == 1 )
					$sql.= " WHERE `opt_InState` = 0 AND ";
				else
					$sql.= " WHERE ";
				$sql.= "`RubricID` = ". $this->RubricID;
				if ( $UserID > 0 )
					$sql.= " AND `UserID` = ". $UserID;				
					
				if(!empty($ForWeek))
					$sql.= " AND  `DateCreate` > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
					
				if ( $Period > 0 && $Period <= 31)
					$sql.= " AND  `DateUpdate` >= '".strftime("%G-%m-%d %H:%M:%S", time()-$Period*24*60*60)."'";
					
				if(!empty($CompanyOnly))
					$sql.= " AND  `UserID` IN (SELECT UserID FROM ".$this->sheme['tables']['prefix']."_users WHERE Status>0)";
				
				$res = $this->db->query($sql);
				
				if ( $res === false )
					return false;
				
				list($this->_stats[$UserID][$this->RubricID][$inState][$ForWeek]) = $res->fetch_row();
				
				$this->_cache->Set($cacheid, $this->_stats[$UserID][$this->RubricID][$inState][$ForWeek], 300);
			}
		}
		return $this->_stats[$UserID][$this->RubricID][$inState][$ForWeek];
	}
	
	
	public function GetLast($UserID = 0, $inState = 1, $optPhoto = 0)
	{
		$inState = intval($inState);
		$cacheid = 'last|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $optPhoto;
		
		$this->_last[$UserID][$this->RubricID][$inState][$optPhoto] = $this->_cache->Get($cacheid);
		
		if ( $this->_last[$UserID][$this->RubricID][$inState][$optPhoto] == false || $_GET['nocache'] > 12 )
		{
			$sql = "SELECT `AdvID`, `DateCreate` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
			$sql.= " WHERE `RubricID` = '".$this->RubricID."'";
			if ( $inState == 1 )
				$sql.= " AND `opt_InState` = 0";
			if ( $UserID > 0 )
				$sql.= " AND `UserID` = ". $UserID;
			if ( $optPhoto == 1 )
				$sql.= " AND `opt_Photo` = ".$optPhoto;
			$sql.= " AND `IsNew` IN (0,1)";
			$sql.= " ORDER BY `DateCreate` DESC LIMIT 0,5";
			
			$res = $this->db->query($sql);
			if ( $res === false )
				return false;
			
			while (($row = $res->fetch_assoc()) != false)
			{
				$rows[$row['AdvID']] = $row;
			}
			
			$this->_last[$UserID][$this->RubricID][$inState][$optPhoto] = $rows;
			$this->_cache->Set($cacheid, $this->_last[$UserID][$this->RubricID][$inState][$optPhoto], 300);
		}
		
		return $this->_last[$UserID][$this->RubricID][$inState][$optPhoto];
	}
	
	
	public function GetFavoritesCount($UserID)
	{
		if ( !is_numeric($UserID) )
			return 0;
		
		
		$cacheid = 'GetFavoritesCount|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID;
		
		
		$this->_stats[$UserID][$this->RubricID][3] = $this->_cache->Get($cacheid);
		
		if ($this->_stats[$UserID][$this->RubricID][3] === false || $_GET['nocache'] > 12)
		{
			$sql = "SELECT count(*) FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['slaves']['Favorite'] ." f";
			$sql.= " INNER JOIN ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ." m ON m.`AdvID` = f.`AdvID`";
			$sql.= " WHERE m.`opt_InState` = 0 AND m.`RubricID` = ". $this->RubricID ." AND f.`Favorite` = ". $UserID;
			//error_log($sql);
			$res = $this->db->query($sql);		
			
			if ( $res === false )
				return false;
			list($this->_stats[$UserID][$this->RubricID][3]) = $res->fetch_row();
			
			$this->_cache->Set($cacheid, $this->_stats[$UserID][$this->RubricID][3], 300);
		}
		
		
		return $this->_stats[$UserID][$this->RubricID][3];
	}
		
	public function ClearCache($UserID = 0)
	{
		
		return		
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|0')&&
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|1')&&
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|2')&&
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|3')&&
			$this->_cache->Remove('GetFavoritesCount|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID)&&
			$this->_cache->Remove('GetCountModerate|'. $this->sheme['tables']['prefix'] .'|'.$this->RubricID.'|'.intval($UserID));
	}
	
	
	public function TestImported($old_AdvID){
	
		$sql = "SELECT AdvID FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];		
		$sql.= " WHERE old_AdvID = ".intval($old_AdvID);		
		
		if ( ($res = $this->db->query($sql)) === false)
			return false;
		
		list($AdvID) = $res->fetch_row();
		
		return $AdvID;
	}


	public function UpdateTariffs()
	{
		LibFactory::GetStatic('datetime_my');
		$now = DateTime_my::NowOffset();

		$sql = "UPDATE `".$this->sheme['tables']['prefix']."_users` SET `Tariff` = 0";
		$sql.= " WHERE `Tariff` > 0";
		$sql.= " AND `TariffTill` IS NOT NULL";
		$sql.= " AND `TariffTill` < '".$now."'";

		if ( $this->db->query($sql) === false )
			return false;

		return true;
	}


	public function UpdateState()
	{
		LibFactory::GetStatic('datetime_my');
		$now = DateTime_my::NowOffset();

		$sql = "SELECT `AdvID` FROM `".$this->sheme['tables']['prefix'] . $this->sheme['tables']['master']."`";

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `Important` = 1";
		$where.= " AND `ImportantTill` IS NOT NULL";
		$where.= " AND `ImportantTill` < '".$now."'";

        $res = $this->db->query($sql.$where);
		$AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];


		$sql = "UPDATE `".$this->sheme['tables']['prefix'] . $this->sheme['tables']['master']."`";
		$sql.= " SET `Important` = 0";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != 0";
		$where.= " AND `DateCreate` < '". $now ."'";
		$where.= " AND `DateValid` > '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = 0";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `Important` > 0";
		$where.= " AND `DateCreate` < '". $now ."'";
		$where.= " AND `DateValid` > '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = 0, DateCreate ='".$now."', DateUpdate ='".$now."'";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != 1";
		$where.= " AND `DateCreate` < '". $now ."'";
		$where.= " AND `DateValid` < '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = 1";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `RubricID` = '".$this->RubricID."'";
		$where.= " AND `opt_InState` != 2";
		$where.= " AND `DateCreate` > '". $now ."'";

		$res = $this->db->query($sql.$where);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];



		$sql = "UPDATE ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
		$sql.= " SET `opt_InState` = 2";
		if ( $this->db->query($sql.$where) === false )
			return false;
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);
		
		return true;
	}
	
	
	public function UserActionUpdate( $AdvIds = array() )
	{
		global $OBJECTS;
		
		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;
		
		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateUpdate` = NOW()";
		$sql.= " WHERE `AdvID` IN (". implode(',', $AdvIds) .") AND `DateUpdate` < '". Datetime_my::DateOffset() ."'";
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		
		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return intval($this->db->affected_rows);
	}
	
	
	public function UserActionProlong( $AdvIds = array(), $Period = 1 )
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
		$sql.= " `DateValid` = `DateValid` + INTERVAL ". $add;
		$sql.= " WHERE `AdvID` IN (". implode(',', $AdvIds) .") AND `IsValid` = 1";
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		
		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return intval($this->db->affected_rows);
	}
	
	public function GetAdditionToUpdate($AdvIds)
	{
		global $OBJECTS;
		
		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;
				
		$sql = "SELECT count(*) FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `DateValid` < '". Datetime_my::DateOffset() ."'";
		$sql.= " AND `IsVisible` = 1";
								
		$res = $this->db->query($sql);
		
		list($addition) = $res->fetch_row();

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return $addition;
	}
	
	public function GetAdditionToShow($AdvIds)
	{
		global $OBJECTS;
		
		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;
				
		$sql = "SELECT count(*) FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `DateValid` >= '". Datetime_my::DateOffset() ."'";
		$sql.= " AND `IsVisible` = 0";
								
		$res = $this->db->query($sql);
		
		list($addition) = $res->fetch_row();

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return $addition;
	}
	
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
		
		$updated = intval($this->db->affected_rows);
		
		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `DateValid` = NOW() + INTERVAL ". $add;
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		if ( $AdvIds !== null )
			$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .") AND `IsValid` = 1";
		//$sql.= " AND `IsVisible` = 1";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);
		
		$this->db->query($sql);
		
		$prolonged = intval($this->db->affected_rows);

		AdvCache::getInstance()->Remove($this, $AdvIds);
		return array($prolonged,$updated);
	}
	
	public function UserActionProlongAndUpdateAll( $RubricID, $Period = 1, $limit = null )
	{
		global $OBJECTS;
		
		if ( (!is_array($AdvIds) || count($AdvIds) == 0) && $AdvIds !== null )
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
		
		// Поднятие в списке
		$sql_update = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql_update.= " `DateUpdate` = NOW()";
		$where = " WHERE `RubricID` = ". $RubricID;
		$where.= " AND `UserID` = ". $OBJECTS['user']->ID;
		if ( $AdvIds !== null )
			$where.= " AND `AdvID` IN (". implode(',', $AdvIds) .") AND `DateUpdate` < '". Datetime_my::DateOffset() ."'";
		$where.= " AND `DateUpdate` < '". Datetime_my::DateOffset() ."'";
		$where.= " AND `IsVisible` = 1";
		$sql_limit = '';
		if ( $limit !== null )
			$sql_limit.= " LIMIT ". intval($limit);
		
		$sql_select = "SELECT `AdvID` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
        $res = $this->db->query($sql_select.$where.$sql_limit);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$this->db->query($sql_select.$where.$sql_limit);
		$updated = intval($this->db->affected_rows);

		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);
		
		
		// Продление
		$sql_update = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql_update.= " `DateValid` = NOW() + INTERVAL ". $add;
		$where = " WHERE `RubricID` = ". $RubricID;
		$where.= " AND `UserID` = ". $OBJECTS['user']->ID;
		if ( $AdvIds !== null )
			$where.= " AND `AdvID` IN (". implode(',', $AdvIds) .") AND `IsValid` = 1";
		if ( $limit !== null )
			$sql_limit.= " LIMIT ". intval($limit);

		$sql_select = "SELECT `AdvID` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
        $res = $this->db->query($sql_select.$where.$sql_limit);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$this->db->query($sql_update.$where.$sql_limit);
		$prolonged = intval($this->db->affected_rows);

		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);

		return array($prolonged, $updated);
	}
	
	public function UserActionDelete( $AdvIds = array() )
	{
		global $OBJECTS;

		foreach ( $AdvIds as $id )
			$this->RemoveAdv($id, $OBJECTS['user']->ID);
	}

	public function UserActionReset( $AdvIds = array() )
	{
		foreach ( $AdvIds as $id )
		{
			AdvStat::getInstance()->Reset($this, $id);
		}
	}

	public function UserActionVisible( $AdvIds = array(), $visible = 1 )
	{
		global $OBJECTS;
		
		if ( !is_array($AdvIds) || count($AdvIds) == 0 )
			return 0;
		
		$visible = intval($visible);
		
		$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql.= " `IsVisible` = ". $visible;
		$sql.= " WHERE `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);

		return intval($this->db->affected_rows);
	}
	
	public function GetCountAdvByBrands($limit = null, $inState = 1){
		
		$cacheid = 'CountAdvByBrands|'. $this->sheme['tables']['prefix'] .'|'.$this->RubricID."|".$inState."|".$limit;
		$rez = $this->_cache->Get($cacheid);
			
		if ( $rez !== false && !($_GET['nocache'] > 12))
			return $rez;
			
		$rez = array();
		
		$sql = "SELECT count(*) as `Cnt`, `Brand` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		
		if ( $inState == 1 )
			$sql.= " WHERE `opt_InState` = 0 AND RubricID=".$this->RubricID;
		else		
			$sql.= " WHERE RubricID=".$this->RubricID;
		$sql.= " GROUP BY `Brand`";
		//$sql.= " ORDER BY `Cnt` DESC";
		
		
		
		if(intval($limit>0))
			$sql.= " LIMIT ".intval($limit);
		
		$res = $this->db->query($sql);
		
		while($row = $res->fetch_assoc())
			$rez[$row['Brand']] = $row['Cnt'];
			
		asort($rez);
		
		$this->_cache->Set($cacheid, $rez, 600);
		return $rez;
	}
	
	public function GetCountAdvByModels($BrandID = null, $limit = null, $inState = 1){
	
		$cacheid = 'GetCountAdvByModels|'. $this->sheme['tables']['prefix'] .'|'.$BrandID.'|'.$this->RubricID."|".$inState."|".$limit;
		$rez = $this->_cache->Get($cacheid);
			
		if ( $rez !== false && !($_GET['nocache'] > 12))
			return $rez;
			
		$rez = array();
		
		$sql = "SELECT count(*) as `Cnt`, `Model` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		
		if(isset($BrandID)){
		
			if ( $inState == 1 )
				$sql.= " WHERE `opt_InState` = 0 AND `Brand` = ".intval($BrandID);
			else
				$sql.= " WHERE `Brand` = ".intval($BrandID);
				
			$sql.= " AND `RubricID` = ".$this->RubricID;
		} else{
		
			if ( $inState == 1 )
				$sql.= " WHERE `opt_InState` = 0 AND `RubricID` = ".$this->RubricID;
			else
				$sql.= " WHERE `RubricID` = ".$this->RubricID;
		}
		
		$sql.= " GROUP BY `Model`";
		//$sql.= " ORDER BY `Cnt` DESC";
		
		if(intval($limit>0))
			$sql.= " LIMIT ".intval($limit);
		
		$res = $this->db->query($sql);
		
		while($row = $res->fetch_assoc())
			$rez[$row['Model']] = $row['Cnt'];
			
		asort($rez);
		
		$this->_cache->Set($cacheid, $rez, 600);
		return $rez;		
	}
	
	public function GetCountModerate($UserID){
	
		if ( !is_numeric($UserID) )
			return 0;
	
		$cacheid = 'GetCountModerate|'. $this->sheme['tables']['prefix'] .'|'.$this->RubricID.'|'.$UserID;
		$rez = $this->_cache->Get($cacheid);
			
		if ( $rez !== false && !($_GET['nocache'] > 12))
			return $rez;
			
		$rez = array();
		
		$sql = "SELECT count(*) FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		
		$sql.= " WHERE `UserID` = ".$UserID;
		$sql.= " AND `Moderate` != 0";
				
		$res = $this->db->query($sql);
		
		list($rez) = $res->fetch_row();
		
		$this->_cache->Set($cacheid, $rez, 300);
		return $rez;		
	}

	public function Fill_opt_Title()
	{
		$this->GetTreeByRubricID();

		if ($this->sheme['tables']['master'] == '_parts')
			$sql = "SELECT `AdvID`, `Name`";
		else
			$sql = "SELECT `AdvID`, `Brand`, `Model`";
		$sql.= " FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		$sql.= " WHERE `RubricID` = ".$this->RubricID;
		$sql.= " AND (`opt_Title` = '' OR `opt_Title` IS NULL)";

		$res = $this->db->query($sql);

		while ( $row = $res->fetch_assoc() )
		{

			if (!empty($row['Name']))
				$opt_Title = $row['Name'];
			else
				$opt_Title = $this->_tree[$row['Brand']]['name']." ".$this->_tree[$row['Model']]['name'];

			$sql = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
			$sql.= " SET `opt_Title` = '".$opt_Title."'";
			$sql.= " WHERE `AdvID` = ".$row['AdvID'];

			$this->db->query($sql);
		}
        $this->db->close();
	}
}


class AdvIterator_auto extends AdvIteratorBase
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'IsVisible', 'RubricID', 'DateCreate', 'DateUpdate', 'UserID',
		'Contacts', 'Phone', 'opt_Photo','Moderate','Remoderate','IsNew', 'CityCode', 'Price', 'Details',
		'Options', 'old_AdvID', 'AllowIM', 'Favorite','Views','Important', 'ImportID'
	);
	
	/**
		Сборка запроса
		Можно переопределять в дочерних классах в случае заковыристых запросов
		@return string
	*/
	protected function PrepareSQL()
	{
		$sql = "SELECT ";
		if ( $this->filter['distinct'] )
			$sql.= "DISTINCT ";
		if ( $this->filter['limit'] > 0 )
			$sql.= "SQL_CALC_FOUND_ROWS ";
		
		// поля
		$fields = array();
		if ( is_array($this->sheme->sheme['scalar_fields']) )
			foreach ( $this->sheme->sheme['scalar_fields'] as $name => $type )
			{
				if ( is_array($this->filter['fields']) && !in_array($name, $this->filter['fields']))
					continue;
				$fields[] = "m.`". $name ."`";
			}
		$sql.= implode(', ', $fields);
		
		$sql.= " FROM `". $this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['master'] ."` m";
		
		// связи
		$joins = array();
		if ( is_array($this->sheme->sheme['vector_fields']) )
		{
			foreach ( $this->sheme->sheme['vector_fields'] as $name => $type )
			{
				if ( array_key_exists($name, $this->filter) || 
					($type['type'] == 'array' && count(array_intersect($type['fields'],array_keys($this->filter)))) )
					$joins[$this->sheme->sheme['tables']['slaves'][$name]] = ' LEFT JOIN '.
						$this->sheme->sheme['tables']['prefix'].$this->sheme->sheme['tables']['slaves'][$name] ." `s_". strtolower($name) .
						"` ON m.`". $this->sheme->sheme['key'] ."` = s_".  strtolower($name) .".`". $this->sheme->sheme['key'] ."`";
			}
		}
		
		if ( count($joins) )
			$sql.= implode(' ', $joins);
		
		// условия
		$where = array();
		foreach ( $this->filter_index as $name )
		{			
			if ( !array_key_exists($name, $this->filter) )
				continue;
			
			$value = $this->filter[$name];
			if ( is_array($value) )
			{
				if ( array_key_exists($name,$this->sheme->sheme['scalar_fields']) )
				{
					// условие на скалярное поле
					$type = $this->sheme->sheme['scalar_fields'][$name]['type'];
					$name = 'm.`'. $name .'`';
				}
				else if ( array_key_exists($name,$this->sheme->sheme['vector_fields']) )
				{
					// условие на векторное поле
					$type = $this->sheme->sheme['vector_fields'][$name]['type'];
					$name = 's_'. strtolower($name) .'.`'. $name .'`';
				}
				else
				{
					// условие на поле из составного векторного поля
					$v = false;
					foreach ( $this->sheme->sheme['vector_fields'] as $fname => $field )
					{
						if ( $field['type'] != 'array' || !in_array($name, $field['fields']) )
							continue;
						$v = $field;
						break;
					}
					if ( $v !== false )
					{
						$type = $v['type'];
						$name = 's_'. strtolower($fname) .'.`'. $name .'`';
					}
					else
						continue;
				}
				
				if ( is_array($value[1]) && strtolower($value[0]) != 'in' && strtolower($value[0]) != 'not in' && strtolower($value[0]) != 'between' )
				{
					$or_where = array();
					foreach ( $value[1] as $v )
					{
						if ( $type == 'char' || $type == 'date' )
							if ( strtolower($value[0]) == 'in' )
								$or_where[] = $name ." IN ('". implode("', '", array_map('add_slashes',$v)) ."')";
							else
								$or_where[] = $name ." ". $value[0] ." '". addslashes($v) ."'";
						else if ( $type == 'int' )
							if ( strtolower($value[0]) == 'in' )
								$or_where[] = $name ." IN (". implode(", ", $v) .")";
							else
							{
								if ( is_numeric($v) );
									$or_where[] = $name ." ". $value[0] ." ". $v;
							}
					}
					$where[] = '('. implode(' OR ', $or_where) .')';
				}
				else
				{
					if ( $type == 'char' )
						if ( strtolower($value[0]) == 'in' )
						{
							$where[] = $name ." IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							$where[] = $name ." NOT IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
					else if ( $type == 'date' )
						if ( strtolower($value[0]) == 'between' )
						{
							if ( $value[1][0] !== false )
								$where[] = $name ." >= ". (substr($value[1][0],0,1)=="'"?"":"'") . $value[1][0] . (substr($value[1][0],0,1)=="'"?"":"'");
							if ( $value[1][1] !== false )
								$where[] = $name ." <= ". (substr($value[1][1],0,1)=="'"?"":"'") . $value[1][1] . (substr($value[1][1],0,1)=="'"?"":"'");
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
					else if ( $type == 'int' || $type == 'float' )
						if ( strtolower($value[0]) == 'in' )
						{
							if ( !empty($value[1]) && is_array($value[1]) )
								$where[] = $name ." IN (". implode(", ", $value[1]) .")";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							if ( !empty($value[1]) && is_array($value[1]) )
								$where[] = $name ." NOT IN(". implode(", ", $value[1]) .")";
						}
						else if ( strtolower($value[0]) == 'between' )
						{
							if ( $value[1][0] !== false )
								$where[] = $name ." >= ". str_replace(',','.',$value[1][0]);
							if ( $value[1][1] !== false )
								$where[] = $name ." <= ". str_replace(',','.',$value[1][1]);
						}
						else
						{
							if ( is_numeric($value[1]) )
								$where[] = $name ." ". $value[0] ." ". $value[1];
						}
					else
						if ( strtolower($value[0]) == 'in' )
						{
							$where[] = $name ." IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else if ( strtolower($value[0]) == 'not in' )
						{
							$where[] = $name ." NOT IN ('". implode("', '", array_map('addslashes',$value[1])) ."')";
						}
						else
						{
							$where[] = $name ." ". $value[0] ." '". addslashes($value[1]) ."'";
						}
				}
			}
			else if ( is_string($value) )
				$where[] = '('. $value .')';
		}
		if ( count($where) ){
			$sql.= ' WHERE '. implode(' AND ', $where);
			if(!empty($this->filter['ext_where']))
				$sql.= " AND ".$this->filter['ext_where'];
		}		
		
		// порядок
		if ( isset($this->filter['order']) )
		{
			$order = array();
			if ( is_array($this->filter['order']) )
			{
				foreach( $this->filter['order'] as $k => $field )
				{
					if ( strtolower($field) == 'rand' )
					{
						$order[] = 'RAND()';
					}
					else
					{
						if ( array_key_exists($field,$this->sheme->sheme['scalar_fields']) )
							$name = 'm.`'. $field .'`';
						if ( array_key_exists($field,$this->sheme->sheme['vector_fields']) )
							$name = 's_'. strtolower($field) .'.`'. $field .'`';
						
						$order[] =  $name ." ". strtoupper($this->filter['dir'][$k]);
					}
				}
			}
			else
			{
				if ( strtolower($this->filter['order']) == 'rand' )
				{
					$order[] = 'RAND()';
				}
				else
				{
					if ( array_key_exists($this->filter['order'],$this->sheme->sheme['scalar_fields']) )
						$name = 'm.`'. $this->filter['order'] .'`';
					if ( array_key_exists($this->filter['order'],$this->sheme->sheme['vector_fields']) )
						$name = 's_'. strtolower($this->filter['order']) .'.`'. $this->filter['order'] .'`';
					$order[] = $name ." ". strtoupper($this->filter['dir']);
				}
			}
			$sql.= " ORDER BY ". implode(', ',$order);
		}
		
		// лимит
		if ( $this->filter['offset'] > 0 || $this->filter['limit'] > 0 )
		{
			$sql.= " LIMIT ";
			if ( $this->filter['offset'] > 0 )
				$sql.= $this->filter['offset'].", ";
			if ( $this->filter['limit'] > 0 )
				$sql.= $this->filter['limit'];
		}
		
		if ( $this->filter['debug'] === true )
		{
			echo $sql. "\n";
			TRACE::Log($sql);
		}
		
//		error_log($sql);
		
		return $sql;
	}
	
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['RubricID'] = array('=', $sheme->RubricID);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}


class Adv_auto extends AdvBase
{
	public $_debug = null;
	
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		//error_log( intval(empty($this->data['Contacts'])));
		if ( empty($this->data['Contacts']) )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_CONTACTS);
			}
			$is_valid = false;
		}
		
		if ( empty($this->data['Phone']) || !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,3}$/',$this->data['Phone'].',') )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_PHONE);
			}
			$is_valid = false;
		}

		if ( empty($this->data['Price']) || !preg_match('/^\d+(\,\d+)?$/', $this->data['Price']))
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_PRICE);
			}
			$is_valid = false;
		}
		
		if ( strlen($this->data['CityCode']) != 22 )
		{
			if ( is_object($OBJECTS['uerror']) ){
				$OBJECTS['uerror']->AddError(ERR_L_AUTO_CITYCODE);
			}
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
	
	
	public function Store()
	{
		$this->data['RubricID'] = $this->sheme->RubricID;
		
		$tree = $this->sheme->GetTreeByRubricID();
		
		if (!empty($this->data['Name']))
			$this->data['opt_Title'] = $this->data['Name'];
		else
			$this->data['opt_Title'] = $tree[$this->data['Brand']]['name']." ".$tree[$this->data['Model']]['name'];
		
		unset($tree);
		
		parent::Store();
	}
	
	public function Remove()
	{
		if ( array_key_exists('Photo', $this->sheme->sheme['vector_fields'] ) )
		{
			$this->VectorLoad('Photo');
			
			if ( is_array($this->data['Photo']) )
			{
				LibFactory::GetStatic('filestore');
				foreach ( $this->data['Photo'] as $photo )
				{
					if( ($img_obj = FileStore::ObjectFromString($photo['Photo'])) !== false )
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['large']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e )
						{
							continue;
						}
					}
					else
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['large']['path'] . FileStore::GetPath_NEW($photo['Photo']));
						}
						catch ( MyException $e ) {}
					}
					
					if( ($img_obj = FileStore::ObjectFromString($photo['PhotoSmall'])) !== false )
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['small']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e )
						{
							continue;
						}
					}
					else
					{
						try
						{
							FileStore::Delete_NEW($this->sheme->_config['photo']['small']['path'] . FileStore::GetPath_NEW($photo['PhotoSmall']));
						}
						catch ( MyException $e ) {}
					}
				}
			}
		}
		
		return parent::Remove();
	}
	
}
?>