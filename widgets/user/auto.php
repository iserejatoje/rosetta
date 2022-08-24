<?

/**
	"Мой Автомобиль"
**/

class Widget_user_auto extends IWidget
{
	private $_params = array();
	
	public function __construct($id)
	{
		global $OBJECTS;
		parent::__construct($id);
		$this->title = 'Мой автомобиль';
	}
	
	public function Init($path, $state = null, $params = array())
	{
		global $OBJECTS;
				
		parent::Init($path, $state, $params);
		
		if ( !isset($params['id']) )
		{
			if ( $OBJECTS['user']->IsAuth() )
				$this->params['id'] = $OBJECTS['user']->ID;
			else
				return false;
		}
	}
	
	protected function OnDefault()
	{
		global $OBJECTS;
		
		$cacheid = "user|auto|".$this->params['id'];
				
		return $this->Render(
			$this->config['templates']['default'], 
			array(),
			array($this, '_OnDefault'), 
			false, 600, $cacheid
		);
	}
	
	protected function _OnDefault()
	{
		global $OBJECTS, $CONFIG;
		
		$user = $OBJECTS['usersMgr']->GetUser($this->params['id']);
		
		if ( $user === null )
			return array();
		
		$cars = array();
		foreach ( $user->Profile['auto']['cars'] as $car )
		{
			$cars[] = array(
				'MarkaID'	=> $car['MarkaID'],
				'ModelID'	=> $car['ModelID'],
				'MarkaName'	=> $car['MarkaName'],
				'ModelName'	=> $car['ModelName'],
				'Year' 		=> $car['Year'],
				'MarkaName'	=> $car['MarkaName'],
				'Volume'	=> $car['Volume'],
				'WheelType'	=> $car['WheelType'],				
				'Count'		=> $car['Count'],				
			);			
		}

		$_anketa['DrivingStyle'] 	= $user->Profile['auto']['DrivingStyle'];
		$_anketa['Tuning'] 			= $user->Profile['auto']['Tuning'];
		$_anketa['RightWheel'] 		= $user->Profile['auto']['RightWheel'];
		$_anketa['AutoSport'] 		= $user->Profile['auto']['AutoSport'];
		$_anketa['AutoThemes'] 		= $user->Profile['auto']['AutoThemes'];
		$_anketa['Expert'] 			= $user->Profile['auto']['Expert'];
		$_anketa['ExpertOther'] 	= $user->Profile['auto']['ExpertOther'];
		
		$anketa = array();
		foreach ( $OBJECTS['user']->Profile['auto']['auto_anketa'] as $k => $q )
		{
			$ans = array();
			foreach ( $q['answers'] as $ak => $a )
			{
				if ( ($q['multiple'] && ($_anketa[$k] & pow(2,$ak-1))) || (!$q['multiple'] && $_anketa[$k]==$ak) )
				{
					$ans[] = array('answer' => $a, 'id' => $ak);
				}
			}
			if ( $q['user_answer'] && !empty($_anketa[$q['user_answer']]) )
			{
				//$ans[] = array('answer' => $_anketa[$q['user_answer']], 'id' => $ak);
				$ans[] = array('answer' => $_anketa[$q['user_answer']]);
			}
			
			if ( sizeof($ans) > 1 )	
				$ak_ = null;
			
			if ( sizeof($ans) )
				$anketa[] = array(
					'question' => $q['question'],
					'answer' => $ans,
					'question_id' => $k,
				);
		}

		return array( 
			'UserID' 	=> $this->params['id'],
			'cars' 		=> $cars,
			'anketa' 	=> $anketa,
			'counter' 	=> $user->Profile['auto']['counter'],
			'page' 		=> $this->params['page']
		);
	}
}
?>