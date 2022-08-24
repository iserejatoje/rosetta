<?
class ApplicationPathProvider_test extends IApplicationPathProvider
{
	public function ParseUrl($url, $data = null)
	{
		list($token, $url) = $this->mgr->Token($url);
		if($token == 'show')
		{
			list($token, $url) = $this->mgr->Token($url);
			if(is_numeric($token))
				$id = intval($token);
			else
				$id = 0;
				
			if($data != null && isset($data['id']))
				$id = $data['id'].'=>'.$id;
				
			return array('url' => $url, 'state' => 'show', 'id' => $id, 'canapp' => true);
		}
		return null;
	}
}
?>