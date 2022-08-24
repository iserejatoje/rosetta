<?
//require_once ($CONFIG['engine_path'].'include/lib.app_comment_micro.php');
require_once ($CONFIG['engine_path'].'include/app_comment_micro/app_comment_micro_iterator.php');
LibFactory::GetStatic("app_comment_micro");
class app_comment_micro_weather extends AppCommentMicro
{
	private $_CityID = null;	
	private $_Precip = array();
	private $_iconurl = "/_img/modules/weather/ico/"; //По дефолту
	private $_city_obj = null;
	private $_Weather = null;
	
	public function __construct($params = array())
	{	
		parent::__construct($params);
		LibFactory::GetStatic('location');
		if (!is_array($params))
			$params = (array)$params;
		if (isset($params['cityid']))
			$this->_CityID = intval($params['cityid']);
		if (isset($params['Precip']) && is_array($params['Precip']))
			$this->_Precip = $params['Precip'];
		if (isset($params['iconurl']) && $params['iconurl']!="")
			$this->_iconurl = $params['iconurl'];
		
		$this->CheckOptions();	


		
	}	

	protected function CheckOptions()
	{
		if (!parent::CheckOptions())
			return false;
	
		if ($this->_CityID === null)
			return false;
			
		if ($this->_city_obj === null)
			$this->_city_obj = Location::GetObjectByID($this->_CityID);		
		if (sizeof($this->_city_obj) > 0)
			return true;
		return false;
	}
	
	public function CreateInstance($data)
	{
		$obj = new self(array(
						'sectionid' => $this->_SectionID,
						'cityid' => $this->_CityID,
						'Precip' => $this->_Precip,
						'iconurl' => $this->_iconurl
						));
		
		$data = array_change_key_case($data, CASE_LOWER);		
		$obj->_ID = $data['commentid'];				
		$obj->_Name = $data['name'];
		$obj->_Text = $data['text'];
		$obj->_Created = $data['created'];		
		$obj->_UserID = $data['userid'];
		$obj->_IsVisible = $data['isvisible'];
		$obj->_IsDel = $data['isdel'];
		$obj->_IsNew = $data['isnew'];
		$obj->_data = $this->_data;
		$obj->_CommentDate = Datetime_my::SimplyDate(Datetime_my::NowOffsetTime(null, strtotime($data['created'])));
		$obj->SetDbAndTables(self::$db, self::$tables);				
		
		return $obj;
	}
	
	private function _get_current_weather()
	{
		
		if ($this->_city_obj === null)
			return array();
		
		if (!isset($this->_city_obj['Code']))
			return array();
		
		$sql = "SELECT T, Precip, WindSpeed, Humidity, Sunrise, Sunset, Barometer FROM `".self::$tables['current']."` ";		
		$sql.= " WHERE `CityCode` = '".addslashes($this->_city_obj['Code'])."' ";
		
		if (($res = self::$db->query($sql)) === false)
			return array();
		if (($row = $res->fetch_assoc()) !== false)
			return $row;
		else
			return array();
	}
	
	public function Update()
	{
		global $OBJECTS;
		
		$curr_weather = $this->_get_current_weather();
		
		if ($this->_ID == 0)
		{
			//$now = time();	
			$now = Datetime_my::NowOffsetTime();
			$hour = idate('H',$now);
			
			if (sizeof($curr_weather) > 0 && isset($curr_weather["T"])) //Костыль для погоды (см. модуль погоды)
			{
				if ( $hour > 5 && $hour < 11 )
				{
					// берем подробную для утра: до 9:00 - для текущего часа, после 9:00 - для 9:00 (утренняя погода)
					$sql = 'SELECT `T` FROM '. self::$tables['adnvanced'] . ' WHERE ';
					$sql.= ' `CityCode` = \''. $this->_city_obj['Code'].'\'';
					$sql.= ' AND `Date` <= \''. date('Y-m-d',$now).' '.min($hour,9).':00:00' .'\'';
					$sql.= ' ORDER BY `Date` DESC LIMIT 1';			
					
					$res = self::$db->query($sql);
					if ( $res !== false && (list($t) = $res->fetch_row()) )
					{			
						$curr_weather['T'] = $t;
						
						if ( $hour < 8 )
							$curr_weather['T'] -= 1;
						else
							$curr_weather['T'] += 1;
					}
				}
			}			
		
			$sql = "INSERT INTO `".self::$tables['comments']."` ";
			$sql.= "SET `UserID` = '".$this->_UserID."', ";					
			$sql.= "`Created` = NOW(), ";
			$sql.= "`SectionID` = ".addslashes($this->_SectionID).", ";
			$sql.= "`CityID` = ".addslashes($this->_CityID).", ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";			
			if (sizeof($curr_weather) > 0)
				foreach($curr_weather as $k=>$v)			
					$sql.= "`".$k."`='".addslashes($v)."', ";
				
			
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
			
		}
		else
		{
			$sql = "UPDATE `".self::$tables['comments']."` ";
			$sql.= "SET ";
			$sql.= "`Name` = '".addslashes($this->_Name)."', ";
			$sql.= "`Text` = '".addslashes($this->_Text)."', ";
			$sql.= "`Created` = '".addslashes($this->_Created)."', ";
			$sql.= "`SectionID` = ".addslashes($this->_SectionID).", ";
			$sql.= "`CityID` = ".addslashes($this->_CityID).", ";
			$sql.= "`IsVisible` = '".addslashes($this->_IsVisible)."', ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
			$sql.= "`IsNew` = '".addslashes($this->_IsNew)."' ";
			$sql.= " WHERE `CommentID` = ".$this->_ID;
		}
		
		self::$db->query($sql);
		if ($this->_ID == 0) 
			$this->_ID = self::$db->insert_id;

		return true;
	}
	
	
	public function GetCommentsCount($filter)
	{
		$sql = 'SELECT COUNT(*) FROM '.self::$tables['comments'];
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();
			
			if ($this->_CityID !== null)
				$sqlt[] = " `CityID`='".$this->_CityID."'";
			
			if ($this->_SectionID !== null)
				$sqlt[] = " `SectionID`='".$this->_SectionID."'";
			
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
			
			if (isset($filter['fields']['isnew']))
			{
				if ($filter['fields']['isnew'] == 0 || $filter['fields']['isnew'] == 1)
					$sqlt[] = " `IsNew` = '".$filter['fields']['isnew']."' ";
			}
			if (isset($filter['fields']['isdel']))
			{
				if ($filter['fields']['isdel'] == 0 || $filter['fields']['isdel'] == 1)
					$sqlt[] = " `IsDel` = '".$filter['fields']['isdel']."' ";
			}
			else
				$sqlt[] = " `IsDel` = 0 ";
						
			$sql.= implode(' AND ', $sqlt);
						
		} 
		
		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY `".implode('`, c.`', $filter['group']).'`';
		}

		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return 0;
		
		$count = $res->fetch_row();
		return $count[0];
	}
		
	
	public function GetComments($filter, $asArray = false )
	{		
		global $CONFIG, $OBJECTS;		
		$sql = 'SELECT * FROM '.self::$tables['comments'];		
		
		if (sizeof($filter['fields']) > 0)
		{
			$sql.= " WHERE ";
			$sqlt = array();

			if ($this->_CityID !== null)
				$sqlt[] = " `CityID`='".$this->_CityID."'";
				
			if ($this->_SectionID !== null)
				$sqlt[] = " `SectionID`='".$this->_SectionID."'";
				
			if (isset($filter['fields']['isvisible']) && is_numeric($filter['fields']['isvisible']))
				$sqlt[] = " `IsVisible` = '".$filter['fields']['isvisible']."' ";
							
			if (isset($filter['fields']['isnew']))
			{
				if ($filter['fields']['isnew'] == 0 || $filter['fields']['isnew'] == 1)
					$sqlt[] = " `IsNew` = '".$filter['fields']['isnew']."' ";
			}
			if (isset($filter['fields']['isdel']))
			{
				if ($filter['fields']['isdel'] == 0 || $filter['fields']['isdel'] == 1)
					$sqlt[] = " `IsDel` = '".$filter['fields']['isdel']."' ";
			}
			else
				$sqlt[] = " `IsDel` = 0 ";
			
			if (isset($filter['fields']['moderate']))
			{
				if ($filter['fields']['moderate'] == 0 || $filter['fields']['moderate'] == 1)
					$sqlt[] = " `moderate` = '".$filter['fields']['moderate']."' ";
			}
							
			$sql.= implode(' AND ', $sqlt);
						
		} 
		
		if (sizeof($filter['group']) > 0) {
			$sql.= " GROUP BY `".implode('`, `', $filter['group']).'`';
		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= " ORDER BY ";
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if (strtolower($f['field']) == 'created')
					$f['field'] = 'Created';
			
				if ( !in_array(strtolower($f['dir']), array('asc','desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = " ".$f['field']." ".$f['dir']." ";
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		if (is_array($filter['limit']) && sizeof($filter['limit']) > 0)
		{
			$sql.= " LIMIT ";
			$sqlt = array();
			if (isset($filter['limit']['offset']) && is_numeric($filter['limit']['offset']) && $filter['limit']['offset'] >= 0)
				$sql.= $filter['limit']['offset'].", ";
			else
				$sql.= "0, ";
			
			if (isset($filter['limit']['limit']) && is_numeric($filter['limit']['limit']))
				$sql.= $filter['limit']['limit'];
			else
				$sql.= 5;
		}

		$list = array();		
		//error_log($sql);
		$res = self::$db->query($sql);
		if ( !$res || !$res->num_rows )
			return null;
		
		if ($is_res === true)
			return $res;
			
		
		
		LibFactory::GetStatic('datetime_my');
		
		while ($row = $res->fetch_assoc())
		{
			//$row['Created'] = DateTime_My::NowOffset(null, strtotime($row['Created']));
			//Trace::Log(date("Y-m-d H:i:s", strtotime($row['Created']))."  ".date("Y-m-d H:i:s", strtotime($row['Created'])));
			$this->_data = $row;
			$row = $this->Get_Weather_Params();
			$list[] = $row['CommentID'];
		}
		//var_dump($list);
		//return $list;
		return new PCommentMicroIterator($list, __CLASS__);	
	}
	
	public function GetComment($id, $array = false)
	{
		$comment = parent::GetComment($id, $array);		
		//Trace::VarDump($comment);
		return self::CreateInstance($comment);
		//return $this->Get_Weather_Params();
	}
	
	private function Get_Weather_Params()
	{	
		global $OBJECTS;
		$Sunrise = explode(':', $this->_data['Sunrise']);
		$Sunset = explode(':', $this->_data['Sunset']);

		$Sunrise = $Sunrise[0]*60+$Sunrise[1];
		$Sunset = $Sunset[0]*60+$Sunset[1];
		
		$offsetTS = strtotime($this->_data['Created']);
		$HourType = 'day';
		if ( $Sunset < date('H', $offsetTS)*60+ date('i', $offsetTS) || 
			$Sunrise > date('H', $offsetTS)*60+ date('i', $offsetTS))
			$HourType = 'night';
			
	
		$this->_data['weather_content'] = true;
		$this->_data['img'] = $this->_iconurl."small/".$HourType."/".$this->_data['Precip'].".png";
		
		$this->_data['PrecipText'] = $this->_Precip[$this->_data['Precip']];
		$this->_data['PrecipImg'] = $this->_data['Precip'];		
		//$this->_data['User'] = $OBJECTS['usersMgr']->GetUser($this->_data['UserID']);
		return $this->_data;
	}
	
	public function __get($name)
	{		
		$name = strtolower($name);
		if ($name == 'weather')
		{
			return $this->Get_Weather_Params();
		}	
		if ($name == 'city')
			return $this->_city_obj['TransName'];
		return parent::__get($name);
	}
}
?>