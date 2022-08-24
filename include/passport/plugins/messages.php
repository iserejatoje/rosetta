<?php

class PMessagesPassportPlugin extends PABasePassportPlugin
{
	private $MessagesCount = array();
	private $config = array(
			'url' => '/passport/im/',
			'administration' => array( 443631, 77 ),
			'max_smiles' => 20,
			'files' => array( // настройки файлов только здесь, потому что они нужны везде, где есть работа с сообщениями
				'url' => '/_i/passport/files/',
				'path' => '/common_fs/i/passport/files/',
				'max_size' => 1992294.4, // 1.9 * 1024 * 1024 // ну что за корявые программеры, во всех языках выражение без переменной является константой и вычисляется пропроцессором
				),
			'smiles_path' => '/_img/modules/passport/im/smiles/',
			// регэксп, чтобы каждый раз не генерить
			'smileregexp' => '@(\:\)|\:\(|\:bad\:|\:tongue\:|\:wink\:|\:air_kiss\:|\:cray\:|\:crazy\:|\:good\:|\:lol\:|\:shok\:|\:blush2\:|\:agree\:|\:alcoholic\:|\:black_eye\:|\:boom\:|\:bravo\:|\:dance\:|\:first_move\:|\:flirt\:|\:fool\:|\:girl_cray\:|\:girl_devil\:|\:girl_haha\:|\:girl_sigh\:|\:give_rose\:|\:help\:|\:hysterics\:|\:king\:|\:kiss\:|\:lazy\:|\:mosking\:|\:music\:|\:new_russian\:|\:not_i\:|\:pardon\:|\:pilot\:|\:pleasantry\:|\:queen\:|\:secret\:|\:stop\:|\:suicide\:|\:superstition\:|\:yess\:|\:thank_you\:|\:tomato\:|\:yes\:|\:umnik\:|\:victory\:|\:xaxa\:)@',
			// сопоставление имени и картинки
			'smilesconv' => array(
				':)' => 'smile.gif', ':(' => 'sad.gif', ':bad:' => 'bad.gif', ':tongue:' => 'tongue.gif', ':wink:' => 'wink.gif',
				':air_kiss:' => 'air_kiss.gif', ':cray:' => 'cray.gif', ':crazy:' => 'crazy.gif', ':good:' => 'good.gif', ':lol:' => 'lol.gif',
				':shok:' => 'shok.gif', ':blush2:' => 'blush2.gif', ':agree:' => 'agree.gif', ':alcoholic:' => 'alcoholic.gif', ':black_eye:' => 'black_eye.gif',
				':boom:' => 'BooM.gif', ':bravo:' => 'bravo.gif', ':dance:' => 'dance4.gif', ':first_move:' => 'first_move.gif', ':flirt:' => 'flirt.gif',
				':fool:' => 'fool.gif', ':girl_cray:' => 'girl_cray2.gif', ':girl_devil:' => 'girl_devil.gif', ':girl_haha:' => 'girl_haha.gif', ':girl_sigh:' => 'girl_sigh.gif',
				':give_rose:' => 'give_rose.gif', ':help:' => 'help.gif', ':hysterics:' => 'hysterics.gif', ':king:' => 'king.gif', ':kiss:' => 'kiss.gif',
				':lazy:' => 'lazy.gif', ':mosking:' => 'mosking.gif', ':music:' => 'music.gif', ':new_russian:' => 'new_russian.gif', ':not_i:' => 'not_i.gif',
				':pardon:' => 'pardon.gif', ':pilot:' => 'pilot.gif', ':pleasantry:' => 'pleasantry.gif', ':queen:' => 'queen.gif', ':secret:' => 'secret.gif',
				':stop:' => 'stop.gif', ':suicide:' => 'suicide.gif', ':superstition:' => 'superstition.gif', ':yess:' => 'yess.gif', ':thank_you:' => 'thank_you.gif',
				':tomato:' => 'tomato.gif', ':yes:' => 'yes.gif', ':umnik:' => 'umnik.gif', ':victory:' => 'victory.gif', ':xaxa:' => 'XaXa.gif'
				),
			'smilesex' => array(
				':)' => 'smile.gif', ':(' => 'sad.gif', ':bad:' => 'bad.gif', ':tongue:' => 'tongue.gif', ':wink:' => 'wink.gif',
				':air_kiss:' => 'air_kiss.gif', ':cray:' => 'cray.gif', ':crazy:' => 'crazy.gif', ':good:' => 'good.gif', ':lol:' => 'lol.gif',
				':shok:' => 'shok.gif', ':blush2:' => 'blush2.gif', ':agree:' => 'agree.gif', ':alcoholic:' => 'alcoholic.gif', ':black_eye:' => 'black_eye.gif',
				':boom:' => 'BooM.gif', ':bravo:' => 'bravo.gif', ':dance:' => 'dance4.gif', ':first_move:' => 'first_move.gif', ':flirt:' => 'flirt.gif',
				':fool:' => 'fool.gif', ':girl_cray:' => 'girl_cray2.gif', ':girl_devil:' => 'girl_devil.gif', ':girl_haha:' => 'girl_haha.gif', ':girl_sigh:' => 'girl_sigh.gif',
				':give_rose:' => 'give_rose.gif', ':help:' => 'help.gif', ':hysterics:' => 'hysterics.gif', ':king:' => 'king.gif', ':kiss:' => 'kiss.gif',
				':lazy:' => 'lazy.gif', ':mosking:' => 'mosking.gif', ':music:' => 'music.gif', ':new_russian:' => 'new_russian.gif', ':not_i:' => 'not_i.gif',
				':pardon:' => 'pardon.gif', ':pilot:' => 'pilot.gif', ':pleasantry:' => 'pleasantry.gif', ':queen:' => 'queen.gif', ':secret:' => 'secret.gif',
				':stop:' => 'stop.gif', ':suicide:' => 'suicide.gif', ':superstition:' => 'superstition.gif', ':yess:' => 'yess.gif', ':thank_you:' => 'thank_you.gif',
				':tomato:' => 'tomato.gif', ':yes:' => 'yes.gif', ':umnik:' => 'umnik.gif', ':victory:' => 'victory.gif', ':xaxa:' => 'XaXa.gif'
				),
			);

	const CH_CONTACTS			= 0x001;		// GetConcatacs
	const CH_MESSAGE			= 0x002;		// UserMessage
	const CH_FILE				= 0x004;		// MessageFile

	public function InContacts() {
		return false;
	}

	public function __construct($user, $mgr)
	{
		parent::__construct($user, $mgr,'Messages');
	}

	public function GetSmilesInfo()
	{
		return array('smiles' => $this->config['smilesex'], 'path' => $this->config['smiles_path']);
	}

	public function SendMessage($uidt, $text, $iype = 0, $ititle = '', $iurl = '', $file = null)
	{
		global $OBJECTS;

		if(!is_numeric($uidt) || $uidt <= 0)
			return false;

		if(!$this->user->IsAuth() && !in_array($this->user->ID,$this->config['administration']))
			return false;

		LibFactory::GetStatic('data');
		$text = Data::BBTagsConvert($text, false);
		$text = Data::SmilesConvert($text, $this->config['smileregexp'], $this->config['smilesconv'], $this->config['smiles_path'], $this->config['max_smiles']);

		$dirs = 0;
		if(in_array($this->user->ID,$this->config['administration']))
			$dirs = 1;

		if ($this->user->Plugins->BlackList->IsInBlackList($uidt, true))
			$dirs = 2;

		$sql = "SELECT UserID, NickName FROM ".PUsersMgr::$tables['users'];
		$sql.= " WHERE UserID IN(".$this->user->ID.", ".$uidt.")";

		$res = PUsersMgr::$db->query($sql);
		if (!$res || $res->num_rows < 2)
			return false;

		while(false != ($row = $res->fetch_assoc())) {
			$users[$row['UserID']] = $row;
		}

		$ToMID = $FromMID = 0;
		PUsersMgr::$db->query("START TRANSACTION");
		if ($dirs == 0 || $dirs == 1) {

			$sql = "INSERT INTO ".PUsersMgr::$tables['messages']. " SET ";
			$sql.= " `UserID` = ".(int) $uidt;
			$sql.= " ,`Folder` = 1 ";
			$sql.= " ,`Created` = NOW() ";
			$sql.= " ,`UserFrom` = ".(int) $this->user->ID;
			$sql.= " ,`NickNameFrom` = '".addslashes($users[$this->user->ID]['NickName'])."'";
			$sql.= " ,`UserTo` = ".(int) $uidt;
			$sql.= " ,`NickNameTo` = '".addslashes($users[$uidt]['NickName'])."'";
			$sql.= " ,`Text` = '".addslashes($text)."'";
			$sql.= " ,`Type` = ".(int) $iype;
			$sql.= " ,`IsNew` = 1 ";
			$sql.= " ,`RefererTitle` = '".addslashes($ititle)."'";
			$sql.= " ,`RefererUrl` = '".addslashes($iurl)."'";

			if (false == PUsersMgr::$db->query($sql)) {
				PUsersMgr::$db->query("ROLLBACK");
				return false;
			}

			$ToMID = PUsersMgr::$db->insert_id;
		}

		if ($dirs == 0 || $dirs == 2) {

			$sql = "INSERT INTO ".PUsersMgr::$tables['messages']. " SET ";
			$sql.= " `UserID` = ".(int) $this->user->ID;
			$sql.= " ,`Folder` = 2 ";
			$sql.= " ,`Created` = NOW() ";
			$sql.= " ,`UserFrom` = ".(int) $this->user->ID;
			$sql.= " ,`NickNameFrom` = '".addslashes($users[$this->user->ID]['NickName'])."'";
			$sql.= " ,`UserTo` = ".(int) $uidt;
			$sql.= " ,`NickNameTo` = '".addslashes($users[$uidt]['NickName'])."'";
			$sql.= " ,`Text` = '".addslashes($text)."'";
			$sql.= " ,`Type` = ".(int) $iype;
			$sql.= " ,`IsNew` = 0 ";
			$sql.= " ,`RefererTitle` = '".addslashes($ititle)."'";
			$sql.= " ,`RefererUrl` = '".addslashes($iurl)."'";

			if (false == PUsersMgr::$db->query($sql)) {
				PUsersMgr::$db->query("ROLLBACK");
				return false;
			}

			$FromMID = PUsersMgr::$db->insert_id;
		}

		if($file !== null && $ToMID != 0 && $FromMID != 0) {
			// цепляем файл
			if(is_file($file['tmp_name']) && FileMagic::IsValidType_NEW($file['tmp_name']))
			{
				LibFactory::GetStatic('filemagic');
				LibFactory::GetStatic('filestore');

				try {
					$name = FileStore::CreateName_NEW(rand(100,999).'_'.time(), $file['tmp_name']);
					$type = FileMagic::GetFileInfo_NEW($file['tmp_name'], $file['name']);
					$file['name'] = FileMagic::CorrectName_NEW($file['name'], $type);
					$fullpath = $this->config['files']['path'].FileStore::GetPath_NEW($name);

					FileStore::Save_NEW($file['tmp_name'], $fullpath, $this->config['files']['max_size']);

					foreach(array($ToMID, $FromMID) as $msgid) {
						$sql = "INSERT INTO ".PUsersMgr::$tables['messages_files']." SET ";
						$sql.= " `MessageID` = ".(int) $msgid;
						$sql.= " ,`MimeType` = '".addslashes($type['mime_type'])."'";
						$sql.= " ,`NameOriginal` = '".addslashes($file['name'])."'";
						$sql.= " ,`Name` = '".addslashes($name)."'";
						$sql.= " ,`Size` = ".(int) $file['size'];
						$sql.= " ,`Icon` = ''";
						$sql.= " ,`ImgWidth` = 0";
						$sql.= " ,`ImgHeight` = 0";
						$sql.= " ,`ImgThumb` = ''";
						$sql.= " ,`ImgThumbSize` = 0";
						$sql.= " ,`ImgThumbWidth` = 0";
						$sql.= " ,`ImgThumbHeight` = 0";

						if (false == PUsersMgr::$db->query($sql)) {
							PUsersMgr::$db->query("ROLLBACK");
							return false;
						}
					}
				} catch (MyException $e) {
					PUsersMgr::$db->query("ROLLBACK");
					return false;
				}
			}
		}

		if ($dirs != 2) {
	
			EventMgr::Raise('passport/plugins/messages/sent', array(
				'from' => $this->user->ID, 
				'to' => $uidt,
				'event' => 'im_message_sent',
			));
		}

		$OBJECTS['log']->Log(
			288, $ToMID, array(
				'FromMessageID' => $FromMID,
				'ToUserID' => $uidt,
				)
			);

		PUsersMgr::$db->query("COMMIT");
		
		$this->ClearCache(self::CH_CONTACTS | self::CH_MESSAGE, array(
			'UserID' => $uidt
		));
		return true ;
	}

	public function GetFilesForMessage($messageid)
	{
		if(!$this->user->IsAuth())
			return 0;
	
		if (!is_numeric($messageid) || $messageid <= 0)
			return null;
	
		if(PUsersMgr::$cacher !== null)
			$file = PUsersMgr::$cacher->Get('up_messages_messagefile_'.$messageid);
		else
			$file = false;

		if ($file === false) {
			$sql = "SELECT * FROM ".PUsersMgr::$tables['messages_files'];
			$sql.= " WHERE MessageID = ".(int) $messageid;
		
			$res = PUsersMgr::$db->query($sql);
			if (!$res || !$res->num_rows)
				return null;

			$file = $res->fetch_assoc();
			// через скрипт
			$file['Url'] = '/service/files/?type=im&id='.$file['FileID'];

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_messages_messagefile_'.$messageid, $file, 0);
		}

		return $file;
	}

	public function DeleteFileForMessage($messageid)
	{
		if(!$this->user->IsAuth())
			return 0;
	
		$sql = "SELECT * FROM ".PUsersMgr::$tables['messages_files'];
		$sql.= " WHERE MessageID = ".(int) $messageid;
	
		if (true != ($res = PUsersMgr::$db->query($sql)))
			return false;
			
		if (!$res->num_rows)
			return true;
			
		LibFactory::GetStatic('filestore');
		while(false != ($file = $res->fetch_assoc())) {
			if (trim($file['Name']) == '')
				continue ;
		
			try
			{
				if (FileStore::IsFile($this->config['files']['path'].FileStore::GetPath_NEW($file['Name']))) {
					FileStore::Delete_NEW(
						$this->config['files']['path'] . FileStore::GetPath_NEW($file['Name']));
				}
			}
			catch (MyException $e) {}		
		}
	
		$sql = "DELETE FROM ".PUsersMgr::$tables['messages_files'];
		$sql.= " WHERE MessageID = ".(int) $messageid;
		
		PUsersMgr::$db->query($sql);
	
		$this->ClearCache(self::CH_FILE, array(
			'MessageID' => $messageid
		));
	
		return true;
	}

	public function GetFoldersInfo($with_count = true)
	{
		//$with_count - надо реализовать (зарезервировано)

		return array(
				'incoming' => array(
					'url' => $this->config['url'].'messages.php',
					),
				'outcoming' => array(
					'url' => $this->config['url'].'messages.php?folder=2',
					),
				'contacts' => array(
					'url' => $this->config['url'].'contacts.php',
					),
				);
	}

	public function GetMessage($messageid, $folder, $setold = false)
	{
		if (!$this->user->IsAuth())
			return null;

		if (!is_numeric($messageid) || $messageid < 0)
			return null;

		if ($folder < 0)
			$folder = 0;
			
		if(PUsersMgr::$cacher !== null)
			$message = PUsersMgr::$cacher->Get('up_messages_message_'.$this->user->ID.'_'.$messageid);
		else
			$message = false;

		if ($message === false) {
			$sql = "SELECT * FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE MessageID = ".(int) $messageid;
			$sql.= " AND UserID = ".$this->user->ID;

			if ($folder > 0)
				$sql.= " AND Folder = ".(int) $folder;
		
			if (true != ($res = PUsersMgr::$db->query($sql)))
				return null;
				
			if (!$res->num_rows)
				return null;
			
			$message = $res->fetch_assoc();
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_messages_message_'.$this->user->ID.'_'.$messageid, $message, 0);
		}
		
		if ($setold && $message['IsNew']) {
			
			$sql = "UPDATE ".PUsersMgr::$tables['messages'];
			$sql.= " SET IsNew = 0 ";
			$sql.= " WHERE MessageID = ".(int) $messageid;
			$sql.= " AND UserID = ".$this->user->ID;
			
			if ($folder > 0)
				$sql.= " AND Folder = ".(int) $folder;
			
			PUsersMgr::$db->query($sql);
		
			$this->ClearCache(self::CH_MESSAGE, array(
				'MessageID' => $messageid,
			));
		}

		LibFactory::GetStatic('datetime_my');
		$message['Created'] = Datetime_my::NowOffset(null, strtotime($message['Created']));			

		return $message;
	}

	public function MakeRead($ids, $isread = true)
	{
		if(!$this->user->IsAuth())
			return false;
	
		if (is_string($ids))
			$ids = explode(',', $ids);
		else
			$ids = (array) $ids;
		
		if (!sizeof($ids))
			return false;
		
		foreach($ids as $id) {
		
			$sql = "UPDATE ".PUsersMgr::$tables['messages'];
			$sql.= " SET IsNew = ".($isread ? 0 : 1);
			$sql.= " WHERE MessageID = ".(int) $id;
			$sql.= " AND UserID = ".$this->user->ID;

			PUsersMgr::$db->query($sql);
		
			$this->ClearCache(self::CH_MESSAGE, array(
				'MessageID' => $id,
			));
		}
		
		return true;
	}

	public function DeleteMessage($ids)
	{
		if(!$this->user->IsAuth())
			return false;
	
		if (is_string($ids))
			$ids = explode(',', $ids);
		else
			$ids = (array) $ids;
		
		if (!sizeof($ids))
			return false;
	
		foreach($ids as $id) {
		
			$sql = "DELETE FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE MessageID = ".(int) $id;
			$sql.= " AND UserID = ".$this->user->ID;

			PUsersMgr::$db->query($sql);
		
			$this->ClearCache(self::CH_MESSAGE, array(
				'MessageID' => $id,
			));
		}
	
		return true;
	}

	public function GetLastMessage()
	{
		if(!$this->user->IsAuth())
			return null;
	
		if(PUsersMgr::$cacher !== null)
			$message = PUsersMgr::$cacher->Get('up_messages_lastmessage_'.$this->user->ID);
		else
			$message = false;

		if ($message === false) {

			$sql = "SELECT * FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			$sql.= " AND Folder = 1 ";
			$sql.= " AND IsNew = 1 ";
			$sql.= " ORDER by Created ASC ";
			$sql.= " LIMIT 1 ";

			if (true != ($res = PUsersMgr::$db->query($sql)))
				return null;
				
			if ($res->num_rows) {
				$message = $res->fetch_assoc();
				$message['Url'] = $this->config['url'].'new.php?m='.$message['MessageID'];
			} else
				$message = null;

			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_messages_lastmessage_'.$this->user->ID, $message, 0);
		}

		if (is_array($message) && sizeof($message)) {
			LibFactory::GetStatic('datetime_my');
			$message['Created'] = Datetime_my::NowOffset(null, strtotime($message['Created']));
		}
		
		return $message;
	}

	public function GetMessages($filter, $setold = false)
	{
		if(!$this->user->IsAuth())
			return array();

		if(isset($filter['isnew']))
		{
			if($filter['isnew'])
				$filter['isnew'] = 1;
			else
				$filter['isnew'] = 0;
		}
		else
			$filter['isnew'] = -1;

		if(!isset($filter['folder']))
			$filter['folder'] = 0;

		if(!isset($filter['type']))
			$filter['type'] = 0;

		if($filter['field'] != 'Created' && $filter['field'] != 'From' &&
			$filter['field'] != 'To' && $filter['field'] != 'Type' && $filter['field'] != 'RefererTitle')
			$filter['field'] = 'Created';

		if($filter['field'] == 'To')
			$filter['field'] = 'NickNameTo';
		if($filter['field'] == 'From')
			$filter['field'] = 'NickNameFrom';

		if(!isset($filter['offset']) || !is_numeric($filter['offset']))
			$filter['offset'] = 0;
		if($filter['offset'] < 0) $filter['offset'] = 0;

		if(!isset($filter['limit']) || !is_numeric($filter['limit']))
			$filter['limit'] = 0;

		$filter['dir'] = strtoupper($filter['dir']);
		if($filter['dir'] != 'ASC' && $filter['dir'] != 'DESC')
			$filter['dir'] = 'ASC';

		$messages = array();

		if($filter['user_chain']) {
			$sql = "SELECT * FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			
			$sql.= " AND ((UserTo = ".$filter['user_chain']." AND Folder = 2) OR ";
			$sql.= " (UserFrom = ".$filter['user_chain']." AND Folder=1)) ";

		} else {
			$sql = "SELECT * FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			if ($filter['folder'] != 0)
				$sql.= " AND Folder = ".$filter['folder'];
				
			if ($filter['isnew'] != -1)
				$sql.= " AND IsNew = ".$filter['isnew'];
				
			if ($filter['type'] != 0)
				$sql.= " AND Type = ".$filter['type'];
		}
		
		$sql.= " ORDER BY ".$filter['field']." ".$filter['dir'];
		if ($filter['limit']) {
			if ($filter['offset'])
				$sql.= " LIMIT ".$filter['offset'].", ".$filter['limit'];
			else
				$sql.= " LIMIT ".$filter['limit'];
		}

		if (true != ($res = PUsersMgr::$db->query($sql)))
			return array();
			
		if (!$res->num_rows)
			return array();
		
		$setoldArr = array();
		LibFactory::GetStatic('datetime_my');
		while(false != ($row = $res->fetch_assoc()))
		{
			$row['Url'] = $this->config['url'].'new.php?m='.$row['MessageID'];
			$row['Created'] = Datetime_my::NowOffset(null,strtotime($row['Created']));
			$messages[] = $row;

			if ($setold && $row['IsNew']) {
				$setoldArr[] = $row['MessageID'];
			}
		}

		if (is_array($setoldArr) && sizeof($setoldArr)) {

			$sql = "UPDATE ".PUsersMgr::$tables['messages'];
			$sql.= " SET IsNew = 0 ";
			$sql.= " WHERE MessageID IN(".implode(',', $setoldArr).")";

			PUsersMgr::$db->query($sql);

			foreach($setoldArr as $messageid) {
				$this->ClearCache(self::CH_MESSAGE, array(
					'MessageID' => $messageid,
				));
			}
		}

		return $messages;
	}

	/**
	 * Количество новых сообщений
	 * @return int
	 *
	 * Возвращает количество новых сообщений (кешируется в объекте)
	 */
	public function GetNewMessagesCount()
	{
		if(!$this->user->IsAuth())
			return 0;
	
		// кэшируем конкретно кол-во новых сообщений
		// сохраняет в массиве, так как при попытке сохранить 0, после реконекта данные теряются

                $count = false;
		if(PUsersMgr::$cacher !== null)
			$count = PUsersMgr::$cacher->Get('up_messages_newmessagescount_'.$this->user->ID);
		
		if($count === false) {
			$sql = "SELECT COUNT(0) FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			$sql.= " AND Folder = 1 ";
			$sql.= " AND IsNew = 1 ";

			if (true != ($res = PUsersMgr::$db->query($sql)))
				return 0;
		
			$count = $res->fetch_row();
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set('up_messages_newmessagescount_'.$this->user->ID, $count, 0);
		}

		return $count[0];
	}

	public function GetMessagesCount($filter)
	{
		if(!$this->user->IsAuth())
			return 0;

		if(isset($filter['isnew']))
		{
			if($filter['isnew'])
				$filter['isnew'] = 1;
			else
				$filter['isnew'] = 0;
		}
		else
			$filter['isnew'] = -1;

		if(!isset($filter['folder']))
			$filter['folder'] = 0;

		if(!isset($filter['type']))
			$filter['type'] = 0;

		if($filter['user_chain']) {
			$sql = "SELECT COUNT(0) FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			
			$sql.= " AND ((UserTo = ".$filter['user_chain']." AND Folder = 2) OR ";
			$sql.= " (UserFrom = ".$filter['user_chain']." AND Folder=1)) ";

		} else {
			$sql = "SELECT COUNT(0) FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;

			if ($filter['folder'] != 0)
				$sql.= " AND Folder = ".$filter['folder'];
				
			if ($filter['isnew'] != -1)
				$sql.= " AND IsNew = ".$filter['isnew'];
				
			if ($filter['type'] != 0)
				$sql.= " AND Type = ".$filter['type'];
		}

		if (true != ($res = PUsersMgr::$db->query($sql)))
			return 0;
			
		list($mcount) = $res->fetch_row();
		return $mcount;
	}

	public function GetContacts($start, $count)
	{
                $result = false;
		if(PUsersMgr::$cacher !== null && $start == 0)
                    $result = PUsersMgr::$cacher->Get('up_messages_getcontacts_'.$this->user->ID);

		if ($result === false) {
			$result = array();
			
			$sql = "SELECT DISTINCT IF(UserID=UserFrom, UserTo, UserFrom) FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			
			if ($count) {
				if ($start)
					$sql.= " LIMIT ".$start.", ".$count;
				else
					$sql.= " LIMIT ".$count;
			}
			
			if (true != ($res = PUsersMgr::$db->query($sql)))
				return array();

			while($row = $res->fetch_row()) {
				$result[] = array('id' => $row[0]);
			}

			if(PUsersMgr::$cacher !== null && $start == 0)
				PUsersMgr::$cacher->Set('up_messages_getcontacts_'.$this->user->ID, $result, 0);
		}
		return $result;
	}

	public function GetContactsCount()
	{
                $result = false;
		if(PUsersMgr::$cacher !== null) {
			$cacheid = 'up_messages_getcontactscount_'.$this->user->ID;
			$result = PUsersMgr::$cacher->Get($cacheid);
		}			

		if ($result === false) {
			
			$sql.= "SELECT COUNT(DISTINCT IF(UserID=UserFrom, UserTo, UserFrom)) FROM ".PUsersMgr::$tables['messages'];
			$sql.= " WHERE UserID = ".$this->user->ID;
			
			if (true != ($res = PUsersMgr::$db->query($sql)))
				return 0;
			
			list($result) = $res->fetch_row();
			if(PUsersMgr::$cacher !== null)
				PUsersMgr::$cacher->Set($cacheid, array($result), 0);
		} else
			$result = $result[0];

		return $result;
	}

	private function SendMail($to)
	{
		global $OBJECTS, $CONFIG;

		$uto = $OBJECTS['usersMgr']->GetUser($to);
		if($uto !== null && $uto->Profile['themes']['talk']['ImNotify'])
		{
			if(!empty($uto->Profile['general']['EmailNotify']))
				$mail = $uto->Profile['general']['EmailNotify'];
			else
				$mail = $uto->Email;

			$subj = '=?windows-1251?B?'.base64_encode("Новое сообщение от ".$this->user->Profile['general']['ShowName']).'?=';

			$link = 'http://'.$CONFIG['env']['site']['domain'].'/passport/im/messages.php?chain='.$this->user->ID;

			LibFactory::GetStatic('datetime_my');
			$time = Datetime_my::NowOffsetTime();

			$message = 'Здравствуйте, '.$uto->Profile['general']['ShowName']."\n\n";
			$message.= $this->user->Profile['general']['ShowName']." отправил Вам сообщение в ".strftime("%H:%M %d.%m.%Y", $time).".\n\n";
			$message.= "Прочитать сообщение можно на странице:\n";
			$message.= $link."\n\n";
			$message.= "С уважением,\nАдминистрация сайта 74.ru.";
			$headers = "Content-Type:text/plain;charset=windows-1251;\n";
			$headers.= "From: noreply@".$CONFIG['env']['site']['domain']."\n";
			return mail($mail, $subj, $message, $headers);
		}
		return true;
	}

	public $types = array(
		'job'		=> 1,
		'auto'		=> 2,
		'realty'	=> 3,
		'forum'		=> 4,
		'love'		=> 5,
		'board'		=> 6,
		'lostfound'	=> 7,
		);

	public $typesdesc = array(
		1 => 'Работа',
		2 => 'Автообъявления',
		3 => 'Недвижимость',
		4 => 'Форум',
		5 => 'Знакомства',
		6 => 'Барахолка',
		7 => 'Бюро находок',
		);

	public $scripts = array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		//'/_scripts/themes/frameworks/jquery/jquery/1.2.6.js',
		'/_scripts/themes/frameworks/jquery/jquery.mousewheel.js',
		'/_scripts/themes/frameworks/jquery/nyromodal/jquery.nyromodal-1.5.5.js',
		'/_scripts/themes/frameworks/jquery/jquery.form.js',
		'/_scripts/modules/passport/im3.js',
	);
	
	public $styles = array(
		'/_styles/modules/passport/im_nyromodal.css',
	);

	public function AddResponse()
	{
		global $OBJECTS;

		/*if ($OBJECTS['user']->ID == 782423)
		{
			$this->scripts[2] = '/_scripts/themes/frameworks/jquery/nyromodal/jquery.nyromodal-1.5.5.js';
			$this->scripts[4] = '/_scripts/modules/passport/im3.js';
		}*/
		
		$OBJECTS['title']->AddScripts($this->scripts);
		$OBJECTS['title']->AddStyles($this->styles);
	}

	public function GetReplyJS($params)
	{
		$reload = 0;
		if($params['Reload'])
			$reload = 1;

		return "mod_passport_im_loader.load("
			.intval($params['UserID']).","
			.intval($params['MessageID']).","
			.intval($params['Type']).",'"
			.htmlspecialchars($params['Title'])."','"
			.htmlspecialchars($params['Url'])."',"
			.$reload.");";
	}

	public function GetMakeReadJS($params)
	{
		return "mod_passport_im_loader.makeread("
			.intval($params['MessageID']).");";
	}

	public function ClearCache($cache, $params = array()) {

		if (!PUsersMgr::$cacher)
			return;

		if ($cache & self::CH_CONTACTS) {
			PUsersMgr::$cacher->Remove('up_messages_getcontactscount_'.$this->user->ID);
			PUsersMgr::$cacher->Remove('up_messages_getcontacts_'.$this->user->ID);

			if ($params['UserID'] > 0) {
				PUsersMgr::$cacher->Remove('up_messages_getcontactscount_'.$params['UserID']);
				PUsersMgr::$cacher->Remove('up_messages_getcontacts_'.$params['UserID']);
			}
		}

		if ($cache & self::CH_MESSAGE) {
			PUsersMgr::$cacher->Remove('up_messages_newmessagescount_'.$this->user->ID);
			PUsersMgr::$cacher->Remove('up_messages_lastmessage_'.$this->user->ID);

			if ($params['UserID'] > 0) {
				PUsersMgr::$cacher->Remove('up_messages_newmessagescount_'.$params['UserID']);
				PUsersMgr::$cacher->Remove('up_messages_lastmessage_'.$params['UserID']);
			}
		}

		if ($cache & self::CH_MESSAGE && $params['MessageID'] > 0) {
			PUsersMgr::$cacher->Remove('up_messages_message_'.$this->user->ID.'_'.$params['MessageID']);
			PUsersMgr::$cacher->Remove('up_messages_messagefile_'.$params['MessageID']);
		}

		if ($cache & self::CH_FILE && $params['MessageID'] > 0) {
			PUsersMgr::$cacher->Remove('up_messages_messagefile_'.$params['MessageID']);
		}
	}
}
