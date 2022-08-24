<?php

class PProfile_news extends PProfilePlain
{
	private $custom_cache = array();
	private $_cg_mgr = null;
	private $_cu_mgr = null;
	private $send_time = null;
	private $send_action = null;
	public function __construct($index, $parent, $user)
	{
		parent::__construct($index, $parent, $user);
		$this->custom_fields = array('list', 'date', 'group','groupmail','groupmaila');
		
	}

	public function Load($index = 'news')
	{
		global $OBJECTS;

		$this->profile[$index] = array();
		// 0 - новости, 1 - уведомления
		if($index != 'mail')
			return;

		$sql = "SELECT * FROM ".PUsersMgr::$tables['log_notification_mail'];
		$sql.= " WHERE UserID = ".$this->user->ID;
		$sql.= " ORDER BY LogTime DESC ";

		$res = PUsersMgr::$db->query($sql);
		while($row = $res->fetch_assoc()) {
			$this->profile[$index][] = $row;
		}
	}

	public function Save()
	{
	}

	private function GetUserInfo($user)
	{
		global $CONFIG;
		$ui = array();
		$info = $this->user->UsersMgr->GetUser($user);
		$ui['id'] = $user;
		$ui['showname'] = $info->Profile['general']['ShowName'];
		$ui['showvisited'] = $info->Profile['general']['showvisited'];
		$ui['gender'] = $info->Profile['general']['Gender'];
		$ui['avatar'] = $info->Profile['general']['Avatar'];
		$ui['avatarurl'] = $info->Profile['general']['AvatarUrl'];
		$ui['avatarwidth'] = $info->Profile['general']['AvatarWidth'];
		$ui['avatarheight'] = $info->Profile['general']['AvatarHeight'];

		$n = STreeMgr::GetNodeByID(STreeMgr::GetSiteTitleIDByRegion($info->RegionID));
		
		$url = 'http://'.$n->Name;
		$ui['infourl'] = $url.$info->Profile['general']['InfoUrl'];

		return $ui;
	}

	public function CustomGet($offset)
	{
		global $OBJECTS, $CONFIG;

		LibFactory::GetStatic('datetime_my');

		switch($offset)
		{
			// обычный список
			case 'list':
				return $this->profile['news'];
			// группировка по дате
			case 'date':
				$list = array();
				foreach($this->profile['news'] as $n)
				{
					$list[$logdate][$n['ActionID']][] = $n;
				}

				return $list;
			// умная группировка по различным факторвам, в зависимости от события
			// группировка: дата, событие, дополнительно
			case 'group':
			case 'groupmail':
			case 'groupmaila':
				// для почты выбираются также все записи, но в PHP дополнительная проверка по
				// времени последней отправки
				// контроль сделан здесь, для того, чтобы не тянуть лишнии данные
				// о объектах, от которых зависит действие
				if($offset == 'groupmail' || $offset == 'groupmaila')
				{
					if(!isset($this->profile['mail']))
						$this->Load('mail');
					$index = 'mail';

					// заполнение времени отработки уведомлений
					$this->send_action = $this->user->Profile['themes']['talk']['SendActions'];
				}
				$list = array();
				
				foreach($this->profile[$index] as $n)
				{
					// пропускаем, что не требуется отправлять
					if($index == 'mail' && !isset($this->send_action[$n['ActionID']]))
					{
						//error_log('skip action: '.$n['ActionID']);
						continue;
					}

					$n['Params'] = unserialize($n['Params']);
					
					if($offset == 'groupmaila')
						$logdate = 0;
					else
						$logdate = substr($n['LogTime'], 0, 10);
						
					$node = STreeMgr::GetNodeByID(STreeMgr::GetSiteTitleIDByRegion($this->user->RegionID));
					
					switch($n['ActionID'])
					{
						// уведомления о личных сообщениях
						case 1:
							$bkey = 'm'.$n['Params']['from'].'_'.$n['ActionID'];
							$i = $this->GetUserInfo($n['Params']['from']);
							$url = 'http://'.$node->Name.'/passport/im/messages.php';
							$list [$logdate][$bkey] ['list'][0] =
								array(
									'time' => $n['LogTime'],
									'data' => array('user' => $i, 'url' => $url),
								);
							break;
						// группировка: друг
						case 19:
							$url = '';
							$bkey = 'u'.$n['Params']['user'].'_'.$n['ActionID'];
							if(!isset($list [$logdate][$bkey] ['user']))
							{
								$list
									[$logdate]['u'.$n['Params']['user'].'_'.$n['ActionID']]
									['user'] = $this->GetUserInfo($n['Params']['user']);
							}
							$domain = $node->Name;
							if($n['ActionID'] == 19)
							{
								$friendspage = 'mypage/friends.php';
								if(in_array($this->user->RegionID, $CONFIG['env']['svoi_regions']))
									$friendspage = 'friends.php';
								$list [$logdate][$bkey]['mypageurl'] = 'http://'.$node->Name.'/passport/'.$friendspage;
							}
							switch($n['ActionID'])
							{
								case 19:
									$key = $n['Params']['friend'];
									if(isset($list [$logdate][$bkey] ['list'][$key]))
										continue;
									$ninfo = $this->GetUserInfo($n['Params']['friend']);
									break;
							}
							if($ninfo !== null)
								$list [$logdate][$bkey] ['list'][$key] =
									array(
										'time' => $n['LogTime'],
										'data' => $ninfo,
									);
							elseif(count($list [$logdate][$bkey] ['list']) == 0)
							{
								unset($list [$logdate][$bkey]);
								$bkey = null;
								continue;
							}
							break;
					}
					if($bkey !== null)
					{
						$list [$logdate][$bkey] ['action'] = $n['ActionID'];
						if(!isset($list [$logdate][$bkey] ['time'])) // последний момент
							$list [$logdate][$bkey] ['time'] = Datetime_my::NowOffset(NULL, strtotime($n['LogTime']));
					}
				}
				return $list;
				break;
		}
		return '';
	}

	public function CustomSet($offset, $value)
	{
	}
}
