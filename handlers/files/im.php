<?

require_once ($CONFIG['engine_path'].'handlers/files/header.php');
class HandlerPlugin_files_im extends HFilesPluginHeader
{
	public function Init($params)
	{
		global $OBJECTS, $CONFIG;
		
		if (!isset($params['id']))
			return false;
		
		$data = $this->GetFileInfo($params['id']);
		if (!$data['status'])
			return false;
		
		$params = array(
			'filename'	=> $data['name'], 
			'mimetype'	=> $data['mime_type'],
			'path'		=> $data['path'],
			'redirect'	=> $data['redirect'],
		);

		return parent::Init($params);
	}
	
	protected function GetFileInfo($id)
	{
		global $OBJECTS;
		
		/*$sql = "SELECT m.UserID, f.Name, f.NameOriginal";
		$sql.= " FROM messages_files as f";
		$sql.= " INNER JOIN messages as m ON m.MessageID=f.MessageID";
		$sql.= " WHERE f.FileID=".$id;*/

                $sql = "SELECT Name, NameOriginal, MimeType";
		$sql.= " FROM messages_files";
		$sql.= " WHERE FileID=".$id;
		
		$db = DBFactory::GetInstance('passport');
		$res = $db->query($sql);
		
		if (false !=($row = $res->fetch_assoc()))
		{
			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('filemagic');

			try {
				$path = FileStore::GetPath_NEW($row['Name']);
				$realpath = FileStore::GetRealPath('/common_fs/i/passport/files/'.$path);
				//$mt = FileMagic::GetFileInfo_NEW($realpath);
                                
				return array(
					'status'	=> true,
					'name'		=> $row['NameOriginal'],
					'mime_type'	=> $row['MimeType'],//$mt,
					'path'		=> $realpath,
					'redirect'	=> '/_i/passport/files/'.$path,
				);
			} catch (MyException $e) {
				return array('status' => false);
			}
		}
		else
			return array('status' => false);
	}
}
?>