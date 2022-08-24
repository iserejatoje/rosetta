<?

class Subsection_afisha_Provider extends SubsectionProvider
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
		return $this->KeyPrefix.'af'.$params['id'];
	}
}

?>