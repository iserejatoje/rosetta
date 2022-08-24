<?

/**
	"Мои Объявления"
**/

class Widget_user_advertise extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Мои объявления';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
		if ( !$OBJECTS['user']->IsAuth() )
			return false;		
		parent::Init($path, $state, $params);
	}
	
	protected function OnDefault()
	{
		global $OBJECTS;
		
		
		$cacheid = "user|advertise|".$OBJECTS['user']->ID;
		
		return $this->Render(
			$this->config['templates']['default'], 
			array(),
			array($this, '_OnDefault'), 
			!$OBJECTS['user']->IsAuth() && false, 900, $cacheid
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		$regid = $CONFIG['env']['regid'];
		
		$my = array();
		
		/************************
		 *	Job
		 ************************/
		$cfg = ModuleFactory::GetConfigById('section', $this->config['sections']['job'][$regid]);
		if( !empty($cfg) )
		{
			$blink = ModuleFactory::GetLinkBySectionId($this->config['sections']['job'][$regid]);
			
			$db = DBFactory::GetInstance($cfg['db']);
			
			$sql = 'SELECT count(*) FROM '.$cfg['tables']['j_vacancy'];
			$sql.= ' WHERE uid='.$OBJECTS['user']->ID;
			$res = $db->query($sql);
			if ( false == list($my['job']['vacancy']['count']) = $res->fetch_row() )
				$my['job']['vacancy']['count'] = 0;
			$my['job']['vacancy']['blink'] = $blink."my/vacancy.php";
			
			$sql = 'SELECT count(*) FROM '.$cfg['tables']['j_resume'];
			$sql.= ' WHERE uid='.$OBJECTS['user']->ID;
			$res = $db->query($sql);
			if ( false == list($my['job']['resume']['count']) = $res->fetch_row() )
				$my['job']['resume']['count'] = 0;
			$my['job']['resume']['blink'] = $blink."my/resume.php";
		}
		/** КОНЕЦ: Job **/
		
		/************************
		 *	Auto
		 ************************/
		$cfg = ModuleFactory::GetConfigById('section', $this->config['sections']['auto'][$regid]);
		if( !empty($cfg) )
		{
			$blink = ModuleFactory::GetLinkBySectionId($this->config['sections']['auto'][$regid]);
			
			$db = DBFactory::GetInstance($cfg['db']);
			
			$sql = 'SELECT COUNT(*)';
			$sql.= ' FROM '.$cfg['tables']['data']['table'];
			$sql.= ' WHERE in_state=0 AND visible=1 AND uid='.$OBJECTS['user']->ID;
			
			$res = $db->query($sql);
			if ( false == (list($my['auto']['adv']['count']) = $res->fetch_row()) )
				$my['auto']['adv']['count'] = 0;
			$my['auto']['adv']['blink'] = $blink."editlist.html";			
		}
		/** КОНЕЦ: Auto **/
		
		/************************
		 *	Realty
		 ************************/
		$my['realty']['total_count'] = 0;
		foreach( $this->config['sections']['realty'][$regid] as $type => $section )
		{
			if ( $type == 'user' )
				continue;
			
			$cfg = ModuleFactory::GetConfigById('section', $section);
			if( !empty($cfg) )
			{
				$db = DBFactory::GetInstance($cfg['db']);
				
				$sql = 'SELECT count(*)';
				$sql.= ' FROM '.$cfg['tables'][$type];
				$sql.= ' WHERE uid='.$OBJECTS['user']->ID.' AND in_state=0';
				if ($cfg['city_id'])
					$sql .= ' AND (address != \'\' OR (street > 0 AND house != \'\'))';
				else
					$sql .= ' AND address != \'\' ';
				
				$res = $db->query($sql);
				if ( false == (list($my['realty'][$type]['count']) = $res->fetch_row()) )
					$my['realty'][$type]['count'] = 0;
				
				$my['realty']['user']['count'] += $my['realty'][$type]['count'];
			}
		}
		$my['realty']['user']['blink'] = ModuleFactory::GetLinkBySectionId($this->config['sections']['realty'][$regid]['user']);
		/** КОНЕЦ: Realty **/
		
		return array( 'my' => $my );
	}
}
?>