<?

require_once $CONFIG['engine_path'].'include/advertise/advmgr.php';

define('ERR_L_REALTY_MASK', 0x005F0000);

define('ERR_L_REALTY_PHONE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_PHONE] = 'Телефон не указан или не сответствует установленному формату!';
define('ERR_L_REALTY_CONTACTS', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_CONTACTS] = 'Укажите контактные данные!';
define('ERR_L_REALTY_PRICE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_PRICE] = 'Укажите цену, цена должна быть числом!';
define('ERR_L_REALTY_ADDRESS', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_ADDRESS] = 'Укажите адрес!';
define('ERR_L_REALTY_AREA', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_AREA] = 'Укажите район города!';
define('ERR_L_REALTY_BUILDINGTYPE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_BUILDINGTYPE] = 'Укажите тип дома!';
define('ERR_L_REALTY_SERIES', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_SERIES] = 'Укажите серию!';
define('ERR_L_REALTY_ROOMCOUNT', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_ROOMCOUNT] = 'Укажите количество комнат!';
define('ERR_L_REALTY_FLOORS', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_FLOORS] = 'Укажите этажность дома!';
define('ERR_L_REALTY_FLOOR', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_FLOOR] = 'Укажите этаж!';
define('ERR_L_REALTY_BUILDINGAREA', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_BUILDINGAREA] = 'Укажите площадь помещения!';
define('ERR_L_REALTY_LANDAREA', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_LANDAREA] = 'Укажите площадь участка!';
define('ERR_L_REALTY_COMMERCETYPE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_COMMERCETYPE] = 'Укажите тип помещения!';
define('ERR_L_REALTY_HOUSETYPE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_HOUSETYPE] = 'Укажите тип!';
define('ERR_L_REALTY_GARDENTYPE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_GARDENTYPE] = 'Укажите тип СНТ!';
define('ERR_L_REALTY_FIRMTYPE', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_FIRMTYPE] = 'Укажите тип организации!';
define('ERR_L_REALTY_CHANGEOBJECTS', ERR_L_REALTY_MASK | $error_code++);
	UserError::$Errors[ERR_L_REALTY_CHANGEOBJECTS] = 'Укажите хотя бы один объект на обмен и хотя бы один требующийся объект!';

class AdvSheme_realty extends AdvShemeBase
{
	public $Rubric = 0;
	
	protected $_cache = null;
	protected $_stats = array();
	protected $_last = array();
	
	public function __construct($path, $prefix = '')
	{
		// база данных
		$this->sheme['db'] = 'adv_realty';		
		// скалярные поля
		$this->sheme['scalar_fields']['AdvID'] 			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['UserID'] 		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Rubric']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['DateCreate']		= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['DateUpdate']		= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['DateValid']		= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['Visible']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Important']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['ImportantTill']	= array( 'type' => 'date' );
		$this->sheme['scalar_fields']['Contacts']		= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Phone']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Email']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['Owner']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Views']			= array( 'type' => 'int' );		
		$this->sheme['scalar_fields']['ReceiveIM']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Cookie']			= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['IP']				= array( 'type' => 'char' );
		$this->sheme['scalar_fields']['IsValid']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['IsNew']			= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Moderate']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Remoderate']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['opt_InState']	= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['old_AdvID']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['GrabSource']		= array( 'type' => 'int' );
		$this->sheme['scalar_fields']['Rotated']		= array( 'type' => 'int' );
		
		// векторные поля
		$this->sheme['vector_fields']['Favorite']		= array( 'type' => 'array', 'fields' => array('Favorite','Remark') );
		
		// ключевое поле
		$this->sheme['key'] = 'AdvID';
		
		parent::__construct($path, $prefix);
		
		// кэш
		LibFactory::GetStatic('cache');
		$this->_cache = new Cache();
        $this->_cache->Init('memcache', 'realty');
	}
	
	/**
		Уничтожение объекта
	*/
	public function Destroy()
	{
		if ( is_object($this->_cache) )
			$this->_cache->Destroy();
		parent::Destroy();
	}
	
	public function GetStatistic($UserID = 0, $inState = 1, $visible = 1, $ForWeek = 0)
	{
		$inState = intval($inState);

		if ( !isset( $this->_stats[$UserID][$this->Rubric][$inState][$ForWeek] ) )
		{
			$cacheid = 'stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|'. $inState;
			if(!empty($ForWeek))
				$cacheid.="|forweek";
			
			$this->_stats[$UserID][$this->Rubric][$inState][$ForWeek] = $this->_cache->Get($cacheid);
			
			if ( $this->_stats[$UserID][$this->Rubric][$inState][$ForWeek] === false || $_GET['nocache'] > 12 )
			{
				$sql = "SELECT count(*) FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
				if ( $inState == 1 )
					$sql.= " WHERE `opt_InState` = 0 AND ";
				else
					$sql.= " WHERE ";
				$sql.= "`Rubric` = ". $this->Rubric;
				if ( $visible == 1 )
					$sql.= " AND `Visible` = 1";
				if ( $UserID > 0 )
					$sql.= " AND `UserID` = ". $UserID;
				if(!empty($ForWeek))
					$sql.= " AND  `DateCreate` > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
				$res = $this->db->query($sql);
				
				if ( $res === false )
					return false;
				
				list($this->_stats[$UserID][$this->Rubric][$inState][$ForWeek]) = $res->fetch_row();
				
				$this->_cache->Set($cacheid, $this->_stats[$UserID][$this->Rubric][$inState][$ForWeek], 300);
			}
		}
		return $this->_stats[$UserID][$this->Rubric][$inState][$ForWeek];
	}

	public function GetLast($UserID = 0, $inState = 1, $visible = 1, $optPhoto = 0)
	{
		$inState = intval($inState);
		$cacheid = 'last|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->RubricID .'|'. $inState .'|'. $optPhoto;
		
		$this->_last[$UserID][$this->RubricID][$inState][$optPhoto] = $this->_cache->Get($cacheid);
		
		if ( $this->_last[$UserID][$this->RubricID][$inState][$optPhoto] == false || $_GET['nocache'] > 12 )
		{
			$sql = "SELECT `AdvID`, `DateCreate` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];
			$sql.= " WHERE `Rubric` = '".$this->Rubric."'";
			if ( $inState == 1 )
				$sql.= " AND `opt_InState` = 0";
			if ( $visible == 1 )
					$sql.= " AND `Visible` = 1";
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
		
		if ( !isset( $this->_stats[$UserID][$this->Rubric][3] ) )
		{
			$cacheid = 'stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|3';
			
			$this->_stats[$UserID][$this->Rubric][3] = $this->_cache->Get($cacheid);
			
			if ( $this->_stats[$UserID][$this->Rubric][3] === false )
			{
				$sql = "SELECT count(*) FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['slaves']['Favorite'] ." f";
				$sql.= " INNER JOIN ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ." m ON m.`AdvID` = f.`AdvID`";
				$sql.= " WHERE m.`opt_InState` = 0 AND m.`Rubric` = ". $this->Rubric ." AND f.`Favorite` = ". $UserID;
				$res = $this->db->query($sql);		
				
				if ( $res === false )
					return false;
				list($this->_stats[$UserID][$this->Rubric][3]) = $res->fetch_row();
				
				$this->_cache->Set($cacheid, $this->_stats[$UserID][$this->Rubric][3], 300);
			}
		}
		
		return $this->_stats[$UserID][$this->Rubric][3];
	}
	
	public function ClearCache($UserID = 0)
	{
		$this->_cache->set('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|0', array(false), 100 );
		$this->_cache->set('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|1', array(false), 100 );
		$this->_cache->set('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|3', array(false), 100 );
		return
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|0') && // все
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|1') && // актуальные
			$this->_cache->Remove('stats|'. $this->sheme['tables']['prefix'] .'|'. intval($UserID) .'|'. $this->Rubric .'|3'); // избранные
	}

	public function UpdateTariffs()
	{
		LibFactory::GetStatic('datetime_my');
		$now = DateTime_my::NowOffset();

		$sql = "UPDATE `".$this->sheme['tables']['prefix']."_firms` SET `Tariff` = 0";
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

		/* Выборка ИД-шников, которые стали не импортант */
		$sql = "SELECT `AdvID` FROM `".$this->sheme['tables']['prefix'] . $this->sheme['tables']['master']."`";

		$where = " WHERE `Rubric` = '".$this->Rubric."'";
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


		/* Выборка ИД-шников, которые будут проапдейтины */
		$sql = "SELECT `AdvID` FROM ". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'];

		$where = " WHERE `Rubric` = '".$this->Rubric."'";
		$where.= " AND `opt_InState` > 0";
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

		$where = " WHERE `Rubric` = '".$this->Rubric."'";
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

		$where = " WHERE `Rubric` = '".$this->Rubric."'";
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
	
	
	public function GetProlongCount($AdvIds = null)
	{
		global $OBJECTS;
		
		$sql = "SELECT count(*) FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		$sql.= " WHERE `Visible` = 1";
		if ( is_array($AdvIds) && count($AdvIds) > 0 )
			$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `Rubric` = ". $this->Rubric;
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `IsValid` = 1";
		$sql.= " AND `DateValid` < NOW()";
		if ( array_key_exists('IsAddressValid', $this->sheme['scalar_fields']) )
			$sql.= " AND `IsAddressValid` = 1";
		
		$res = $this->db->query($sql);
		if ( $res === false )
			return 0;
		
		list($count) = $res->fetch_row();

		AdvCache::getInstance()->Remove($this, $AdvIds);

		return $count;
	}
	
	
	public function GetShowActiveCount($AdvIds = null)
	{
		global $OBJECTS;
		
		$sql = "SELECT count(*) FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
		$sql.= " WHERE `Visible` = 0";
		if ( is_array($AdvIds) && count($AdvIds) > 0 )
			$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `Rubric` = ". $this->Rubric;
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `DateCreate` < NOW()";
		$sql.= " AND `DateValid` > NOW()";
		
		$res = $this->db->query($sql);
		if ( $res === false )
			return 0;
		
		list($count) = $res->fetch_row();
		
		return $count;
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
		$sql.= " `DateValid` = `DateValid` + INTERVAL ". $add .", ";
		$sql.= " `opt_InState` = 0";
		$sql.= " WHERE `AdvID` IN (". implode(',', $AdvIds) .") AND `IsValid` = 1";
		if ( array_key_exists('IsAddressValid', $this->sheme['scalar_fields']) )
			$sql.= " AND `IsAddressValid` = 1";
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;
		
		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);

		return intval($this->db->affected_rows);
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
		$sql.= " `DateValid` = NOW() + INTERVAL ". $add .", ";
		$sql.= " `opt_InState` = 0";
		$sql.= " WHERE `UserID` = ". $OBJECTS['user']->ID;
		$sql.= " AND `AdvID` IN (". implode(',', $AdvIds) .") AND `IsValid` = 1";
		if ( array_key_exists('IsAddressValid', $this->sheme['scalar_fields']) )
			$sql.= " AND `IsAddressValid` = 1";
		$sql.= " AND `Visible` = 1";
		if ( $limit !== null )
			$sql.= " LIMIT ". intval($limit);

		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);

		$prolonged = intval($this->db->affected_rows);

		return array($prolonged,$updated);
	}
	
	public function UserActionProlongAndUpdateAll( $Period = 1, $limit = null, $only_old = false )
	{
		global $OBJECTS;
		
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
		$where = " WHERE `Rubric` = ". $this->Rubric;
		$where.= " AND `UserID` = ". $OBJECTS['user']->ID;
		$where.= " AND `DateUpdate` < '". Datetime_my::DateOffset() ."'";
		$where.= " AND `Visible` = 1";
		$sql_limit = '';
		if ( $limit !== null )
			$sql_limit = " LIMIT ". intval($limit);
		
		$sql_select = "SELECT `AdvID` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
        $res = $this->db->query($sql_select.$where.$sql_limit);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];
		
		$this->db->query($sql_update.$where.$sql_limit);
		$updated = intval($this->db->affected_rows);

		AdvCache::getInstance()->Remove($this, $AdvIDs);
		unset($AdvIDs);
		
		// Продление
		$sql_update = "UPDATE `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."` SET";
		$sql_update.= " `DateValid` = NOW() + INTERVAL ". $add .", ";
		$sql_update.= " `opt_InState` = 0";
		$where = " WHERE `Rubric` = ". $this->Rubric;
		$where.= " AND `UserID` = ". $OBJECTS['user']->ID;
		$where.= " AND `IsValid` = 1 ";
		if ( $only_old === true )
			$where.= " AND `DateValid` < NOW()";
		if ( array_key_exists('IsAddressValid', $this->sheme['scalar_fields']) )
			$where.= " AND `IsAddressValid` = 1";
		$where.= " AND `Visible` = 1";
		$sql_limit = '';
		if ( $limit !== null )
			$sql_limit = " LIMIT ". intval($limit);
		
		$sql_select = "SELECT `AdvID` FROM `". $this->sheme['tables']['prefix'] . $this->sheme['tables']['master'] ."`";
        $res = $this->db->query($sql_select.$where.$sql_limit);
        $AdvIDs = array();
		while ( $adv = $res->fetch_assoc() )
			$AdvIDs[] = $adv['AdvID'];

		$this->db->query($sql_update.$where.$sql_limit);
		$prolonged = intval($this->db->affected_rows);
		
		AdvCache::getInstance()->Remove($this, $AdvIDs); unset($AdvIDs);
		unset($AdvIDs);
		
		
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
		$sql.= " `Visible` = ". $visible;
		$sql.= " WHERE `AdvID` IN (". implode(',', $AdvIds) .")";
		$sql.= " AND `UserID` = ". $OBJECTS['user']->ID;

		$this->db->query($sql);

		AdvCache::getInstance()->Remove($this, $AdvIds);
		
		return intval($this->db->affected_rows);
	}
	
	
	public function GetFirmByUser($UserID)
	{
		$sql = "SELECT * FROM `". $this->sheme['tables']['prefix'] . "_firms` f";
		$sql.= " INNER JOIN `". $this->sheme['tables']['prefix'] . "_firms_ref` r";
		$sql.= " WHERE f.`FirmID` = r.`FirmID` AND r.`UserID` = ". $UserID;
		
		$this->db->query($sql);
	}
}

class AdvIterator_realty extends AdvIteratorBase
{
	// эталонный фильтр. задает доступные поля в where и их порядок
	protected $filter_index = array(
		'AdvID', 'opt_InState', 'Visible', 'IsNew', 'Rubric', 'DateCreate', 'Important', 'DateUpdate', 'UserID',
		'Address', 'House', 'opt_Address', 'Area', 'LandmarkID', 'CommerceType', 'BuildingArea', 'RoomCount', 'Price', 'Price2',
		'LandArea', 'BuildingType', 'Series', 'DeadlineQuarter', 'DeadlineYear', 'Lifetime', 'Floor', 'Floors', 'Decoration', 'Details',
		'Windows', 'BuildingStage', 'Lavatory', 'Options', 'Ownership', 'Phone', 'Owner', 'opt_Photo', 'Favorite', 'ImportID', 'old_AdvID',
		'IsAddressValid', 'MapX', 'MapY', 'ObjectType', 'Object', 'OfferExPay', 'Moderate', 'GrabSource', 'Rotated'
	);
	
	public function __construct($sheme, $filter = array(), $load_vectors = false)
	{
		$filter['Rubric'] = array('=', $sheme->Rubric);
		parent::__construct($sheme, $filter, $load_vectors);
	}
}

class Adv_realty extends AdvBase
{
	public function IsValid()
	{
		global $OBJECTS;
		
		$is_valid = true;
		
		if ( empty($this->data['Phone']) || !preg_match('/^((\d\d\d-\d\d-\d\d|\(\d\d\d\) \d\d\d-\d\d-\d\d|\(\d\d\d\d\) \d\d-\d\d-\d\d|\(\d\d\d\d\d\) \d-\d\d-\d\d|8-\d\d\d-\d\d\d-\d\d\d\d|\+7-\d\d\d-\d\d\d-\d\d\d\d)\,\s*){1,2}$/',$this->data['Phone'].',') )
		{
			if ( is_object($OBJECTS['uerror']) )
				$OBJECTS['uerror']->AddError(ERR_L_REALTY_PHONE);
			$is_valid = false;
		}
		
		return ( parent::IsValid() && $is_valid );
	}
	
	
	public function Store()
	{
		$this->data['Rubric'] = $this->sheme->Rubric;
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
					if ( !empty($photo['Photo']) )
					{
						try
						{
							$img_obj = FileStore::ObjectFromString($photo['Photo']);
							FileStore::Delete_NEW($this->sheme->_config['photo']['large']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e ){}
					}
					if ( !empty($photo['PhotoSmall']) )
					{
						try
						{
							$img_obj = FileStore::ObjectFromString($photo['PhotoSmall']);
							FileStore::Delete_NEW($this->sheme->_config['photo']['small']['path'] . FileStore::GetPath_NEW($img_obj['file']));
							unset($img_obj);
						}
						catch ( MyException $e ){}
					}
				}
			}
		}
		
		return parent::Remove();
	}
}


?>