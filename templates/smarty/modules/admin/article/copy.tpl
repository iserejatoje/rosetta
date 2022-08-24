<script type="text/javascript" src="/_scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>

<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<form id="cancel">
{$SECTION_ID_FORM}
</form>
{if $UERROR->GetErrorByIndex('global')}
	<p align="center">
		<span style="color: red"><b>{$UERROR->GetErrorByIndex('global')}</b></span>
	</p>
{else}
<form method="post" enctype="multipart/form-data">
	{$SECTION_ID_FORM}
	<input type="hidden" name="action" value="{$action}" />
	{if $id}<input type="hidden" name="id" value="{$id}" />{/if}
	
	<table width="100%" cellspacing="1" class="dTable">
	{if $UERROR->GetErrorByIndex('sections') != ""}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td><span style="color: red"><b>{$UERROR->GetErrorByIndex('sections')}</b></span></td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Куда</td>
		<td>
			<script> 
			{if !$smarty.get.user}
				var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}',
				{literal}
				{
					max_elements: 0,
					action: 'moduletreenode'
				}
				{/literal});
				
				p.render_sections({$nodes});
				p.get_sections(0); 
			{/if}
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
{/if}