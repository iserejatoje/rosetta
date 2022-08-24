<?php

	$params = $params[0];
	
	if( !(Data::Is_Number($params['col']) && $params['col']>0))
		$params['col']=1;
	if( !(Data::Is_Number($params['colo']) && $params['colo']>0))
		$params['colo']=1;
	if( !(Data::Is_Number($params['offset']) && $params['offset']>=0))
		$params['offset']=0;
	if( !(Data::Is_Number($params['id']) && $params['id']>=0))
		$params['id']=0;
	if( !($params['withtext']==1 || $params['withtext']==0))
		$params['withtext']==0;

	$list = array(
		'withtext' => $params['withtext'],
		'list' => array(),
	);
		
	$sql = 'SELECT * FROM '.$this->_config['tables']['article'].' as  a';
	$sql.= ' INNER JOIN '.$this->_config['tables']['ref'].' AS r ';
	$sql.= ' ON (r.NewsID = a.NewsID AND r.SectionID = '.$this->_env['sectionid'].')';
		
	$where = array();
	if ( $params['id'] )
		$where[] = ' a.NewsID = '.$params['id'];
	$where[] = 'a.isVisible = 1';

	if ( $this->_params['id'] )
		$where[] = ' a.NewsID != '.$this->_params['id'];
	$where[] = ' a.Date <= \''.$this->_params['debugdate'].'\'';

	$sql.= ' WHERE '.implode(' AND ', $where);
	$sql.= ' ORDER BY a.Date DESC';
	$sql.= ' LIMIT '.$params['offset'].','.$params['col'];

	$res = $this->_db->query($sql);
	if ( !$res || !$res->num_rows )
		return $list;

	LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');

	while ( false != ($news = $res->fetch_assoc()) ) {

		try {
			if ($news['ThumbnailImg'] && FileStore::IsFile($this->_config['images_dir'].FileStore::GetPath_NEW($news['ThumbnailImg']))) {
				$info = Images::PrepareImage_NEW(FileStore::GetPath_NEW($news['ThumbnailImg']),
					$this->_config['images_dir'], $this->_config['images_url']);

				if (!empty($info)) {
					$news['ThumbnailImg'] = array(
						'file' => $info['url'],
						'w' => $info['w'],
						'h'	=> $info['h'],
					);
				} else
					$news['ThumbnailImg'] = null;
			} else {
				$news['ThumbnailImg'] = null;
			}
		} catch(MyException $e) {
			$news['ThumbnailImg'] = null;
		}

		if ( !$params['withtext'] )
			unset($news['Anon']);

		$news['Date'] = strtotime(Datetime_my::NowOffset(null, strtotime($news['Date'])));
		$news['TitleArr'] = $this->_ParsenameArticle($news['Title'], $news['TitleType']);
		
		$list['list'][] = $news;
	}

	return $list;

?>