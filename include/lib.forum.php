<?

//2do: флаги премодерации не трогаются, как следствие не пересчитывается статистика при обновлеии
class lib_forum
{
	// раздел, табличка на сайте
	private $section = 0;
	private $config = null;		// конфиг раздела
	private $user_id = 0;		// идентификатор пользователя, с паспортом пропадет надобность
	private $login = '';		// логин пользователя, с паспортом пропадет надобность
	private $client;			// информация о клиенте
	private $db;
	private $_cache;			// разные кэши
	private $site_url;			// Домен сайта
	private $section_path;		// имя раздела
	private $lib_passport = null;// работа с пользователями

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

		$this->config = ModuleFactory::GetConfigById('section', $this->section, true);

		$this->db = DBFactory::GetInstance($this->config['db']);
		
		$this->GetClientInfo();
	}
	
	/**
	 * Добавить тему
	 * @param int раздел форума, в который необходимо добавить тему
	 * @param string заголовок темы
	 * @param string сообщение
	 * @param array флаги создания темы и сообщения
	 * @return int идентификатор темы, в случае ошибки 0
	 */
	function AddTheme($fsection, $title, $message, $flags = array())
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
		$sql.= " visible=1,";
		$sql.= " type=0,";
		if(!empty($flags['theme']['fixed']) && $flags['theme']['fixed'] === true)
			$sql.= " fixed=1,";
		if(!empty($flags['theme']['moderate']) && $flags['theme']['moderate'] === true)
			$sql.= " moderate=1,";
		$sql.= " icon=''";

		$this->db->query($sql);
		$theme_id = $this->db->insert_id;
		
		$this->AddToSendQueue($theme_id, 0);
		$mess_id = $this->AddMessage($theme_id, $message, true, true, false, $flags);
		$this->AddToSearchIndex('theme.html?id='.$theme_id.'&p=1');
		$this->ALog(1, $theme_id, array('section' => $fsection));
		
		$this->StatisticUpdateThemes($fsection);		// добавили кол-во тем
		$this->StatisticUpdateUserMessages($userid);	// добавили кол-во сообщений пользователю
		$this->StatisticUpdateLastMessage($mess_id);	// обновили последнее сообщение
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
			
			$this->StatisticUpdateSectionFromThemes($id, $show);			
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
		}
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
			$sql = "SELECT id FROM ".$this->config['tables']['themes'];
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
		return ModuleFactory::GetLinkBySectionId($this->section).'theme.html?id='.$id;
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
		$sql.= " user='',";
		$sql.= " login='".$this->login."',";
		$sql.= " message='".addslashes($msg['message'])."',";
		$sql.= " emessage='".addslashes($msg['emessage'])."',";
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
	
				$this->AddToSearchIndex('theme.html?id='.$theme_id.'&p='.$page);
				
				$this->ALog(14, $id, array('theme' => $theme_id));
				
				// для премодерируемого сообщения ничего не делаем со статистикой
				if($moderate == 0)
				{
					$this->StatisticUpdateCountForMessage($id, true, true);	// добавили кол-во сообщений для темы и раздела
					$this->StatisticUpdateLastMessage($id);					// обновили последнее сообщение
				}
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
			// накручиваем статистику
			$this->StatisticUpdateCountForMessage($message_id, true, true);
			
			$sql = "UPDATE ".$this->config['tables']['messages']." SET";
			$sql.= " moderate=0";
			$sql.= " WHERE id=".$message_id;
			$this->db->query($sql);
			
			$this->StatisticUpdateLastMessage($message_id);
		}		
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
		$sql.= " login='".$this->login."',";
		$sql.= " name='".addslashes($title)."'";
		$sql.= " WHERE id=".$theme_id;
		$this->db->query($sql);
		
		$this->ALog(3, $row[2], array());
		
		// найдем сообщение и проапдейтим
		$sql = "SELECT id FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme_id." AND is_theme=1";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
		{
			$this->UpdateMessage($row[0], $message, true, true, false, $flags);
		}
		$this->StatisticUpdateLastMessage($row[0]);
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
		$sql.= " message='".addslashes($msg['message'])."',";
		$sql.= " emessage='".addslashes($msg['emessage'])."',";
		$sql.= " visible=1,";
		if(!empty($flags['message']['fixed']))
			$sql.= " fixed=".($flags['message']['fixed']===true?1:0).',';
		$sql.= " ip='".$this->client['IP']."',";
		$sql.= " ip_fw='".$this->client['ForwardedIP']."'";
		$sql.= " WHERE id=".$message_id;
		
		$this->db->query($sql);
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
		
		$this->StatisticUpdateSectionFromThemes($theme_id, false);
		
		$sql = "UPDATE ".$this->config['tables']['themes']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE id=".$theme_id;
		$this->db->query($sql);
		
		$sql = "UPDATE ".$this->config['tables']['files']." SET";
		$sql.= " is_del=1";
		$sql.= " WHERE mess_id IN(SELECT id FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE theme_id=".$theme_id.')';
		$this->db->query($sql);
		
		$sql = "UPDATE ".$this->config['tables']['messages']." SET";
		$sql.=" is_del=1";
		$sql.=" WHERE theme_id=".$theme_id;
		$this->db->query($sql);
		
		$this->ALog(19, $id, array());
		
		$this->StatisticUpdateLastMessageForSection($theme_id);		
		
		$this->AddToSearchIndex('theme.html?id='.$theme_id.'&p=%');
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
			$sql.= "SELECT moderate FROM ".$this->config['tables']['messages'];
			$sql.= " WHERE id=".$message_id." AND is_theme!=1";
			$res = $this->db->query($sql);
			$row = $res->fetch_row();
			if($row === false)
				return;
			
			$sql = "UPDATE ".$this->config['tables']['files']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE mess_id=".$message_id;
			$this->db->query($sql);
			
			if($row[0] == 0)
				$this->StatisticUpdateCountForMessage($message_id, false);
			
			$sql = "UPDATE ".$this->config['tables']['messages']." SET";
			$sql.= " is_del=1";
			$sql.= " WHERE id=".$message_id." AND is_theme!=1";
			$this->db->query($sql);
			
			$this->ALog(18, $mess_id, array());
			
			if($row[0] == 0)
			{
				$sql = "SELECT id FROM ".$this->config['tables']['messages'];
				$sql.= " WHERE theme_id=".$tid." AND is_del!=1";
				$sql.= " ORDER BY created DESC LIMIT 1";
				$res = $this->db->query($sql);
				if($row = $res->fetch_row())
					$this->StatisticUpdateLastMessage($row[0]);
				
				$this->AddToSearchIndex('theme.html?id='.$theme_id.'&p=%');
			}
		}		
	}
	
	/**
	 * Получить тему для сообщения
	 * @param int идентификатор сообщения
	 * @return int идентификатор темы, 0 - тема не найдена
	 */
	function GetThemeByMessage($message_id)
	{
		$sql = "SELECT theme_id	FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE id='".$message_id."' AND is_del!=1";
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
		//$old = $OBJECTS['log']->SetSection($this->section);
		//$OBJECTS['log']->Log($action, $object, $params, $this->user_id);
		//$OBJECTS['log']->SetSection($old);
	}
	
	/**
	 * Установка идентификатора пользователя
	 * @param string логин пользователя
	 */
	function SetUser($login)
	{
		$this->login = $this->Escape($login);
	}
	
	// функции для работы со статистикой	
	/**
	 * копируем данные о последнем сообщении в раздел
	 * @param int $section идентификатор раздела
	 */
	private function StatisticUpdateLastMessageForSection($section)
	{
		// найдем последнее сообщение
		$sql = "SELECT m.created,m.user,m.login,t.name,t.id	FROM ".$this->config['tables']['themes']." AS t";
		$sql.= " LEFT JOIN ".$this->config['tables']['messages']." as m";
		$sql.= " ON m.theme_id = t.id AND m.is_del!=1 AND m.moderate!=1 AND m.visible=1";
		$sql.= " WHERE t.sec_id=".$section." AND t.is_del!=1";
		$sql.= " ORDER BY m.created DESC LIMIT 1";
		
		$res = $this->db->query($sql);
		if($row2 = $res->fetch_row())
		{
			while($section != 0)
			{
				$sql = "UPDATE ".$this->config['tables']['sections']." as s SET";
				$sql.= " s.last_date='".$row2[0]."',";
				$sql.= " s.last_user='".$row2[1]."',";
				$sql.= " s.last_login='".$row2[2]."',";
				$sql.= " s.last_theme='".$row2[3]."',";
				$sql.= " s.last_theme_id='".$row2[4]."'";
				$sql.= " WHERE s.id=".$section;
				$this->db->query($sql);
				
				$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
				$sql.= " WHERE id=".$section;
				$res = $this->db->query($sql);
				if($row = $res->fetch_row())
					$section = $row[0];
				else
					$section = 0;
			}
		}
		else
		{
			// сообщений в разделе нет, просто чистим последние данные
			while($section != 0)
			{
				$sql = "UPDATE ".$this->config['tables']['sections']." as s SET";
				$sql.= " s.last_date='0',";
				$sql.= " s.last_user=0,";
				$sql.= " s.last_login='',";
				$sql.= " s.last_theme='',";
				$sql.= " s.last_theme_id=0";
				$sql.= " WHERE s.id=".$section;
				$this->db->query($sql);
				
				$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
				$sql.= " WHERE id=".$section;
				$res = $this->db->query($sql);
				if($row = $res->fetch_row())
					$section = $row[0];
				else
					$section = 0;
			}
		}
	}
	
	/**
	 * функция обновляет данные раздела по данным темы
	 * используется при переносе и удалении темы
	 * раздел обязательно один для всех тем (под разные разделы надо еще доделать)
	 * @param mixed темы
	 * @param bool true увеличиваем, false уменьшаем
	 */
	private function StatisticUpdateSectionFromThemes($themes, $inc = true)
	{
		if(!is_array($themes))
			$themes = array($themes);
		
		$count = count($themes);
		if($count <= 0)
			return;
		if($inc === false)
			$count = -$count;
		
		$sql = "SELECT sec_id FROM ".$this->config['tables']['themes'];
		$sql.= " WHERE id IN (".implode(',', $themes).") AND is_del!=1";
		$sql.= " LIMIT 1";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$section = $row[0];
		else
			return;
		
		// цикл по темам
		// счетчик сообщений у раздела
		$sql = "SELECT sec_id, sum(messages) FROM ".$this->config['tables']['themes'];
		$sql.= " WHERE id IN (".implode(',', $themes).") AND is_del!=1 GROUP BY sec_id";
		$res = $this->db->query($sql);
		while($row = $res->fetch_row())
		{
			if($inc === false)
				$mcount[$row[0]] = -$row[1];
			else
				$mcount[$row[0]] = $row[1];
		}
		
		$sql = "UPDATE ".$this->config['tables']['sections']." SET";
		$sql.= " themes=themes+(".$count."),";
		$sql.= " messages=messages+(".$mcount[$section].")";
		$sql.= " WHERE id=".$section." AND is_del!=1";
		$this->db->query($sql);
		
		$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
		$sql.= " WHERE id=".$section;
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$id = $row[0];
		else
			$id = 0;
		
		while($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['sections']." SET";
			$sql.= " themes=themes+(".$count."),";
			$sql.= " messages=messages+(".$mcount[$section].")";
			$sql.= " WHERE id=".$id;
			$this->db->query($sql);
			
			$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
			$sql.= " WHERE id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				$id = $row[0];
			else
				$id = 0;
		}
	}
	
	/**
	 * увеличиваем кол-во сообщений, для сообщений (скорее всего будет переход на эту функцию везде)
	 * увеличение кол-ва сообщений в таблицах разделов и тем
	 * @param mixed $ids идентификаторы сообщений
	 * @param bool $inc true - увеличиваем false - уменьшаем
	 * @param bool $fuser true - применить для пользователей
	 */
	// !!! функция является упрощенной и использование для сообщений из нескольких тем недопустимо (общая админка)
	private function StatisticUpdateCountForMessage($ids, $inc = true, $fuser = false)
	{
		// увеличение идет по одному сообщению, mysql работает не совсем так, если использовать IN
		$users = array();
		if(is_array($ids))
			$count = count($ids);
		else
		{
			$count = 1;
			$ids = array($ids);
		}
		
		if($count <= 0)
			return;
		
		$sql = "SELECT id,theme_id,user	FROM ".$this->config['tables']['messages'];
		$sql.= " WHERE id IN (".implode(',',$ids).') AND is_del!=1';
		$res = $this->db->query($sql);
		$ids = array();
		while($row = $res->fetch_row())
		{
			$ids[] = $row[0];
			$users[$row[2]]++;
			$theme = $row[1];
		}
		
		$count = count($ids);
		
		if($count <= 0)
			return;
		
		if($inc === false)
			$count = -$count;
		
		// статистика сообщений для темы и раздела
		$sql = "UPDATE ".$this->config['tables']['themes']." as t SET";
		$sql.= " t.messages=t.messages+(".$count.")";
		$sql.= " WHERE t.id=".$theme;
		$sql.= " AND t.is_del!=1";
		$this->db->query($sql);
		
		$sql = "SELECT sec_id";
		$sql.= " FROM ".$this->config['tables']['themes'];
		$sql.= " WHERE id=".$theme;
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
			$id = $row[0];
		else
			$id = 0;
		
		while($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['sections'];
			$sql.= " SET messages=messages+(".$count.")";
			$sql.= " WHERE id=".$id;
			$this->db->query($sql);
			
			$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
			$sql.= " WHERE id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				$id = $row[0];
			else
				$id = 0;
		}
		
		if($fuser)
		{
			foreach($users as $k => $v)
			{
				if($inc === false)
					$v = -$v;
				// статистика сообщений для пользователя
				$sql = "UPDATE ".$this->config['tables']['users'];
				$sql.= " SET messages=messages+(".$v.")";
				$sql.= " WHERE id=".$k;
				$this->db->query($sql);	
				$this->StatisticUpdateUserMessagesRating($k);
			}
		}	
	}
	
	/**
	 * увеличиваем кол-во тем для раздела
	 * используем при добавлении новой темы (в этом случае не увеличиваем кол-во сообщений)
	 * @param int $section идентификатор раздела
	 * @param bool $inc true - увеличиваем false - уменьшаем
	 */
	private function StatisticUpdateThemes($id, $inc = true)
	{
		if($inc == true)
			$count = 1;
		else
			$count = -1;
		// увеличиваем кол-во для разедла
		while($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['sections']." SET";
			$sql.= " themes=themes+(".$count.")";
			$sql.= " WHERE";
			$sql.= " id=".$id;
			
			$this->db->query($sql);
			
			$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
			$sql.= " WHERE id=".$id;
			
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				$id = $row[0];
			else
				$id = 0;
		}
	}
	
	/**
	 * Изменение кол-ва сообщений для конкретного пользователя
	 * используется при добавлении сообщения и темы
	 * @param int идентификатор пользователя
	 * @param bool true - увеличиваем false - уменьшаем
	 */
	private function StatisticUpdateUserMessages($user, $inc = true)
	{
		if($user <= 0)
			return;
		if($inc == true)
			$count = 1;
		else
			$count = -1;
		
		$sql = "UPDATE ".$this->config['tables']['users']." SET";
		$sql.= " messages=messages+(".$count.")";
		$sql.= " WHERE id=".$user;
		$this->db->query($sql);	
		$this->StatisticUpdateUserMessagesRating($user);
	}
	
	/**
	 * копируем данные о последнем сообщении в раздел
	 * @param int $message идентификатор сообщения
	 */
	private function StatisticUpdateLastMessage($message)
	{
		// кидаем последнее сообщение в раздел и тему
		$sql = "UPDATE ".$this->config['tables']['messages']." as m, ".$this->config['tables']['themes']." as t SET";
		$sql.= " t.last_date=m.created,";
		$sql.= " t.last_user=m.user,";
		$sql.= " t.last_login=m.login";
		$sql.= " WHERE 1=1";
		$sql.= " AND t.id=m.theme_id";
		$sql.= " AND m.id=".$message;
		$sql.= " AND t.is_del!=1";
		$sql.= " AND m.is_del!=1";
		$this->db->query($sql);
		
		$sql = "SELECT t.sec_id";
		$sql.= " FROM";
		$sql.= " ".$this->config['tables']['messages']." as m,";
		$sql.= " ".$this->config['tables']['themes']." as t";
		$sql.= " WHERE m.id=".$message;
		$sql.= " AND t.id=m.theme_id";
		$res = $this->db->query($sql);
		if($row = $res->fetch_row())
		{
			$id = $row[0];
			$sql = "SELECT m.created,m.user,m.login,t.name,t.id";
			$sql.= " FROM ".$this->config['tables']['messages']." as m, ".$this->config['tables']['themes']." as t";
			$sql.= " WHERE m.id=".$message;
			$sql.= " AND t.id=m.theme_id";
			$res = $this->db->query($sql);
			{
				if(!($row2 = $res->fetch_row()))
					$id = 0;
			}
		}
		else
			$id = 0;
		
		while($id != 0)
		{
			$sql = "UPDATE ".$this->config['tables']['sections']." as s SET";
			$sql.= " s.last_date='".$row2[0]."',";
			$sql.= " s.last_user='".$row2[1]."',";
			$sql.= " s.last_login='".$row2[2]."',";
			$sql.= " s.last_theme='".$row2[3]."',";
			$sql.= " s.last_theme_id=".$row2[4]."";
			$sql.= " WHERE s.id=".$id;
			$this->db->query($sql);
			
			$sql = "SELECT parent FROM ".$this->config['tables']['sections'];
			$sql.= " WHERE id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
				$id = $row[0];
			else
				$id = 0;
		}
	}
	
	/**
	 * Обновление рейтинга "по сообщениям" у пользователей
	 * @param mixed пользователи
	 */
	private function StatisticUpdateUserMessagesRating($users)
	{
		if(!is_array($users))
			$users = array($users);
		foreach($users as $id)
		{
			$sql = "SELECT messages FROM ".$this->config['tables']['users'];
			$sql.= " WHERE";
			$sql.= " id=".$id;
			$res = $this->db->query($sql);
			if($row = $res->fetch_row())
			{
				foreach($this->config['message_rating'] as $rating => $v)
					if($row[0] < $v['messages'])
						break;
				if($rating >= count($this->config['message_rating']))
					$rating = count($this->config['message_rating'])-1;
				$sql = "UPDATE ".$this->config['tables']['users']." SET";
				$sql.= " rating_m=".$rating;
				$sql.= " WHERE";
				$sql.= " id=".$id;
				$this->db->query($sql);
			}
		}
	}
	
	/**
	 * Добавить в очередь индексации для поиска
	 * @param string путь для индексации
	 */
	private function AddToSearchIndex($url)
	{
		global $DCONFIG;
		$lib_dpsearch = LibFactory::GetInstance("dpsearch");
		$lib_dpsearch->Init($DCONFIG['REGION']);
		$lib_dpsearch->add_in_queue($this->site_url.'/'.$this->section_path.'/'.$url);
	}
	
	/**
	 * Добавить сообщение в очередь отправки
	 * @param int идентификатор
	 * @param string тип theme - тема, message - сообщение
	 * @param int идентификатор пользователя (зарезервировано, не используется)
	 */	
	function AddToSendQueue($id, $type = "message", $user = 0)
	{
		$type = $type=="message"?1:0;
		$sql = "INSERT INTO ".$this->config['tables']['subscribe_queue']." SET";
		$sql.= " target_id=".$id.',';
		$sql.= " type=".$type.',';
		$sql.= " user=0";
		$this->db->query($sql);
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
	function IsUserExists($login)
	{
		LibFactory::GetStatic('passport');
		if($this->lib_passport === null)
			$this->lib_passport = new Passport('', '', false, true,
				DBFactory::GetInstance($this->config['db']), $this->config['tables']['users']); 
		return $this->lib_passport->IsLoginRegistered($login);
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
		$text = trim(Data::Escape(strip_tags($text)));
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
}

?>
