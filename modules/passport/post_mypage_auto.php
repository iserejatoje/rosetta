<?

if ( !$OBJECTS['user']->IsAuth() )
	$this->redirect_not_authorized();

$car_ids = App::$Request->Post['car_ids']->AsArray( array(), Request::UNSIGNED_NUM );

if ( is_array($car_ids) ) {
	LibFactory::GetStatic('filestore');

	foreach ( $car_ids as $id ) {
		try {
			$path = FileStore::GetPath_NEW($OBJECTS['user']->Profile['auto']['cars'][$id]['LargePhoto']);
			if (FileStore::IsFile($this->_config['auto_photo']['large']['path'].$path))
				FileStore::Delete_NEW($this->_config['auto_photo']['large']['path'].$path);
		} catch (MyException $e) {}

		try {
			$path = FileStore::GetPath_NEW($OBJECTS['user']->Profile['auto']['cars'][$id]['SmallPhoto']);
			if (FileStore::IsFile($this->_config['auto_photo']['small']['path'].$path))
				FileStore::Delete_NEW($this->_config['auto_photo']['small']['path'].$path);
		} catch (MyException $e) {}

		unset ($OBJECTS['user']->Profile['auto']['cars'][$id]);
	}
}

//Response::Redirect('/'.$this->_env['section'].'/mypage/auto.php');

?>