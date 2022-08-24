<?

if ( !$OBJECTS['user']->IsAuth() )
	$this->redirect_not_authorized();

$Anketa = App::$Request->Post['Anketa']->AsArray(array());

$_anketa = array();

// проверка анкеты
foreach ( $Anketa as $q_index => $qestion )
{
	if ( array_key_exists($q_index, $this->_config['auto_anketa']) )
	{
		$_anketa[$q_index] = array();
		if ( $this->_config['auto_anketa'][$q_index]['multiple'] )
		{
			foreach ( $qestion as $k => $value )
			{
				if ( $k === 'other' )
				{
					$_anketa[$q_index][$k] = strip_tags($value);
				}
				else
				{
					if ( array_key_exists($k, $this->_config['auto_anketa'][$q_index]['answers']) && Data::Is_Number($value) )
						$_anketa[$q_index][$k] = $value > 0 ? 1 : 0;
				}
			}
		}
		else
		{
			if ( array_key_exists($qestion, $this->_config['auto_anketa'][$q_index]['answers']) )
				$_anketa[$q_index] = (int) $qestion;
		}
	}
}

$OBJECTS['user']->Profile['auto']['Anketa'] = serialize($_anketa);

Response::Redirect('/'.$this->_env['section'].'/msg.auto_profile_ok.html');

?>