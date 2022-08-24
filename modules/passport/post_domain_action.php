<?php
include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

if (!$OBJECTS['user']->IsAuth())
{
	$data = 'Вы не авторизованы!';
	echo $json->encode(array('status' => 'error', 'data' => $data));
	exit();
}

LibFactory::GetStatic('domain');

$text = trim(App::$Request->Post['text']->Value());
$type = Domain::DT_USER;//App::$Request->Post['type']->Value(3); - нахуя такая дыра? как будто здесь что-то еще можно регать...
$state = App::$Request->Post['state']->Int(0);
$text = iconv('UTF-8', 'WINDOWS-1251', $text);
$object = $OBJECTS['user']->ID;//App::$Request->Post['object']->Value(); - нахуя такая дыра? чтобы регать можно было кому угодно и что угодно?


$info = Domain::GetInfo($type, $object);

if ( in_array($state, array(0,1)))
{
	// create | update
	if (strlen($text) < $this->_config['limits']['min_domain_name_len'])
	{
		$data = 'Вы задали слишком короткий адрес. Минимальная длинна адреса <b>'.$this->_config['limits']['min_domain_name_len'].'</b> символа.';
		echo $json->encode(array('status' => 'error', 'data' => $data));
		exit();
	}
	if (strlen($text) > $this->_config['limits']['max_domain_name_len'])
	{
		$data = 'Вы задали слишком длинный адрес. Максимальная длинна адреса <b>'.$this->_config['limits']['min_domain_name_len'].'</b> символа.';
		echo $json->encode(array('status' => 'error', 'data' => $data));
		exit();
	}
	if (!Domain::IsNameValid($text))
	{
		$data = 'Адрес содержит недопустимые символы. Можно использоваться символы латинского алфавита, цифры и дефис "-"';
		echo $json->encode(array('status' => 'error', 'data' => $data));
		exit();
	}
	if( $state == 0 )
	{
		// create
		if( $info !== false )
		{
			$data = 'Вы не можете зарегистрировать себе больше одного адреса.';
			echo $json->encode(array('status' => 'error', 'data' => $data,));
			exit;
		}
		if( Domain::IsDomainExists($text, $this->_env['site']['regdomain']) === false && Domain::CheckForbidden($text, '') === false )
		{
			if (Domain::Create($text, $type, $object, $this->_env['site']['regdomain']))
			{
				$data = 'Адрес зарегистрирован!';
				echo $json->encode(array('status' => 'ok', 'data' => $data,'url' => $this->_config['files']['get']['domain']['string'],));
				exit;
			}
			else
			{
				$data = 'Ошибка регистрации адреса';
				echo $json->encode(array('status' => 'error', 'data' => $data,));
				exit;
			}
		}
	}
	if( $state == 1 )
	{
		// update
		if ($info['Name'] == $text && $info['Domain'] == $this->_env['site']['regdomain'])
		{
			$data = 'Адрес изменен!';
			echo $json->encode(array('status' => 'ok', 'data' => $data,'url' => $this->_config['files']['get']['domain']['string'],));
			exit;
		}
		if( Domain::IsDomainExists($text, $this->_env['site']['regdomain']) === false && Domain::CheckForbidden($text, '') === false )
		{
			if (Domain::Update($text, $type, $object, $info['Domain']))
			{
				$data = 'Адрес изменен!';
				echo $json->encode(array('status' => 'ok', 'data' => $data,'url' => $this->_config['files']['get']['domain']['string'],));
				exit;
			}
			else
			{
				$data = 'Ошибка изменения адреса';
				echo $json->encode(array('status' => 'error', 'data' => $data,));
				exit;
			}
		}
	}
	
}
elseif ($state == 3)
{
	// delete
	if (Domain::Remove($type, $object))
	{
		$data = '<font color="red">Адрес удален.</font> <a href="/passport/domain.php">Выбрать другой адрес</a>';
		echo $json->encode(array('status' => 'ok', 'data' => $data));
		exit;
	}
	else
	{
		$data = 'Не удалось удалить адрес';
		echo $json->encode(array('status' => 'error', 'data' => $data,));
		exit;
	}
}

$result = array(
	'status' 	=> 'generate',
	'data'		=> 'Нельзя выбрать такой адрес. <br>Введите другой или выберите адрес из списка:',
);

$result['list'] = Domain::GenerateName(
	$text, 
	$type,
	$object, 
	$this->_env['site']['regdomain'], 
	$this->_env['regid'], 	
	$OBJECTS['user']->Profile['general']['FirstName'], 
	$OBJECTS['user']->Profile['general']['LastName'],
	true
);

exit($json->encode($result));
?>