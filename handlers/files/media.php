<?

require_once ($CONFIG['engine_path'].'handlers/files/header.php');

LibFactory::GetStatic('statincrement');
class HandlerPlugin_files_media extends HFilesPluginHeader
{
	private $lib;
	private $db;
	
	public function Init($params)
	{	
		global $OBJECTS, $CONFIG;
		
		if (!isset($params['id']))
			return false;
		
		$this->lib = LibFactory::GetInstance('multimedia');
		$this->db = DBFactory::GetInstance($this->lib->config['db']);
		
		$id = intval($params['id']);
		
		$data = $this->GetFileInfo($id);
		
		if (!$data['status'])
			return false;
		
		$this->Statistics($id);
		
		if (isset($_SERVER['HTTP_RANGE'])) 
		{
			$range = $_SERVER['HTTP_RANGE'];  
			$range = str_replace('bytes=', '', $range);  
		}
		else
			$range = 0;
		if ($range)
			Response::Status(206);
		else
			Response::Status(200);
				
		header("Content-Disposition: attachment; filename=\"".$data['name']."\"");
		header("Accept-Ranges: bytes");
		header("Content-Length: ".$data['filesize'] - $range);
		header("Content-Range: bytes ".$range."-".($data['filesize'] - 1).'/'.$data['filesize']);
		header("Content-Type: application/octet-stream; charset=windows-1251");
		header("Content-Transfer-Encoding: binary");
	
			
		$params = array(
			'filename'	=> $data['name'], 
			'mimetype'	=> $data['mt']['mime_type'], 
			'path'		=> $data['path'],
			'redirect'	=> $data['redirect'],
		);
			
	
		return parent::Init($params);
	}
	
	protected function GetFileInfo($id)
	{
		global $OBJECTS;
		
		if ( ($row = $this->lib->GetFile($id)) === null )
			return array('status' => false);
		
		if ($row['Type'] == 1) //видео
		{
			$name = $row['path_download'];
			$type = $this->lib->config['types']['video_source'];
		}
		elseif($row['Type'] == 2) //аудио
		{
			$name = $row['Path'];
			$type = $this->lib->config['types']['audio'];
		}
		else
			return array('status' => false);
		
		try
		{
			$file = $this->lib->GetMediaFile( $name, $type );
		}
		catch( MyException $e ) {
			return array('status' => false);
		}
		
		$ext = "";
		if (($pos = strrpos($file['path'], ".")) !== false)
			$ext = substr($file['path'], $pos, strlen($file['path'])-1);
		
		$download_fname = $row['Title'].$ext;
		
		$result = array(
			'status'	=> true,
			'name'		=> $row['Title'].$ext,
			'mt' 		=> array('mime_type' => $file['mime']),
			'path'		=> $file['path'],
			'redirect'	=> "/".preg_replace("@^http://.*?\/@i", "", $file['url']), //т.к. делается внутренний редирект
			'filesize'	=> $file['size'],
		);
		
		return $result;
		
		
	}
	
	private function Statistics($id)
	{
		$referer = strtolower($_GET['referer']);
		$referer = preg_replace('@^([^#]+)@','$1',$referer);
		$referer = trim($referer,' /');
		
		if ($referer == 'undefined' || $referer == 'null')
			$referer = '';
				
		$UniqueID = $this->_source_db_getUniqueID($referer, $id);
			
		StatIncrement::Log(
			$this->lib->config['db'], $this->lib->config['tables']['tree'],
			'DownloadCount', 'TreeID', $id
		);
			
		StatIncrement::Log(
				$this->lib->config['db'], $this->lib->config['tables']['links_ref'],
				'DownloadCount', 'UniqueID', $UniqueID
			);
	}
	
	private function _source_db_getUniqueID($referer, $FileID) 
	{
		$sql = 'SELECT LinkID FROM '.$this->lib->config['tables']['links_list'];
		$sql.= ' WHERE `LinkData` = \''.addslashes($referer).'\'';

		if (true != ($res = $this->db->query($sql)))
			return null;
		
		$linkID = 0;
		if ($res->num_rows)
			list($linkID) = $res->fetch_row();
		else {
			$sql = 'INSERT INTO '.$this->lib->config['tables']['links_list'];
			$sql.= ' SET `LinkData` = \''.addslashes($referer).'\'';
			
			if (false != ($res = $this->db->query($sql)))
				$linkID = $this->db->insert_id;
		}
		
		if (!$linkID)
			return null;
			
		$sql = 'SELECT UniqueID FROM '.$this->lib->config['tables']['links_ref'];
		$sql.= ' WHERE `LinkID` = '.$linkID;
		$sql.= ' AND `FileID` = '.$FileID.' AND `Date` = CURRENT_DATE()';
		if (true != ($res = $this->db->query($sql)))
			return null;
			
		$UniqueID = 0;
		if ($res->num_rows)
			list($UniqueID) = $res->fetch_row();
		else {
			$sql = 'INSERT INTO '.$this->lib->config['tables']['links_ref'];
			$sql.= ' SET `LinkID` = '.$linkID.', `FileID` = '.$FileID.', `Date` = CURRENT_DATE()';
			if (true != ($res = $this->db->query($sql)))
				return null;
				
			$UniqueID = $this->db->insert_id;
		}
		
		if (!$UniqueID)
			return null;
		
		return $UniqueID;
	}

	
}
?>