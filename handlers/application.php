<?
/**
 * Хендлер для работы с приложениями
 * @package Handlers
 */

class Handler_application extends IHandler
{
	private $blocks = array();
	private $objects = array();
	private $params = array();
	private $application = null;
	
	public function Init($params)
	{
		global $OBJECTS, $CONFIG;
		$this->params = $params;

		include_once $CONFIG['engine_path']."include/smarty_v2.php";
		include_once $CONFIG['engine_path']."include/misc.php";
		include_once $CONFIG['engine_path']."include/json.php";
		include_once $CONFIG['engine_path']."include/title.php";
		LibFactory::GetStatic('application');
		LibFactory::GetStatic('data');

		$host = $_SERVER['HTTP_HOST'];
		if(strpos($host, 'www.') === 0)
			$host = substr($host, 4);
		if(strpos($host, 'dvp.') === 0)
			$host = substr($host, 4);

		$CONFIG['env']['site']	= ModuleFactory::GetConfigById('site', $CONFIG['siteid_v2'][$host]);
		$CONFIG['env']['site']['domain'] = $host;
		$CONFIG['env']['regid']	= Data::Is_Number($CONFIG['tree'][ $CONFIG['env']['site']['tree_id'] ]['regions'])?$CONFIG['tree'][ $CONFIG['env']['site']['tree_id'] ]['regions']:0;
		$CONFIG['env']['section'] = $params['params']['section'];

		// TEMPORARY
		if(in_array($CONFIG['env']['regid'], $CONFIG['env']['svoi_regions']))
			$CONFIG['env']['svoi'] = true;

		$OBJECTS['title'] = new Title();
		$OBJECTS['smarty'] = new CSmarty();
		if($_GET['nocache'] > 10)
		{
			$OBJECTS['smarty']->caching = 0;
			$OBJECTS['smarty']->force_compile = true;
        }
		else
		{
			$OBJECTS['smarty']->caching = $CONFIG['env']['site']['cache_mode'];
			$OBJECTS['smarty']->force_compile = $CONFIG['env']['site']['debug'];
		}

		$OBJECTS['smarty']->assign_by_ref('GLOBAL_ENV', App::$Global);
		$OBJECTS['smarty']->assign_by_ref('CURRENT_ENV', $CONFIG['env']);		

		$OBJECTS['smarty']->assign_by_ref('TITLE', $OBJECTS['title']);
		$OBJECTS['smarty']->assign_by_ref('UERROR', $OBJECTS['uerror']);
		$OBJECTS['smarty']->assign_by_ref('BLOCKS', $this->blocks);
		$OBJECTS['smarty']->assign_by_ref('USER', $OBJECTS['user']);
		
		$this->application = ApplicationMgr::GetInstance($params["params"]['name'], $params["params"]['folder'], $params);
		return true;
	}
	
	public function Run()
	{
		global $OBJECTS, $CONFIG;

		foreach($this->application->Config['blocks'] as $k=>$b)
		{
			if(count($b)>0)
				foreach($b as $k2 => $v)
				{
					if( !isset($v['type']) )
						continue;

					if( isset($v['sectionid']) )
						$id = $v['sectionid'];
					else
						unset($id);

					if($v['type'] == 'this')
					{
						$this->objects[$k.'/'.$k2] = $this->application;
						if($v['name'] == 'main')
						{
							$this->blocks[$k][$k2] = $this->application->Run($this->params['params']['query']);
						}
						else
							$this->blocks[$k][$k2] = $this->application->GetBlock($v['name'], $v['template'], $v['lifetime'], $v['params']);
                    }
					elseif( $v['type'] == 'component' || $v['type'] == 'widget')
					{
						$p = strrpos($v['name'], '/');
						if($p === false)
							continue;

						$folder = substr($v['name'], 0, $p);
						$name = substr($v['name'], $p + 1);

						$showed = true;
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
							if($v['type'] == 'component')
								$this->objects[$k.'/'.$k2] = ApplicationMgr::GetInstance($v['name'], null, array());
							
							if($v['ref']['link'])
							{
								foreach($v['ref']['link'] as $l)
								{
									$v1 =& $this->GetValue($l['source']);
									if($v['type'] == 'container')
										$this->SetValue($l['destination'], $v1, $k.'/'.$k2);
									elseif($v['type'] == 'widget')
									{
										if(substr($l['destination'], 0, 5) == '$this')
										{
											$v['params'][substr($l['destination'], 6)] = $v1;
										}
									}
								}
							}

							if($v['type'] == 'component')
								$this->blocks[$k][$k2] = $this->objects[$k.'/'.$k2]->Run($v['page']);
							elseif($v['params']['method'] != 'sync')
							{
								LibFactory::GetStatic('container');
								$this->blocks[$k][$k2] = Container::GetWidgetInstance($v['name'], null, $v['params']);
							}
							else
							{
								LibFactory::GetStatic('container');
								$this->blocks[$k][$k2] = Container::GetWidgetInstance($v['name'], null, $v['params'], Container::HTML);
							}
						}
                    }
					elseif( isset($id) || ($id = ModuleFactory::GetSectionId($v['site'], $v['section'])) !== false)
						$this->blocks[$k][$k2] = ModuleFactory::GetBlock(
								$v['type'], $id, $v['name'],
								$v['template'],	$v['lifetime'],	$v['params']
								);
					else
					{
						Data::e_backtrace("Can't get instance of section or application; type=".$v['type']."; (old)siteID=".$v['site']."; section=".$v['section']);
						$this->blocks[$k][$k2] = "";
					}
				}

			//ApplicationMgr::Redirect($pattern, $folder, $name, $id, $url);
		}

		$OBJECTS['smarty']->caching=0;
		$OBJECTS['smarty']->display($this->application->Config['templates']['index']);
		
		return true;
	}

	public function IsLast()
	{
		return true;
	}
	
	public function Dispose()
	{
		$this->application->Dispose();
		return true;
	}

	private function &GetValue(&$value, $ths = '')
	{
		if(substr($value, 0, 5) == '$this')
		{
			$value = '$'.$ths.substr($value, 5);
        }
		if(substr($value, 0, 1) == '$')
		{
			$v = explode(':', substr($value, 1));
			return $this->objects[$v[0]]->GetPropertyByRef($v[1]);
		}
		else
			return $value;
    }

	private function SetValue($name, &$value, $ths = '')
	{
		if(substr($name, 0, 5) == '$this')
		{
			$name = '$'.$ths.substr($name, 5);
        }
		if(substr($name, 0, 1) == '$')
		{
			$v = explode(':', substr($name, 1));
			$this->objects[$v[0]]->SetPropertyByRef($v[1], $value);
		}
    }
}
?>