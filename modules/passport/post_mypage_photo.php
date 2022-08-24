<?

if(!$OBJECTS['user']->IsAuth())
	$this->redirect_not_authorized();
	
$is_del_avatar = false;
$is_del_photo  = false;

if(App::$Request->Post['del_avatar']->Int(0) == 1 || is_file($_FILES['avatar']['tmp_name']))
	$is_del_avatar = true;
	
if(App::$Request->Post['del_photo']->Int(0) == 1 || is_file($_FILES['photo']['tmp_name']))
	$is_del_photo  = true;

$ChangedFields = array();
if( $is_del_avatar === true)
{
	LibFactory::GetStatic('filestore');
	if (!empty(App::$User->Profile['general']['Avatar'])) {
		
		try
		{
			if( ($img_obj = FileStore::ObjectFromString(App::$User->Profile['general']['Avatar'])) !== false )
			{
				$del_file = FileStore::GetPath_NEW($img_obj['file']);
				$del_file = App::$User->Profile['general']['Avatar_Path'] . $del_file;
				if (FileStore::IsFile($del_file))
					FileStore::Delete_NEW($del_file);
				App::$User->Profile['general']['Avatar'] = '';
			}
		}
		catch (MyException $e) { }
	}

	if (!empty(App::$User->Profile['general']['AvatarSmall'])) {
		try
		{
			if( ($img_obj = FileStore::ObjectFromString(App::$User->Profile['general']['AvatarSmall'])) !== false )
			{
				$del_file = FileStore::GetPath_NEW($img_obj['file']);
				$del_file = App::$User->Profile['general']['Avatar_Small_Path'] . $del_file;
				if (FileStore::IsFile($del_file))
					FileStore::Delete_NEW($del_file);
				App::$User->Profile['general']['AvatarSmall'] = '';
			}
		}
		catch (MyException $e) { }
	}
}

if( $is_del_photo === true)
{
	LibFactory::GetStatic('filestore');
	if (!empty(App::$User->Profile['general']['Photo'])) {
	
		try
		{
			if( ($img_obj = FileStore::ObjectFromString(App::$User->Profile['general']['Photo'])) !== false )
			{
				$del_file = FileStore::GetPath_NEW($img_obj['file']);
				$del_file = App::$User->Profile['general']['Photo_Path'] . $del_file;
				if (FileStore::IsFile($del_file))
					FileStore::Delete_NEW($del_file);
				App::$User->Profile['general']['Photo'] = '';
			}
		}
		catch (MyException $e) { }
	}

	App::$User->Profile['general']['Photo'] = '';
}

// загружаем аватар
if( is_file($_FILES['avatar']['tmp_name']) )
{
    LibFactory::GetStatic('filestore');
    LibFactory::GetStatic('filemagic');
    LibFactory::GetStatic('images');

	$lfile = $sfile = '';
    try
    {
        $lfile = FileStore::Upload_NEW('avatar', App::$User->Profile['general']['Avatar_Path'],
            App::$User->ID.'_'.rand(100, 999), FileMagic::MT_WIMAGE,
            App::$User->Profile['general']['avatar_file_size'],
            App::$User->Profile['general']['avatar_upload_options']
		);
		
		$lfile = FileStore::GetPath_NEW($lfile);
		$avatarObj = Images::PrepareImageToObject($lfile, App::$User->Profile['general']['Avatar_Path']);
		$lfile = FileStore::ObjectToString($avatarObj);

		$sfile = FileStore::Upload_NEW('avatar', App::$User->Profile['general']['Avatar_Small_Path'],
            App::$User->ID.'_'.rand(100, 999), FileMagic::MT_WIMAGE,
            App::$User->Profile['general']['avatar_small_file_size'],
            App::$User->Profile['general']['avatar_small_upload_options']
		);
		
		$sfile = FileStore::GetPath_NEW($sfile);
		$avatarSmallObj = Images::PrepareImageToObject($sfile, App::$User->Profile['general']['Avatar_Small_Path']);
		$sfile = FileStore::ObjectToString($avatarSmallObj);
    }
    catch (MyException $e)
    {
        if( $e->getCode() > 0 )
            UserError::AddErrorWithArgsIndexed('avatar', $e->getCode(), $e->getUserErrorArgs());
        else
            UserError::AddErrorIndexed('avatar', ERR_M_PASSPORT_INCORRECT_SETTINGS_AVATAR);

		try
		{
			try
			{
				$fileObj = FileStore::ObjectFromString($lfile);
				$lfile = $fileObj['file'];
			}
			catch (MyException $e) { }
		
		
			if (FileStore::IsFile(App::$User->Profile['general']['Avatar_Path'].FileStore::GetPath_NEW($lfile)))
				FileStore::Delete_NEW(App::$User->Profile['general']['Avatar_Path'].FileStore::GetPath_NEW($lfile));
			
			try
			{
				$fileObj = FileStore::ObjectFromString($sfile);
				$sfile = $fileObj['file'];
			}
			catch (MyException $e) { }

			if (FileStore::IsFile(App::$User->Profile['general']['Avatar_Small_Path'].FileStore::GetPath_NEW($sfile)))
				FileStore::Delete_NEW(App::$User->Profile['general']['Avatar_Small_Path'].FileStore::GetPath_NEW($sfile));
		} catch (MyException $e) {}

        return false;
    }
	
    App::$User->Profile['general']['Avatar'] = $lfile;
	App::$User->Profile['general']['AvatarSmall'] = $sfile;
	$ChangedFields['Avatar'] = $lfile;
	$ChangedFields['AvatarSmall'] = $sfile;
}

// загружаем фото
if( is_file($_FILES['photo']['tmp_name']) )
{
    LibFactory::GetStatic('filestore');
    LibFactory::GetStatic('filemagic');

    try
    {
        $file = FileStore::Upload_NEW('photo', App::$User->Profile['general']['Photo_Path'],
            App::$User->ID.'_'.rand(100, 999), FileMagic::MT_WIMAGE,
            App::$User->Profile['general']['photo_file_size'],
            App::$User->Profile['general']['photo_upload_options']
		);
		
		$file = FileStore::GetPath_NEW($file);
		$photoObj = Images::PrepareImageToObject($file, App::$User->Profile['general']['Photo_Path']);
		$file = FileStore::ObjectToString($photoObj);
    }
    catch (MyException $e)
    {
        if( $e->getCode() > 0 )
            UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
        else
            UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_INCORRECT_SETTINGS_PHOTO);

        return false;
    }

    App::$User->Profile['general']['Photo'] = $file;
	$ChangedFields['Photo'] = $file;

	/**
	 * Если при загрузке фотографии у пользователя нет аватара, то он создается из фотографии
	 */
	if (empty(App::$User->Profile['general']['Avatar'])) {
		try
		{
			$src_file = App::$User->Profile['general']['PhotoPath'];
			$file = FileStore::CreateName_NEW(App::$User->ID.'_'.rand(100, 999), $src_file, FileMagic::MT_WIMAGE);
			
			$dest_file = App::$User->Profile['general']['Avatar_Path'].FileStore::GetPath_NEW($file);
			FileStore::Save_NEW($src_file, $dest_file, null,
				App::$User->Profile['general']['avatar_upload_options']
			);
			
			$dest_file = App::$User->Profile['general']['Avatar_Small_Path'].FileStore::GetPath_NEW($file);
			FileStore::Save_NEW($src_file, $dest_file, null,
				App::$User->Profile['general']['avatar_upload_options']
			);
		}
		catch (MyException $e)
		{
			if( $e->getCode() > 0 )
				UserError::AddErrorWithArgsIndexed('photo', $e->getCode(), $e->getUserErrorArgs());
			else
				UserError::AddErrorIndexed('photo', ERR_M_PASSPORT_INCORRECT_SETTINGS_PHOTO);

			try
			{
				$file = FileStore::GetPath_NEW($file);
				if (FileStore::IsFile(App::$User->Profile['general']['Avatar_Path'].$file))
					FileStore::Delete_NEW(App::$User->Profile['general']['Avatar_Path'].$file);

				if (FileStore::IsFile(App::$User->Profile['general']['Avatar_Small_Path'].$file))
					FileStore::Delete_NEW(App::$User->Profile['general']['Avatar_Small_Path'].$file);
			} catch (MyException $e) {}

			return false;
		}

		try 
		{
			$file = FileStore::GetPath_NEW($file);
			$avatarObj = Images::PrepareImageToObject($file, App::$User->Profile['general']['Avatar_Path']);
			$file = FileStore::ObjectToString($avatarObj);
			App::$User->Profile['general']['Avatar'] = $file;
			App::$User->Profile['general']['AvatarSmall'] = $file;
			
			$ChangedFields['Avatar'] = $file;
			$ChangedFields['AvatarSmall'] = $file;
		}
		catch(MyException $e) { }
	}
}

if ( $this->_config['log_profile_changes'] === true && count($ChangedFields) > 0 ) {
	$OBJECTS['log']->Log(340, 0, $ChangedFields);
}

$OBJECTS['log']->Log(267, 0, array());

Response::Redirect('/' . $this->_env['section'] . '/msg.mypage_photo.html');
