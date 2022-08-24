<?

if ( !$OBJECTS['user']->IsAuth() )
	$this->redirect_not_authorized();

$id 				= App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
$action			 	= App::$Request->Post['action']->Value('');
$car['MarkaID'] 	= App::$Request->Post['MarkaID']->Int(0, Request::UNSIGNED_NUM);
$car['ModelID'] 	= App::$Request->Post['ModelID']->Int(0, Request::UNSIGNED_NUM);
$car['ModelName'] 	= App::$Request->Post['ModelName']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
$car['Year'] 		= App::$Request->Post['Year']->Int(0, Request::UNSIGNED_NUM);
$car['Volume'] 		= App::$Request->Post['Volume']->Int(0, Request::UNSIGNED_NUM);
$car['WheelType'] 	= App::$Request->Post['WheelType']->Int(-1, Request::UNSIGNED_NUM);
$car['Capacity'] 	= App::$Request->Post['Capacity']->Int(0, Request::UNSIGNED_NUM);


if ( $action == 'mypage_auto_edit_car' && $id == 0 )
	UserError::AddError(ERR_M_PASSPORT_AUTO_CAR_NOT_FOUND);
if ( $car['MarkaID'] == 0 || ($car['ModelID'] == 0 && empty($car['ModelName']) ) )
	UserError::AddErrorIndexed('markamodel', ERR_M_PASSPORT_AUTO_INCORRECT_MARKA_MODEL);
if ( $car['Capacity'] == 0 )
	UserError::AddErrorIndexed('capacity', ERR_M_PASSPORT_AUTO_INCORRECT_CAPACITY);
if ( $car['Year'] == 0 )
	UserError::AddErrorIndexed('year', ERR_M_PASSPORT_AUTO_INCORRECT_YEAR);
if ( $car['Volume'] == 0 )
	UserError::AddErrorIndexed('volume', ERR_M_PASSPORT_AUTO_INCORRECT_VOLUME);
if ( $car['WheelType'] == -1 )
	UserError::AddErrorIndexed('wheeltype', ERR_M_PASSPORT_AUTO_INCORRECT_WHEELTYPE);

	
if ( UserError::IsError() )
	return false;

LibFactory::GetStatic('filestore');
LibFactory::GetStatic('filemagic');

if ( $action == 'mypage_auto_edit' )
{
	$OBJECTS['user']->Profile['auto']['cars'][$id]['MarkaID'] = $car['MarkaID'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['ModelID'] = $car['ModelID'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['ModelName'] = $car['ModelName'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['Capacity'] = $car['Capacity'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['Year'] = $car['Year'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['Volume'] = $car['Volume'];
	$OBJECTS['user']->Profile['auto']['cars'][$id]['WheelType'] = $car['WheelType'];

	if (App::$Request->Post['del_photo']->Bool() === true || is_file($_FILES["Photo"]['tmp_name']) ) {
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

		$OBJECTS['user']->Profile['auto']['cars'][$id]['LargePhoto'] = '';
		$OBJECTS['user']->Profile['auto']['cars'][$id]['SmallPhoto'] = '';
	}

	if (is_file($_FILES["Photo"]['tmp_name'])) {
		$lfile = $sfile = '';
		try {
			$lfile = FileStore::Upload_NEW("Photo", $this->_config['auto_photo']['large']['path'], $OBJECTS['user']->ID,
				FileMagic::MT_WIMAGE,
				$this->_config['auto_photo']['file_size'],
				$this->_config['auto_photo']['large']['params']
			);
		} catch (MyException $e) {
			if( $e->getCode() > 0 )
				UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO);

			return false;
		}

		try {
			$sfile = FileStore::Upload_NEW("Photo", $this->_config['auto_photo']['small']['path'], $OBJECTS['user']->ID,
				FileMagic::MT_WIMAGE,
				$this->_config['auto_photo']['file_size'],
				$this->_config['auto_photo']['small']['params']
			);
		} catch (MyException $e) {
			if( $e->getCode() > 0 )
				UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO);

			try {
				$path = FileStore::GetPath_NEW($lfile);
				if (FileStore::IsFile($this->_config['auto_photo']['large']['path'].$path))
					FileStore::Delete_NEW($this->_config['auto_photo']['large']['path'].$path);
			} catch (MyException $e) {}

			return false;
		}
	}

	$OBJECTS['user']->Profile['auto']['cars'][$id]['SmallPhoto'] = $sfile;
	$OBJECTS['user']->Profile['auto']['cars'][$id]['LargePhoto'] = $lfile;
} else {
	if (is_file($_FILES["Photo"]['tmp_name'])) {
		$lfile = $sfile = '';
		try {
			$lfile = FileStore::Upload_NEW("Photo", $this->_config['auto_photo']['large']['path'], $OBJECTS['user']->ID,
				FileMagic::MT_WIMAGE,
				$this->_config['auto_photo']['file_size'],
				$this->_config['auto_photo']['large']['params']
			);
		} catch (MyException $e) {
			if( $e->getCode() > 0 )
				UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO);

			return false;
		}

		try {
			$sfile = FileStore::Upload_NEW("Photo", $this->_config['auto_photo']['small']['path'], $OBJECTS['user']->ID,
				FileMagic::MT_WIMAGE,
				$this->_config['auto_photo']['file_size'],
				$this->_config['auto_photo']['small']['params']
			);
		} catch (MyException $e) {
			if( $e->getCode() > 0 )
				UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_AUTO_CANT_UPLOAD_PHOTO);

			try {
				$path = FileStore::GetPath_NEW($lfile);
				if (FileStore::IsFile($this->_config['auto_photo']['large']['path'].$path))
					FileStore::Delete_NEW($this->_config['auto_photo']['large']['path'].$path);
			} catch (MyException $e) {}

			return false;
		}

		$car['SmallPhoto'] = $sfile;
		$car['LargePhoto'] = $lfile;
	}

	$OBJECTS['user']->Profile['auto']['cars']->Add($car);
}

Response::Redirect('/'.$this->_env['section'].'/mypage/auto.php');

?>