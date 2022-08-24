{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

<form id="cancel">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="node" value="{$parent}" />
{$SECTION_ID_FORM}
</form>


<style>
	{literal}
	.asmSelect {	
		display: none; 
	}	
	
	.asmContainer {
		/* container that surrounds entire asmSelect widget */
	}
	
	.asmOptionDisabled {
		/* disabled options in new select */
		color: #999; 
	}

	.asmHighlight {
		/* the highlight span */
		padding: 0;
		margin: 0 0 0 1em;
	}

	.asmList {
		/* html list that contains selected items */
		margin: 0.25em 0 1em 0; 
		position: relative;
		display: block;
		padding-left: 0; 
		list-style: none; 
	}

	.asmListItem {
		/* li item from the html list above */
		position: relative; 
		margin-left: 0;
		padding-left: 0;
		list-style: none;
		background: #ddd;
		border: 1px solid #bbb; 
		width: 100%; 
		margin: 0 0 -1px 0; 
		line-height: 1em;
	}

	.asmListItem:hover {
		background-color: #e5e5e5;
	}

	.asmListItemLabel {
		/* this is a span that surrounds the text in the item, except for the remove link */
		padding: 5px; 
		display: block;
	}

	.asmListSortable .asmListItemLabel {
		cursor: move; 
	}

	.asmListItemRemove {
		/* the remove link in each list item */
		position: absolute;
		right: 0; 
		top: 0;
		padding: 5px; 
	}

	{/literal}
</style>

<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/autocomplete/jquery.autocomplete.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.asmselect.js"></script>


<form name="firmform" method="post" enctype="multipart/form-data">
{$SECTION_ID_FORM}
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="manufacturerid" value="{$form.ManufacturerID}" />

<table width="100%" cellspacing="1" cellpadding="2">
	
	{if $UERROR->GetErrorByIndex('Name') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Name')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0" width="150">Название</td>
		<td width="85%"><input type="text" name="Name" value="{$form.Name}" class="input_100"></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('icon') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('icon')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Логотип</td>
		<td width="85%">
			{if !empty($form.Icon.f)}
			<br><img src="{$form.Icon.f}">
			<input type="checkbox" name="del_icon" value="1"/> удалить
			{/if}
			<input type="file" name="icon" value="" class="input_100">
		</td>
	</tr>
	{if $UERROR->GetErrorByIndex('Sections') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Sections')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0" width="150">Раздел</td>
		<td width="85%">
			<script> 
				var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}&treeid={$treeid}',
				{literal}
				{
					max_elements: 1,
					autoselect: true,
					single: true,
					action: 'treenode'
				}
				{/literal});
				p.render_sections({$node_root});
				p.get_sections(0); 
			</script>
		</td>
	</tr>
	
</table>
<center><br><input type="submit" value="Сохранить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>
{/if}