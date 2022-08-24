<?
$form = array();
$form['form'] = array();

if (isset($params[0]))
	$user = $OBJECTS['usersMgr']->GetUser($params[0]);
else
	$user = $OBJECTS['user'];

$form['Phone'] = $user->Profile['auto']['Phone'];
$form['Anketa'] = unserialize($user->Profile['auto']['Anketa']);
$form['DefaultCarID'] = $user->Profile['auto']['DefaultCarID'];
$form['cars'] = &$user->Profile['auto']['cars'];

LibFactory::GetStatic('filestore');
LibFactory::GetStatic('images');

if ( isset($this->_config['opinion_sections'][$this->_env['regid']]) )
{
	$cfg = ModuleFactory::GetConfigById('section', $this->_config['opinion_sections'][$this->_env['regid']]);
	$form['opinion_link'] = ModuleFactory::GetLinkBySectionId($this->_config['opinion_sections'][$this->_env['regid']]);
	$opinion_db = DBFactory::GetInstance( !empty($cfg['tables']['data']['db']) ? $cfg['tables']['data']['db'] : $cfg['db']);
}

foreach ( $form['cars'] as $car_id => $car )
{
	if (trim($car['LargePhoto']) != '')
	{
		try {
			$large_photo = Images::PrepareImage_NEW(FileStore::GetPath_NEW($car['LargePhoto']),
				$this->_config['auto_photo']['large']['path'], $this->_config['auto_photo']['large']['url']);
		
			$form['cars'][$car_id]['large_photo'] = $large_photo;
		} catch(MyException $e) {}
	}
	
	if (trim($car['SmallPhoto']) != '')
	{
		try {
			$small_photo = Images::PrepareImage_NEW(FileStore::GetPath_NEW($car['SmallPhoto']), 
				$this->_config['auto_photo']['small']['path'], $this->_config['auto_photo']['small']['url']);
		
			$form['cars'][$car_id]['small_photo'] = $small_photo;
		} catch(MyException $e) {}
	}

	if ( isset($this->_config['opinion_sections'][$this->_env['regid']]) && is_array($cfg) )
	{
		// получим количество отзывов
		$sql = "SELECT count(*) FROM `{$cfg['tables']['data']['table']}`
				WHERE `parent` = " . $car['ModelID'];
		if ( $res = $opinion_db->query($sql) )
			list($form['cars'][$car_id]['opinion_count']) = $res->fetch_row();
	}
}

//trace::vardump($form);
return $form;

?>