<?

/**
* Бизнес-логика для автоотзывов
*
* @author Винникова Оксана
* @version 1.0
* @created xx-апр-2010
*/

class BL_modules_opinion
{
	public $title_separator = '. ';
	
	private $_db		= null;
	private $tables		= array();
	private $fields		= array();
	private $automarka_rubrics = array(
			8 => 'Отечественные авто',
			9 => 'Иномарки',
		);

	
	private $opinion_col_pp = 20;
	private $last_count 	= 20;
	private $p 				= 1;
	private $is_vip 		= 0;
	private $sectionid 		= 0;
	private $images_path	= '';
	
	protected $opinions 	= null;		 // список отзывов
	protected $opinion 	= null;			 // конкретный отзыв
	
	function __construct()
	{
		LibFactory::GetStatic('datetime_my');
		LibFactory::GetStatic('arrays');
	}

	function Init($params)
	{

		if(isset($params['db']) && !empty($params['db']))
			$this->_db = DBFactory::GetInstance($params['db']);

		if(isset($params['sectionid']) && Data::Is_Number($params['sectionid']))
			$this->sectionid = (int) $params['sectionid'];
		
		if(isset($params['tables']) && is_array($params['tables']))
			$this->tables = $params['tables'];

		if(isset($params['fields']) && is_array($params['fields']))
			$this->fields = $params['fields'];

		if( isset($params['admin_mode']) )
			$this->admin_mode = (bool) $params['admin_mode'];
			
		if(isset($params['opinion_col_pp']))
			$this->opinion_col_pp = $params['opinion_col_pp'];

		if(isset($params['last_count']))
			$this->last_count = $params['last_count'];

		if(isset($params['is_vip']))
			$this->is_vip = $params['is_vip'];

		if(isset($params['scale_mark']))
			$this->scale_mark = $params['scale_mark'];

		if(isset($params['images_path']))
			$this->images_path = $params['images_path'];

		if(isset($params['p']) && Data::Is_Number($params['p']))
			$this->p = (int) $params['p'];

	}
	
	/**
	* Изменить значение параметра
	*
	* @return boolean
	* @param param_name string - имя устанавливаемого параметра
	* @param param_value string - новое значение устанавливаемого параметра
	*/
	public function SetParameterValue($param_name = '', $param_value = '')
	{
		if( empty($param_name) )
			return false;
			
		switch( $param_name )
		{
			case 'opinion_col_pp':
				if( Data::Is_Number($param_value) )
					$this->opinion_col_pp = (int) $param_value;
			break;
		}
		
		return true;
	}


/************************ Автоотзывы ************************/
	/**
	* Получить автомароки
	*
	* @return array
	*/
	public function _getTreeData()
	{
		LibFactory::GetStatic('source');
		LibFactory::GetMStatic('advertise','advmgr');
		try
		{
			$obj = AdvMgr::GetSheme("auto");
		}
		catch(Exception $e)
		{
			return null;
		}

		foreach ( $this->automarka_rubrics as $k => $name )
		{
			$data[-$k] = array(
					'name' => $name,
					'parent' => 0,
					'data' => array('name' => $name, 'type' => 0),
				);

			$data_ = $obj->GetBrandsByRubricID($k);
			
			if ( count($data_) )
			{
				foreach ( $data_ as $row )
				{
					if ( $row['parent'] == 0 )
						$row['parent'] = -$k;
					$row['data'] = array('name' => $row['name'], 'type' => $row['type']);
					$data[$row['id']] = $row;
					
					$models = $obj->GetModelsByBrandAndRubricID($row['id'] , $k);
					foreach ( $models as $model )
					{
						$model['data'] = array('name' => $model['name'], 'type' => $model['type']);
						$data[$model['id']] = $model;
					}
				}
			}
			unset($data_);
		}
		
		return $data;
	}

	/**
	* Получить id-ы VIPмоделей
	*
	* @return array 
	*/
	public function _getVIPModels()
	{
		$params['is_vip'] = true;
		$params['type'] = 2;
		$params['parent'] = $this->_getVIPMarks();

		LibFactory::GetStatic('source');
		$models = Source::GetData('db.auto', $params);

		$ids = array();
		foreach ($models as $model)
			$ids[] = $model['id'];

		return $ids;
	}

	public function _getVIPMarks()
	{
		$params['is_vip'] = true;
		$params['type'] = 1;

		LibFactory::GetStatic('source');
		$marks = Source::GetData('db.auto', $params);

		$ids = array();
		foreach ($marks as $m)
				$ids[] = $m['id'];

		return $ids;
	}


	/**
	* Удалить фото к отзыву
	*
	* @return boolean
	* @param PhotoID integer - ID фото
	*/
	public function DeletePhoto($PhotoID = null)
	{
		if ( !empty($PhotoID) )
		{
			$photo = $this->GetPhotoByID($photo_id);
			LibFactory::GetStatic('filestore');

			if (trim($photo['thumb_name']) != '') {
				try {
					$img_obj = FileStore::ObjectFromString($photo['thumb_name']);
					FileStore::Delete_NEW($this->images_path.FileStore::GetPath_NEW($img_obj['file']));
					unset($img_obj);
				} catch ( MyException $e ){
					try {
						FileStore::Delete_NEW($this->images_path.FileStore::GetPath_NEW($photo['thumb_name']));
					} catch(MyException $e) {}
				}
			}

			if (trim($photo['photo_name']) != '') {
				try {
					$img_obj = FileStore::ObjectFromString($photo['photo_name']);
					FileStore::Delete_NEW($this->images_path.FileStore::GetPath_NEW($img_obj['file']));
					unset($img_obj);
				} catch ( MyException $e ){
					try {
						FileStore::Delete_NEW($this->images_path.FileStore::GetPath_NEW($photo['photo_name']));
					} catch(MyException $e) {}
				}
			}

			$sql = "DELETE
				FROM {$this->tables['photo']['table']} 
				WHERE photo_id=" . (int)$PhotoID;
			if ( empty($this->tables['photo']['db']) )
				$this->_db->query($sql);
			else
				DBFactory::GetInstance($this->tables['photo']['db'])->query($sql);
		}
	}

	/**
	* Проверка, если ли такое фото
	*
	* @return array(thumb_name, photo_name)
	* @param PhotoID integer - ID фото
	*/
	public function GetPhotoByID($PhotoID = null)
	{
		if( empty($PhotoID) )
			return false;

		$sql = "SELECT thumb_name, photo_name
			FROM $this->tables['photo']['table']} 
			WHERE photo_id=" . (int)$PhotoID;
		if ( empty($this->tables['photo']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['photo']['db'])->query($sql);

		return $res->fetch_assoc();
	}


	/**
	* Все пользователи паспорта, писавшие отзывы
	*
	* @return array
	*/
	public function GetUidByOpinion()
	{
		$array_uid = array();
		$sql = "SELECT DISTINCT uid
			FROM {$this->tables['data']['table']}
			WHERE visible=1 and uid!=0";
	
		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables["data"]['db'])->query($sql);

		while ( $row = $res->fetch_row() ) {
			$array_uid[] = $row[0];
		}
		return $array_uid;
	}

	/**
	* Общее количество отзывов к определенным моделям
	*
	* @return integer
	* @param ids array -  idы моделей
	*/
	public function GetAllOpinionByIDs($ids = null, $uid = 0)
	{
		if( empty($ids) && empty($uid))
			return 0;

		$sql = "SELECT count(*)
			FROM {$this->tables['data']['table']}";
		if (is_array($uid) && count($uid))
			$sql.= " WHERE uid in (" . implode(',', (array) $uid) . ") AND visible=1";
		elseif (is_array($ids) && count($ids))
			$sql.= " WHERE parent in (" . implode(',', (array) $ids) . ") AND visible=1";
		elseif ($uid>0)
			$sql.= " WHERE uid = ".$uid;

		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables["data"]['db'])->query($sql);
		$row = $res->fetch_row();

		return $row[0];
	}

	/**
	* Общее количество отзывов к маркам
	*
	* @return array
	*/
	public function GetCountForMark()
	{
		$sql = "SELECT parent,count(id)
			FROM {$this->tables['data']['table']}
			WHERE visible=1
			GROUP BY parent";

		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables["data"]['db'])->query($sql);

		while ( $row = $res->fetch_row() )
			$count[$row[0]] = $row[1];
		$tree = $this->_getTreeData();
		foreach ($tree as $tr) {
//			$count_mark[$tr["id"]] = $count[$tr["id"]];
			$count_mark[$tr["parent"]]+=$count[$tr["id"]];

		}
		return $count_mark;
	}
	
	/**
	 * Функция возвращает часть URL.
	 * 
	 * @return vars array - массив со структурой описанной внутри функции.
	 * @param mark bool - если true возвращает ссылку по Марке (Бренду), false - по модели. 
	 */
	public function GetModelUrl($adv=array())
	{
		return $this->GetURL($adv,false);
	}
	 
	 
 	public function GetMarkUrl($adv=array())
	{
		return $this->GetURL($adv,true);
	} 
	 
	private function GetURL($adv=array(),$mark=false)
	{
		$vars = array(
			'url' => '',
			'count' => 0
		);

		if ( !empty($adv['Model']) && isset($this->tables[0]) )
		{
			//проверка наличия отзывов
			$sql = "SELECT count(*)";
			$sql.= " FROM `". $this->tables[0] ."`";
			$sql.= " WHERE `parent` = ". $adv['Model'] ." AND `visible` = 1";
		
			$res_opinion = $this->_db->query($sql);
			
			if( $mark )
			{
				$vars['url'] = ModuleFactory::GetLinkBySectionID($this->sectionid) .'mark/'. $adv['Brand'] .'.php';	
			}
			else
			{
				if ( !empty($res_opinion) && false != ($opinion_cnt = $res_opinion->fetch_row()) && $opinion_cnt[0] )
				{
					$vars['url'] = ModuleFactory::GetLinkBySectionID($this->sectionid) .'model/'. $adv['Model'] .'.php';
					$vars['count'] = $opinion_cnt[0];
				}
				else
					$vars['url'] = ModuleFactory::GetLinkBySectionID($this->sectionid) .'mark/'. $adv['Brand'] .'.php'; 
			}
		}

		return $vars;
		
	}
	

	/**
	* Последние отзывы
	*
	* @return array
	* @param ids array -  idы моделей
	*/
	public function GetLastOpinionByIDs($ids=null, $islast=true, $start=0, $uid=0)
	{
		$opinions = array();
		if ($islast !== true ) {
		
			if( empty($ids) && empty($uid))
				return array();

			$sql = "SELECT id,parent,{$this->fields['out']}
				FROM {$this->tables['data']['table']}";

			if (is_array($uid) && count($uid))
				$sql.= " WHERE uid in ( " .implode(',', (array) $uid). " ) AND visible=1";
			elseif (is_array($ids) && count($ids))
				$sql.= " WHERE parent in ( " .implode(',', (array) $ids). " ) AND visible=1";
			elseif ($uid>0)
				$sql.= " WHERE uid = ".$uid;				

			$sql.= " ORDER BY created DESC
				LIMIT $start,".$this->opinion_col_pp;
		} else {
			// выбираем только последние отзывы
			$sql = "SELECT id,parent,{$this->fields['out']}
				FROM {$this->tables['data']['table']} ";
			if($this->is_vip)
			{
				$vipids = $this->_getVIPModels();
				if(count($vipids) > 0)
					$sql.= " WHERE parent IN(".implode(',', (array)$vipids).") ";
			}
			$sql.= "ORDER BY created DESC
				LIMIT ".$this->last_count;
		}
		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables["data"]['db'])->query($sql);
		while ( $row = $res->fetch_assoc() )
			$opinions[] = $row;
		return $opinions;
	}

	/**
	* Если ли фото к отзывам
	*
	* @return array
	* @param ids array -  idы моделей
	*/
	public function GetPhotoIsTrue($ids=null)
	{
		if( empty($ids) )
			return false;

		$is_photo = array();
		$sql = "SELECT DISTINCT adv_id
			FROM {$this->tables['photo']['table']} 
			WHERE adv_id IN(".implode(',', (array)$ids).")";
	
		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['photo']['db'])->query($sql);
	
		while ( $row = $res->fetch_row() )
			$is_photo[$row[0]] = true;		

		return $is_photo;
	}

	/**
	* Вернуть фото к конкретному отзыву
	*
	* @return array
	* @param ids array -  idы моделей
	*/
	public function GetPhotoDetails($OpinionID = null)
	{
		if( empty($OpinionID) )
			return false;

		$photos = array();

		$sql = "SELECT photo_id, thumb_name, photo_name
			FROM {$this->tables['photo']['table']} 
			WHERE adv_id=" . (int)$OpinionID;

		if ( empty($this->tables['photo']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['photo']['db'])->query($sql);
	
		while ( $row = $res->fetch_row() )
			$photos[] = $row;

		return $photos;
	}

	/**
	* Принадлежит ли отзыв пользователю
	*
	* @return array
	* @param OpinionID Integer -  id отзыва
	* @param UserID Integer -  id пользователя
	*/
	public function IsUserOpinion($OpinionID,$UserID)
	{
		if( empty($OpinionID) || empty($UserID))
			return false;
			
		$sql = "SELECT id
			FROM {$this->tables['data']['table']}
			WHERE id=" . (int)$OpinionID . " AND uid=" . (int)$UserID;

		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['data']['db'])->query($sql);
		
		if ($data = $res->fetch_assoc())
			return true;
			
		return false;
	}
	
	/**
	* Вернуть конкретный автоотзыв
	*
	* @return array
	* @param OpinionID Integer -  id отзыва
	*/
	public function GetOpinionDetails($OpinionID = null)
	{
		if( empty($OpinionID) )
			return false;

		$sql = "SELECT id,parent,{$this->fields['out']}
			FROM {$this->tables['data']['table']}
			WHERE id=" . (int)$OpinionID;

		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['data']['db'])->query($sql);

		return $data = $res->fetch_assoc();
	}

	/**
	* Вернуть параметры автоотзыва с оценками
	*
	* @return array
	* @param OpinionID Integer -  id отзыва
	*/
	public function GetOpinionParams($OpinionID = null)
	{
		if( empty($OpinionID) )
			return false;

		$params = array();

		$sql = "SELECT ParamID,MarkID,Mark,Descr
			FROM {$this->tables['param']['table']}
			WHERE OpinionID=" . (int)$OpinionID;

		if ( empty($this->tables['data']['db']) )
			$res = $this->_db->query($sql);
		else
			$res = DBFactory::GetInstance($this->tables['data']['db'])->query($sql);

		while ($data = $res->fetch_assoc()) 
			$params[$data["MarkID"]] = $data;

		return $params;
	}

	/**
	* Добавить, отредактировать отзыв
	*
	* @return Integer
	* @param action Integer - add-insert, edit-update
	* @param id Integer -  id отзыва
	* @param data array - добавляемые характеристики
	* @param count_nodes Integer - сколько моделей у вершины
	* @param uid Integer -  uid пользователя
	*/
	public function EditOpinion($uid = 0, $data = null, $count_nodes, $action="add", $id = 0)
	{
		if (is_array($data) && !empty($data)) {
			$ip 	= App::$Request->Server['REMOTE_ADDR'];
			$ip_fw	= App::$Request->Server['HTTP_X_FORWARDED_FOR'];

			$parent = $data['model'];
			if ( $parent == 0 ) // если не задана марка, то добавляем в раздел
				$parent = $data['parent'];

			if ( $action == 'add' )
				$sql = "INSERT INTO";
			else 
				$sql = "UPDATE";

			$sql.= " {$this->tables['data']['table']} SET";
			$sql.= " `uid` = ".$uid.",";
			$sql.= " `parent` = '".$parent."',";
			$sql.= " `visible`= 1,";
			$sql.= " `created` = NOW(),";
			$sql.= " `ip` = '".$ip."',";
			$sql.= " `ip_fw` = '".$ip_fw."',";
			if ( !$count_nodes )
				$sql.= " `model_name` = '".$data['model_name']."',";
			$sql.= " `year` = '".$data['year']."',";
			$sql.= " `probeg` = '".$data['probeg']."',";
			$sql.= " `probegyour` = '".$data['probegyour']."',";
			$sql.= " `srok` = '".$data['srok']."',";
			$sql.= " `volume` = '".$data['volume']."',";
			$sql.= " `enginepower` = '".$data['enginepower']."',";
			$sql.= " `gearbox` = '".$data['gearbox']."',";
			$sql.= " `drive` = '".$data['drive']."',";
			$sql.= " `descr` = '".$data['descr']."',";
			$sql.= " `new` = 1";

			if ( $action == 'edit' )
				$sql.= " WHERE `id` = ".$id;

			if ( empty($this->tables['data']['db']) )
			{
				$this->_db->query($sql);
				if ( $action == 'add' )
					$id = $this->_db->insert_id;
			}
			else
			{
				$db = DBFactory::GetInstance($this->tables['data']['db']);
				$db->query($sql);
				if ( $action == 'add' )
					$id = $db->insert_id;
			}

		}
		return $id;
	}

	/**
	* Добавить фотки к отзыву
	*
	* @param id Integer -  id отзыва
	* @param photo array - добавляемые фото 
	*/
	public function AddPhoto($id = 0, $photo = null)
	{
		if ($id && !empty($photo)) 
		{
			$sql = "INSERT INTO {$this->tables['photo']['table']}
				SET adv_id=$id,
				photo_name='".addslashes($photo['large'])."',
				thumb_name='".addslashes($photo['small'])."'";
			if ( empty($this->tables['photo']['db']) ) {
				$this->_db->query($sql);
			} else {
				DBFactory::GetInstance($this->tables['photo']['db'])->query($sql);		
			}
		}
	}

	/**
	* Добавить оценки к отзыву
	*
	* @param id Integer -  id отзыва
	* @param params array - добавляемые оценки
	* @param params_descr array - добавляемые комментарии
	*/
	public function AddParams($id = 0, $params = null, $params_descr = null)
	{
		if ($id && !empty($params)) 
		{
			//Удалить предыдущие оценки
			$sql = "DELETE FROM {$this->tables['param']['table']}
				WHERE OpinionID=$id";
			if ( empty($this->tables['param']['db']) )
				$this->_db->query($sql);
			else
				DBFactory::GetInstance($this->tables['param']['db'])->query($sql);		

			$grade = 0;
			foreach ($params as $k => $p) {
				$sql = "INSERT INTO {$this->tables['param']['table']}
					SET OpinionID=$id,
					MarkID='{$k}',
					Mark='{$p}',
					Descr='{$params_descr[$k]}'";
				if ( empty($this->tables['param']['db']) )
					$this->_db->query($sql);
				else
					DBFactory::GetInstance($this->tables['param']['db'])->query($sql);		
				$grade+=$p;
			}
			$sql = "UPDATE {$this->tables['data']['table']}
				SET grade=".$grade." WHERE id=$id";
			if ( empty($this->tables['param']['db']) )
				$this->_db->query($sql);
			else
				DBFactory::GetInstance($this->tables['param']['db'])->query($sql);		
		}
	}			

	/**
	* Предупредить модератора о подозрительном отзыве
	*
	* @param id Integer -  id отзыва
	*/
	public function _Add_Alert($id = 0, $type = 0)
	{
		if ($id>0) {
			$sql = "REPLACE INTO ".$this->tables['alert']['table'];
			$sql.= "(id,type)";
			$sql.= "VALUES";
			$sql.= "(".$id.",".$type.")";
			$this->_db->query($sql);	

			$sql = "UPDATE ".$this->tables['data']['table'];
			$sql.= " SET new=1";
			$sql.= " WHERE id=".$id;
			$this->_db->query($sql);	
		}
	}

}
?>