<?
	class lib_stat
	{
		function __constructor()
		{			
		}
		
		function Get($namespace, $key)
		{
			$db = DBFactory::GetInstance('public');
			$sql = "SELECT value
					FROM statistic
					WHERE namespace='$namespace' AND name='$key'";
			$res = $db->query($sql);
			if($row = $res->fetch_row())
				return unserialize($row[0]);
			else
				return false;
		}
		
		function GetRegionStat($region = null)
		{
			global $CONFIG;
			
			if($region == null)
				$region = $CONFIG['env']['regid'];
				
			$ids = array();
			
			$it = STreeMgr::Iterator(array(
				'visible' => 1,
				'type' => 1,
				'regions' => $CONFIG['env']['regid']
			));
			
			// сбор сайтов по региону
			foreach($it as $node)
			{
				if(eregi("^[a-zA-Z0-9\x2d]{1,63}\.[a-z]{2,10}$",$node->Name))
					$ids[] = $node->ID;
			}			
			
			if(count($ids) > 0)
			{
				$rambstack = $stat = array();
				$keys = array(	'today_clients','today_pages','yesterday_clients','yesterday_pages',
								'sevendays_clients','sevendays_pages','month_clients','month_pages');
				$sql = "SELECT * FROM ramb_st";
				$sql.= " WHERE section_id IN(".implode(',', $ids).")";
				
				$res = DBFactory::GetInstance('rugion')->query($sql);
				while($row = $res->fetch_assoc())
				{
					$sn = STreeMgr::GetNodeByID($row['section_id']);
				
					// порядок
					$stat['mclients_ord'][ $row['ramb_id'] ] = $row['month_clients'];
					$stat['site_ord'][ $row['section_id'] ] = $sn->Ord;
					if(!isset($stat['rambler_ord'][ $row['ramb_id'] ]) || $stat['rambler_ord'][ $row['ramb_id'] ] > $sn->Ord)
						$stat['rambler_ord'][ $row['ramb_id'] ] = $sn->Ord;
					
					// по секшену
					$stat['site'][ $row['section_id'] ]['statistic'] = $row;
					$stat['site'][ $row['section_id'] ]['domain'] = $sn->Name;
					$stat['site'][ $row['section_id'] ]['rambler_id'] = $row['ramb_id'];
					
					// по раблеру
					$stat['rambler'][ $row['ramb_id'] ]['statistic'] = $row;
					$stat['rambler'][ $row['ramb_id'] ]['domain'][] = $sn->Name;

					if(!isset($rambstack[ $row['ramb_id'] ]))
					{
						$rambstack[ $row['ramb_id'] ] = 1;
						foreach($keys as $k)
							$stat['total'][$k]+= $row[$k];
					}
				}
				
				arsort($stat['mclients_ord']);
				asort($stat['site_ord']);
				asort($stat['rambler_ord']);

				return $stat;
			}
			else
				return null;
		}
		
		function GetSiteStat($ramb_id)
		{
			if(!is_numeric($ramb_id) || $ramb_id<=0)
				return false;
				
			$sql = "SELECT * FROM ramb_st";
			$sql.= " WHERE ramb_id=".$ramb_id;
			
			$db = DBFactory::GetInstance('rugion');
			$result = $db->query($sql);
			
			if($result && false != ($row = $result->fetch_assoc()))
				return $row;
			else
				return false;
		}
		
		function get_stat_dir($domain, $directory)
		{
			
			if(empty($domain))
				return false;

			if(empty($directory))
				return false;
			
			if (strpos($directory, '/' ) === 0)
				$directory = substr($directory, 1);
				
			if ($directory{strlen($directory)-1} != '/')
				$directory.= '/';
            /*
			$db = DBFactory::GetInstance('site');
			$sql = "SELECT t.name FROM app_env ae";
			$sql.= " INNER JOIN tree t ON ae.SectionID=t.id";
			$sql.= " WHERE ae.Name='rambler_id'";
			$sql.= " AND `Value`=".(int) $site_id;

			$result = $db->query($sql);
			$domains = array();
			while($row = $result->fetch_assoc()) {
				$domains[] = "'".addslashes($row['name'])."'";
			}
            */
			$sql = "SELECT `stat` FROM `li_st_dir` ";
			$sql.= " WHERE `domain` = '".addslashes($domain)."'";
			//$sql.= " WHERE `domain` in (".implode(',', $domains).")";
			$sql.= " AND `dir` = '".addslashes($directory)."'";
			$db_rugion = DBFactory::GetInstance('rugion');
			$result = $db_rugion->query($sql);

			if ($result === false)
				return false;
			
			if( ($row = $result->fetch_assoc()) != false )
				return $row['stat'];
			else
				return false;
		}

		/*function get_stat_dir($site_id, $directory) 
		{

			if(empty($site_id))
				return false;
			
			if($directory{0} != '/')
				$directory = '/'.$directory;
			
			if($directory{strlen($directory)-1} != '/')
				$directory.= '/';
							
			$sql = 'SELECT `stat` FROM ramb_st_dir ';
			$sql .= ' WHERE `rid` = '.(int) $site_id.' AND `dir` = \''.addslashes($directory).'\'';
				
			$db = DBFactory::GetInstance('rugion');
			$result = $db->query($sql);
			
			if($result && false != ($row = $result->fetch_row())) {
				return $row[0];
			} else
				return false;
		}*/
		
		function GetRegionStat_li($region = null)
		{		
			global $CONFIG;
			
			$stat = array();
			
			$sql = "SELECT site, date, visitors_1day, visitors_31days";
			$sql.= " FROM stat_li_current";
			if($region !== null)
				$sql.= " WHERE site='".addslashes($region)."'";
			
			$res = DBFactory::GetInstance('site')->query($sql);
			
			while($row = $res->fetch_assoc())
			{
				$stat[$row['site']] = array(
					'visitors' => $row['visitors_1day'],	
					'visitors31day' => $row['visitors_31days'],								
					'date' => $row['date'],
				);			
			}
			
			return $stat;		
		}
	}
?>