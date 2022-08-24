<?

class Subsection_svoi_Provider extends SubsectionProvider
{
	private $tree		= null;
	private $filled		= false;
	/**
	 * Вернуть дерево подразделов для данного раздела
	 * @return Tree дерево разделов
	 */
	public function GetTree()
	{
		return array();
	}
	
	public function CreateKey($params)
	{
		return $this->KeyPrefix.'s'.$params['id'];
	}

	public function AddLocation($params)
	{
		global $OBJECTS, $CONFIG;

		// пока тупо прямой запрос к бд, потом все равно переделаем
		switch($CONFIG['env']['regid'])
		{
			case 2:		$title = "Живая УФА";							break;
			default:	$title = "Социальная сеть";						break;
        }

		$OBJECTS['title']->AppendBefore($title);
		//$OBJECTS['title']->AddPath($title, '/svoi/');

		$db = DBFactory::GetInstance('passport');
		$sql = "SELECT * FROM community";
		$sql.= " WHERE CommunityID=".intval($params['id']);
		$res = $db->query($sql);
		$row = $res->fetch_assoc();
		if($row)
		{
			$OBJECTS['title']->AppendBefore($row['Name']);
			$OBJECTS['title']->AddPath($row['Name'], $this->GetLink(array('id' => $params['id'])));
		}
    }

	public function GetLink($params)
	{
		return '/svoi/community/'.$params['id'].'/';
    }
}

?>