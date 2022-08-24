<?
class PProfile_general extends PProfilePlain
{
	private $custom_cache = array();
	private $cfg = array();
		
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->fields = array('firstname','lastname','midname','birthday','gender',
  								'postcode','area','district','city','street','apartment','phone','house','persons','floor', 'card');
		$this->custom_fields = array('visited', 'showname','age');
	}

	public function Load()
	{
		global $OBJECTS;

		
		if(PUsersMgr::$cacher !== null)
			$this->profile = PUsersMgr::$cacher->Get('up_general_'.$this->user->ID);
		else
			$this->profile = false;

		if($this->profile === false)
		{
			$sql = "SELECT * FROM ".PUsersMgr::$tables['profile_general'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			if (false != ($res = PUsersMgr::$db->query($sql)) && $res->num_rows) {
				$this->profile = $res->fetch_assoc();
				$this->profile = array_change_key_case($this->profile, CASE_LOWER);
			} else {
				// пустой профиль
				$this->profile['showhow']			= 1;
			}

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_general_'.$this->user->ID, $this->profile, 3600);
		}
		
	}

	public function Save()
	{
		if(!is_a($this->user, 'PUser') || $this->user->ID <= 0)
			return;

		if(PUsersMgr::$cacher !== null)
			PUsersMgr::$cacher->Remove('up_general_'.$this->user->ID);

		//2do: четко проверь типы параметров
		if(!preg_match('@[\d]{4}-[\d]{2}-[\d]{2}@', $this->profile['birthday']))
			$this->profile['birthday'] = '0000-00-00';

		$sql = "REPLACE INTO ".PUsersMgr::$tables['profile_general']." SET ";
		$sql.= " UserID = ".$this->user->ID;

		foreach($this->fields as $field) {
			$sql.= " , `".$field."` = '".addslashes($this->profile[$field])."'";
		}

		PUsersMgr::$db->query($sql);
	}


	public function CustomGet($offset)
	{
		if(isset($this->custom_cache[$offset]))
			return $this->custom_cache[$offset];

		if($offset == 'infourl')
		{
			if($this->user != null && $this->user->ID > 0)
				return '/passport/info.php?id='.$this->user->ID;
			else
				return '';
		}		
		elseif ($offset == 'showvisited')
		{
			LibFactory::GetStatic('datetime_my');
			return Datetime_my::NowOffset(NULL, strtotime($this->user->Visited));
		}
		elseif ($offset == 'showname')
		{
			$showname = trim(str_replace(
				array('@fn','@ln','@mn'),
				array($this->profile['firstname'],$this->profile['lastname'],$this->profile['midname']),
				'@fn @mn @ln'
			));

			if ( $showname != '')
				return $showname;
			
			return $this->user->NickName;

		}
		elseif ( $offset == 'emailnotify' )
		{
			return $this->user->Email;
		}

		return '';
	}

	public function CustomSet($offset, $value)
	{
	}
}
?>
