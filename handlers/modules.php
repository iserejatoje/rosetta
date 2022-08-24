<?
/**
 * Хендлер для работы с модулями
 * @package Handlers
 */
class Handler_modules extends IHandler
{
	private $blocks = array();
	private $objects = array();

	public function Init($params)
	{
	
		global $OBJECTS, $CONFIG;

		//!!!!!!(FOR_COMPATIBLE_V1)
		global $DCONFIG;
		//!!!!!!(FOR_COMPATIBLE_V1):END

		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		include_once $CONFIG['engine_path']."include/lib.stpl.php";
		include_once $CONFIG['engine_path']."include/misc.php";
		include_once $CONFIG['engine_path']."include/title.php";

		//!!!!!!(FOR_COMPATIBLE_V1) //2do надо убрать, т.к. переделываем в модуль
		include_once $CONFIG['engine_path']."include/blocks.php";

		LibFactory::GetStatic('data');

		// создаем окружение
		$host = $_SERVER['HTTP_HOST'];

		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);			
		
		$pos = strpos($_SERVER['REQUEST_URI'], '?');
		if($pos === false)
			$url = $_SERVER['REQUEST_URI'];
		else
			$url = substr($_SERVER['REQUEST_URI'], 0, $pos);
		
		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['url'] = $url;
		$CONFIG['env']['uri'] = $_SERVER['REQUEST_URI'];
		
		$sid_v2 = STreeMgr::GetSiteIDByHost($host);
		
		$sn = STreeMgr::GetNodeByID($sid_v2);
		$regid	= Data::Is_Number($sn->Regions)?$sn->Regions:0;
		
		$CONFIG['env']['ns'] = ModuleFactory::GetSectionInfoByPath($sid_v2, $url);
		
		if($CONFIG['env']['ns']['ns'] === null || $CONFIG['env']['ns']['sectionid'] === null || $CONFIG['env']['ns']['sectionid'] == 0)
			Response::Status(404, RS_SENDPAGE | RS_EXIT);

		$CONFIG['env']['sectionid']	= $CONFIG['env']['ns']['sectionid'];
		$CONFIG['env']['params'] = $CONFIG['env']['ns']['params'];
				
		$CONFIG['env']['section'] = ModuleFactory::GetLinkBySectionId(
			$CONFIG['env']['ns']['sectionid'],
			$CONFIG['env']['ns']['nsparams'],
			false
		);
		
		$CONFIG['env']['host'] = $_SERVER['HTTP_HOST'];

		$CONFIG['env']['siteinfo'] = $sn->ToArray();
		$node = STreeMgr::GetNodeByID($CONFIG['env']['ns']['sectionid']);
		$CONFIG['env']['sectioninfo'] = $node->ToArray();

		$CONFIG['env']['regid']	= Data::Is_Number($sn->Regions)?$sn->Regions:0;

		$CONFIG['env']['site'] = $CONFIG['env']['ns']['ns']->GetEnv($sid_v2, $CONFIG['env']['ns']['sectionid']);

		$CONFIG['env']['site']['tree_id'] = $sid_v2;

		// тут установлен design
		STPL::SetTheme($CONFIG['env']['site']['design']);

		$CONFIG['env']['site']['domain'] = $host;

		unset($host);

		// устанавливаем внешнюю кодировку
		if( $node !== null && strlen($node->ExternalEncoding) > 0 )
			App::SetExternalEncoding($node->ExternalEncoding);
		if( App::IsEncode() === true )
		{
			// включаем буферизацию с перекодировкой
			Response::StartEncodeBuffering();
		}

		// создаем необходимые объекты
		$OBJECTS['title'] = new Title();
		$OBJECTS['smarty'] = new CSmarty();
		$OBJECTS['smarty']->assign('MAIN_DOMAIN', MAIN_DOMAIN);

		header('Content-type: text/html; charset=utf-8');
		$OBJECTS['title']->Add('meta', array('http-equiv' => 'Content-Type', 'content' => 'text/html;charset=utf-8'));

		// установка глобальных стилей и скриптов из окружения сайта
		//if(is_array($CONFIG['env']['site']['scripts']))
			//$OBJECTS['title']->AddScripts($CONFIG['env']['site']['scripts']);

		//if(is_array($CONFIG['env']['site']['styles']))
			//$OBJECTS['title']->AddStyles($CONFIG['env']['site']['styles']);

		// установим для тайтла базовые параметры
		// 2do: Это надо убрать
		
		/*if(!empty($CONFIG['env']['site']['sitetitle']))
			$OBJECTS['title']->Title = $CONFIG['env']['site']['sitetitle'];
		else
			$OBJECTS['title']->Title = $CONFIG['env']['site']['domain'];*/
		
		
		
		// установим параметры заголовка: КОНЕЦ
		
		
		//!!!!!!(FOR_COMPATIBLE_V1)
		$DCONFIG['section']	= $CONFIG['env']['section'];
		$DCONFIG['params']	= $CONFIG['env']['params'];
		$DCONFIG['title'] =& $OBJECTS['title'];
		$DCONFIG['smarty'] = & $OBJECTS['smarty'];

		$snode = STreeMgr::GetNodeByID($CONFIG['env']['site']['tree_id']);

		$CONFIG['smarty']['title'] =& $CONFIG['env']['site']['title'];
		$DCONFIG['smarty']->assign('SITE_SECTION', $DCONFIG['section']);
		$DCONFIG['smarty']->assign('GLOBAL', $CONFIG['smarty']);
		//!!!!!!(FOR_COMPATIBLE_V1):END

		// убрать эти переменные из массива.
		unset($_GET['section'], $_GET['params']);

		// выставляем настройки сайта для объектов
		if($CONFIG['env']['site']['debug'] == true)
			$OBJECTS['smarty']->force_compile = true;
		if(isset($CONFIG['env']['site']['cache_mode']))
			$OBJECTS['smarty']->caching = $CONFIG['env']['site']['cache_mode'];

		// отключаем кэш
		//if(isset($_GET['nocache']) && $_GET['nocache']>10)
		//{
			$OBJECTS['smarty']->caching = 0;
			$OBJECTS['smarty']->force_compile = true;
		//}

		// отдаем окружение в смарти (по ссылке!!!)
		$OBJECTS['smarty']->assign_by_ref('GLOBAL_ENV', App::$Global);
		$OBJECTS['smarty']->assign_by_ref('CURRENT_ENV', $CONFIG['env']);
		// отдаем необходимые объекты в смарти (по ссылке!!!)
		$OBJECTS['smarty']->assign_by_ref('TITLE', $OBJECTS['title']);
		$OBJECTS['smarty']->assign_by_ref('UERROR', $OBJECTS['uerror']);
		$OBJECTS['smarty']->assign_by_ref('BLOCKS', $this->blocks);
		$OBJECTS['smarty']->assign_by_ref('USER', $OBJECTS['user']);

		App::SetTitleObject($OBJECTS['title']);
		App::SetUserErrorObject($OBJECTS['uerror']);
		App::SetUserObject($OBJECTS['user']);

		return true;
	}

	public function Run()
	{
		if($_GET['usebe'] > 10)
			$this->RunBlocksNew();
		else
			$this->RunBlocksOld();
	}

	// новый обработчик блоков
	public function RunBlocksNew()
	{
		global $OBJECTS, $CONFIG;

		// Создаем объект основного модуля
		ModuleFactory::SetModuleAction();
		$OBJECTS['user']->SectionID = $CONFIG['env']['sectionid'];

		BLFactory::GetInstance('system/blocks');		// загрузка фабрики блоков

		$blocks = BlockFactory::GetRootBlocks($CONFIG['env']['site']["tree_id"]);
		foreach($blocks as $blockid)
		{
			$block = BlockFactory::GetInstance($blockid);
			echo $block->Render();
		}
	}

	// старый обработчик блоков
	public function RunBlocksOld()
	{
		global $OBJECTS, $CONFIG;

		// Создаем объект основного модуля
		ModuleFactory::SetModuleAction();
		$OBJECTS['user']->SectionID = $CONFIG['env']['sectionid'];
		// Запускаем основной модуль

		if( $GLOBALS['engine_no_action'] !== true )
		{
			if(ModuleFactory::GetModuleAction()->Action($CONFIG['env']['params']) !== true)
			{
				foreach(ModuleFactory::GetModuleAction()->Config['blocks'] as $k=>$b)
				{
					if(is_array($b) && count($b)>0)
						foreach($b as $k2 => $v)
						{
							if($v['type'] == 'this')
							{
								$this->objects[$k.'/'.$k2] = ModuleFactory::GetModuleAction();
							}
							
							// здесь можно будет потом написать WARNING куданить... чтобы отловить те места, где блоки определены по-старому
							if( $v['post'] === true && $showed === true && $v['type'] == 'block' && isset($id) )
							{
								$this->objects[$k.'/'.$k2] = ModuleFactory::GetInstance($id, $v['params']);
								if($this->objects[$k.'/'.$k2]->Action($CONFIG['env']['params']))
								{
									break 2;
								}
							}
						}
				}
			}
		}

		

		// 1 версия
		//	engine_v1 include engine_block
		// 2 версия
		//	this block widget
		// виджеты
		//	widget
		// привязки
		// this | block <- widget | block

		// формирование левого и правого блоков
		$___block_v1 = array('engine_v1', 'include');//, 'engine_block');
		foreach(ModuleFactory::GetModuleAction()->Config['blocks'] as $k=>$b)
		{

			if(is_array($b) && count($b)>0)
				foreach($b as $k2 => $v)
				{
					$showed = true;
					if( !isset($v['type']) )
						continue;

					if(in_array($v['type'], $___block_v1) )
					{
						$start_block = microtime(true);
						$start_block_memory = memory_get_usage();
						$other_params = array();

						if($v['type'] == 'engine_v1') $v['type'] = $v['old_type'];
							$this->blocks[$k][$k2] = ModuleFactory::GetBlock_v1(
								$v['type'], $v['section'], $v['block'],
								$v['template'],	$v['lifetime'],	$v['params'],
								$v['path']
								);
						$other_params[] = $v['block'];
						$other_params[] = $v['section'];
					}
					else
					{
						// для совместимости со старым типом определения блоков движка. сделали преобразование
						if( isset($v['sectionid']) )
							$id = $v['sectionid'];
						else
							unset($id);

						// собрать массив с данными
						// значение можно получить только от отрендеренных блоков
						// отдать в инициализацию

						if($v['type'] == 'block' || $v['type'] == 'widget')
						{
							if($v['type'] == 'widget')
							{
								$p = strrpos($v['name'], '/');
								if($p === false)
									continue;

								$folder = substr($v['name'], 0, $p);
								$name = substr($v['name'], $p + 1);
							}

							if(isset($v['ref']))
							{
								if(isset($v['ref']['condition']))
								{
									foreach($v['ref']['condition'] as $cond)
									{
										$v1 =& $this->GetValue($cond['field']);
										$v2 =& $this->GetValue($cond['value']);

										if(!ApplicationMgr::GetCompareProvider($cond['type'])->Compare($v1, $v2))
										{
											$showed = false;
											break;
	                                    }
	                                }
	                            }
	                        }

							if($showed == true)
							{
								if($v['ref']['link'])
								{
									foreach($v['ref']['link'] as $l)
									{
										$v1 =& $this->GetValue($l['source']);
										if(substr($l['destination'], 0, 5) == '$this')
										{
											$v['params'][substr($l['destination'], 6)] = $v1;
										}
	                                }
	                            }

							}
						}

						// здесь можно будет потом написать WARNING куданить... чтобы отловить те места, где блоки определены по-старому
						if($showed === true)
						{
							$start_block = microtime(true);
							$start_block_memory = memory_get_usage();
							$other_params = array();

							if($v['type'] == 'widget')
							{
								$other_params[] = $v['name'];
								if($v['params']['method'] == 'ssi') {
									LibFactory::GetStatic('container');
									$this->blocks[$k][$k2] = Container::GetWidgetInstance($v['name'], null, $v['params'], Container::SSI);
								}
								elseif($v['params']['method'] != 'sync')
								{
									LibFactory::GetStatic('container');
									$this->blocks[$k][$k2] = Container::GetWidgetInstance($v['name'], null, $v['params']);
									//continue; // дальше не надо
								}
								else
								{
									LibFactory::GetStatic('container');
									$this->blocks[$k][$k2] = Container::GetWidgetInstance($v['name'], null, $v['params'], Container::HTML);
									//continue; // дальше не надо
								}

							}
							elseif($v['type'] == 'engine_block')
							{
								if( isset($v['block']) )
									$v['name'] = $v['block'];
								$other_params[] = $v['name'];
								$this->blocks[$k][$k2] = ModuleFactory::GetBlock(
										$v['type'], $id, $v['name'],
										$v['template'],	$v['lifetime'],	$v['params']
										);
							}
							elseif(	isset($id) || $v['type'] == 'this' )
							{
								if($v['type'] == 'this' && !isset($this->objects[$k.'/'.$k2]))
								{
									$this->objects[$k.'/'.$k2] = ModuleFactory::GetModuleAction();
								}
								elseif($v['type'] == 'block' && !isset($this->objects[$k.'/'.$k2]))
								{
									$this->objects[$k.'/'.$k2] = ModuleFactory::GetInstance($id, $v['params']);
								}
								$other_params[] = $v['name'];
								$this->blocks[$k][$k2] = ModuleFactory::GetBlock(
										$v['type'], $id, $v['name'],
										$v['template'],	$v['lifetime'],	$v['params']
										);
							}
							else
							{
								Data::e_backtrace("Can't get instance of section; type=".$v['type']."; (old)siteID=".$v['site']."; section=".$v['section']);
								$this->blocks[$k][$k2] = "";
							}
						}
					}

				}
		}



		if( $GLOBALS['engine_no_action'] !== true )
		{
			$OBJECTS['smarty']->caching=1;
			$OBJECTS['smarty']->assign_by_ref('TEMPLATE', ModuleFactory::GetModuleAction()->Config['templates']);
			$OBJECTS['smarty']->display(ModuleFactory::GetModuleAction()->Config['templates']['index']);
		}

		return true;
	}

	public function Dispose()
	{
		return true;
	}

	private function &GetValue(&$value, $ths = '')
	{
		$v = explode(':', substr($value, 1));
		if(substr($value, 0, 1) == '$' && is_callable(array($this->objects[$v[0]], 'GetPropertyByRef')))
		{
			return $this->objects[$v[0]]->GetPropertyByRef($v[1]);
		}
		else
			return $value;
    }
}
