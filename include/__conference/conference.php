<?php

require_once ($CONFIG['engine_path'].'include/lib.datetime_my.php');

/**
 * @author Овчинников Евгений
 * @version 1.0
 * @created 09-апр-2009 11:34:16
 * по всем изменениям и дополнениям к автору
 */
class Conference
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
		if ( isset($data['conferenceid']) && is_numeric($data['conferenceid']) ) {
			$this->_ID = $data['conferenceid'];
			unset($data['conferenceid']);
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

		$sql = 'SELECT * FROM conference WHERE conferenceid='.$id;
		$res = Conference::$db->query($sql);
		if($res !== false && $data = $res->fetch_assoc())
			return new self($data);

		return null;
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
			
			case 'tsdate':
			case 'time':
				if ( $this->_cache['time'] )
					return $this->_cache['time'];
				
				return $this->_cache['time'] = Datetime_my::NowOffsetTime(null, strtotime($this->_Fields['date']));
			break;
			
			case 'tsdateend':
			case 'timeend':
				if ( $this->_cache['timeend'] )
					return $this->_cache['timeend'];
				
				return $this->_cache['timeend'] = Datetime_my::NowOffsetTime(null, strtotime($this->_Fields['dateend']));
			break;
			
			case 'dateend':
				return date('Y-m-d H:i:s', $this->tsdateend);
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
						'absolute' => $this->_cache['url'].$this->_Fields['nameid'].'.html',
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
					$preparedImage = Images::PrepareImageFromObject($img_obj, 
									ConferenceMgr::$images_dir, ConferenceMgr::$images_url);
					
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