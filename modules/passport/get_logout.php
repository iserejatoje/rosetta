<?

if(isset($_GET['ALL'])) {
		$con2 = mysqli_connect("localhost",'ipkhratd_tech', 'mTpoofdA', 'ipkhratd_tech');
			$query = "INSERT INTO logoutall(email) VALUES ('admin@rosetta.ru')";
			$getLogout = mysqli_query($con2, $query);
			$query = "INSERT INTO logoutall(email) VALUES ('shop@rosetta.pro')";
			$getLogout = mysqli_query($con2, $query);
			$query = "INSERT INTO logoutall(email) VALUES ('test@gmail.com')";
			$getLogout = mysqli_query($con2, $query);
			$query = "INSERT INTO logoutall(email) VALUES ('settings@gmail.com')";
			$getLogout = mysqli_query($con2, $query);
			$query = "INSERT INTO logoutall(email) VALUES ('info@atom.st')";
			$getLogout = mysqli_query($con2, $query);
		//result = mysqli_fetch_array($getLogout);
		//$OBJECTS['user']->LogoutAll($usersObjects);
		//$OBJECTS['usersMgr']->LogoutAll($OBJECTS['usersMgr']->GetUsers());
		//$OBJECTS['usersMgr']->LogoutAll(App::$User->ID,App::$User->SessionCode);
} else {
	if($OBJECTS['user']->IsAuth())
	{
		// EventMgr::Raise('passport/user/logout', array(
		// 	'userid' => $OBJECTS['user']->ID,
		// ));
		$OBJECTS['user']->Logout();
	}

	$url = App::$Request->Get['url']->Url(false, false);

	if( $url !== false) {
		Response::Redirect( $url );
  }	else {
	  Response::Redirect('/'.$this->_env['section'].'/'.$this->_config['files']['get']['login']['string']);
	}
}
?>
