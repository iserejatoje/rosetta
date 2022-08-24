<?php

require_once (ENGINE_PATH.'include/lib.datetime_my.php');

class Article
{	
	/**
	 * идентификатор новости
	 */
	private $_ID = null;
	private $_Fields = array();
	private $_cache = array();
	private $_data = array();
	
	function __construct($data)
	{
		// убрать
		$this->_data = $data;

		$data = array_change_key_case($data, CASE_LOWER);
		if ( isset($data['newsid']) && is_numeric($data['newsid']) ) {
			$this->_ID = $data['newsid'];
			unset($data['newsid']);
			$this->_Fields = $data;
		}
	}

	/**
	 * создать экземпляр сообщества по данным из бд
	 */
	public static function CreateInstance($data)
	{
		if ( is_array($data) )
			return new self($data);
		
		$id = intval($data);
		if($id <= 0)
			return null;

		$sql = 'SELECT * FROM news WHERE NewsID='.$id;
		$res = ArticleMgr::$db->query($sql);
		if($res !== false && $data = $res->fetch_assoc())
			return new self($data);

		return null;
	}
	
	public function getReference() {
		if ($this->_ID === null)
			return array();
		
		$sql = 'SELECT * FROM news_ref WHERE NewsID='.$this->_ID;
		$res = ArticleMgr::$db->query($sql);
		
		$refs = array();
		while(false != ($row = $res->fetch_assoc()))
			$refs[$row['SectionID']] = $row;
		
		return $refs;
	}
	
	public function &__get($name)
	{
		global $OBJECTS;
		
		$name = strtolower($name);
		switch($name)
		{
			case 'id':
				return $this->_ID;
			break;
			
			case 'time':
			case 'tsdate':
				if ( $this->_cache['time'] )
					return $this->_cache['time'];
				
				return $this->_cache['time'] = Datetime_my::NowOffsetTime(null, strtotime($this->_Fields['date']));
			break;
			
			case 'date':
				return date('Y-m-d H:i:s', $this->tsDate);
			break;
			
			case 'url':
				
				//if ( isset($this->_Fields['sectionid']) )
					//$this->_Fields['sectionid']
				
				if ( !isset($this->_cache['url']) ) {
					$this->_cache['url'] = 
						ModuleFactory::GetLinkBySectionId($this->_Fields['sectionid'], array(), true);
						
					$this->_cache['url'] = array(
						'absolute' => $this->_cache['url'].$this->_ID.'.html',
						'relative' => $this->_cache['url'].date('Y/m/d/', $this->tsDate).'#'.$this->_ID,
					);
				}

				return $this->_cache['url'];
			break;
			
			case 'data':
				return $this->_data;
			break;

		case 'thumb':
				if (is_array($this->_Fields['thumbnailimg']))
					return $this->_Fields['thumbnailimg'];

				if(empty($this->_Fields['thumbnailimg']))
					return null;

				LibFactory::GetStatic('filestore');
				LibFactory::GetStatic('images');
				
				try
				{
					$img_obj = FileStore::ObjectFromString($this->_Fields['thumbnailimg']);
					$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
					$preparedImage = Images::PrepareImageFromObject($img_obj, ArticleMgr::$images_dir, ArticleMgr::$images_url);
					
					unset($img_obj);
				}
				catch ( MyException $e )
				{
					$this->_Fields['thumbnailimg'] = null;
				}
				
				if (!empty($preparedImage)) {
					$this->_Fields['thumbnailimg'] = array(
						'File'		=> $preparedImage['url'],
						'Width'		=> $preparedImage['w'],
						'Height'	=> $preparedImage['h'],
					);
				}
				return $this->_Fields['thumbnailimg'];
			break;
			
			default:
				if ( isset($this->_Fields[$name]) )
					return $this->_Fields[$name];
				return null;
			break;
		}
	}
	
	public function __set($name, $value)
	{
		
	}
}
?>