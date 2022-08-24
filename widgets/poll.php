<?
class Widget_poll extends IWidget
{
	protected $_db;
	private	$captcha;
	private $_sectionid;
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Голосование';
		
		
		if (isset($OBJECTS['title']))
			$OBJECTS['title']->AddScript('/resources/scripts/widgets/announce/poll.js');
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
		
		parent::Init($path, $state, $params);
		
		if ( !empty($params['config']) )
			$this->LoadConfig($params['config']);
		$this->_db = DBFactory::GetInstance('poll');
	}
	
	protected function OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		if (isset($this->params['regions']) && !empty($this->params['regions']))
			$this->params['regions'] = (array) $this->params['regions'];

		if (isset($this->params['sections']) && !empty($this->params['sections']))
			$this->params['sections'] = (array) $this->params['sections'];

		if (isset($this->params['sites']) && !empty($this->params['sites']))
			$this->params['sites'] = (array) $this->params['sites'];

		if (empty($this->params['regions']) && empty($this->params['sections'])){
			$this->params['regions'] = array($CONFIG['env']['regid']);
			$this->params['sites'] = array(STreeMgr::GetNodeByID($CONFIG['env']['sectionid'])->ParentID);
		}

		$result = $this->_G_Details();
		
		if ($result === false)
			return false;

		$template = "widgets/poll/default";
		if (isset($this->params['template']) && STPL::IsTemplate($this->params['template']))
			$template = $this->params['template'];		
		
		if(isset($this->title))
			$result['title'] = $this->title;
	
		return STPL::Fetch($template, $result);
	}
	
	protected function &_G_Details()
	{
		global $OBJECTS, $CONFIG;
				
		$res = array();
		$res['wpoll'] =& $this->_Get_Details_Poll();
		
		if (intval($res['wpoll']['PollId']) <= 0)
			return false;
		
		return  $res;
	}

	
	protected function &_Get_Details_Poll() 
	{	
		global $CONFIG;
		$sql = 'SELECT q.*, r.RefId, r.SectionID FROM poll_question q';
		$sql.= ', poll_ref r ';
		$sql.= ' WHERE ';
		$sql.= ' r.PollId = q.PollId ';
		$sql.= ' AND r.opt_inState = 1 ';
		$sql.= ' AND q.Visible = 1 ';
		$sql.= ' AND q.Closed = 0 ';
		
		if (!empty($this->params['regions']))
			$sql.= ' AND r.RegionID IN ('.implode(",",$this->params['regions']).')';
		
		if (!empty($this->params['sections']))
			$sql.= ' AND r.SectionID IN ('.implode(",",$this->params['sections']).')';
		
		if (!empty($this->params['sites']))
			$sql.= ' AND r.SiteID IN ('.implode(",",$this->params['sites']).')';
		
		
		$sql.= " ORDER BY q.Date DESC";
				
		if ((!empty($this->params['offset'])) 
			&& $this->params['offset'] > 0)
			$sql.= " LIMIT ".(int)$this->params['offset'].", 1";
		else
			$sql.= " LIMIT 1";		
		
		
		$res = $this->_db->query($sql);

		$poll = array();
		
		if ( $res && $res->num_rows ) 
		{
			$poll = $res->fetch_assoc();
			
			$n = STreeMgr::GetNodeByID($poll['SectionID']);
			
			if( $n !== null && strlen($n->Name) > 0 )
				$this->title = $n->Name;
		
			$poll['url'] = '/'.ModuleFactory::GetLinkBySectionId($poll['SectionID'], array(), false).'/';

			$sql = "SELECT a.* FROM poll_answer a ";
			$sql .= " WHERE a.PollId=".$poll['PollId'];
			$sql .= " ORDER BY a.AnswerId ASC";
			$poll['answers'] = array();
			$res_ans = $this->_db->query($sql);
			while ( false != ($ans = $res_ans->fetch_assoc()) ) 
				$poll['answers'][] = $ans;
		}
		
		if($poll['Captcha']==1)
		{
			$this->captcha = LibFactory::GetInstance('captcha');
			 $poll['captcha_key'] = 'w'.$this->id;
			 $poll['captcha_path'] = $this->captcha->get_path($poll['captcha_key']);
		}
		
		return $poll;
	}
	
	
	public function GetJSHandlers()
	{
		return array(
			);
	}
}
?>