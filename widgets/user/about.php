<?

/**
	"Фотография"
**/

class Widget_user_about extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = '';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		parent::Init($path, $state, $params);
		
		//if($OBJECTS['user']->ID != 2)
		//	return false;

		if ( !isset($params['id']) )
			if ( $OBJECTS['user']->IsAuth() )
				$this->params['id'] = $OBJECTS['user']->ID;
			else
				return false;		
	}
	
	protected function OnDefault()
	{
		global $OBJECTS;
		
		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);		
		if (
		     $user === null || 
		     ($user->Blocked == 1 && $OBJECTS['user']->ID != $user->ID)
		   )
			return '';

		LibFactory::GetStatic('location');

		return $this->Render(
			$this->config['templates']['default'], array(), array($this, '_OnDefault'), 
			false
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		if ( $this->params['id'] == $OBJECTS['user']->ID )		
			$user = $OBJECTS['user'];
		else
			$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);
			
		$form = array();
			
		LibFactory::GetStatic('domain');
		$form['user_domain'] = Domain::GetInfo(3, $user->ID);
		
		if ( $this->params['id'] == $OBJECTS['user']->ID )
			$form['can_choice_domain'] = true;
		else
			$form['can_choice_domain'] = false;
		if( $form['user_domain'] === false )
		{
			$address = Domain::GenerateName($OBJECTS['user']->Profile['general']['FirstName'], 3, $OBJECTS['user']->ID, $this->_env['site']['regdomain'], $this->_env['regid'], $OBJECTS['user']->Profile['general']['FistName'], $OBJECTS['user']->Profile['general']['LastName']);
			$form['user_name_variant'] = $address[0];
		}
			
		// загрузка конфига паспорта второй версии, без разницы какой, лишь бы второй версии
		$config = ModuleFactory::GetConfigById('section', 3629); // ufa1.ru
		
		if (isset($this->config['horoscope_sectionid'][App::$CurrentEnv['regid']]))
		{			
			$form['horoscope_url'] = STreeMgr::GetLinkBySectionId($this->config['horoscope_sectionid'][App::$CurrentEnv['regid']]);
		}
		else
			$form['horoscope_url'] = App::$Protocol . App::$CurrentEnv['site']['regdomain'].'/horoscope/';
			
		$birthday = $user->Profile['general']['BirthDay'];
		$year	= 0;
		$month	= 0;
		$day	= 0;
		if(preg_match('@^([\d]{4})-([\d]{2})-([\d]{2})$@', $birthday, $matches))
		{
			$year	= intval($matches[1]);
			$month	= intval($matches[2]);
			$day	= intval($matches[3]);
		}

		$form['birthday_year']		= $year;
		$form['birthday_month']		= $month;
		$form['birthday_day']		= $day;

		if ( checkdate  ( $month  , $day  , $year  ) ) 
		{
			$h = LibFactory::GetInstance('horoscope');
			$h->Init();
			$form['zodiac']				= $h->GetZodiacByDate(strtotime($user->Profile['general']['BirthDay']));
		} 
		else
			$form['zodiac'] = false;

		$form['nickname']			= $user->NickName;
		$form['showname']			= $user->Profile['general']['ShowName'];
		$form['firstname']			= $user->Profile['general']['FirstName'];
		$form['lastname']			= $user->Profile['general']['LastName'];
		$form['midname']			= $user->Profile['general']['MidName'];
		$form['gender']				= $user->Profile['general']['Gender'];

		$form['area']				= $user->Profile['general']['Area'];
		$form['street']				= $user->Profile['general']['Street'];
		list($form['house'], $form['house_index']) =
			explode('-', $user->Profile['general']['House']);
		
		$form['about']				= $user->Profile['general']['About'];
		$form['showhow']			= $user->Profile['general']['ShowHow'];
		
		$form['icq']			= $user->Profile['general']['ICQ'];
		$form['skype']			= $user->Profile['general']['Skype'];
		$form['phone']			= $user->Profile['general']['Phone'];
		$form['showvisited']	= $user->Profile['general']['showvisited'];
		
		$form['citytext'] = '';
		if ( $user->Profile['location']['current'] ) {

			$loc_pc = Location::ParseCode($user->Profile['location']['current']);
			if (Location::ObjectLevel($loc_pc) >= Location::OL_CITIES) {
				$code = Location::GetPartcodeByLevel($user->Profile['location']['current'], Location::OL_VILLAGES);
				$code.= '0000';

				$objects = Location::GetObjects(Location::ParseCode($code));
				if ( is_array($objects) && sizeof($objects) )
					$form['citytext'] = $objects[0]['Name'];
			}
		}
		
		if ( $user->ID != $OBJECTS['user']->ID ) 
		{
			if ( ( $user->Profile['general']['ContactRights'] & 2 && !$OBJECTS['user']->Plugins->Friends->IsFriend($user_id) ) || 
				!($user->Profile['general']['ContactRights'] & 1)
			)
				$form['icq'] = null;
			
			if ( ( $user->Profile['general']['ContactRights'] & 8 && !$OBJECTS['user']->Plugins->Friends->IsFriend($user_id) ) || 
				!($user->Profile['general']['ContactRights'] & 4)
			)
				$form['skype'] = null;
			
			if ( ( $user->Profile['general']['ContactRights'] & 128 && !$OBJECTS['user']->Plugins->Friends->IsFriend($user_id) ) || 
				!($user->Profile['general']['ContactRights'] & 64)
			)
				$form['phone'] = null;	
		}

		$form['allowchangeview'] = !$user->IsInRole('m_generation_member_'.$this->_env['regid'] );

		if (!isset($params[0]))
		{
			LibFactory::GetStatic('arrays');
			$form['years_arr']		= range(date('Y') , 1940);
			$form['months_arr']		= Arrays::$Month['subjective'];
			$form['days_arr']		= range(1, 31);
		}

		$form['marriad_arr'] = $config['marriad'];
		//$form['children_arr'] = $this->_config['children'];
		//$form['height_arr'] = $this->_config['height'];
		//$form['weight_arr'] = $this->_config['weight'];

		if( $user->Profile['general']['Avatar'] != '' )
		{	
			$form['avatar'] = array(
					'file' => $user->Profile['general']['AvatarUrl'],
					'w' => $user->Profile['general']['AvatarWidth'],
					'h' => $user->Profile['general']['AvatarHeight'],
					);
		}

		if( $user->Profile['general']['Photo'] != '' )
		{	
			$form['photo'] = array(
					'file' => $user->Profile['general']['PhotoUrl'],
					'w' => $user->Profile['general']['PhotoWidth'],
					'h' => $user->Profile['general']['PhotoHeight'],
					);
		}

		// Получаем список "плохих" полей
		if ( $user->ID == $OBJECTS['user']->ID )
		{
			$form['bad_fields'] = array();
			if ( $user->Blocked == 1 )
				$form['bad_fields'] = PUsersMgr::GetBadFieldsForUser($user->ID);
		}
			
		$form['userid'] = $user->ID;
			
		return array (
			'UserID' => $user->ID,
			'form' => $form
		);
	}
}
?>