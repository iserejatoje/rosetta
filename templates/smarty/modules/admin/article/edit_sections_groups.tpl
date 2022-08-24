<script type="text/javascript" src="/_scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>
<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<form id="cancel">
<input type="hidden" name="action" value="sections_groups" />
{$SECTION_ID_FORM}
</form>

{*if sizeof($UERROR->ERRORS)}
	<div align="center" style="color:red"><b>{$UERROR->GetErrorsText()}</b></div><br/>
{/if*}

<form method="post">
	{$SECTION_ID_FORM}
	<input type="hidden" name="action" value="{$action}" />
	<input type="hidden" name="descr" value="" />

	<table width="100%" cellspacing="1" class="dTable">
		{if $UERROR->GetErrorByIndex('GroupName') != ''}
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<td style="color:red;">{$UERROR->GetErrorByIndex('GroupName')}</td>
		</tr>
		{/if}
		<tr>
			<td bgcolor="#F0F0F0">Название</td>
			<td width="100%"><input type="text" name="Name" value="{$Name}" class="input_100"></td>
		</tr>
		{if $UERROR->GetErrorByIndex('Sections') != ''}
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<td style="color:red;">{$UERROR->GetErrorByIndex('Sections')}</td>
		</tr>
		{/if}
		<tr>
			<td bgcolor="#F0F0F0">Разделы</td>
			<td>
				<script> 
					var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}',
					{literal}
					{
						max_elements: 0,
						action: 'moduletreenode'
					}
					{/literal});
					p.render_sections({$Nodes});
					p.get_sections(0); 
				</script>
			</td>
		</tr>
	</table>
	
	<center>
		<input type="submit" value="Сохранить" /> 
		<input type="reset" value="Очистить" /> 
		<input type="button" value="Назад" onclick="fcancel();">
	</center>
</form>