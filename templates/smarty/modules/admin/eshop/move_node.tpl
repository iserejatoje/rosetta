<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>

{literal}
<script language="javascript" type="text/javascript">
<!--
function fcancel()
{
	document.getElementById('cancel').submit();
}
// -->
</script>
{/literal}

<p><b>
	{foreach from=$path item=p name=path}
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
		{if !$smarty.foreach.path.last} / {/if}
	{/foreach}</b>
</p>

{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{/if}

<form id="cancel">
<input type="hidden" name="action" value="catalog" />
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="node" value="{$parent}" />
{$SECTION_ID_FORM}
</form>

<form name="firmform" method="post" enctype="multipart/form-data">
{$SECTION_ID_FORM}
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="action" value="{$action}" />

<table width="100%" cellspacing="1" cellpadding="2">
	<tr>
		<td bgcolor="#F0F0F0" width="150">Раздел куда переместить</td>
		<td width="85%">
			<script> 
					var p = new TV_MultiSelect('{php}echo App::$Env['url'];{/php}?section_id={$SECTION_ID}&treeid={$treeid}',
					{literal}
					{
						max_elements: 1,
						single: true,
						skip_nodes: [{/literal}{","|implode:$skip_nodes}{literal}],
						action: 'treenode'
					}
					{/literal});
					p.render_sections();
					p.get_sections(0); 
			</script><br/>
			<small>Выберите раздел для перемещения.</small> 
		</td>
	</tr>
</table>
<center><br><input type="submit" value="Продолжить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>
