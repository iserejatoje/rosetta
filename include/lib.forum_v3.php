<?

class lib_forum_v3
{
	// раздел, табличка на сайте
	private $section = 0;
	private $config = null;		// конфиг раздела
	private $user_id = 0;		// идентификатор пользователя, с паспортом пропадет надобность
	private $login = '';		// логин пользователя, с паспортом пропадет надобность
	private $client;			// информация о клиенте
	private $db;
	private $_cache;			// разные кэши
	private $cache;			// lib_cache
	private $site_url;			// Домен сайта
	private $section_path;		// имя раздела

	function __construct()
	{
	}

	/**
	 * Инициализация
	 * @param int идентификатор раздела сайта
	 */
	function Init($section)
	{
		LibFactory::GetStatic('data');
		$this->section = intval($section);

		LibFactory::GetStatic('cache');
        $this->cache = new Cache();
        $this->cache->Init('memcache', 'section_' . $this->section);

		$this->config = ModuleFactory::GetConfigById('section', $this->section);

		$this->db = DBFactory::GetInstance($this->config['db']);

		$this->GetClientInfo();
	}

	/**
	 * Инициализация
	 * @param int идентификатор раздела сайта
	 */
	function AppInit($folder, $name, $id)
	{
		LibFactory::GetStatic('data');
		LibFactory::GetStatic('application');

		$this->section = 0;

		LibFactory::GetStatic('cache');
        $this->cache = new Cache();
        $this->cache->Init('memcache', 'section_' . $folder.'|'.$name.'|'.$id);

		$this->config = ApplicationMgr::GetConfig($name, $folder);

		$this->db = DBFactory::GetInstance($this->config['db']);

		$this->GetClientInfo();
	}

	function AddSection($fsection, $name, $flags = array())
	{
		global $CONFIG;

		if($fsection === null)
		{
			$fsection = $this->config['root'];
			if(!is_numeric($fsection))
				return false;
		}
		$name = addslashes($name);
		$descr = addslashes($flags['section']['descr']);
		if(is_numeric($flags['section']['treeid']))
			$treeid = $flags['section']['treeid'];
		else
			$treeid = 0;

		$regid = $siteid = 0;

		if ( $treeid )
		{
			$n = STreeMgr::GetNodeByID($treeid);
			if($n !== null)
			{
				$regid = (int) $n->Regions;
				$siteid = (int) $n->ParentID;
			}
		}

		if(isset($flags['section']['visible']) && $flags['section']['visible'] === false)
			$visible = 0;
		else
			$visible = 1;
		if(isset($flags['section']['closed']) && $flags['section']['closed'] == true)
			$closed = 1;
		else
			$closed = 0;
		if(isset($flags['section']['oregcwrite']) && $flags['section']['oregcwrite'] == true)
			$oregcwrite = 1;
		else
			$oregcwrite = 0;
		$sql = "INSERT INTO ".$this->config['tables']['sections']."
				(parent,name,descr,visible,closed,oregcwrite,regid,siteid,treeid)
				VALUES
				($fsection, '$name', '$descr', $visible, $closed, $oregcwrite, $regid, $siteid, $treeid)";
		$this->db->query($sql);
		$id = $this->db->insert_id;
		if(is_numeric($flags['section']['uniqueid']))
		{
			$sql = "INSERT INTO ".$this->config['tables']['rootref'];
			$sql.= " SET UniqueID=".$flags['section']['uniqueid'].',';
			$sql.= " RootID=".$id;
			$this->db->query($sql);
		}
		return $id;
	}

	/**
	 * Добавить тему
	 * @param int раздел форума, в который необходимо добавить тему
	 * @param string заголовок темы
	 * @param string сообщение
	 * @param array флаги создания темы и сообщения
	 * @return int идентификатор темы, в случае ошибки 0
	 */
	function AddTheme($fsection, $title, $message, $flags = array(), $min_msg = 2)
	{
		$fsection = intval($fsection);
		if($this->config === null || !$this->IsSectionExists($fsection))
			return false;

		$theme_name = $this->Escape($title);

		$sql = "INSERT INTO ".$this->config['tables']['themes']." SET";
		$sql.= " sec_id=".$fsection.',';
		if(!isset($flags['theme']['created']))
			$sql.= " created=NOW(),";
		else
			$sql.= " created='".$flags['theme']['created']."',";
		$sql.= " user=".$this->user_id.',';
		$sql.= " login='".$this->login."',";
		$sql.= " name='".$theme_name."',";
		$sql.= " type=0,";
		if(isset($flags['theme']['visible']) && $flags['theme']['visible'] === false)
			$sql.= " visible=0, ";
		else
			$sql.= " visible=1, ";
		if(!empty($flags['theme']['fixed']) && $flags['theme']['fixed'] === true)
			$sql.= " fixed=1,";
		if(!empty($flags['theme']['moderate']) && $flags['theme']['moderate'] === true)
			$sql.= " moderate=1,";
		$sql.= " icon='',";
		$sql.= " min_msg_for_active=".$min_msg;

		$this->db->query($sql);
		$theme_id = $this->db->insert_id;

		$this->AddToSendQueue($theme_id, 0);
		$bb_conv = false;
		if(!empty($flags['theme']['bbconv']))
			$bb_conv = $flags['theme']['bbconv'];
		$mess_id = $this->AddMessage($theme_id, $message, true, true, $bb_conv, $flags);
		
		$this->ALog(1, $theme_id, array('section' => $fsection));
		$this->ALog(14, $mess_id, array('section' => $fsection));
		//$this->AddToSearchIndex('theme.php?id='.$theme_id.'&p=1');

		return $theme_id;
	}

	/**
	 * Получить тему
	 * @param int идентификатор темы
	 * @return array данные темы false - темы нет
	 */
	function GetTheme($theme_id)
	{
		$sql = "SELECT * FROM ".$this->config['tables']['themes'];
		$sql.= " WHERE id=".$theme_id;
		$res = $this->db->query($sql);
		if($row = $res->fetch_assoc())
			return $row;
		else
			return false;
	}

	/**
	 * Показать или скрыть тему
	 * @param int идентификатор темы
	 * @param bool показывать или нет
	 */
	function ShowTheme($id, $show = true)
	{
		$id = intval($id);
		if($id != 0 && $this->IsThemeVisible($id) != $show)
		{
			$sql = "UPDATE ".$this->config['tables']['themes'].' SET';
			$sql.= " visible=".($show==true?1:0);
			$sql.= " WHERE id=".$id;
			$this->db->query($sql);
			$this->ALog($show == true?26:25, $id, array());
		}
	}

	/**
	 * Видима ли тема
	 * @param int идентификатор темы
	 * @return bool видимость
	 */
	function IsThemeVisible($id)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "SELECT visible FROM ".$this->config['tables']['themes'];
			$sql.= " WHERE id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				if($row[0] == 1)
					return true;
		}
		return false;
	}

	/**
	 * Закрепить тему
	 * @param int идентификатор темы
	 * @param bool true - закрепить false - открепить
	 */

	function FixTheme($id, $fix = true)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['themes'].' SET';
			$sql.= " fixed=".($fix==true?1:0);
			$sql.= " WHERE id=".$id;
			$this->db->query($sql);
			$this->ALog($fix == true?28:277, $id, array());
		}
	}

	/**
	 * Получить сообщение
	 * @param int идентификатор сообщения
	 */

	function GetMessage($id)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "SELECT * FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE id = ".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_assoc())
				return $row;
		}
		return 0;
	}

	/**
	 * Получить идентификатор сообщения темы
	 * @param int идентификатор темы
	 */

	function GetMessageIdForTheme($id)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "SELECT id FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE is_theme=1";
			$sql.= " AND theme_id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				return $row[0];
		}
		return 0;
	}

	/**
	 * Получить ссылку на тему форума
	 * @param int тема форума
	 * @return string ссылка на форум
	 */

	function GetLinkForTheme($id)
	{
		return ModuleFactory::GetLinkBySectionId($this->section).'theme.php?id='.$id;
	}

	/**
	 * Добавить сообщение
	 * @param int идентификатор темы
	 * @param string сообщение
	 * @param bool сообщение для темы
	 * @param bool конвертировать смайлы
	 * @param bool конвертировать bb тэги
	 * @param array флаги добавления сообщения
	 * @return int идентификатор сообщения, в случае ошибки 0
	 */
	function AddMessage($theme_id, $message, $is_theme = false, $sm_conv = true, $bb_conv = true, $flags = array())
	{
		$theme_id = intval($theme_id);
		if($this->config === null || ($theme = $this->GetTheme($theme_id)) === false)
			return false;

		$msg = $this->EscapeMessage($message, $sm_conv, $bb_conv);

		$sql = "INSERT INTO ".$this->config['tables']['messages']." SET";
		$sql.= " theme_id=".$theme_id.",";
		if(!isset($flags['message']['created']))
			$sql.= " created=NOW(),";
		else
			$sql.= " created='".$flags['message']['created']."',";
		$sql.= " user=".$this->user_id.",";
		$sql.= " login='".addslashes($this->login)."',";
		$sql.= " message='".$msg['message']."',";
		$sql.= " emessage='".$msg['emessage']."',";
		$sql.= " visible=1,";
		$sql.= " ip='".$this->client['IP']."',";
		$sql.= " ip_fw='".$this->client['ForwardedIP']."',";
		$sql.= " cookie='".addslashes($this->client['Cookie'])."',";
		$moderate = 0;
		if(isset($flags['message']['moderate']))
			$moderate = $flags['message']['moderate']===true?1:0;
		else
			$moderate = $theme['moderate'];
		if($is_theme == false)
			$sql.= " moderate=".$moderate.",";
		if(!empty($flags['message']['fixed']) && $flags['message']['fixed'] === true)
			$sql.= " fixed=1,";
		$sql.= " is_theme=".($is_theme?1:0);

		$this->db->query($sql);
		$id = $this->db->insert_id;
		if($id != 0)
		{
			if($is_theme === false)
			{
				$this->AddToSendQueue($id, "message");

				// вычислим страницу
				$sql = "SELECT count(*) FROM ".$this->config['tables']['messages'];
				$sql.= " WHERE theme_id=".$theme_id." AND is_del!=1 AND moderate=0";

				$res = $this->db->query($sql);
				if($row = $res->fetch_row())
				{
					$page = floor($row[0] / $this->config['messagesperpage']) + 1;
					if($row[0] % $this->config['messagesperpage'] == 0) $page--;
				}

				//$this->AddToSearchIndex('theme.php?id='.$theme_id.'&p='.$page);

				$this->ALog(14, $id, array('theme' => $theme_id));
			}
		}
		return $id;
	}

	/**
	 * Закрепить сообщение
	 * @param int идентификатор сообщения
	 * @param bool true - закрепить false - открепить
	 */
	function FixMessage($id, $fix = true)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['messages'].' SET';
			$sql.= " fixed=".($fix==true?1:0);
			$sql.= " WHERE id=".$id;
			$this->db->query($sql);
			$this->ALog($fix == true?23:24, $id, array());
		}
	}

	/**
	 * Подтвердить премодерируемое сообщение
	 * @param int идентификатор сообщения
	 */
	function ApplyMessage($message_id)
	{
		$message_id = intval($message_id);
		if($this->config === null || $message_id == 0)
			return;

		$sql.= "SELECT moderate FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE id=".$message_id;
		$res = $this->db->query($sql);
		$row = $res->fetch_row();
		if($row !== false && $row[0] == 1)
		{
			$sql = "UPDATE ".$this->config['tables']['messages']." SET";
			$sql.= " moderate=0";
			$sql.= " WHERE id=".$message_id;
			$this->db->query($sql);
			$this->ALog(32, $message_id, array());
		}
	}

	/**
	 * Подтвердить  сообщение в ответ на "Обратить внимание модератора"
	 * @param int идентификатор сообщения
	 */
	function ApplyAlertMessage($message_id)
	{
		$message_id = intval($message_id);
		if($this->config === null || $message_id == 0)
			return;

		$sql = "DELETE FROM ".$this->config['tables']['alert'];
		$sql.= " WHERE id=".$message_id;
		$this->db->query($sql);
	}

	/**
	 * Изментить тему
	 * @param int идентификатор темы
	 * @param string заголовок темы
	 * @param string сообщение
	 * @param array флаги обновления темы и сообщения
	 */
	function UpdateTheme($theme_id, $title, $message, $flags = array())
	{
		$theme_id = intval($theme_id);
		if($this->config === null || !$this->IsThemeExists($theme_id))
			return;

		$title = $this->Escape($title);

		$sql = "UPDATE ".$this->config['tables']['themes']." SET";
		if(!empty($flags['theme']['fixed']))
			$sql.= " fixed=".($flags['theme']['fixed']===true?1:0).',';
		if(!isset($flags['theme']['created']))
			$sql.= " created=NOW(),";
		else
			$sql.= " created='".$flags['theme']['created']."',";
		if(!empty($flags['theme']['moderate']) && $flags['theme']['moderate'] === true)
			$sql.= " moderate=1,";
		$sql.= " login='".addslashes($this->login)."',";
		$sql.= " name='".addslashes($title)."'";
		$sql.= " WHERE id=".$theme_id;

		$this->db->query($sql);

		$this->ALog(3, $theme_id, array());

		// найдем сообщение и проапдейтим
		$sql = "SELECT id FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme_id." AND is_theme=1";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
		{
			$this->UpdateMessage($row[0], $message, true, true, $flags['message']['bb_conv'] === true ? true : false, $flags);
		}
	}

	/**
	 * Изментить сообщение
	 * @param int идентификатор сообщения
	 * @param string сообщение
	 * @param bool сообщение для темы
	 * @param bool конвертировать смайлы
	 * @param bool конвертировать bb тэги
	 * @param array флаги обновления сообщения
	 */
	function UpdateMessage($message_id, $message, $is_theme = false, $sm_conv = true, $bb_conv = true, $flags = array())
	{
		$message_id = intval($message_id);
		if($this->config === null || !$this->IsMessageExists($message_id))
			return;

		$msg = $this->EscapeMessage($message, $sm_conv, $bb_conv);

		// правим сообщение в теме
		$sql = "UPDATE ".$this->config['tables']['messages']." SET";
		if(!isset($flags['message']['created']))
			$sql.= " created=NOW(),";
		else
			$sql.= " created='".$flags['message']['created']."',";
		$sql.= " message='".$msg['message']."',";
		$sql.= " emessage='".$msg['emessage']."',";
		$sql.= " visible=1,";
		if(!empty($flags['message']['fixed']))
			$sql.= " fixed=".($flags['message']['fixed']===true?1:0).',';
		$sql.= " ip='".$this->client['IP']."',";
		$sql.= " ip_fw='".$this->client['ForwardedIP']."'";
		$sql.= " WHERE id=".$message_id;

		$this->db->query($sql);
		$this->ALog(17, $message_id, array());
	}

	/**
	 * Удалить тему
	 * @param int идентификатор темы
	 */
	function DeleteThemesByUniqueId($UniqueID)
	{
		$UniqueID = intval($UniqueID);
		if($this->config === null || $UniqueID == 0)
			return;

		$sql = "SELECT id FROM ".$this->config['tables']['themes'];
		$sql.= " WHERE UniqueID = ".$UniqueID;
		$res = $this->db->query($sql);
		if ( !$res )
			return;

		$themes = array();
		while ( list($id) = $res->fetch_row() )
			$themes[] = $id;

		if ( count($themes) == 0 )
			return;

		$sql = "UPDATE ".$this->config['tables']['themes']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE id IN (".implode(',',$themes).")";
		$this->db->query($sql);

		/*$sql = "UPDATE ".$this->config['tables']['files']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE mess_id IN(SELECT id FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id IN (".implode(',',$themes)."))";
		$this->db->query($sql);

		$sql = "UPDATE ".$this->config['tables']['messages']." SET";
		$sql.=" is_del=1";
		$sql.=" WHERE theme_id IN (".implode(',',$themes).")";
		$this->db->query($sql);*/

		foreach ( $themes as $id )
			$this->ALog(2, $id, array());
	}

	/**
	 * Удалить тему
	 * @param int идентификатор темы
	 */
	function DeleteTheme($theme_id)
	{
		$theme_id = intval($theme_id);
		if($this->config === null || $theme_id == 0)
			return;

		$sql = "UPDATE ".$this->config['tables']['themes']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE id=".$theme_id;
		$this->db->query($sql);

		/*$sql = "UPDATE ".$this->config['tables']['files']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE mess_id IN(SELECT id FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme_id.')';
		$this->db->query($sql);

		$sql = "UPDATE ".$this->config['tables']['messages']." SET";
		$sql.=" is_del=1";
		$sql.=" WHERE theme_id=".$theme_id;
		$this->db->query($sql);*/

		$this->ALog(2, $theme_id, array());

		//$this->AddToSearchIndex('theme.php?id='.$theme_id.'&p=%');
	}

	/**
	 * Удалить сообщение
	 * @param int идентификатор сообщения
	 */
	function DeleteMessage($message_id)
	{
		$message_id = intval($message_id);
		if($this->config === null || $message_id == 0)
			return;

		$tid = $this->GetThemeByMessage($message_id);

		if($tid != 0)
		{
			// для премодерации
			/*$sql.= "SELECT moderate FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE id=".$message_id." AND is_theme!=1";
			$res = $this->db->query($sql);
			$row = $res->fetch_row();
			if($row === false)
				return;*/

			$sql = "UPDATE ".$this->config['tables']['files']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE mess_id=".$message_id;
			$this->db->query($sql);

			$sql = "UPDATE ".$this->config['tables']['messages']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE id=".$message_id." AND is_theme!=1";
			$this->db->query($sql);

			$this->ALog(18, $message_id, array());

			/*if($row[0] == 0)
			{
				$this->AddToSearchIndex('theme.php?id='.$theme_id.'&p=%');
			}*/
		}
	}

	/**
	 * Удалить сообщение
	 * @param int идентификатор сообщения
	 */
	function DeleteAlertMessage($message_id)
	{
		$message_id = intval($message_id);
		if($this->config === null || $message_id == 0)
			return;

		$tid = $this->GetThemeByMessage($message_id);

		if($tid != 0)
		{
			$sql = "SELECT is_theme, theme_id FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE id=".$message_id;
			$res = $this->db->query($sql);
			$row = $res->fetch_assoc();
			if($row === false)
				return;

			if ($row['is_theme'] != 0)
				$this->DeleteTheme($row['theme_id']);
			else
				$this->DeleteMessage($message_id);

			$sql = "DELETE FROM ".$this->config['tables']['alert'];
			$sql.= " WHERE id=".$message_id;
			$this->db->query($sql);

			/*if ($row['is_theme'] != 0)
			{
				$sql = "UPDATE ".$this->config['tables']['themes']." SET";
				$sql.= " is_del=1";
				$sql.= " WHERE id=".$row['theme_id'];
				$this->db->query($sql);
			}

			$sql = "UPDATE ".$this->config['tables']['files']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE mess_id=".$message_id;
			$this->db->query($sql);

			$sql = "UPDATE ".$this->config['tables']['messages']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE id=".$message_id." AND is_theme!=1";
			$this->db->query($sql);

			$sql = "DELETE FROM ".$this->config['tables']['alert'];
			$sql.= " WHERE id=".$message_id;
			$this->db->query($sql);

			$this->ALog(18, $mess_id, array());

			if($row[0] == 0)
			{
				$this->AddToSearchIndex('theme.php?id='.$theme_id.'&p=%');
			}*/
		}
	}

	/**
	 * Получить тему для сообщения
	 * @param int идентификатор сообщения
	 * @return int идентификатор темы, 0 - тема не найдена
	 */
	function GetThemeByMessage($message_id, $deleted = false)
	{
		$message_id = intval($message_id);
		$sql = "SELECT theme_id	FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE id='".$message_id."'";
		if ( $deleted === false )
			$sql .= "AND is_del !=1 ";

		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			return $row[0];
		else
			return 0;
	}

	/**
	 * Получить кол-во сообщений для темы
	 * @param int идентификатор темы
	 * @param bool с сообщением темы
	 */
	function GetMessagesCountForTheme($id, $with_theme = false)
	{
		$id = intval($id);
		if($id != 0)
		{
			$sql = "SELECT count(*) FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE theme_id=".$id;
			$sql.= " AND moderate=0";
			$sql.= " AND visible=1";
			$sql.= " AND is_del=0";
			if($with_theme === false)
				$sql.= " AND is_theme=0";
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				return $row[0];
		}
		return 0;
	}

	/**
	 * Получить сообщения темы
	 * @param int идентификатор темы
	 * @param int позиция первого сообщения (0 - с начала) (для получения всех с заданной позиции необходимо указать кол-во элементов)
	 * @param int кол-во (0 - все)
	 * @param bool включать сообщение темы?
	 * @return array список сообщений
	 *   id идентификатор
	 *   message тело сообщение
	 *   login автор
	 */
	function GetMessagesForTheme($theme, $start = 0, $count = 0, $with_theme = false)
	{
		$msg = array();
		$theme = intval($theme);
		if($this->config === null || $theme == 0)
			return $msg;
		$sql = "SELECT * FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme;
		$sql.= " AND moderate=0";
		$sql.= " AND is_del=0";
		$sql.= " AND visible=1";
		if($with_theme !== true)
			$sql.= " AND is_theme=0";
		$sql.= " ORDER BY created";
		if($start > 0 || $count > 0)
		{
			$sqll = " LIMIT ";
			if($start === 0)
				$sqll.= $count;
			else if($start != 0 && $count != 0)
				$sqll.= $start.','.$count;
			else $sqll = '';
			$sql.= $sqll;
		}
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$msg[] = $row;
		return $msg;
	}

	/**
	 * Получить список последних сообщений темы
	 * @param int идентификатор темы
	 * @param int кол-во сообщений
	 * @param bool включать сообщение темы?
	 * @return array список сообщений
	 *   id идентификатор
	 *   message тело сообщение
	 *   login автор
	 */
	function GetLastMessagesForTheme($theme, $count, $with_theme = false)
	{
		$msg = array();
		$theme = intval($theme);
		if($this->config === null || $theme == 0)
			return $msg;
		$sql = "SELECT * FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme;
		$sql.= " AND moderate=0";
		$sql.= " AND is_del=0";
		$sql.= " AND visible=1";
		if($with_theme !== true)
			$sql.= " AND is_theme=0";
		$sql.= " ORDER BY created DESC";
		$sql.= " LIMIT ".$count;
		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
			$msg[] = $row;
		return $msg;
	}

	/**
	 * Запись в лог действий, используется для того, чтобы сохранить раздел
	 */
	private function ALog($action, $object, $params)
	{
		global $OBJECTS;
		$old = $OBJECTS['log']->SetSectionID($this->section);
		$OBJECTS['log']->Log($action, $object, $params, $OBJECTS['user']->ID);
		$OBJECTS['log']->SetSectionID($old);
	}

	/**
	 * Установка идентификатора пользователя
	 * @param string логин пользователя
	 */
	function SetUser($login)
	{
		$this->login = $this->Escape($login);
	}

	/**
	 * Установка идентификатора пользователя
	 * @param int идентификатор пользователя
	 */
	function SetUserID($id)
	{
		$this->user_id = $id;
	}

	/**
	 * Добавить в очередь индексации для поиска
	 * @param string путь для индексации
	 */
	private function AddToSearchIndex($url)
	{
		global $DCONFIG;
		//$lib_dpsearch = LibFactory::GetInstance("dpsearch");
		//$lib_dpsearch->Init($DCONFIG['REGION']);
		//$lib_dpsearch->add_in_queue($this->site_url.'/'.$this->section_path.'/'.$url);
	}

	/**
	 * Добавить сообщение в очередь отправки
	 * @param int идентификатор
	 * @param string тип theme - тема, message - сообщение
	 * @param int идентификатор пользователя (зарезервировано, не используется)
	 */
	function AddToSendQueue($id, $type = "message", $user = 0)
	{
		/*$type = $type=="message"?1:0;
		$sql = "INSERT INTO ".$this->config['tables']['subscribe_queue']." SET";
		$sql.= " target_id=".$id.',';
		$sql.= " type=".$type.',';
		$sql.= " user=0";
		$this->db->query($sql);*/
	}

	/**
	 * Проверка существования раздела
	 * @param int идентификатор раздела
	 * @return bool true - раздел существует
	 */
	function IsSectionExists($section)
	{
		if($section == 0)
			return false;
		if(!isset($this->_cache['section_exists'][$section]))
		{
			$sql = "SELECT count(*)";
			$sql.= " FROM ".$this->config['tables']['sections'];
			$sql.= " WHERE id=".$section;
			$res = $this->db->query($sql);
			$row = $res->fetch_row();
			$this->_cache['section_exists'][$section] = ($row[0] == 1);
		}
		return $this->_cache['section_exists'][$section];
	}

	/**
	 * Проверка существования темы
	 * @param int идентификатор темы
	 * @return bool true - тема существует
	 */
	function IsThemeExists($theme)
	{
		if($theme == 0)
			return false;
		if(!isset($this->_cache['themes_exists'][$theme]))
		{
			$sql = "SELECT count(*)";
			$sql.= " FROM ".$this->config['tables']['themes'];
			$sql.= " WHERE id=".$theme;
			$res = $this->db->query($sql);
			$row = $res->fetch_row();
			$this->_cache['themes_exists'][$theme] = ($row[0] == 1);
		}
		return $this->_cache['themes_exists'][$theme];
	}

	/**
	 * Проверка существования сообщения
	 * @param int идентификатор сообщения
	 * @return bool true - сообщение существует
	 */
	function IsMessageExists($message)
	{
		if($message == 0)
			return false;
		if(!isset($this->_cache['message_exists'][$message]))
		{
			$sql = "SELECT count(*)";
			$sql.= " FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE id=".$message;
			$res = $this->db->query($sql);
			$row = $res->fetch_row();
			$this->_cache['message_exists'][$message] = ($row[0] == 1);
		}
		return $this->_cache['message_exists'][$message];
	}

	/**
	 * Проверка существования пользователя в базе
	 * @param string имя пользователя
	 * @return bool true - пользователь существует
	 */
	/*function IsUserExists($login)
	{
		return PUsersMgr::IsNameExists($login, '', '');
	}*/

	/**
	 * информация о клиенте, заполняет массив класса
	 */
	public function SetClientInfo($IP = '', $ForwardedIP = '', $Cookie = '')
	{
		$this->client = array(
				'IP' => $IP ? $IP : getenv("REMOTE_ADDR"),
				'ForwardedIP' => $ForwardedIP ? $ForwardedIP : getenv("HTTP_X_FORWARDED_FOR"),
				'Cookie' => $Cookie ? $Cookie : $_COOKIE[$this->config['cookie_name']]
				);
	}

	/**
	 * получение информации о клиенте, заполняет массив класса
	 */
	private function GetClientInfo()
	{
		$this->client = array(
				'IP' => getenv("REMOTE_ADDR"),
				'ForwardedIP' => getenv("HTTP_X_FORWARDED_FOR"),
				'Cookie' => $_COOKIE[$this->config['cookie_name']]
				);
	}

	/**
	 * Экранирование данных
	 * @param string сообщение
	 */
	private function Escape($text)
	{
		$text = str_replace('&shy;', '', $text);
		$text = str_replace('&nbsp;', ' ', $text);
		$text = str_replace(
				array('&#0160;', '&#160;', '&#0173;', '&#173;'),
				array('','','',''),
				$text );
		$text = str_replace('­', '', $text); // невидимый символ, просьба не трогать
		$text = htmlspecialchars($text);
		$text = trim(addslashes(Data::Escape(strip_tags($text))));
		return $text;
	}

	/**
	 * Экранирование данных для форума
	 * @param string сообщение
	 * @param bool конвертировать смайлы?
	 * @param bool конвертировать BB-теги?
	 */
	private function EscapeMessage($message, $sm_conv, $bb_conv)
	{
		$emessage = $this->Escape($message);
		if($bb_conv === true)
			$message = Data::BBTagsConvert($emessage);
		if($sm_conv === true)
			$message = Data::SmilesConvert($message, $this->config['smileregexp'], $this->config['smilesconv'], $this->config['smiles_path'], $this->config['max_smiles']);
		$message = Data::RepeatedConvert($message);
		return array('message' => $message, 'emessage' => $emessage);
	}

	public function GetSectionsArray($root = null, $check_visible = true)
	{
		if($root === null)
			$root = $this->config['root'];
		$tree = $this->GetSectionTree($root, $check_visible);
		$ids = $this->_get_section_array_recursive($tree);
		$ids[] = $root;
		return $ids;
	}

	protected function _get_section_array_recursive($node)
	{
		$arr = array();
		foreach($node->Nodes as $n)
		{
			$arr[] = $n->Id;
			if(!empty($n->Nodes))
				$arr = array_merge($arr, $this->_get_section_array_recursive($n));
		}
		return $arr;
	}

	private static $_tree_cache = null;
	public function GetSectionTree($root = null, $check_visible = true)
	{
		if($root === null)
			$root = $this->config['root'];
		if(!isset($this->_tree[$root][$check_visible]))
		{
			LibFactory::GetStatic('tree');
			if(self::$_tree_cache === null)
			{
				self::$_tree_cache = $this->cache->Get('tree');
				if(self::$_tree_cache === false)
				{
					self::$_tree_cache = array();
					$sql = "SELECT id, parent, name, visible";
					$sql.= " FROM ".$this->config['tables']['sections'];
					if ($check_visible === true)
						$sql.= " WHERE visible=1";
					$sql.= " ORDER BY ord";

					$res = $this->db->query($sql);
					while($row = $res->fetch_row())
						self::$_tree_cache[$row[0]] = array('parent' => $row[1], 'data' => array('title' => $row[2], 'type' => 'section', 'visible' => $row[3]), 'name' => $row[0]);
					$this->cache->Set('tree', self::$_tree_cache, 60);
				}

			}
			$this->_tree[$root][$check_visible] = new Tree();
			$this->_tree[$root][$check_visible]->BuildTree(self::$_tree_cache, $root);

		}

		return $this->_tree[$root][$check_visible];
	}

	/**
	 * Избранные темы для пользователя, функция не кэширует
	 * @param array список разделов (вытаскивает также вложенные)
	 * @param int кол-во избранных тем
	 * @param bool подтягивать ли последнее сообщение
	 * @return array список избранных тем
	 */
	public function GetThemeSelected($limit, $with_messages = false)
	{
		global $OBJECTS;
		if($OBJECTS['user']->IsAuth())
		{
			// получение списка тем
			$sql = "SELECT DISTINCT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
			$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
			$sql.= " FROM ".$this->config['tables']['selected']." as st";
			$sql.= " INNER JOIN ".$this->config['tables']['themes']." as t ON t.id=st.ThemeID";
			$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
			$sql.= " WHERE st.UserID=".$OBJECTS['user']->ID." AND t.is_del!=1 AND t.created<=NOW()";
			$sql.= " AND t.visible=1 AND s.visible=1";
			$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

			$slist = $this->_GetThemes($sql, $with_messages);
			return $slist;
		}
		else
			return array();
	}

	/**
	 * Избранные темы для пользователя, функция не кэширует
	 * @param int id темы
	 * @param bool добавить ли в избранные
	 * @return array список избранных тем
	 */
	public function SetThemeSelected($theme, $selected)
	{
		global $OBJECTS;
		if($OBJECTS['user']->IsAuth() && is_int($theme))
		{
			if($selected == true)
			{
				// проверим наличие темы и ее видимость
				$sql = "SELECT id FROM ".$this->config['tables']['themes'];
				$sql.= " WHERE id=".$theme." AND is_del=0 AND visible=1";
				//error_log($sql);
				$res = $this->db->query($sql);
				if($row = $res->fetch_row())
				{
					$sql = "INSERT IGNORE INTO ".$this->config['tables']['selected'];
					$sql.= " SET UserID=".$OBJECTS['user']->ID.",";
					$sql.= " ThemeID=".$theme;
					$this->db->query($sql);
					$this->ALog(289,$theme,array());
				}
			}
			else
			{
				$sql = "DELETE FROM ".$this->config['tables']['selected'];
				$sql.= " WHERE UserID=".$OBJECTS['user']->ID." AND ThemeID=".$theme;
				$res = $this->db->query($sql);
				$this->ALog(290,$theme,array());
			}
		}
	}

	/**
	 * Последние темы в которых писал пользователь, функция не кэширует
	 * @param array список разделов (вытаскивает также вложенные)
	 * @param int кол-во тем
	 * @param bool подтягивать ли последнее сообщение
	 * @return array список тем
	 */
	public function GetThemeUser($limit, $with_messages = false, $exclude = array(), $user_id = null)
	{
		global $OBJECTS;

		if(is_int($user_id)) {
			//задан пользователь - получаем список тем для него
			$sql = "SELECT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
			$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
			$sql.= " FROM ".$this->config['tables']['themes']." as t";
			$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
			$sql.= " WHERE t.is_del!=1 AND t.created<=NOW() AND t.user=".$user_id;
			if(is_array($exclude) && count($exclude) > 0)
				$sql.= " AND t.id NOT IN(".implode(',', $exclude).")";
			$sql.= " AND t.visible=1 AND s.visible=1";
			$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

			$slist = $this->_GetThemes($sql, $with_messages);
			return $slist;
		} else {
			// пользователь не задан - берем для текущего
			if($OBJECTS['user']->IsAuth())
			{
				// получение списка тем
				$sql = "SELECT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
				$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
				$sql.= " FROM ".$this->config['tables']['themes']." as t";
				$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
				$sql.= " WHERE t.is_del!=1 AND t.created<=NOW() AND t.user=".$OBJECTS['user']->ID;
				if(is_array($exclude) && count($exclude) > 0)
					$sql.= " AND t.id NOT IN(".implode(',', $exclude).")";
				$sql.= " AND t.visible=1 AND s.visible=1";
				$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

				$slist = $this->_GetThemes($sql, $with_messages);
				return $slist;
			}
			else
				return array();
		}
	}

	/**
	 * Последние активные темы, функция не кэширует
	 * @param array список разделов (вытаскивает также вложенные)
	 * @param int кол-во тем
	 * @param bool подтягивать ли последнее сообщение
	 * @return array список тем
	 */
	public function GetThemeActive($limit, $with_messages = false, $exclude = array())
	{
		global $OBJECTS;
		// получение списка тем
		$sql = "SELECT DISTINCT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
		$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
		$sql.= " FROM ".$this->config['tables']['selected']." as st";
		$sql.= " INNER JOIN ".$this->config['tables']['themes']." as t ON t.id=st.ThemeID";
		$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
		$sql.= " WHERE st.UserID=".$OBJECTS['user']->ID." AND t.is_del!=1 AND t.created<=NOW()";
		if(is_array($exclude) && count($exclude) > 0)
			$sql.= " AND t.id NOT IN(".implode(',', $exclude).")";
		$sql.= " AND t.visible=1 AND s.visible=1";
		$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

		$slist = $this->_GetThemes($sql, $with_messages);
		return $slist;
	}

	public function GetSectionApp($id)
	{
		$sql = "SELECT RootID FROM svoi_rootref WHERE UniqueID=".intval($id);
		$res = $this->db->query($sql);
		$row = $res->fetch_row();
		if($row != false)
			return $row[0];
		else
			return 0;
	}

	/**
	 * Последние активные темы, функция не кэширует
	 * @param array список разделов (вытаскивает также вложенные)
	 * @param int кол-во тем
	 * @param bool подтягивать ли последнее сообщение
	 * @return array список тем
	 */
	public function GetThemeActiveApp($limit, $root, $blink, $with_messages = false)
	{
		global $OBJECTS;

		$sql = "SELECT RootID FROM ".$this->config['tables']['rootref']." WHERE UniqueID=".intval($root);
		$res = $this->db->query($sql);
		$row = $res->fetch_row();

		if($row === null)
			return array();

		$ss = $this->GetSectionsArray($row[0]);
		if(count($ss) == 0)
			return array();

		// получение списка тем
		$sql = "SELECT DISTINCT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
		$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
		$sql.= " FROM ".$this->config['tables']['themes']." as t";
		$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
		$sql.= " WHERE t.is_del!=1 AND t.created<=NOW()";
		$sql.= " AND s.id IN(".implode(',', $ss).")";
		$sql.= " AND t.visible=1 AND s.visible=1";
		$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

		$slist = $this->_GetThemes($sql, $with_messages, null, $blink);
		return $slist;
	}

	/**
	 * Количество активных тем
	 */
	public function GetThemeCountActiveApp($root)
	{
		global $OBJECTS;

		$sql = "SELECT RootID FROM ".$this->config['tables']['rootref']." WHERE UniqueID=".intval($root);
		$res = $this->db->query($sql);
		$row = $res->fetch_row();

		if($row === null)
			return array();

		$ss = $this->GetSectionsArray($row[0]);
		if(count($ss) == 0)
			return array();

		// получение списка тем
		$sql = "SELECT COUNT(*) ";
		$sql.= " FROM ".$this->config['tables']['themes']." as t";
		$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
		$sql.= " WHERE t.is_del!=1 AND t.created<=NOW()";
		$sql.= " AND s.id IN(".implode(',', $ss).")";
		$sql.= " AND t.visible=1 AND s.visible=1";

		$res = $this->db->query($sql);

		if ( !$res || !$res->num_rows )
			return 0;

		$count = $res->fetch_row();

		return $count[0];
	}

	/**
	 * Количество сообщений в форуме
	 */
	public function GetCountForumMessagesApp($root)
	{
		global $OBJECTS;

		$sql = "SELECT RootID FROM ".$this->config['tables']['rootref']." WHERE UniqueID=".intval($root);
		$res = $this->db->query($sql);
		$row = $res->fetch_row();

		if($row === null)
			return 0;

		// Количества сообщений
		$sql = "SELECT SUM(t.messages) ";
		$sql.= " FROM ".$this->config['tables']['themes']." as t";
		$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
		$sql.= " WHERE t.is_del !=1 ";
		$sql.= " AND s.id = ".$row[0];
		$sql.= " AND t.visible=1 AND s.visible=1";

		$res = $this->db->query($sql);

		if ( !$res || !$res->num_rows )
			return 0;

		$count = $res->fetch_row();

		return $count[0];
	}

	/**
	* Последние темы, в которых писал пользователь, включая не созданные им
	* @param int пользовательский id
	 * @param int кол-во тем
	 * @param bool подтягивать ли последнее сообщение
	 * @return array список тем
	*/
	public function GetLastThemeUser($user_id, $limit, $with_messages = false, $exclude = array() ) {
			global $OBJECTS;

			$themes = array();
			$sql = "SELECT DISTINCT theme_id";
			$sql.= " FROM ".$this->config['tables']['messages']." m";
			$sql.= " INNER JOIN ".$this->config['tables']['themes']." t ON t.id=m.theme_id";
			$sql.= " INNER JOIN ".$this->config['tables']['sections']." s ON s.id=t.sec_id";
			$sql.= " WHERE m.user=".$user_id." AND m.is_del!=1 AND m.visible=1 AND m.created<=NOW() AND";
			$sql.= " t.is_del!=1 AND t.visible=1 AND t.created<=NOW() AND";
			$sql.= " s.visible=1";
			$sql.= " ORDER BY m.created DESC LIMIT ".$limit;
			$res = $this->db->query($sql);
			while ($row = $res->fetch_row())
				$themes[] = $row[0];
			if (count($themes)==0)
				return array();
			$ids = implode(',',$themes);

			$sql = "SELECT t.id, t.sec_id, t.name, t.user, t.login, t.messages, t.views, UNIX_TIMESTAMP(t.last_date) as last_date,";
			$sql.= " t.last_user, t.last_login, t.closed, t.visible, t.moderate, t.fixed, t.icon, s.treeid";
			$sql.= " FROM ".$this->config['tables']['themes']." as t";
			$sql.= " INNER JOIN ".$this->config['tables']['sections']." as s ON s.id=t.sec_id";
			$sql.= " WHERE t.is_del!=1 AND t.created<=NOW() AND t.id IN (".$ids.")";
			if(is_array($exclude) && count($exclude) > 0)
				$sql.= " AND t.id NOT IN(".implode(',', $exclude).")";
			$sql.= " AND t.visible=1 AND s.visible=1";
			$sql.= " ORDER BY t.last_date DESC LIMIT ".$limit;

			$slist = $this->_GetThemes($sql, $with_messages, $user_id);
			return $slist;
	}

	private function _GetThemes($sql, $with_messages, $user_id=null, $blink_ = null)
	{
		LibFactory::GetStatic('datetime_my');
		$slist = array();
		$tree = $this->GetSectionTree();

		$res = $this->db->query($sql);
		while($row = $res->fetch_assoc())
		{
			if($with_messages === true)
			{
				$sql = "SELECT message, id FROM ".$this->config['tables']['messages'];
				$sql.= " WHERE theme_id=".$row['id']." AND moderate=0 AND visible=1 AND is_del=0";
				if ($user_id!=null)
					$sql.= " AND user=".$user_id;
				$sql.= " ORDER BY created DESC";
				$sql.= " LIMIT 1";

				$res2 = $this->db->query($sql);
				if($row2 = $res2->fetch_assoc()) {
					$row['message'] = $row2['message'];
					$row['message_id'] = $row2['id'];
				}
			}

			$row['last_date'] = Datetime_my::NowOffset(NULL, $row['last_date']);
			if($row['icon'] > 0 && $row['icon'] <= count($this->config['icons']))
			{
				$row['icon'] = $this->config['icons'][$row['icon']]['file'];
				$row['alt'] = $this->config['icons'][$row['icon']]['alt'];
			}
			else
				$row['icon'] = '';

			list($node, $desc) = $tree->FindById($row['sec_id'], true);

			if($blink_ === null)
			{
				if (!empty($row['treeid']))
					$blink = ModuleFactory::GetLinkBySectionId($row['treeid']);
				else
					$blink = '';
			}
			else
				$blink = $blink_;

			foreach($desc as $key => $sss)
			{
				$desc[$key]['url'] = $blink.$this->config['files']['get']['view']['string'].'?id='.$desc[$key]['id'];
			}

			$row['path'] = $desc;
			$row['url'] = $blink.$this->config['files']['get']['theme']['string'].'?id='.$row['id'];
			$row['url_section'] = $blink.$this->config['files']['get']['view']['string'].'?id='.$row['sec_id'];
			$row['url_last'] = $blink.$this->config['files']['get']['theme']['string'].'?id='.$row['id'].'&act=last';

			$slist[] = $row;
		}
		return $slist;
	}
}

?>
