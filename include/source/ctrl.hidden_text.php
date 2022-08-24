<?php

/**
 * Получение скрытого текста
 * @return string
 */
function source_ctrl_hidden_text($params)
{
	if ( preg_match('@board/(\d+)/(\d+)/(\w+)@', $params['source'], $matche) )
	{
		switch ( $matche[3] )
		{
			case 'contacts':
				Response::NoCache();
				
				// Antiflood - BEGIN
				LibFactory::GetStatic('stpl');
				LibFactory::GetStatic('antiflood');
				$af = AntiFlood::getInstance();
				$af->ApplyRule(array(
					'name' => 'general',
					'key' => 2,
					'condition' => array(),
					'score' => array(
						'multiply' => 1,
						'add' => 1
					),
				));
				$af->SetGlobalHandle(false);
				$af->SetStatusSent(true);
				$af->SetCaptchaCheck(true);
				$status = $af->GetStatus();
				if ( $status == AntiFlood::ST_CAPTCHA )
				{
					$captcha = LibFactory::GetInstance('captcha');
					$result = STPL::Fetch('controls/hidden_text', array(
							'state' => 'captcha',
							'source' => $params['source'],
							'captcha_path' => $captcha->get_path()
						));
					echo iconv('cp1251','utf8',$result);
					exit;
				}
				else if ( $status != AntiFlood::ST_NORMAL )
				{
					echo iconv('cp1251','utf8','доступ запрещен');
					exit;
				}
				// Antiflood - END
				
				$_config = ModuleFactory::GetConfigById('section', $matche[1]);
				if ( !is_array($_config) )
					return '';
				
				$db = DBFactory::GetInstance($_config['db']);
				
				$sql = "SELECT `Contacts` FROM `". $_config['regid'] ."_advertise`";
				$sql.= " WHERE `AdvID` = ". intval($matche[2]);
				$res = $db->query($sql);
				if ( $res === false || $res->num_rows == 0 )
					return '';
				
				list($result) = $res->fetch_row();
				
				$result = STPL::Fetch('controls/hidden_text', array(
							'state' => 'text',
							'text' => $result
						));
				echo iconv('cp1251','utf8',$result);
				exit;
		}
	}
	
	return '';
}

?>