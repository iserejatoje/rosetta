<?

/**
	"Мой Автомобиль"
**/

class Widget_user_place extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Места';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		parent::Init($path, $state, $params);
		
		if ( !isset($params['id']) )
			return false;		
	}
	
	protected function OnDefault()
	{	
		global $OBJECTS;

		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);		
		if ( $user === null )
			return '';
				
		return $this->Render(
			$this->config['templates']['default'], 
			array(), array($this, '_OnDefault'), false
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
			
		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);		
		
		$back_url = App::$Request->Server['REQUEST_URI']->Url();
		$place_list = array();
		$place_list_top = array();
		$city_arr = array();

		if (strlen($this->params['citycode']) < 22)
			$this->params['citycode'] .= str_repeat('0', 22-strlen($this->params['citycode']));

		LibFactory::GetStatic('location');
		LibFactory::GetMStatic('place', 'placesimplemgr');
		$loc_pc = Location::ParseCode($this->params['citycode']);	

		// ===================================================
		// [B] Карьера
		//

		$places = $user->Profile['places'][PlaceSimpleMgr::PT_GENERAL]->Value();

		$place_list[PlaceSimpleMgr::PT_GENERAL] = array();
		foreach( $places as $place ) {

			//if ( !$place['IsVisible'] )
			//	continue ;
		
			$placeObj = $place->getObject();
			if ( $placeObj === null )
				continue ;

			$place = $place->Value();
			
			$CityText = '';
			if ( $placeObj->CityCode ) {
				if ( !isset($city_arr[$placeObj->CityCode]) ) {
					$objects = Location::GetObjects(Location::ParseCode($placeObj->CityCode));

					if ( !empty($objects) )
						$city_arr[$placeObj->CityCode] = $objects[0]['Name'];
			
				}
				$CityText = $city_arr[$placeObj->CityCode];
			} else{

				if ( empty($placeObj->CityText) && $placeObj->City ) {
					if ( !isset($city_arr[$placeObj->City]) )
						$city_arr[$placeObj->City] = $placeObj->CityAsText;
						
					$CityText = $city_arr[$placeObj->City];
				} else 
					$CityText = $placeObj->CityText;
			}

			$place_list[PlaceSimpleMgr::PT_GENERAL][] = array(
				'PlaceID'	=> $placeObj->ID,
				'Name'		=> $placeObj->Name,
				'CityText'	=> $CityText,
				'CityCode'	=> $placeObj->CityCode,

				// usr data
				'Position'	=> $place['Position'],
				'YearStart'	=> intval(substr($place['DateStart'], 0, 4)),
				'YearEnd'	=> intval(substr($place['DateEnd'], 0, 4)),
				'MonthStart'=> intval(substr($place['DateStart'], 4)),
				'MonthEnd'	=> intval(substr($place['DateEnd'], 4)),
				'UsersCount'=> PlaceSimpleMgr::getInstance()->GetUsersCount($place['PlaceID'], PlaceSimpleMgr::PT_GENERAL),
			);
		}
		// [E] Карьера
		// ===================================================
		

		// ===================================================
		// [B] Образование
		//

		$places = PlaceSimpleMgr::getInstance()->GetPlaces(
			array(
				'flags' => array(
					'UserID'	=> $user->ID,
					'TypeID'	=> array(
						PlaceSimpleMgr::PT_SECONDARY_EDUCATION,
						PlaceSimpleMgr::PT_HIGHER_EDUCATION
					),
					'IsVisible' => 1,
					'IsVerified' => -1,
				),
			)
		);
			
		$place_list[PlaceSimpleMgr::PT_SECONDARY_EDUCATION] = array();
		foreach( array(PlaceSimpleMgr::PT_SECONDARY_EDUCATION,PlaceSimpleMgr::PT_HIGHER_EDUCATION) as $type ) {
			$places = $user->Profile['places'][$type]->Value();
			if ( $places === null ) 
				continue ;

			foreach( $places as $place ) {
				//if ( !$place['IsVisible'] )
				//	continue ;
			
				$placeObj = $place->getObject();
				if ( $placeObj === null )
					continue ;

				$place = $place->Value();
				$CityText = '';
				if ( $placeObj->CityCode ) {
					if ( !isset($city_arr[$placeObj->CityCode]) ) {
						$objects = Location::GetObjects(Location::ParseCode($placeObj->CityCode));
						if ( !empty($objects) )
							$city_arr[$placeObj->CityCode] = $objects[0]['Name'];
				
					}
					$CityText = $city_arr[$placeObj->CityCode];
				} else{

					if ( empty($placeObj->CityText) && $placeObj->City ) {
						if ( !isset($city_arr[$placeObj->City]) )
							$city_arr[$placeObj->City] = $placeObj->CityAsText;
							
						$CityText = $city_arr[$placeObj->City];
					} else 
						$CityText = $placeObj->CityText;
				}
				
				if ( $type == PlaceSimpleMgr::PT_SECONDARY_EDUCATION ) {
					
					$place['Faculty'] = null;
					$place['Chair'] = $placeObj->GetSpecializeByID($place['Chair']);
				} else {
					$place['Faculty'] = $placeObj->GetFacultyByID($place['Faculty']);
					$place['Chair'] = $placeObj->GetChairByID($place['Chair'], $place['Faculty']['FacultyID']);
				}
				
				$place_list[PlaceSimpleMgr::PT_SECONDARY_EDUCATION][] = array(
					'PlaceID'	=> $placeObj->ID,
					'Name'		=> $placeObj->Name,
					'TypeID'	=> $placeObj->Type,
					'CityText'	=> $CityText,
					'CityCode'	=> $placeObj->CityCode,

					// usr data
					'YearStart'	=> intval(substr($place['DateStart'], 0, 4)),
					'YearEnd'	=> intval(substr($place['DateEnd'], 0, 4)),
					'Faculty'	=> $place['Faculty'],
					'Chair'		=> $place['Chair'],
					'Class'		=> $place['Class'],
					'UsersCount'=> PlaceSimpleMgr::getInstance()->GetUsersCount($place['PlaceID'], $type),
				);
			}
		}
			
		LibFactory::GetStatic('arrays');
		
		$passportConfig = ModuleFactory::GetConfigById('section', App::$CurrentEnv['sectionid']);
		//trace::vardump($passportConfig);
		return array(
			'UserID' => $user->ID,
			'list' => $place_list,
			'list_top' => $place_list_top,
			'page' => $this->params['page'],
			'back_url' => $back_url,
			'months_arr' => Arrays::$Month['subjective'],
			'passport_config' => $passportConfig,
		);
	}
}
?>