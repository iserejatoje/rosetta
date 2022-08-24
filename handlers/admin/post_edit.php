<?
	/*if(
		!( $this->pathinfo['action'] == 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_create') ) &&
		!( $this->pathinfo['action'] != 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_edit') ) &&
		!( $OBJECTS['user']->IsInRole('e_adm_sections_header_edit') )
		)
		Response::Status(403, RS_SENDPAGE | RS_EXIT);
*/
	$item = array(
		'id' => $this->controls['form']->GetControl('idlabel')->GetTitle(),
	);

	$n = $this->controls['form']->GetControl('nameedit')->GetTitle();
	if(empty($n))
		$OBJECTS['uerror']->AddErrorIndexed('name', ERR_E_ADMIN_WRONG_NAME);
	else
		$item['name'] = $n;

	/*if (
		( $this->pathinfo['action'] == 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_create') ) ||
		( $this->pathinfo['action'] != 'new' && $OBJECTS['user']->IsInRole('e_adm_sections_edit') )
	)*/
	if (1)
	{
		$n = $this->controls['form']->GetControl('pathedit')->GetTitle();
		if(empty($n))
			$OBJECTS['uerror']->AddErrorIndexed('path', ERR_E_ADMIN_WRONG_PATH);
		else
			$item['path'] = $n;

		if($this->pathinfo['action'] == 'new')
		{
			$item['parent'] = $this->pathinfo['section'];
		}


		$item['module'] = $this->controls['form']->GetControl('moduleedit')->GetTitle();
		/*$c = $this->controls['form']->GetControl('modulesselect');
		$i = $c->GetSelected();$i = $c->GetItem($i[0]);
		//if(empty($i['id']))
		//	$OBJECTS['uerror']->AddErrorIndexed('module', ERR_E_ADMIN_WRONG_MODULE);
		//else
			$item['module'] = $i['id'];*/

		$c = $this->controls['form']->GetControl('typeselect');
		$i = $c->GetSelected();$i = $c->GetItem($i[0]);
		//if(empty($i['id']))
		//	$OBJECTS['uerror']->AddErrorIndexed('type', ERR_E_ADMIN_WRONG_TYPE);
		//else
			$item['type'] = $i['id'];

		$r = $this->controls['form']->GetControl('regionedit')->GetTitle();
		//if(!is_numeric($r))
		//	$OBJECTS['uerror']->AddErrorIndexed('regions', ERR_E_ADMIN_WRONG_REGION);
		//else
			$item['regions'] = $r;

		$c = $this->controls['form']->GetControl('visiblecb');
		$item['visible'] = $c->GetChecked();
		$c = $this->controls['form']->GetControl('deletedcb');
		$item['deleted'] = $c->GetChecked();

		$item['params'] = $this->controls['form']->GetControl('paramsedit')->GetTitle();


		$c = $this->controls['form']->GetControl('restrictedcb');
		$item['restricted'] = $c->GetChecked();
		$c = $this->controls['form']->GetControl('istitlecb');
		$item['istitle'] = $c->GetChecked();
		$c = $this->controls['form']->GetControl('sslcb');
		$item['ssl'] = $c->GetChecked();

		$c = $this->controls['form']->GetControl('eencodingselect');
		$i = $c->GetSelected();
		$i = $c->GetItem($i[0]);
		//if(empty($i['id']))
		//	$OBJECTS['uerror']->AddErrorIndexed('encoding', ERR_E_ADMIN_WRONG_ENCODING);
		//else
		$item['external_encoding'] = $i['id'];
	}


	//if ( $OBJECTS['user']->IsInRole('e_adm_sections_header_edit') )
	if (1)
	{
		// Header
		$item['header_title'] 		= $this->controls['form']->GetControl('header_title_edit')->GetTitle();
		$c = $this->controls['form']->GetControl('header_title_action_select');
		$i = $c->GetSelected();$i = $c->GetItem($i[0]);
		$item['header_title_action'] = $i['id'];

		$item['header_keywords'] 	= $this->controls['form']->GetControl('header_keywords_edit')->GetTitle();
		$c = $this->controls['form']->GetControl('header_keywords_action_select');
		$i = $c->GetSelected();$i = $c->GetItem($i[0]);
		$item['header_keywords_action'] = $i['id'];

		$item['header_description'] = $this->controls['form']->GetControl('header_description_edit')->GetTitle();
		$c = $this->controls['form']->GetControl('header_description_action_select');
		$i = $c->GetSelected();$i = $c->GetItem($i[0]);
		$item['header_description_action'] = $i['id'];
	}


	if($OBJECTS['uerror']->IsError())
		return false;

	if(!$this->bl->StoreNode($item))
	{
		$OBJECTS['uerror']->AddErrorIndexed('error', ERR_E_ADMIN_UNKNOWN_ERROR);
		TRACE::VarDump($OBJECTS['uerror']->GetErrorsArray());
		return false;
	}


	if($this->pathinfo['action'] == 'new')
		Response::Redirect($this->GetCurrentPath());
	else
		Response::Redirect($this->GetParentPath());
?>
