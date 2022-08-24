<?php

function source_db_video($params)
{
	
	switch($params['type'])
	{
	
		case 'news_search':
			$params['sectionid'] = intval($params['sectionid']);
			if (empty($params['sectionid']) || strlen($params['query']) < 3)
				return array();

			$db = DBFactory::GetInstance('news');
			$data = array();
			$sql = "SELECT STRAIGHT_JOIN n.* from news_ref r";
			$sql.= " INNER JOIN news n ON (r.NewsID=n.NewsID) WHERE ";
			$sql.= " r.SectionID = ".$params['sectionid'];
			$sql.= " AND n.Title LIKE '".$params['query']."%'";
			$sql.= " LIMIT 20";

			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				$data[$row['NewsID']] = array(
					'id' 		=> $row['NewsID'],
					'Title'		=> $row['Title'],
					'Date'		=> $row['Date'],
					'Sections'	=> array(),
				);
			}
			if (count($data) == 0)
				return $data;
				
			$sql = "SELECT * from news_ref WHERE NewsID IN (".implode(',', array_keys($data)).")";
			
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				if ($row['SectionID'] == $params['sectionid'])
					continue;
				$data[$row['NewsID']]['Sections'][] = array(
					'sectionid' => $row['SectionID'],
				);
			}
			
			return $data;
			
		case 'conference_search':
			$params['sectionid'] = intval($params['sectionid']);
			if (empty($params['sectionid']) || strlen($params['query']) < 3)
				return array();
				
			$db = DBFactory::GetInstance('conference');
			$data = array();
			$sql = "SELECT STRAIGHT_JOIN c.* from conference_ref r";
			$sql.= " INNER JOIN conference c ON (r.ConferenceID=c.ConferenceID) WHERE ";
			$sql.= " r.SectionID = ".$params['sectionid'];
			$sql.= " AND c.Title LIKE '".$params['query']."%'";
			$sql.= " LIMIT 20";
			
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				$data[$row['ConferenceID']] = array(
					'id' 		=> $row['ConferenceID'],
					'Title'		=> $row['Title'],
					'Date'		=> $row['Date'],
					'Sections'	=> array(),
				);
			}
			if (count($data) == 0)
				return $data;
				
			$sql = "SELECT * from conference_ref WHERE ConferenceID IN (".implode(',', array_keys($data)).")";
			
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				if ($row['SectionID'] == $params['sectionid'])
					continue;
				$data[$row['ConferenceID']]['Sections'][] = array(
					'sectionid' => $row['SectionID'],
				);
			}
			
			return $data;

		case 'rating_v2_search':

			LibFactory::GetStatic('bl');
			$bl_system = BLFactory::GetInstance('system/config');
			$config = $bl_system->LoadConfig('module_engine', 'rating_v2');
			if (!is_array($config) || empty($config))
				return array();

			$bl_params = array(
				'tables'	=> $config['tables'],
				'db'		=> $config['db'],
			);

			$bl = BLFactory::GetInstance('modules/rating_v2');
			$bl->Init($bl_params);

			$data = $bl->GetRatingListSearch($params['sectionid'], $params['query']);
			if (!is_array($data) || count($data) == 0)
				return array();
			
			$result = array();
			foreach($data as $k => $v)
			{
				$result[$v['RatingID']] = array(
					'id' 		=> $v['RatingID'],
					'Title'		=> $v['Name'],
					'Date'		=> $v['Date'],
					'Sections'	=> array(),
				);
			}
			return $result;

		case 'news_magic_by_section':
			if (empty($params['sectionid']) || empty($params['id']))
				return array();
				
			$db = DBFactory::GetInstance('news');
			$data = array();
			$sql = "SELECT STRAIGHT_JOIN n.*, r.SectionID from news_ref r";
			$sql.= " INNER JOIN news n ON (r.NewsID=n.NewsID) WHERE";
			$sql.= " n.NewsID IN (".implode(',', $params['id']).")";
			$sql.= " AND r.SectionID IN (".implode(',', $params['sectionid']).")";
			
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				$data[] = array(					
					'uniqueid'	=> $row['NewsID'],
					'Title'		=> $row['Title'],
					'Date'		=> $row['Date'],
					'SectionID'	=> $row['SectionID'],
				);
			}
			return $data;
		case 'conference_by_section':
			if (empty($params['sectionid']) || empty($params['id']))
				return array();
				
			$db = DBFactory::GetInstance('conference');
			$data = array();
			$sql = "SELECT STRAIGHT_JOIN c.*, r.SectionID from conference_ref r";
			$sql.= " INNER JOIN conference c ON (r.ConferenceID=c.ConferenceID) WHERE";
			$sql.= " c.ConferenceID IN (".implode(',', $params['id']).")";
			$sql.= " AND r.SectionID IN (".implode(',', $params['sectionid']).")";
			
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				$data[] = array(					
					'uniqueid'	=> $row['ConferenceID'],
					'Title'		=> $row['Title'],
					'Date'		=> $row['Date'],
					'SectionID'	=> $row['SectionID'],
				);
			}
			return $data;
		case 'rating_v2_by_section':
			if (empty($params['sectionid']) || empty($params['id']))
				return array();

			$bl_system = BLFactory::GetInstance('system/config');
			$config = $bl_system->LoadConfig('module_engine', 'rating_v2');
			if (!is_array($config) || empty($config))
				return array();

			$bl_params = array(
				'tables'	=> $config['tables'],
				'db'		=> $config['db'],
			);

			$bl = BLFactory::GetInstance('modules/rating_v2');
			$bl->Init($bl_params);

			$data = $bl->GetRatingListSearch(1, "", $params['id']);

			if (!is_array($data) || count($data) == 0)
				return array();

			$result = array();
			foreach($data as $k => $v)
			{
				$result[] = array(
					'uniqueid'	=> $v['RatingID'],
					'Title'		=> $v['Name'],
					'Date'		=> $v['Date'],
					'SectionID'	=> $v['SectionID'],
				);
			}
			
			return $result;

		case 'videos_list':
			$db = DBFactory::GetInstance('video');
			$data = array();
			
			$sql = "SELECT VideoID, Name FROM videos WHERE";
			if (is_numeric($params['id']))
				$sql.= " VideoID = ".$params['id'];
			else
				$sql.= " VideoID IN (".implode(',', $params['id']).")";
			$sql.= " AND IsActive = 1";
						
			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			while ($row = $res->fetch_assoc())
			{
				$data[$row['VideoID']] = $row;
			}			
			return $data;
			
		case 'get_video':
			if (empty($params['Module']))
				return null;
			
			if ($params['UniqueID'] <= 0)
				return null;			
		
			$db = DBFactory::GetInstance('video');
		
			$sql = 'SELECT v.Source FROM videos_ref r ';
			$sql.= ' INNER JOIN videos v ON(v.VideoID = r.VideoID) ';
			$sql.= ' WHERE r.Module = \''.addslashes($params['Module']).'\'';
			$sql.= ' AND r.UniqueID = \''.intval($params['UniqueID']).'\'';
			$sql.= ' AND r.IsActive = 1';

			if ($params['master'] !== true)
				$res = $db->query($sql);
			else
				$res = $db->query($sql);

			if (!$res || !$res->num_rows)
				return false;
				
			list($Source) = $res->fetch_row();
				
			$lib = LibFactory::GetInstance('multimedia');
			try
			{
				$info = $lib->GetInfo($Source);
			}
			catch(MyException $e)
			{
				return null;
			}
			return $info;
		
		break ;
	}
	
	return ;
}



?>