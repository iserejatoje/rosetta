<?php

LibFactory::GetStatic('statincrement');

/**
 * Получение списка типов коробки передач автомобилей
 * @return array данные id - идентификатор, name - название коробки
 */
function source_db_media($params)
{
	global $DCONFIG, $CONFIG;

	if(!is_numeric($_GET['id']) || $_GET['id'] <= 0)
		return array();

	$FileID = (int) $_GET['id'];
	$lib = LibFactory::GetInstance('multimedia');
	$referer = strtolower($_GET['referer']);
	$referer = preg_replace('@^([^#]+)@','$1',$referer);
	$referer = trim($referer,' /');

	if ($referer == 'undefined' || $referer == 'null')
		$referer = '';

	//error_log($referer);

	$UniqueID = _source_db_getUniqueID($lib, $referer, $FileID);

	switch($_GET['action']) {
		case 'play':
			if ($UniqueID)
				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['tree'],
					'PlayCount', 'TreeID', $FileID
				);

				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['links_ref'],
					'PlayCount', 'UniqueID', $UniqueID
				);
		break;
		case 'adv_go':
				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['tree'],
					'ClickCount', 'TreeID', $FileID
				);
		break;

		case 'adv_show':
				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['tree'],
					'PlayCount', 'TreeID', $FileID
				);
		break;

		case 'download':
			if ($UniqueID)
				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['tree'],
					'DownloadCount', 'TreeID', $FileID
				);

			StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['links_ref'],
					'DownloadCount', 'UniqueID', $UniqueID
				);
			//internal_redirect($lib, $FileID);
		break;
		case 'playlist':

			$id = STreeMgr::GetSectionIDByLink($referer);

			$node = STreeMgr::GetNodeById($id);
			if ($node === null || $node->Regions == 0)
			{
				return array();
			}
			else
			{
				$region = $node->Regions;
				$host = $node->Parent->Name;
			}

			LibFactory::GetStatic('bl');
			$bl = BLFactory::GetInstance('system/config');
			$config = $bl->LoadConfig('module_engine', 'video');

			if ($config === null)
				return array();

			$p = intval($_GET['p']);
			if ($p <= 0)
				$p = 0;

			$dbVideo = DBFactory::GetInstance('video');
			$cl = LibFactory::GetInstance('sphinx_api');

			$sql = "SELECT VideoID FROM videos WHERE Source = ".$FileID;
			if (true != ($res = $dbVideo->query($sql)))
				return array();

			if (!$res->num_rows)
				return array();

			list($VideoID) = $res->fetch_row();

			LibFactory::GetMStatic('tags', 'tagsmgr');
			$tags = TagsMgr::getInstance()->getTagsRef(array(
				'UniqueID' => array($VideoID),
				'Module' => 'video',
			));
			if (count($tags) == 0 )
				return array();

			$nameTags = array();
			foreach($tags as $tag)
				$nameTags[$tag['TagID']] = $cl->EscapeString($tag['Name']);

			if (count($nameTags) == 0)
				return array();

			$index = 'video_playlist';

			$cl->SetMatchMode ( SPH_MATCH_EXTENDED2 );
			$cl->SetArrayResult ( true );

			$cl->SetFilter ( 'RegionID', array($region), false );
			$cl->SetFilter ( 'Source', array($FileID), true );

			$cl->SetSortMode ( SPH_SORT_EXTENDED, 'created DESC, @weight DESC');

			$ext_query = '@TagsText "'.implode('" | @TagsText "', $nameTags).'"';
			$cl->SetLimits($p, 6);

			$res = $cl->Query (iconv('WINDOWS-1251', 'UTF-8', $ext_query), $index );
			if ( $res === false || !is_array( $res['matches']) || !sizeof( $res['matches']) )
			{
				$cl->SetMatchMode ( SPH_MATCH_FULLSCAN );
				$cl->SetArrayResult ( true );

				$cl->SetFilter ( 'RegionID', array($region), false );
				$cl->SetFilter ( 'Source', array($FileID), true );

				//$cl->SetSortMode ( SPH_SORT_EXTENDED, 'created DESC, @weight DESC');
				$cl->SetSortMode ( SPH_SORT_EXTENDED, 'created DESC, @weight DESC');

				$cl->SetLimits($p, 6);

				$res = $cl->Query ('', $index );
				if ( $res === false || !is_array( $res['matches']) || !sizeof( $res['matches']) )
					return array();
			}

			if (empty($res['matches']))
				return array();

			$total = $res['total'];

			$videoIds = array();
			foreach($res['matches'] as $v)
				$videoIds[$v['id']] = $v['id'];

			$sql = "SELECT * FROM videos WHERE VideoID IN (".implode(',', $videoIds).")";

			if (true != ($res = $dbVideo->query($sql)))
				return array();

			LibFactory::GetStatic('filestore');
			LibFactory::GetStatic('ustring');
			LibFactory::GetStatic('images');

			$list = array();
			while ($row = $res->fetch_assoc())
			{
				$thumb = '';
				if (trim($row['Thumb']) != '') {
					try {
						$img_obj = FileStore::ObjectFromString($row['Thumb']);
						$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);

						$thumb = Images::PrepareImageFromObject($img_obj,
							$config['thumb']['path'], $config['thumb']['url']);

					} catch(MyException $e) {
						continue;
					}

					if (empty($thumb))
						continue;
				} else {
					continue;
				}

				$list[$row['VideoID']] = array(
					'name'		=> UString::Truncate($row['Name'], 60),
					'thumb'		=> $thumb['url'],
					'duration'	=> $row['Duration'],
					'views'		=> $row['Views'],
					'total'		=> $total,
					//'VideoID'	=> $row['VideoID'],
				);
			}

			if (empty($list))
				return array();

			$videoBySections = array();
			$sql = "SELECT * FROM videos_ref";
			$sql.= " WHERE RegionID=".$region." AND IsActive=1";
			$sql.= " AND VideoID IN (".implode(",", array_keys($list)).")";

			$res = $dbVideo->query($sql);
			while($row = $res->fetch_assoc())
			{
				if (in_array($row['VideoID'], $videoBySections))
					continue;

				$videoBySections[] = $row['VideoID'];

				if ($row['Module'] == 'news_magic')
					$list[$row['VideoID']]['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
				elseif ($row['Module'] == 'conference')
					$list[$row['VideoID']]['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".html";
				elseif ($row['Module'] == 'rating_v2')
					$list[$row['VideoID']]['url'] = STreeMgr::GetLinkBySectionId($row['SectionID']).$row['UniqueID'].".php";
			}

			return $list;
		break;
		default:
			if ($UniqueID)
				StatIncrement::Log(
					$lib->config['db'], $lib->config['tables']['links_ref'],
					'ViewsCount', 'UniqueID', $UniqueID
				);

			StatIncrement::Log(
				$lib->config['db'], $lib->config['tables']['tree'],
				'ViewsCount', 'TreeID', $FileID
			);

			StatIncrement::Log(
				'video', 'videos', 'Views', 'Source', $FileID
			);


			$config = $lib->GetConfig($FileID, $_GET['typePlayer'], $referer);

			return $config;
	}
}



function _source_db_getUniqueID($lib, $referer, $FileID) {

	$db = DBFactory::GetInstance($lib->config['db']);

	$sql = 'SELECT LinkID FROM '.$lib->config['tables']['links_list'];
	$sql.= ' WHERE `LinkData` = \''.addslashes($referer).'\'';

	if (true != ($res = $db->query($sql)))
		return null;

	$linkID = 0;
	if ($res->num_rows)
		list($linkID) = $res->fetch_row();
	else {
		$sql = 'INSERT INTO '.$lib->config['tables']['links_list'];
		$sql.= ' SET `LinkData` = \''.addslashes($referer).'\'';

		if (false != ($res = $db->query($sql)))
			$linkID = $db->insert_id;
	}

	if (!$linkID)
		return null;

	$sql = 'SELECT UniqueID FROM '.$lib->config['tables']['links_ref'];
	$sql.= ' WHERE `LinkID` = '.$linkID;
	$sql.= ' AND `FileID` = '.$FileID.' AND `Date` = CURRENT_DATE()';
	if (true != ($res = $db->query($sql)))
		return null;

	$UniqueID = 0;
	if ($res->num_rows)
		list($UniqueID) = $res->fetch_row();
	else {
		$sql = 'INSERT INTO '.$lib->config['tables']['links_ref'];
		$sql.= ' SET `LinkID` = '.$linkID.', `FileID` = '.$FileID.', `Date` = CURRENT_DATE()';
		if (true != ($res = $db->query($sql)))
			return null;

		$UniqueID = $db->insert_id;
	}

	if (!$UniqueID)
		return null;

	return $UniqueID;
}

?>
