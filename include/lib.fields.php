<?php

//2do: типы полей добавлять по мере надобности

class Fields
{
	static $FIELD_TYPE = array(
		'string' => array('name' => 'Строка'),
		'text' => array('name' => 'Текстовое поле'),
		'number' => array('name' => 'Целое число'),
		'float' => array('name' => 'Вещественное число'),
		'image' => array('name' => 'Картинка'),
		'datetime' => array('name' => 'Дата и время'),
		'date' => array('name' => 'Дата'),
		'checkbox' => array('name' => 'Галочка'),
		'select' => array('name' => 'Список'),
	);
	
	/**
	* Возвращает список добавочных полей
	*
	* @param $fields - список полей
	* @param $add_string - array('o.', 'o_') - для сложных запросов
	*/
	static function Get_AddFields($fields, $add_string = null)
	{
		$add_fields = array();
		$add_field = "";
		if(count($fields))
			foreach($fields as $k=>$v)
				if(!isset($add_fields[$k]))
				{
					$add_fields[$k] = $v;
					$add_field.= ", ".(isset($add_string[0])?$add_string[0]:"") . $k . ((isset($add_string[1]) && $add_string[1]!="")?" AS ".$add_string[1].$k:"");
				}

		return array($add_fields, $add_field);
	}
	
	
	/**
	* Подготовка полей для возврата в шаблон
	*
	* @param $mod - экземпляр класса владельца
	* @param $fields - полный список полей
	* @param $add_fields - список необходимых полей
	* @param $row - массив полей
	* @param $params - параметры для форматирования данных
	* @param $get_array - выдергивать мыссивы необходимые для полей.
	* @exception BTException
	*/
	static function Get_Prepared_Fields(&$mod, $fields, $add_fields, $row = array(), $params = array(), $get_array = true)
	{
		if($add_fields === null)
			$add_fields = $fields;
		if(count($add_fields))
		{
			foreach($add_fields as $k=>$v1)
			{
				$v = $fields[$k];
				// текстовое поле
				if($v["ftype"]=="text")
				{
					$row[$k] = $row[$k];
				}
				// дата и время
				else if($v["ftype"]=="datetime")
				{
					$row[$k] = strtotime($row[$k]);
				}
				// дата
				else if($v["ftype"]=="date")
				{
					$row[$k] = strtotime($row[$k]);
				}
				// картинка
				else if($v["ftype"]=="image")
				{
					LibFactory::GetStatic('filestore');
					LibFactory::GetStatic('images');
					
					if( !empty($row[$k]) )
					{
						try
						{
							$img_obj = FileStore::ObjectFromString($row[$k]);
							$img_obj['file'] = FileStore::GetPath_NEW($img_obj['file']);
							$row[$k] = Images::PrepareImageFromObject($img_obj, $params['photo']['images']['path'], $params['photo']['images']['url']);
							unset($img_obj);
						}
						catch ( MyException $e )
						{
							// пустая картинка
							$row[$k] = Images::PrepareImageFromObject($params['photo']['empty_img']['meta'], '', $params['photo']['empty_img']['url']);
						}
					}
					else
						$row[$k] = Images::PrepareImageFromObject($params['photo']['empty_img']['meta'], '', $params['photo']['empty_img']['url']);
				}
				// список
				else if($v["ftype"]=="select")
				{
					$row[$k] = Data::ChangeQuotes($row[$k]);
					if( $get_array === true )
					{
						if(isset($v["params"]["arr_id"]))
							$row['arrays'][$k] = $mod->_GetArray($v["params"]["arr_id"]);
						else
							$row['arrays'][$k] = array();
					}
				}
			}
		}
			
		return $row;
	}
	
	
	/**
	* Подготовка полей для возврата в шаблон
	*
	* @param $mod - экземпляр класса владельца
	* @param $fields - полный список полей
	* @param $add_fields - список необходимых полей
	* @param $get_array - выдергивать мыссивы необходимые для полей.
	*/
	static function Get_Prepared_Arrays(&$mod, $fields, $add_fields)
	{
		$list = array();
		if($add_fields === null)
			$add_fields = $fields;
		if(count($add_fields))
			foreach($add_fields as $k=>$v1)
			{
				$v = $fields[$k];
				// список
				if($v["ftype"]=="select")
				{
					if(isset($v["params"]["arr_id"]))
						$list[$k] = $mod->_GetArray($v["params"]["arr_id"]);
					else
						$list[$k] = array();
				}
			}
			
		return $list;
	}
	
	
	/**
	* Проверяет поля перед сохранением
	* !!! Этот метод нигде не используется !!!
	*
	* @param $mod - экземпляр класса владельца
	* @param $fields - полный список полей
	* @param $add_fields - список необходимых полей
	* @param arrp array - POST
	* @param arrf array - FILES
	* @param $params - параметры для форматирования данных
	*/
	static function CheckFields(&$mod, $fields, $add_fields = null, $arrp = array(), $arrf = array(), $params = array())
	{
		
		$err = array();

		if($add_fields === null)
			$add_fields = $fields;

		if(count($add_fields))
			foreach($add_fields as $k=>$v1)
			{
				$v = $fields[$k];
				// картинка
				if($v["ftype"]=="image")
				{
					if ($arrf[$k]['name'])
					{
						if( ($arrf[$k]['size']/1024) > $v["params"]["size"] )
							$err[$k]= sprintf('Изображение "%1$s" должно быть не более %2$s Кб!', $v["name"], $v["params"]["size"]);
							
						$imginfo = @getimagesize($arrf[$k]['tmp_name']);
						if($imginfo === false)
							$err[$k]= sprintf("Файл '%s' не является изображением!", $arrf[$k]['name']);
						else if( ($imginfo[0]>$v["params"]["w"]) || ($imginfo[1]>$v["params"]["h"]) )
							$err[$k]= sprintf('Изображение "%1$s" должно быть не более %2$sx%3$spx!', $v["name"], $v["params"]["w"], $v["params"]["h"]);
					}
				}
				// дата и время
				if($v["ftype"]=="datetime")
				{
					if (!(checkdate($arrp[$k."_Month"], $arrp[$k."_Day"], $arrp[$k."_Year"])
					&& ($arrp[$k."_Hour"]>=0 && $arrp[$k."_Hour"]<=23)
					&& ($arrp[$k."_Minute"]>=0 && $arrp[$k."_Minute"]<=59)
					))
						$err[$k]= ($v["name"]?$v["name"].": ":"")."Неверная дата!";
				}
				// дата
				if($v["ftype"]=="date")
				{
					if (!checkdate($arrp[$k."_Month"], $arrp[$k."_Day"], $arrp[$k."_Year"]))
						$err[$k]= ($v["name"]?$v["name"].": ":"")."Неверная дата!";
				}
				// number
				if($v["ftype"]=="number")
				{
					if (!Data::Is_Number($arrp[$k]))
						$err[$k]= ($v["name"]?$v["name"].": ":"")."Неверное число!";
				}
				// float
				if($v["ftype"]=="float")
				{
					if (!is_numeric($arrp[$k]))
						$err[$k]= ($v["name"]?$v["name"].": ":"")."Неверное число!";
				}
				// text
				if($v["ftype"]=="text")
				{
					if(isset($v['params']['max_len']))
						if(strlen($arrp[$k]) > $v['params']['max_len'])
							$err[$k]= sprintf('Длина текста "%1$s" не может превышать %2$s символов!', $v["name"], $v['params']['max_len'])."<br>\n";
				}
				// string
				if($v["ftype"]=="string")
				{
					if(isset($v['params']['max_len']))
						if(strlen($arrp[$k]) > $v['params']['max_len'])
							$err[$k]= sprintf('Длина текста "%1$s" не может превышать %2$s символов!', $v["name"], $v['params']['max_len'])."<br>\n";
				}
			}
		if(count($err))
			return $err;
		else
			return true;
	}


	/**
	* Сохраняет поля
	*
	* @param $mod - экземпляр класса владельца
	* @param $fields - полный список полей
	* @param $id - ID наименования
	* @param $add_fields - список необходимых полей
	* @param arrp array - POST
	* @param arrf array - FILES
	* @param $params - параметры для форматирования данных
	* @exception BTException
	*/
	static function SaveFields(&$mod, $fields, $add_fields = null, $id, $arrp = array(), $arrf = array(), $params = array())
	{
		$err = array();
		
		if($add_fields === null)
			$add_fields = $fields;

		$sqlt="";
		if(count($add_fields))
		{
			foreach($add_fields as $k=>$v1)
			{
				$v = $fields[$k];
				// картинка
				if($v["ftype"]=="image")
				{
					if ($arrp["check_".$k])
					{
						// выборка из базы названия текущей картинки
						$sql_img = 'SELECT ' . $k . ' FROM ' . $params['tbl'];
						$sql_img.= ' WHERE item_id = ' . $id;
						$res_img = $params['db']->query($sql_img);
						
						if( ($row_img = $res_img->fetch_row()) && !empty($row_img[0]) )
						{
							LibFactory::GetStatic('filestore');
							
							try
							{
								$img_obj = FileStore::ObjectFromString($row_img[0]);
								$img = $params['photo']['images']['path'] . FileStore::GetPath_NEW($img_obj['file']);
								FileStore::Delete_NEW($img);
								unset($img_obj);
							}
							catch ( MyException $e )
							{
								try
								{
									FileStore::Delete_NEW($params['photo']['images']['path'] . FileStore::GetPath_NEW($row_img[0]));
								}
								catch ( MyException $e )
								{
									$err[] = 'Не получилось удалить изображение.';
									break;
								}
							}
							
							$sqlt.= ($sqlt?", ":" ").$k." = ''";
						}
					}
					else
					{
						if ( !empty($arrf[$k]['name']) )
						{
							LibFactory::GetStatic('filestore');
							LibFactory::GetStatic('filemagic');
							LibFactory::GetStatic('images');
						
							//Delete OLD Image
							
							// выборка из базы названия текущей картинки
							$sql_img = 'SELECT ' . $k . ' FROM ' . $params['tbl'];
							$sql_img.= ' WHERE item_id = ' . $id;
							$res_img = $params['db']->query($sql_img);
							
							if( ($row_img = $res_img->fetch_row()) && !empty($row_img[0]) )
							{
								try
								{
									$img_obj = FileStore::ObjectFromString($row_img[0]);
									$img = $params['photo']['images']['path'] . FileStore::GetPath_NEW($img_obj['file']);
									FileStore::Delete_NEW($img);
									unset($img_obj);
								}
								catch ( MyException $e )
								{
									try
									{
										FileStore::Delete_NEW($params['photo']['images']['path'] . FileStore::GetPath_NEW($row_img[0]));
									}
									catch ( MyException $e )
									{
										$err[] = 'Не получилось удалить изображение.';
										break;
									}
								}
							}

							// Upload Image
							$pr = 'small'; // только маленькая картинка
						
							$prefix = $id . '_' . $k . $params[$pr]['prefix'];
						
							try
							{
								$fname = FileStore::Upload_NEW(
									$k,
									$params['photo']['images']['path'],
									$prefix,
									FileMagic::MT_WIMAGE,
									$params['photo'][$pr]['max_size'],
									$params['photo'][$pr]['params']
								);
							}
							catch (BTException $e)
							{
								$err[] = 'Не получилось загрузить изображение.';
								break;
							}
							
							$fname = FileStore::GetPath_NEW($fname);
							$fname = Images::PrepareImageToObject($fname, $params['photo']['images']['path'], $params['photo']['images']['url']);
							$fname = FileStore::ObjectToString($fname);
							
							$sqlt.= ($sqlt?", ":" ").$k." = '".$fname."'";
						}
					}
				}
				// дата и время
				else if($v["ftype"]=="datetime")
				{
					$sqlt.= ($sqlt?", ":" ").$k." = '".$arrp[$k."_Year"]."-".$arrp[$k."_Month"]."-".$arrp[$k."_Day"]." ".$arrp[$k."_Hour"].":".$arrp[$k."_Minute"].":00"."'";
				}
				// дата
				else if($v["ftype"]=="date")
				{
					$sqlt.= ($sqlt?", ":" ").$k." = '".$arrp[$k."_Year"]."-".$arrp[$k."_Month"]."-".$arrp[$k."_Day"]."'";
				}
				// галка
				else if($v["ftype"]=="checkbox")
				{
					$sqlt.= ($sqlt?", ":" ").$k." = '".($arrp[$k]?"1":"0")."'";
				}
				else
					$sqlt.= ($sqlt?", ":" ").$k." = '".addslashes($arrp[$k])."'";
			}
		}
		
		if($sqlt)
		{
			if ($params['new'] === true)
			{
				$sql = "INSERT INTO ".$params["tbl"]." SET";
				$sql.= " item_id = ".$id;
				$sql.= ", type = ".$params['type'].", ";
				$sql.= $sqlt;
			}
			else
			{
				$sql = "UPDATE ".$params["tbl"]." SET";
				$sql.= $sqlt;
				if (isset($params['id_name']))
					$sql.= " WHERE `".$params['id_name']."`=".$id;
				else
					$sql.= " WHERE id=".$id;
			}
			$params['db']->query($sql);
		}

		if(count($err))
			return $err;
		else
			return true;
	}


	/**
	* Удаляет позицию с полями
	*
	* @param $mod - экземпляр класса владельца
	* @param $fields - полный список полей
	* @param $row - данные
	* @param $params - параметры для форматирования данных
	* @exception BTException
	*/
	static function DeleteFields(&$mod, $fields, $row, $params = array())
	{
		foreach($fields as $k=>$v)
		{
			// если это картинка
			if( $v["ftype"]=="image" && !empty($row[$k]) )
			{
				LibFactory::GetStatic('filestore');
					
				try
				{
					$img_obj = FileStore::ObjectFromString($row[$k]);
					$img = $params['photo']['images']['path'] . FileStore::GetPath_NEW($img_obj['file']);
					FileStore::Delete_NEW($img);
					unset($img_obj);
				}
				catch ( MyException $e )
				{
					try
					{
						FileStore::Delete_NEW($params['photo']['images']['path'] . FileStore::GetPath_NEW($row[$k]));
					}
					catch ( MyException $e ) {}
				}
			}
		}
	}


}

?>