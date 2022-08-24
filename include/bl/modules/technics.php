<?

/**
* Бизнес-логика для каталогов техники
*
* @author Шайтанова Валентина
* @version 1.0
* @created xx-авг-2010
*/

class BL_modules_technics
{
	const TYPE_PHOTOCAMERA	= 1;	// 	тип техники - фотокамеры
	const TYPE_VIDEOCAMERA	= 2;	// 	видеокамеры
	const TYPE_TV			= 3;	// 	tv
	const TYPE_NOTEBOOKS	= 4;	// 	ноутбуки
	const TYPE_CATALOG		= 5;	// 	сотовые телефоны
	
	// типы каталогов техники
	static $technics_types = array(
		self::TYPE_PHOTOCAMERA => 'photocamera',
		self::TYPE_VIDEOCAMERA => 'videocamera',
		self::TYPE_TV => 'tv',
		self::TYPE_NOTEBOOKS => 'notebooks',
		self::TYPE_CATALOG => 'catalog'
	);
			

	private $_db	= null;
	private $tables	= array();
	private $sectionid = 0;
	
	private $technics_type = 0; // тип техники
	
	private $item_col_pp = 20;
	private $p = 1;						// страница
	private $admin_mode = false;		// работа в режиме админки (т. е. не используется slave)
	
	private $add_fields = null;
	private $fields = null;
	private $photo_temp = null;			// параметры для временных фоток
	private $photo = null;				// параметры для реальных фоток
	
	public $property_list = null;		// поля-свойства модели
	public $property_tree = null;
	
	private $_arrays = null;
	
	function __construct() {}

	function Init($params)
	{
		if(isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);
			
		if(isset($params['sectionid']) && Data::Is_Number($params['sectionid']))
			$this->sectionid = (int) $params['sectionid'];
		
		if(isset($params['technics_type']) && Data::Is_Number($params['technics_type']))
			$this->technics_type = (int) $params['technics_type'];
		
		if(isset($params['tables']) && is_array($params['tables']))
			$this->tables = $params['tables'];
			
		if(isset($params['fields']) && is_array($params['fields']))
			$this->fields = $params['fields'];
			
		if(isset($params['add_fields']) && is_array($params['add_fields']))
			$this->add_fields = $params['add_fields'];
			
		if(isset($params['photo_temp']) && is_array($params['photo_temp']))
			$this->photo_temp = $params['photo_temp'];
			
		if(isset($params['photo']) && is_array($params['photo']))
			$this->photo = $params['photo'];
			
		if( isset($params['admin_mode']) )
			$this->admin_mode = (bool) $params['admin_mode'];
		
		if(isset($params['item_col_pp']) && Data::Is_Number($params['item_col_pp']))
			$this->item_col_pp = (int) $params['item_col_pp'];
		
		if(isset($params['p']) && Data::Is_Number($params['p']))
			$this->p = (int) $params['p'];
	}
	
	public function GetTechnicTypes()
	{
		return self::$technics_types;
	}
	
	/**
	* Получить галерею для модели
	*
	* @return array
	* @param id integer - ID модели
	*/
	public function GetGallery($id = 0)
	{
		return $this->_GetGallery($id, false);
	}
	
	/**
	* Получить галерею для временной (сграбленной, не выставленной) модели
	*
	* @return array
	* @param id integer - ID модели
	*/
	public function GetGalleryTemp($id = 0)
	{
		return $this->_GetGallery($id, true);
	}
	
	/**
	* Получить галерею для модели
	*
	* @return array
	* @param id integer - ID модели
	* @param is_temp boolean - true: временные позиции; false: выставленные позиции
	*/
	protected function _GetGallery($id = 0, $is_temp = true)
	{
		$gallery = array();
		
		if( !Data::Is_Number($id) || !$id )
			return $gallery;
			
		$id = (int) $id;
		$is_temp = (bool) $is_temp;
		
		$tables = array();
		
		if( $is_temp )
		{
			$tables['gallery'] = $this->tables['gallery_temp'];
			$photo = $this->photo_temp;
		}
		else
		{
			$tables['gallery'] = $this->tables['gallery'];
			$photo = $this->photo;
		}
		
		$sql = "SELECT * FROM " . $tables['gallery'];
		$sql.= " WHERE item_id=" . $id;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		LibFactory::GetStatic('filestore');
		LibFactory::GetStatic('images');
		
		while($row = $res->fetch_assoc())
		{
			for($i=1;$i<=2;$i++)
			{
				if ( !empty($row['img'.$i]) )
				{
					try
					{
						$img_obj = FileStore::ObjectFromString($row['img'.$i]);
						$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
						$row['img'.$i] = Images::PrepareImageFromObject($img_obj, $photo['gallery']['path'], $photo['gallery']['url']);
						unset($img_obj);
					}
					catch ( MyException $e )
					{
						// пустая картинка
						$row['img'.$i] = Images::PrepareImageFromObject($photo['empty_img']['meta'], '', $photo['empty_img']['url']);
					}
				}
				else
					$row['img'.$i] = Images::PrepareImageFromObject($photo['empty_img']['meta'], '', $photo['empty_img']['url']);
			}
			
			if( !preg_match('@(http:\/\/)(.*)@', $row['GalleryExPictureLink'], $matches) )
				$row['GalleryExPictureLink'] = 'http://' . $row['GalleryExPictureLink'];
			if( !preg_match('@(http:\/\/)(.*)@', $row['GalleryExSourceLink'], $matches) )
				$row['GalleryExSourceLink'] = 'http://' . $row['GalleryExSourceLink'];
			
			$gallery[$row['id']] = $row;
		}
		
		return $gallery;
	}
	
	
	
	public function _GetArray($id = 0)
	{
		global $DCONFIG;
		
		if(!Data::Is_Number($id))
			$id = 0;
		
		if(isset($this->_arrays[$id]))
			return $this->_arrays[$id];

		$this->_arrays[$id] = array();
		
		$sql = "SELECT id, name, visible FROM ".$this->tables['array'];
		$sql.= " WHERE parent=".$id;
		$sql.= " ORDER BY ord";
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while($row = $res->fetch_assoc())
			$this->_arrays[$id][$row["id"]] = $row;

		$this->_arrays[$id][0] = array(
			'id' => 0,
			'name' => "-- N/A --",
			'visible' => 0,
		);

		return $this->_arrays[$id];
	}
	
	/**
	* Получить список выставленных позиций
	*
	* @return array
	* @param filter array - фильтр (для ORDER BY)
	* @param id integer - ID позиции (не обязат. параметр)
	*/
	public function GetItemList($filter = null, $id = 0)
	{
		return $this->_GetItemList($filter, false, $id);
	}
	
	/**
	* Получить список временных позиций
	*
	* @return array
	* @param filter array - фильтр (для ORDER BY)
	* @param id integer - ID позиции (не обязат. параметр)
	*/
	public function GetItemTempList($filter = null, $id = 0)
	{
		return $this->_GetItemList($filter, true, $id);
	}
	
	/**
	* Получить список позиций
	*
	* @return array
	* @param filter array - фильтр (для ORDER BY)
	* @param is_temp boolean - true: временные позиции; false: выставленные позиции
	* @param id integer - ID позиции (не обязат. параметр)
	*/
	protected function _GetItemList($filter = null, $is_temp = true, $id = 0)
	{
		$data = array();
		
		$is_temp = (bool) $is_temp;
		
		$tables = array();
		
		if( $is_temp )
		{
			$params = array(
				'photo' => $this->photo_temp
			);
			
			$tables['item'] = $this->tables['item_temp'];
		}
		else
		{
			$params = array(
				'photo' => $this->photo
			);
			
			$tables['item'] = $this->tables['item'];
		}
		
		if(!sizeof($filter))
			$filter = array(
				'sort' => array(
					array('field' => 'date_add', 'dir' => 'DESC')
				)
			);
	
		$sql = "SELECT * FROM ".$tables['item'];
		$sql.= " WHERE type = ".$this->technics_type;

		if( $id && Data::Is_Number($id) )
		{
			$sql .= ' AND id = ' . (int) $id;
		}
		elseif( !$is_temp )
		{
			$sql .= ' AND IsModerated = 0'; // для выставленных выбирать только неотмодерированные
		}
		
		if (sizeof($filter['sort']) > 0)
		{
			$sql.= ' ORDER BY ';
			$sqlt = array();
			
			foreach ($filter['sort'] as $f)
			{
				if ( !in_array(strtolower($f['dir']), array('asc', 'desc')) )
					$f['dir'] = 'ASC';
				
				$sqlt[] = ' ' . $f['field'] . ' ' . $f['dir'] . ' ';
			}
			
			$sql.= implode(',', $sqlt);
		}
		
		$sql .= ' LIMIT ' . ($this->item_col_pp * ($this->p-1)) . ', ' . $this->item_col_pp;
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while($row = $res->fetch_assoc())
		{
			$row['date_made'] = strtotime($row['date_made']);
			$row['date_add'] = strtotime($row['date_add']);
			
			$data[$row['id']] = $row;
		}
		
		return $data;
	}
	
	/**
	* Проверка, есть ли модель в уже выставленных
	* Для админки
	*
	*/
	public function GetItemByParams($item = null)
	{
		if( null === $item )
			return false;
	
		$id = 0;
	
		$sql = "SELECT i.id FROM ".$this->tables['item']." AS i";
		$sql.= " LEFT JOIN ".$this->tables['item_property']." AS p ON p.item_id = i.id";
		$sql.= " WHERE p.".$this->fields['brand']." = '".$item['brand']."'";
		$sql.= " AND i.name='".addslashes($item['name'])."'";
		$sql.= " AND i.type=".$this->technics_type;
		
		$res = $this->_db->query($sql);
		
		if($row = $res->fetch_assoc())
			$id = $row['id'];
			
		return $id;
	}
		
	public function GetPropertyList($get = false)
	{
		if($this->property_list !== null)
		{
			if($get)
				return $this->property_list;
			else
				return true;
		}
		
		$this->property_list = array();
		$sql = "SELECT * FROM ".$this->tables['property'];
		$sql.= " ORDER BY ord";
		
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		while($row = $res->fetch_assoc())
		{
			if($row['type'] == 2)
			{
				$this->property_list['p'.$row['id']] = $row;
				if($row['params']!="")
					$this->property_list['p'.$row['id']]['params'] = unserialize($row['params']);
				else
					$this->property_list['p'.$row['id']]['params'] = array();
			}
		}
		
		if($get)
			return $this->property_list;
		else
			return true;
	}
	
	public function GetPropertyTree($get = false)
	{
		if($this->property_tree !== null)
		{
			if($get)
				return $this->property_tree;
			else
				return true;
		}
		
		LibFactory::GetStatic('tree');

		$sql = "SELECT id, parent, name, type, ftype, ord, visible, params FROM ".$this->tables['property'];
		$sql.= " ORDER BY ord";
				
		$res = $this->admin_mode ? $this->_db->query($sql) : $this->_db->query($sql);
		
		$data = array();
		
		while($row = $res->fetch_assoc())
		{
			$data[$row["id"]] = array(
				'parent' => $row["parent"],
				'data' => array(
					'name' => $row["name"],
					'type' => $row["type"],
					'ftype' => $row["ftype"],
					'ord' => $row["ord"],
					'visible' => $row["visible"],
					'params' => ($row['params']!=""?unserialize($row['params']):array()),
				),
				'name' => $row["name"],
			);
		}
		
		$this->property_tree = new Tree();
		$this->property_tree->BuildTree($data);

		if($get)
			return $this->property_tree;
		else
			return true;
	}
	
	public function DeleteItem($ids = array())
	{
		return $this->_DeleteItem($ids, false);
	}
	
	public function DeleteItemTemp($ids = array())
	{
		return $this->_DeleteItem($ids, true);
	}
	
	private function _DeleteItem($ids = array(), $is_temp = true)
	{
		if( null === $ids )
			return false;
		
		$ids = (array) $ids;
		$is_temp = (bool) $is_temp;
		
		if( $is_temp )
		{
			$params = array(
				'photo' => $this->photo_temp,
				'tables' => array(
					'item' => $this->tables['item_temp'],
					'item_property' => $this->tables['item_property_temp'],
					'gallery' => $this->tables['gallery_temp']
				),
				'is_temp' => $is_temp
			);
		}
		else
		{
			$params = array(
				'photo' => $this->photo,
				'tables' => array(
					'item' => $this->tables['item'],
					'item_property' => $this->tables['item_property'],
					'gallery' => $this->tables['gallery']
				),
				'is_temp' => $is_temp
			);
		}
		
		$this->_delete_item($ids, $params);
			
		return true;
	}
	
	/**
	* Публикация модели из временных позиций в реальные
	* Для админки
	*
	*/
	public function PublicItemTemp($id = 0)
	{
		if(is_array($id))
		{
			foreach($id as $v)
				$this->PublicItemTemp($v);
		}
		else
		{
			if(!Data::Is_Number($id))
				return false;

			$fl_error = false;
			
			$sql = "SELECT * FROM ".$this->tables['item_temp']." AS i";
			$sql.= " LEFT JOIN ".$this->tables['item_property_temp']." AS p ON i.id = p.item_id";
			$sql.= " WHERE i.id=".$id;
			
			$res = $this->_db->query($sql);
			
			$item_id = 0;
			
			if($row = $res->fetch_assoc())
			{
				$details = $row;
				
				// смотрим наличие наименования в базе
				$sql = "SELECT * FROM ".$this->tables['item']." AS i";
				$sql.= " LEFT JOIN ".$this->tables['item_property']." AS p ON i.id = p.item_id";
				$sql.= " WHERE i.name='".addslashes($details['name'])."'";
				
				if(count($this->public_fields))
					foreach($this->public_fields as $par)
						$sql.= " AND ".$par."='".addslashes($details[$par])."'";

				$res = $this->_db->query($sql);
				
				$old = array();
				
				if($row = $res->fetch_assoc())
					$old = $row;
				
				if(!$old['id'])
				{// нет такого, добавляем
					$sql = "INSERT INTO ".$this->tables['item']." SET";
					$sql.= " visible='1',";
					$sql.= " type='".$details['type']."',";
					$sql.= " name='".addslashes($details['name'])."',";
					$sql.= " s_price='".addslashes($details['s_price'])."',";
					$sql.= " date_made='".addslashes($details['date_made'])."',";
					$sql.= " date_add='".addslashes($details['date_add'])."'";
					
					$this->_db->query($sql);
					
					$item_id = $this->_db->insert_id;
					
					$old['need_prop'] = 1;
					$old['need_gallery'] = 1;
				}
				else
					$item_id = $old['id'];
				
				if($old['need_prop'])
				{
					$this->GetPropertyTree();
					$this->GetPropertyList();
					
					$sqlt = '';
					
					if(count($this->property_list))
					{
						LibFactory::GetStatic('filestore');
						
						foreach($this->property_list as $k=>$v)
						{
							if($v['ftype']=='image')
							{
								if( !$old[$k] && !empty($details[$k]) )
								{
									try
									{
										try
										{
											$img_obj = FileStore::ObjectFromString($details[$k]);
											$path = FileStore::GetPath_NEW($img_obj['file']);
											unset($img_obj);
										}
										catch ( MyException $e )
										{
											$path = FileStore::GetPath_NEW($details[$k]);
										}
										
										FileStore::Copy_NEW(
											$this->photo_temp['images']['path'].$path,
											$this->photo['images']['path'].$path,
											true
										);
									}
									catch ( MyException $e )
									{
										continue;
									}
									
									$sqlt.= ($sqlt==""?"":",")." ".$k."='".addslashes($details[$k])."'";
								}
							}
							else
								$sqlt.= ($sqlt==""?"":",")." ".$k."='".addslashes($details[$k])."'";
						}
					}
					if($sqlt)
					{
						$sql = "INSERT INTO ".$this->tables['item_property']." SET";
						$sql.= $sqlt;
						$sql.= ", item_id=".$item_id;
						$sql.= ", type=".$this->technics_type;
						
						$this->_db->query($sql);
						
						$sql = "UPDATE ".$this->tables['item']." SET";
						$sql.= " need_prop=0 WHERE id=".$item_id;
						
						$this->_db->query($sql);
					}
				}
				
				if($old['need_gallery'])
				{
					if($old['id'])
					{
						$sql = "SELECT id FROM ".$this->tables['gallery'];
						$sql.= " WHERE item_id=".$item_id;
						$res = $this->_db->query($sql);
						
						$a = array();
						
						while($row = $res->fetch_assoc())
							$a[] = $row['id'];
							
						$this->DeleteGallery($a);
					}

					$sql = "SELECT * FROM ".$this->tables['gallery_temp'];
					$sql.= " WHERE item_id=".$id;
					
					$res = $this->_db->query($sql);
					
					$a = array();
					
					while($row = $res->fetch_assoc())
						$a[$row['id']] = $row;
						
					if(count($a))
					{
						LibFactory::GetStatic('filestore');
					
						foreach($a as $v)
						{
							$sql = "INSERT INTO ".$this->tables['gallery']." SET";
							$sql.= " item_id=".$item_id.",";
							$sql.= " name='".addslashes($v['name'])."',";
							$sql.= " ord=".$v['ord'].",";
							$sql.= " visible=1,";
							$sql.= " IsInGalleryEx=" . $v['IsInGalleryEx'] . ","; // дополнительные картинки
							$sql.= " GalleryExPictureLink='" . $v['GalleryExPictureLink'] . "',";
							$sql.= " GalleryExSourceLink='" . $v['GalleryExSourceLink'] . "'";
							
							$this->_db->query($sql);
							
							$gal_id = $this->_db->insert_id;
							
							$sqlt= "";
							
							for($i=1;$i<=2;$i++)
							{
								try
								{
									if( !empty($v['img'.$i]) )
									{
										try
										{
											$img_obj = FileStore::ObjectFromString($v['img'.$i]);
											$path = FileStore::GetPath_NEW($img_obj['file']);
											unset($img_obj);
										}
										catch ( MyException $e )
										{
											$path = FileStore::GetPath_NEW($v['img'.$i]);
										}
										
										FileStore::Copy_NEW(
											$this->photo_temp['gallery']['path'].$path,
											$this->photo['gallery']['path'].$path,
											true
										);
									}
								}
								catch ( MyException $e )
								{
									$fl_error = true;
									break;
								}
								
								if( !empty($v['img'.$i]) )
									$sqlt.= ($sqlt==""?"":",")." img".$i."='".addslashes($v['img'.$i])."'";
							}
							
							if( $fl_error )
								break;

							if( !empty($sqlt) )
							{
								$sql = "UPDATE ".$this->tables['gallery']." SET";
								$sql.= $sqlt;
								$sql.= " WHERE id=".$gal_id;
								
								$this->_db->query($sql);
							}
						}
					}
					
					if( !$fl_error )
					{
						$sql = "UPDATE ".$this->tables['item']." SET";
						$sql.= " need_gallery=0,";
						$sql.= " IsModerated=1";
						$sql.= " WHERE id=".$item_id;
						
						$this->_db->query($sql);
					}
				}
			}
			
			if( !$fl_error )
				$this->DeleteItemTemp($id);
				
			return $item_id; // todo: где вызывается, учесть
		}
	}
	
	/**
	* Для админки
	*
	*/
	protected function _delete_item($id = 0, $params = null)
	{
		if( null === $params )
			return false;
	
		if(is_array($id))
		{
			foreach($id as $v)
				$this->_delete_item($v, $params);
		}
		else
		{
			if(!Data::Is_Number($id) || !$id)
				return false;

			$this->GetPropertyTree();
			$this->GetPropertyList();
			
			$pars = array(
				'photo' => $params['photo'],
			);
			
			$sql = "SELECT * FROM ".$params['tables']['item'];
			$sql.= " WHERE id=".$id;
			
			$res = $this->_db->query($sql);
			
			if($row = $res->fetch_assoc())
			{
				LibFactory::GetStatic("fields");
				try
				{
					Fields::DeleteFields($this, $this->property_list, $row, $pars);
				}
				catch (BTException $e)
				{
					return false;
				}
			}

			$sql = "SELECT id FROM ".$params['tables']['gallery'];
			$sql.= " WHERE item_id=".$id;
			
			$res = $this->_db->query($sql);
			
			$a = array();
			
			while($row = $res->fetch_assoc())
				$a[] = $row['id'];
			
			if(count($a)>0)
			{
				if( $params['is_temp'] )
					$this->DeleteGalleryTemp($a);
				else
					$this->DeleteGallery($a);
			}
			
			$sql = "DELETE FROM " . $params['tables']['item'];
			$sql.= " WHERE id=".$id;	
			$this->_db->query($sql);
			
			$sql = "DELETE FROM " . $params['tables']['item_property'];
			$sql.= " WHERE item_id=".$id;	
			$this->_db->query($sql);
		}
		
		return true;
	}
	
	public function DeleteGalleryTemp($id = 0)
	{
		$this->_DeleteGallery($id, true);
	}
	
	public function DeleteGallery($id = 0)
	{
		$this->_DeleteGallery($id, false);
	}
		
	protected function _DeleteGallery($id = 0, $is_temp = true)
	{
		$is_temp = (bool) $is_temp;
	
		$params = array();
		
		if( $is_temp )
		{
			$params['photo'] = $this->photo_temp;
			$params['table'] = $this->tables['gallery_temp'];
		}
		else
		{
			$params['photo'] = $this->photo;
			$params['table'] = $this->tables['gallery'];
		}
		
		$this->_delete_gallery($id, $params);
	}
	
	/**
	* Для админки
	*
	*/
	protected function _delete_gallery($id = 0, $params = null)
	{
		if( null === $params )
			return false;
	
		if(is_array($id))
		{
			foreach($id as $v)
				$this->_delete_gallery($v, $params);
		}
		else
		{
			if(!Data::Is_Number($id) || !$id)
				return false;

			$sql = "SELECT * FROM ".$params['table'];
			$sql.= " WHERE id=".$id;
			
			$res = $this->_db->query($sql);
			
			if($row = $res->fetch_assoc())
			{
				LibFactory::GetStatic('filestore');
			
				for($i=1;$i<=2;$i++)
				{
					if( empty($row['img'.$i]) )
						break;
				
					try
					{
						$img_obj = FileStore::ObjectFromString($row['img'.$i]);
                        $img = $params['photo']['gallery']['path'] . FileStore::GetPath_NEW($img_obj['file']);
						FileStore::Delete_NEW($img);
						unset($img_obj);
					}
					catch ( MyException $e )
					{
						try
						{
							FileStore::Delete_NEW($params['photo']['gallery']['path'].FileStore::GetPath_NEW($row['img'.$i]));
						}
						catch ( MyException $e )
						{
							return false;
						}
					}
				}
			}

			$sql = 'DELETE FROM ' . $params['table'];
			$sql.= ' WHERE id=' . $id;	
			$this->_db->query($sql);
		}
		
		return true;
	}
	
	/**
	* Поставить статус "отмодерировано" - флаг IsModerated = 1
	* Для админки
	*
	* @return boolean
	* @param item_id integer - ID модели
	* @param IsModerated boolean - состояние модерации (0 - требуется модерация; 1 - отмодерировано)
	*/
	public function SetModerated($item_id = 0, $IsModerated = true)
	{
		if( null === $item_id )
			return false;
			
		$sql = 'UPDATE ' . $this->tables['item'];
		$sql.= ' SET IsModerated = ' . ( $IsModerated ? 1 : 0 );
		$sql.= ' WHERE id IN (' . implode(',', (array) $item_id) . ')';
		
		return $this->_db->query($sql);
	}
	
/************************ Остальные ************************/
	
	public function __get($name)
	{
		$name = strtolower($name);

		switch($name)
		{
			case 'page':
				return $this->p;
			break;
		}
	}
	
	public function __set($name, $value)
	{
		$name = strtolower($name);
	
		switch($name)
		{
			case 'page':
				if(Data::Is_Number($value))
					$this->p = (int) $value;
			break;
		}
	}
}

?>