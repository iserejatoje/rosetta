<?php

	require_once ($CONFIG['engine_path'].'configure/lib/passport/error.php');
	require_once ('passport/usersmgr.php');
	require_once ('passport/user.php');
	require_once ('passport/plugins.php');
	require_once ('passport/iprofileprovider.php');
	require_once ("passport/dbprofileprovider.php");
	require_once ('passport/profilemgr.php');
	//require_once ('passport/profileprovidermgr.php');
	require_once ('passport/sessionmgr.php');
	include_once ('passport/roles.php');
	require_once ('passport/group.php');
	require_once ('passport/groupmgr.php');
	require_once ('passport/rolesmgr.php');
	require_once ('passport/util.php');
	require_once ('passport/usersiterator.php');

?>