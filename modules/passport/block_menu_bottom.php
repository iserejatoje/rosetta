<?

if($template === null)
	$template = $this->_config['templates']['menu_bottom_block'];

$params['can_switch_user'] = $OBJECTS['user']->IsInRole('m_passport_switch_user')?true:false;
if ( isset(App::$Request->Cookie['burl']) )
	$params['back_url'] = App::$Request->Cookie['burl']->Url(false, false);

if(!empty($params['back_url']))
{
	$section = ModuleFactory::GetSectionIDByLink($params['back_url']);
	if($section != 0)
	{
		$n = STreeMgr::GetNodeByID($section);
		$params['section_domain'] 	= $n->Parent->Name;
		$params['section_name'] 	= $n->Name;
	}
}

return $this->RenderBlock($template, $params, null);
?>
