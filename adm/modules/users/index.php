<?php

include_once ENGINE_PATH.'include/json.php';
include_once ENGINE_PATH.'include/lib.objects.php';

// модуль использует объект пользователя и на версии бех паспорта работать не будет
class AdminModule
{
	static $TITLE = 'управление пользователями';
	static $FIELDS = array(
		'begin' => array('begin', 'DESC'),
		'end' => array('end', 'DESC'),
		'type' => array('type', 'ASC'),
		'name' => array('name', 'ASC'),
		'company' => array('company', 'ASC'));
	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 20;
	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	function __construct($config, $aconfig, $id)
	{
		$this->_id = &$id;
		$this->_config = &$config;
		$this->_aconfig = &$aconfig;
		$this->_db = DBFactory::GetInstance('passport');
	}

	function Action()
	{
		if($this->_PostAction()) return;
		$this->_GetAction();
	}

	function GetPage()
	{
		global $DCONFIG;

		switch($this->_page)
		{
		default:
			$this->_title = "Пользователи";
			$html = $this->_GetMainPage();
			break;
		}
		App::$Title->AddStyle('/resources/scripts/themes/frameworks/extjs/2.0.2/resources/css/ext-all.css');
		App::$Title->AddStyle('/resources/scripts/themes/frameworks/extjs/2.0.2/resources/css/add-all.css');
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'users', 'text' => 'Пользователи')
				),
			'selected' => $this->_page);
	}

	function GetTitle()
	{
		return $this->_title;
	}

	private function _PostAction()
	{
		global $DCONFIG;
		switch($_POST['action'])
		{
//		case 'company_create':
//			$this->_CompanyEdit(true);
//			header("location:"."?{$DCONFIG['SECTION_ID_URL']}&action=company");
//			exit(1);
		}
		return false;
	}

	private function _GetAction()
	{
		global $DCONFIG;
		switch($_GET['action'])
		{
			case 'users':
				$this->_page = 'users';
				break;

			// пользователи
			case 'usersget': // AJAX
				echo $this->AjaxUsersGet();
				exit(0);
			case 'usersprofilegetinfo': // AJAX
				echo $this->AjaxUsersProfileGetUserInfo();
				exit(0);
			case 'usersprofileblogs': // AJAX
				echo $this->AjaxUsersProfileBlogs();
				exit(0);
			case 'usersprofilephones': // AJAX
				echo $this->AjaxUsersProfilePhones();
				exit(0);
			case 'usersgetinfo': // AJAX
				echo $this->AjaxUsersGetUserInfo();
				exit(0);
			case 'usersupdateprofiletalk': // AJAX
				echo $this->AjaxUsersUpdateProfileTalk();
				exit(0);
			case 'usersupdateprofileblogs': // AJAX
				echo $this->AjaxUsersUpdateProfileBlogs();
				exit(0);
			case 'usersupdateprofilephones': // AJAX
				echo $this->AjaxUsersUpdateProfilePhones();
				exit(0);
			case 'userscreateuser': // AJAX
				echo $this->AjaxUsersCreateUser();
				exit(0);
			case 'usersupdateuser': // AJAX
				echo $this->AjaxUsersUpdateUser();
				exit(0);
			case 'usersdeleteuser': // AJAX
				echo $this->AjaxUsersDeleteUser();
				exit(0);
			case 'usersactivateuser': // AJAX
				echo $this->AjaxUsersActivateUser();
				exit(0);
			case 'usersblockuser': // AJAX
				echo $this->AjaxUsersBlockUser();
				exit(0);
			case 'usersdeluser': // AJAX
				echo $this->AjaxUsersDelUser();
				exit(0);
			case 'rolesgetforuser': // AJAX
				echo $this->AjaxRolesGetForUser();
				exit(0);
			case 'setpermissionforuser': // AJAX
				echo $this->AjaxSetPermissionForUser();
				exit(0);
			case 'groupsgetforuser': // AJAX
				echo $this->AjaxUsersGetGroups();
				exit(0);
			case 'groupssetforuser': // AJAX
				echo $this->AjaxUsersSetGroups();
				exit(0);

			// группы
			case 'groupsget': // AJAX
				echo $this->AjaxGroupGet();
				exit(0);
			case 'groupscreategroup': // AJAX
				echo $this->AjaxGroupCreate();
				exit(0);
			case 'groupsgetgroup': // AJAX
				echo $this->AjaxGroupGetGroup();
				exit(0);
			case 'groupsdeleteobj': // AJAX
				echo $this->AjaxGroupDeleteObj();
				exit(0);
			case 'groupsupdategroup': // AJAX
				echo $this->AjaxGroupUpdate();
				exit(0);
			case 'groupblock': // AJAX
				echo $this->AjaxGroupBlock();
				exit(0);
			case 'rolesgetforgroup': // AJAX
				echo $this->AjaxRolesGetForGroup();
				exit(0);
			//case 'groupsaverolesforgroup': // AJAX
			//	echo $this->AjaxGroupSaveRolesForGroup();
			//	exit(0);
			case 'setpermissionforgroup': // AJAX
				echo $this->AjaxSetPermissionForGroup();
				exit(0);

			// роли
			case 'rolesgettree': // AJAX
				echo $this->AjaxRolesGetTree($_REQUEST['isfull'] == 'true'?true:false, $_REQUEST['withperm'] == 'true'?true:false);
				exit(0);
			case 'rolescreaterole': // AJAX
				echo $this->AjaxRoleCreate();
				exit(0);
			case 'rolescreatefolder': // AJAX
				echo $this->AjaxRoleCreateFolder();
				exit(0);
			case 'rolesdeleteobj': // AJAX
				echo $this->AjaxRoleDeleteObj();
				exit(0);
			case 'rolesupdaterole': // AJAX
				echo $this->AjaxRoleUpdate();
				exit(0);
			case 'rolesgetrole': // AJAX
				echo $this->AjaxRolesGetRole();
				exit(0);
			case 'rolesgetfolder': // AJAX
				echo $this->AjaxRolesGetFolder();
				exit(0);
			case 'rolesupdatefolder': // AJAX
				echo $this->AjaxRoleUpdateFolder();
				exit(0);

			case 'objectsgettree':
				echo $this->AjaxGetObjectsTree();
				exit(0);

			// вообще левые действия
			case 'deletefromforumforuser':
				echo $this->AjaxDeleteFromForumForUser();
				exit(0);

			default:
				$this->_page = 'users';
				break;
		}
	}

	private function AjaxUsersBlockUser()
	{
		global $OBJECTS;

		$id = $_REQUEST['userid'];
		if(!is_numeric($id) || $id <= 0)
			return $this->SendError('Вы не можете изменить блокировку для этого пользователя', 'Внимание!');

		PUsersMgr::Block($id, $_REQUEST['block']==1?true:false);
		
		return $this->SendOk();
	}

	private function AjaxUsersDelUser()
	{
		global $OBJECTS;
		$id = $_REQUEST['userid'];
		if(!is_numeric($id) || $id <= 0)
			return $this->SendError('Вы не можете изменить блокировку для этого пользователя', 'Внимание!');

		PUsersMgr::Delete($id, $_REQUEST['del']==1?1:0);
		return $this->SendOk();
	}

	private function AjaxUsersDeleteUser()
	{
		global $OBJECTS;
		$id = $_REQUEST['userid'];
		if(!is_numeric($id) || $id <= 0)
			return $this->SendError('Вы не можете удалить этого пользователя', 'Внимание!');
		
		PUsersMgr::Remove($id);
		return $this->SendOk();
	}

	private function AjaxUsersActivateUser()
	{
		global $OBJECTS;
		$id = $_REQUEST['userid'];
		if(!is_numeric($id) || $id <= 0)
			return $this->SendError('Вы не можете удалить этого пользователя', 'Внимание!');

		$code = PUsersMgr::ActivationCodeRemember($id, 1);
		if (!$code)
			$code = intval(PUsersMgr::ActivationCodeRemember($id, 2));
		if ($code)
		{
			PUsersMgr::Activate($code);
			return $this->SendError('Пользователь успешно активирован', 'Информация');
		}
		else
			return $this->SendError('Пользователь уже активирован', 'Внимание!');
	}

	private function AjaxUsersUpdateProfileTalk()
	{
		global $OBJECTS;

		if (null != ($user = $OBJECTS['usersMgr']->GetUser($_REQUEST['userid']))) {
			$signature 	= trim(strip_tags($_REQUEST['signature']));
			$signaturecommerce 	= trim($_REQUEST['signaturecommerce']);

			$user->Profile['themes']['talk']['signature'] = $signature;
			$user->Profile['themes']['talk']['signaturecommerce'] = $signaturecommerce;
		}

		return $this->SendOk();
	}

	private function AjaxUsersUpdateProfileBlogs()
	{
		global $OBJECTS;

		if (null != ($user = $OBJECTS['usersMgr']->GetUser($_REQUEST['userid']))) {
			$ismain 	= intval($_REQUEST['ismain']) > 0 ? 1 : 0;
                        $position       = trim(strip_tags($_REQUEST['position']));
                      
			$user->Profile['themes']['blogs']['ismain'] = $ismain;
                        $user->Profile['themes']['blogs']['position'] = $position;
			LibFactory::GetMStatic('diaries', 'diarymgr');
			$diaries = DiaryMgr::getInstance()->GetDiariesByUser($user->ID);
			
			if ($diaries !== null)
			{
				foreach($diaries as $diary)
				{
					$diary->IsMain = $ismain;
					$diary->Update();
				}
			}
		}

		return $this->SendOk();
	}
	
	private function AjaxUsersUpdateProfilePhones()
	{
		global $OBJECTS;
		
		$user = $OBJECTS['usersMgr']->GetUser($_REQUEST['userid']);
		if ($user === null)
			return $this->SendError('Пользователь не найден', 'Ошибка'); 
		
		$phone = trim(strip_tags($_REQUEST['phone']));
		
		if ($phone == "")
		{	
			$user->Plugins->Phones->Remove();
		}
		else
		{
			LibFactory::GetStatic('data');
			if (!Data::Is_Phone($phone))            
				return $this->SendError('Ошибка в номере телефона', 'Информация');
			
			$current_phone = $user->Plugins->Phones->GetPhone();
			if ($current_phone != "" && $current_phone == $phone)
				return $this->SendError('Номер уже зарегистрирован и подтверждён', 'Информация');
									
			$registered = $user->Plugins->Phones->Register($phone);
			if ($registered === false)
				return $this->SendError('Ошибка регистрации номера телефона', 'Информация');
		}
		

		return $this->SendOk();
	}
	
	private function AjaxUsersCreateUser()
	{
		global $OBJECTS;

		$email 		= trim(strip_tags($_REQUEST['email']));
		$ouremail 	= trim(strip_tags($_REQUEST['ouremail']));
		$password 	= trim(strip_tags($_REQUEST['password']));
		$question 	= trim(strip_tags($_REQUEST['question']));
		$answer 	= trim(strip_tags($_REQUEST['answer']));
		$regionid 	= intval($_REQUEST['reqionid']);

		if(empty($email))
			return $this->SendError('Почтовый ящик не может быть пустым', 'Внимание!');
		elseif(PUsersMgr::IsEMailExists($email))
			return $this->SendError('Почтовый ящик '.$email.' уже зарегистрирован', 'Внимание!');

		if(!empty($ouremail) && PUsersMgr::IsEMailExists($ouremail))
			return $this->SendError('Почтовый ящик '.$ouremail.' уже зарегистрирован', 'Внимание!');

		$salt = Data::GetRandStr(16);

		$id = $OBJECTS['usersMgr']->Add(array(
			'Email' 	=> $email,
			'OurEmail' 	=> $ouremail,
			'Password' 	=> $password,
			'Salt' 		=> $salt,
			'Question' 	=> $question,
			'Answer' 	=> $answer,
			'Blocked' 	=> $_REQUEST['blocked'],
			'RegionID'	=> $regionid,
		));
		if($id === null)
			return $this->SendError('Пользователь с таким почтовым ящиком уже существует', 'Внимание!');
		return $this->SendOk();
	}

	private function AjaxUsersUpdateUser()
	{
		global $OBJECTS;

		$email 		= trim(strip_tags($_REQUEST['email']));
		$ouremail 	= trim(strip_tags($_REQUEST['ouremail']));
		$password 	= trim(strip_tags($_REQUEST['password']));
		$question 	= trim(strip_tags($_REQUEST['question']));
		$answer 	= trim(strip_tags($_REQUEST['answer']));
		$regionid 	= intval($_REQUEST['regionid']);

		if(empty($email))
			return $this->SendError('Почтовый ящик не может быть пустым', 'Внимание!');
		elseif(PUsersMgr::IsEMailExists($email, '', $_REQUEST['userid']))
			return $this->SendError('Почтовый ящик '.$email.' уже зарегистрирован', 'Внимание!');

		if(!empty($ouremail) && PUsersMgr::IsEMailExists($ouremail, '', $_REQUEST['userid']))
			return $this->SendError('Почтовый ящик '.$ouremail.' уже зарегистрирован', 'Внимание!');

		$salt = Data::GetRandStr(16);

		$OBJECTS['usersMgr']->UpdateByID(array(
			'ID' 		=> $_REQUEST['userid'],
			'Email' 	=> $email,
			'OurEmail' 	=> $ouremail,
			'Password' 	=> $password,
			'Salt' 		=> $salt,
			'Question' 	=> $question,
			'Answer' 	=> $answer,
			'Blocked' 	=> $_REQUEST['blocked'],
			'RegionID'	=> $regionid,
		));

		return $this->SendOk();
	}

	private function AjaxUsersProfileGetUserInfo()
	{
		global $OBJECTS;

		$userid = -1;
		if(is_numeric($_REQUEST['userid']))
			$userid = intval($_REQUEST['userid']);

		if($userid == 0)
			return $this->SendError('Вы не можете изменить данные для пользователя гость', 'Внимание!');

		$ui = null;
		if($userid != -1)
		{
			if (null != ($user = $OBJECTS['usersMgr']->GetUser($userid))) {
				$profile = $user->Profile['themes']['talk'];

				$ui = array(
					'UserID' => $userid,
					'EMail' => $user->Email
				);
				foreach(array('signature','signaturecommerce') as $k) {
					$ui[$k] = $profile[$k];
				};
			}
		}

		if($userid == -1 || $ui == null)
			$this->SendError('Пользователь не найден', 'Внимание!');

		return $this->SendOk($ui);
	}
	
	private function AjaxUsersProfileBlogs()
	{
		global $OBJECTS;

		$userid = -1;
		if(is_numeric($_REQUEST['userid']))
			$userid = intval($_REQUEST['userid']);

		if($userid == 0)
			return $this->SendError('Вы не можете изменить данные для пользователя гость', 'Внимание!');

		$ui = null;
		if($userid != -1)
		{
			if (null != ($user = $OBJECTS['usersMgr']->GetUser($userid))) {
				
				$ui = array(
					'UserID' 	=> $userid,
					'EMail' 	=> $user->Email,
					'ismain'	=> $user->Profile['themes']['blogs']['ismain'],
                                        'position'	=> $user->Profile['themes']['blogs']['position'],
				);
				
			}
		}

		if($userid == -1 || $ui == null)
			$this->SendError('Пользователь не найден', 'Внимание!');

		return $this->SendOk($ui);
	}
	
	private function AjaxUsersProfilePhones()
	{
		global $OBJECTS;

		$userid = -1;
		if (is_numeric($_REQUEST['userid']))
			$userid = intval($_REQUEST['userid']);
		else
			return $this->SendError('Пользователь не найден', 'Внимание!');

		if ($userid == 0)
			return $this->SendError('Вы не можете изменить данные для пользователя гость', 'Внимание!');
				
		$user = $OBJECTS['usersMgr']->GetUser($userid);		
		if ($user === null)
			return $this->SendError('Пользователь не найден', 'Внимание!');
			
		$phone = $user->Plugins->Phones->GetPhone();				
			
		$ui = array(
			'UserID' 	=> $userid,
			'Email' 	=> $user->Email,
			'phone'		=> $phone,
		);
		
		return $this->SendOk($ui);
	}

	private function AjaxUsersGetUserInfo()
	{
		global $OBJECTS;
		$userid = -1;
		if(is_numeric($_REQUEST['userid']))
			$userid = intval($_REQUEST['userid']);

		if($userid == 0)
			return $this->SendError('Вы не можете изменить данные для пользователя гость', 'Внимание!');

		$ui = null;
		if($userid != -1)
		{
			$ui = $OBJECTS['usersMgr']->GetUserInfoArray($userid);
			$ui['ShowName'] = $OBJECTS['usersMgr']->GetUser($userid)->Profile['general']['ShowName'];
		}

		if($userid == -1 || $ui == null)
			$this->SendError('Пользователь не найден', 'Внимание!');


		return $this->SendOk($ui);
	}

	private function AjaxUsersGet()
	{
		global $OBJECTS;
		$json = new Services_JSON();		

		$filter['id'] = -1;
		if(is_numeric($_REQUEST['userid']))
			$filter['id'] = intval($_REQUEST['userid']);

		$filter['email'] = trim($_REQUEST['email']);

		$filter['ouremail'] = trim($_REQUEST['ouremail']);

		if(isset($_REQUEST['sort']))
			$filter['field'] = $_REQUEST['sort'];

		if(isset($_REQUEST['group']))
			$filter['group'] = intval($_REQUEST['group']);
		else
			$filter['group'] = 0;

		if(isset($_REQUEST['dir']))
			$filter['dir'] = $_REQUEST['dir'];

		$filter['offset'] = intval($_REQUEST['start']);
		$filter['limit'] = intval($_REQUEST['limit']);
		if($filter['offset'] < 0)
			$filter['offset'] = 0;
		if($filter['limit'] < 0)
			$filter['limit'] = 50;

		$filter['isdel'] = -1;

		$users = $OBJECTS['usersMgr']->GetUsers($filter);

		$uis = array();
		foreach($users as $user)
		{
			$ui = $OBJECTS['usersMgr']->GetUserInfoArray($user['id']);
			$ui['ShowName'] = $OBJECTS['usersMgr']->GetUser($user['id'])->Profile['general']['ShowName'];
			if($ui !== null)
				$uis[] = $ui;
		}
		return $json->encode(array('users' => $uis, 'count' => $OBJECTS['usersMgr']->GetUsersCount($filter)));
	}

	private function AjaxGroupUpdate()
	{
		$id = intval($_REQUEST['id']);
		$name = trim(strip_tags($_REQUEST['name']));
		$description = trim(strip_tags($_REQUEST['description']));

		PGroupMgr::Update($id, $name, $description);
		return $this->SendOk(array('text' => $name, 'qtip' => $description, 'id' => $node, 'leaf'=>false, 'type' => 'group'));
	}

	private function AjaxGroupBlock()
	{
		$id = intval($_REQUEST['id']);
		$name = trim(strip_tags($_REQUEST['name']));
		$description = trim(strip_tags($_REQUEST['description']));

		PGroupMgr::Block($id, $_REQUEST['block']==0?false:true);
		return $this->SendOk();
	}

	private function AjaxGroupDeleteObj()
	{
		$id = intval($_REQUEST['id']);
		if(PGroupMgr::Remove($id) == false)
			return $this->SendError("Не удалось удалить группу.", "Внимание!");
		return $this->SendOk();
	}

	private function AjaxGroupCreate()
	{
		$name = trim(strip_tags($_REQUEST['name']));
		$description = trim(strip_tags($_REQUEST['description']));

		$id = PGroupMgr::Create($name, $description, $parent);
		return $this->SendOk(array('text' => $name, 'qtip' => $description, 'id' => $id, 'leaf'=>false, 'type' => 'group'));
	}

	private function AjaxUsersGetGroups()
	{
		$json = new Services_JSON();		

		$user = intval($_REQUEST['userid']);

		$gsu = PGroupMgr::GetGroupsForUser($user);

		$groups = PGroupMgr::GetGroups();
		foreach($groups as $k => $v)
		{
			if(in_array($v['GroupID'], $gsu))
				$groups[$k]['IsSet'] = 1;
			else
				$groups[$k]['IsSet'] = 0;

		}

		return $json->encode(array('groups' => $groups, 'count' => sizeof($groups)));
	}

	private function AjaxGroupGet()
	{
		$parent = intval($_REQUEST['node']);
		$groups = PGroupMgr::GetGroups();

		$json = new Services_JSON();
		
		array_unshift($groups, array(
			'GroupID' => 0,
			'Name' => ' - Любая - ',
			'Description' => '',
			'Blocked' => 0,
		));

		return $json->encode(array('groups' => $groups, 'count' => count($groups)));
	}

	private function AjaxGroupGetGroup()
	{
		$id = intval($_REQUEST['id']);
		$group = PGroupMgr::GetGroup($id);
		if($group === false)
			return $this->SendError('Группа не найдена', 'Внимание!');

		return $this->SendOk(array('name' => $group->Name, 'description' => $group->Description, 'id' => $node));
	}

	private function AjaxSetPermissionForUser()
	{
		$nr = explode('|', $_REQUEST['object'], 2);
		$otype = substr($nr[0], 0, 1);
		$obj = intval(substr($nr[0], 1));
		$user = intval($_REQUEST['user']);
		$rtype = substr($_REQUEST['role'], 0, 1);
		$role = intval(substr($_REQUEST['role'], 1));
		$permission = intval($_REQUEST['permission']);
		$addkey = $nr[1];

		if($rtype == 'r')
		{
			PRolesMgr::SetRoleForUser($user, $obj, $role, $addkey, $permission);
			return $this->SendOk(array('role' => $_REQUEST['role'], 'permission' => $permission));
		}
		else
			$this->SendOk(array('role' => '', 'permission' => 0));
	}

	private function AjaxUsersSetGroups()
	{
		$user = intval($_REQUEST['user']);
		$group = intval($_REQUEST['group']);
		$isset = intval($_REQUEST['isset']);

		if($user >= 0 && $group >= 0 && ($isset == 0 || $isset == 1))
			PGroupMgr::SetGroupsForUser($user, $group, $isset==1);
		return $this->SendOk();
	}

	private function AjaxSetPermissionForGroup()
	{
		$nr = explode('|', $_REQUEST['object'], 2);
		$otype = substr($nr[0], 0, 1);
		$obj = intval(substr($nr[0], 1));
		$group = intval($_REQUEST['group']);
		$rtype = substr($_REQUEST['role'], 0, 1);
		$role = intval(substr($_REQUEST['role'], 1));
		$permission = intval($_REQUEST['permission']);
		$addkey = $nr[1];

		if($rtype == 'r')
		{
			$__ = "SetRoleForGroup($group, $obj, $role, $addkey, $permission)";
			PRolesMgr::SetRoleForGroup($group, $obj, $role, $addkey, $permission);
			return $this->SendOk(array('role' => $_REQUEST['role'], 'permission' => $permission,'ex' => $__));
		}
		else
			$this->SendOk(array('role' => '', 'permission' => 0));
	}

	private function AjaxRoleDeleteObj()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$node = intval(substr($_REQUEST['node'], 1));
		if($type == 'r')
			PRoles::Remove($node);
		else if($type == 'f')
		{
			$tree = PRoles::GetTree();
			if($node != 0)
				$_node = $tree->FindById($node);
			else
				$_node = $tree;
			$roles = PRoles::GetRoles();
			if(count($_node->Nodes) == 0 && count($roles[$node]) == 0)
				PRoles::RemoveFolder($node);
			else
				return $this->SendError("Данная папка не пуста, вы не можете удалить ее.", "Внимание!");
		}
		return $this->SendOk();
	}

	private function AjaxRolesGetRole()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$node = intval(substr($_REQUEST['node'], 1));
		if($type != 'r')
			return $this->SendError("Ошибка запроса данных", "Внимание!");

		$roles = PRoles::GetRoles(-1, 'RoleID');

		return $this->SendOk(array('name' => $roles[$node]['Name'], 'russian_name' => $roles[$node]['RussianName'], 'description' => $roles[$node]['Description'], 'id' => 'r'.$node));
	}

	private function AjaxRolesGetFolder()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$node = intval(substr($_REQUEST['node'], 1));
		if($type != 'f')
			return $this->SendError("Ошибка запроса данных", "Внимание!");

		$folders = PRoles::GetFolders();

		return $this->SendOk(array('name' => $folders[$node]['Name'], 'description' => $folders[$node]['Description'], 'id' => 'f'.$node));
	}

	private function AjaxRoleUpdateFolder()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$node = intval(substr($_REQUEST['node'], 1));
		if($type != 'f')
			return $this->SendError("Ошибка запроса данных", "Внимание!");
		$name = addslashes(trim(strip_tags($_REQUEST['name'])));
		$description = addslashes(trim(strip_tags($_REQUEST['description'])));

		PRoles::UpdateFolder($node, $name, $description);
		return $this->SendOk(array('text' => $name, 'qtip' => $description, 'id' => 'f'.$node, 'leaf'=>false, 'type' => 'folder'));
	}

	private function AjaxRoleUpdate()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$node = intval(substr($_REQUEST['node'], 1));
		if($type != 'r')
			return $this->SendError("Ошибка запроса данных", "Внимание!");
		$name = addslashes(trim(strip_tags($_REQUEST['name'])));
		$russian_name = addslashes(trim(strip_tags($_REQUEST['russian_name'])));
		$description = addslashes(trim(strip_tags($_REQUEST['description'])));

		PRoles::Update($node, $russian_name, $description);
		return $this->SendOk(array('text' => $russian_name.' ('.$name.')', 'qtip' => $description, 'id' => 'r'.$node, 'leaf'=>true, 'iconCls' => 'users-roles-tree-role', 'type' => 'role'));
	}

	private function AjaxRoleCreate()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$parent = intval(substr($_REQUEST['node'], 1));
		if($type != 'f')
			return $this->SendError("Ошибка запроса данных", "Внимание!");
			
		if (!$parent)
			return $this->SendError('Неудалось добавить роль.', 'Внимание!');

		$name = addslashes(trim(strip_tags($_REQUEST['name'])));
		$russian_name = addslashes(trim(strip_tags($_REQUEST['russian_name'])));
		$description = addslashes(trim(strip_tags($_REQUEST['description'])));

		$id = PRoles::Add($name, $russian_name, $description, $parent);
		if($id == 0)
			return $this->SendError('Неудалось добавить роль.', 'Внимание!');
		else if($id == -1)
			return $this->SendError('Роль с данным именем уже существует.', 'Внимание!');
		else
			return $this->SendOk(array('text' => $russian_name.' ('.$name.')', 'qtip' => $description, 'id' => 'r'.$id, 'leaf'=>true, 'iconCls' => 'users-roles-tree-role', 'type' => 'role'));
	}

	private function AjaxRoleCreateFolder()
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$parent = intval(substr($_REQUEST['node'], 1));
		if($type != 'f')
			return $this->SendError("Ошибка запроса данных", "Внимание!");
		$name = addslashes(trim(strip_tags($_REQUEST['name'])));
		$description = addslashes(trim(strip_tags($_REQUEST['description'])));

		$id = PRoles::AddFolder($name, $description, $parent);
		return $this->SendOk(array('text' => $name, 'qtip' => $description, 'id' => 'f'.$id, 'leaf'=>false, 'type' => 'folder'));
	}

	private function AjaxRolesGetForGroup()
	{
		$group = intval($_REQUEST['group']);

		$nr = explode('|', $_REQUEST['object'], 2);
		$type = substr($nr[0], 0, 1);
		$object = intval(substr($nr[0], 1));
		if($type != 'o')
			return $json->encode(array(''));
		$addkey = $nr[1];

		$groles = PRolesMgr::GetRolesForGroupAndSection($group, $object, $addkey);

		$roles = array();
		foreach($groles as $role)
		{
			$roles['r'.$role['RoleID']] = $role['Action'];
		}

		return $this->SendOk($roles);
	}

	private function AjaxRolesGetForUser()
	{
		$nr = explode('|', $_REQUEST['object'], 2);
		$user = intval($_REQUEST['user']);
		$type = substr($nr[0], 0, 1);
		$object = intval(substr($nr[0], 1));
		if($type != 'o')
			return $json->encode(array(''));
		$addkey = $nr[1];

		$groles = PRolesMgr::GetRolesForUserAndSection($user, $object, $addkey);

		$roles = array();
		foreach($groles as $role)
		{
			$roles['r'.$role['RoleID']] = $role['Action'];
		}

		return $this->SendOk($roles);
	}

	private function getTreeForGroup($groles, $roles, $otree, $rtree)
	{
		$nodes = array();
		if(count($node->Nodes))
			foreach($node->Nodes as $n)
			{
				if($n->Data['Type'] == 0 || $n->Data['Type'] == 1)
					$nodes[] =  array('text' => $n->Data['Name'], 'id' => 'o'.$n->Id, 'leaf'=>false, 'type' => 'ofolder', 'children' => $this->genObjectsTree($n));
				else if($n->Data['Type'] == 2 || $n->Data['Type'] == 3)
					$nodes[] =  array('text' => $n->Data['Name'], 'id' => 'o'.$n->Id, 'leaf'=>true, 'type' => 'object', 'iconCls' => 'users-roles-tree-object');
			}
		else
			return null;
		return $nodes;
	}

	private function getTreeForGroup_n($node, $roles)
	{
		$nodes = array();
		if(count($node->Nodes) == 0 && count($roles[$node->Id]) == 0)
			return null;
		// папки
		if(count($node->Nodes))
			foreach($node->Nodes as $n)
			{
				$cnodes = $this->genRolesTree($n, $roles);
				if(count($cnodes))
					$nodes[] =  array('text' => $n->Data['Name'], 'qtip' => $n->Data['Description'], 'id' => 'f'.$n->Id, 'leaf'=>false, 'type' => 'folder', 'children' => $cnodes);
			}

		// роли
		if(count($roles[$node->Id]))
			foreach($roles[$node->Id] as $n)
				$nodes[] =  array('text' => $n['RussianName'].' ('.$n['Name'].')', 'qtip' => $n['Description'], 'id' => 'r'.$n['RoleID'], 'leaf'=>true, 'iconCls' => 'users-roles-tree-role', 'type' => 'role');
		return $nodes;
	}

	private function AjaxGetObjectsTree()
	{
		$rn = explode('|',$_REQUEST['node'],2);
		$type = substr($rn[0], 0, 1);
		$parent = intval(substr($rn[0], 1));
		if($type != 'o')
			return $json->encode(array(''));
		$addkey = $rn[1];
		$objs = new WebObjects();
		$tree = $objs->GetTree();
		if($parent != 0)
			$node = $tree->FindById($parent);
		else
			$node = $tree;

		$json = new Services_JSON();
		
		// папки
		$nodes = $this->genObjectsTree($node, $addkey);

		return $json->encode($nodes);
	}

	private function genObjectsTree($node, $addkey)
	{
		$nodes = array();
		if($node->Data['Type'] == 2 || $node->Data['Type'] == 3 || $node->Data['Type'] == 4)
		{
			LibFactory::GetStatic('subsection');
			$ssprov = SubsectionProviderFactory::GetInstance($node->Id);
			if($ssprov !== null)
			{
				$stree = $ssprov->GetTree();

				if(strlen($addkey) === 0)
					$snode = $stree;
				else
					$snode = $stree->FindById($addkey);

				if($snode != false)
				{
					if(count($snode->Nodes))
						foreach($snode->Nodes as $n)
						{
							$nodes[] =  array('text' => $n->Data['name'], 'id' => 'o'.$node->Id.'|'.$n->Id, 'leaf'=>false, 'type' => 'subsection');
						}
				}
			}
			else
				return null;
		}
		else
		{
			if(count($node->Nodes))
			{
				foreach($node->Nodes as $n)
				{
					if($n->Data['Type'] == 0 || $n->Data['Type'] == 1)
						$nodes[] =  array('text' => $n->Data['Name'], 'id' => 'o'.$n->Id, 'leaf'=>false, 'type' => 'ofolder');
					else if($n->Data['Type'] == 2 || $n->Data['Type'] == 3 || $n->Data['Type'] == 4)
						$nodes[] =  array('text' => $n->Data['Name'], 'id' => 'o'.$n->Id, 'leaf'=>false, 'type' => 'object', 'iconCls' => 'users-roles-tree-object');
				}
			}
			else
				return null;
		}
		return $nodes;
	}

	private function AjaxRolesGetTree($full = false, $withperm = false)
	{
		$type = substr($_REQUEST['node'], 0, 1);
		$parent = intval(substr($_REQUEST['node'], 1));
		if($type != 'f')
			return $json->encode(array(''));
		
		$tree = PRoles::GetTree();
		if($parent != 0)
			$node = $tree->FindById($parent);
		else
			$node = $tree;

		$object = null;
		$group = null;
		if($withperm === true)
		{
			$otype = substr($_REQUEST['object'], 0, 1);
			if($otype == 'o')
			{
				$object = intval(substr($_REQUEST['object'], 1));
				$group = intval($_REQUEST['group']);
			}
		}

		$roles = PRoles::GetRoles($parent);
		
		$json = new Services_JSON();

		$nodes = $this->genRolesTree($node, $roles, $full, $object, $group);

		return $json->encode($nodes);
	}

	private function genRolesTree($node, $roles, $full = false, $object = null, $group = null)
	{
		$nodes = array();
		if(count($node->Nodes) == 0 && count($roles[$node->Id]) == 0)
			return null;
		// папки
		if(count($node->Nodes))
			foreach($node->Nodes as $n)
			{
				$cnodes = $full==true?$this->genRolesTree($n, $roles, $full):null;
				if($full == true && count($cnodes) == 0)
					$leaf = true;
				else
					$leaf = false;
				$nodes[] =  array('text' => $n->Data['Name'], 'qtip' => $n->Data['Description'], 'id' => 'f'.$n->Id, 'leaf'=>$leaf, 'type' => 'folder', 'children' => $cnodes);
			}

		// роли
		if($object !== null)
			$roles_perm = PRolesMgr::GetRolesForObject($group, $object);
		
		if(is_array($roles[$node->Id]) && count($roles[$node->Id]))
			foreach($roles[$node->Id] as $n)
				if($object !== null)
				{
					if(isset($roles_perm[$n['RoleID']]))
						$perm = $roles_perm[$n['RoleID']]['Action'];
					else
						$perm = 0;
					$nodes[] =  array('text' => $n['RussianName'].' ('.$n['Name'].')', 'qtip' => $n['Description'], 'id' => 'r'.$n['RoleID'], 'leaf'=>true, 'iconCls' => 'users-roles-tree-role', 'type' => 'role', 'permission' => $perm, 'uiProvider' => 'col');
				}
				else
					$nodes[] =  array('text' => $n['RussianName'].' ('.$n['Name'].')', 'qtip' => $n['Description'], 'id' => 'r'.$n['RoleID'], 'leaf'=>true, 'iconCls' => 'users-roles-tree-role', 'type' => 'role');
		return $nodes;
	}

	private function SendError($error, $title = 'Ошибка')
	{
		$json = new Services_JSON();		
		return $json->encode(array('status' => 'error', 'message' => $error, 'title' => $title));
	}

	private function SendOk($data = array())
	{
		$json = new Services_JSON();		
		return $json->encode(array('status' => 'ok', 'data' => $data));
	}

	private function _GetMainPage()
	{
		global $DCONFIG;
		return $DCONFIG['tpl']->fetch('users/users_main.tpl');
	}

	// левые функции
	private function AjaxDeleteFromForumForUser()
	{
		$userid = intval($_REQUEST['userid']);
		if($userid > 0)
		{
			// при нынешнем хранении файлов по форумам, удалить их невозможно
			$db = DBFactory::GetInstance('rugion_forum');
			$sql = "SELECT count(*) FROM messages";
			$sql.= " WHERE is_theme=0 AND is_del=0 AND visible=1 AND user=".$userid;
			$res = $db->query($sql);
			if($row = $res->fetch_row())
				$messages = $row[0];
			else
				$messages = 0;

			$sql = "SELECT count(*) FROM themes";
			$sql.= " WHERE is_del=0 AND visible=1 AND user=".$userid;
			$res = $db->query($sql);
			if($row = $res->fetch_row())
				$themes = $row[0];
			else
				$themes = 0;

			$sql = "UPDATE messages";
			$sql.= " SET is_del=1";
			$sql.= " WHERE is_theme=0 AND is_del=0 AND visible=1 AND user=".$userid;
			$db->query($sql);

			$sql = "UPDATE themes";
			$sql.= " SET is_del=1";
			$sql.= " WHERE is_del=0 AND visible=1 AND user=".$userid;
			$db->query($sql);

			return $this->SendOk(array('messages' => $messages, 'themes' => $themes));
		}
		else
			return $this->SendError('Пользователь не указан');
	}
}

?>
