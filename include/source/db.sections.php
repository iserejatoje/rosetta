<?
	function sort_stat($a, $b)
	{
		return ($a['site']['month_clients'] > $b['site']['month_clients']) ? -1 : 1;
	}
	function source_db_sections($params)
	{
		if (isset($params['with_env'])) // Параметр, указывающий, нужно ли нам окружение
		{
			$use_env = $params['with_env'];
			unset($params['with_env']);
		}

		if (isset($params['with_stat']))	// Параметр, указывающий, нужна ли нам статистика по модулю
		{
			$use_stat = $params['with_stat'];
			unset($params['with_stat']);
		}

		LibFactory::GetStatic('bl');
		$bl = BLFactory::GetInstance('system/env');

		$data = array();

		$it = STreeMgr::Iterator( $params ); // Получаем итератор для перечисления найденых разделов по заданным параметрам

		foreach ($it as $l => $node )
		{
			if ( $params['parent_is_title'] && !$node->Parent->IsTitle ) // Если сайт второстепенный - то пропускаем
				continue;

			$data[$l] = $node->ToArray();	// получаем данные по разделу
			$data[$l]['site']['section_id'] = $node->Parent->ID;
			$data[$l]['link'] = ModuleFactory::GetLinkBySectionID($l); // Получаем ссылку на раздел

			if ($use_env) // если нам надо
				$data[$l]['env'] = $bl->LoadEnv($node->Parent->ID); // То получаем еще и окружение раздела

			if ($use_stat)
			{
				$sql = "SELECT `regid`, `month_clients`, `month_pages`, `ramb_id` FROM `ramb_st`";
				$sql.= " WHERE `section_id` = '".$data[$l]['site']['section_id']."'";
				$result = DBFactory::GetInstance('rugion')->query($sql);
				$res = $result->fetch_assoc();
				foreach ($res as $name => $val)
					$data[$l]['site'][$name] = $val;
			}
		}
		//if ($params['sort_stat'] == 1)
		usort($data, 'sort_stat');
		return $data;
	}
?>
