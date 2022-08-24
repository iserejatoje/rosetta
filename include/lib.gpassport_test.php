<?php

require_once ($CONFIG['engine_path'].'configure/lib/passport/error.php');
require_once ('passport_test/usersmgr.php');
require_once ('passport_test/user.php');
require_once ('passport_test/plugins.php');
require_once ('passport_test/iprofileprovider.php');
require_once ("passport_test/dbprofileprovider.php");
require_once ('passport_test/profilemgr.php');
//require_once ('passport/profileprovidermgr.php');
require_once ('passport_test/sessionmgr.php');
include_once ('passport_test/roles.php');
require_once ('passport_test/group.php');
require_once ('passport_test/groupmgr.php');
require_once ('passport_test/rolesmgr.php');
require_once ('passport_test/util.php');
//require_once ('passport/RoleProviderMgr.php');
if(IS_ADM == true)
{
}

?>