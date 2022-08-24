{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы: 
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}



<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<form name="mod_mail_filter_form" id="mod_mail_filter_form" method="post">
<input type="hidden" name="action" value="">
<tr align="left">
	<th width="20px" style="padding:0px; padding-left:3px;"><input type="checkbox" id="mainch" ></th>
	<th width="40px">&nbsp;</th>
	<th width="31%">Название</th>
	<th width="34%">Условие</th>
	<th width="34%">Действие</th>
</tr>
{if count($res.list)>0}
{foreach from=$res.list item=l key=k}
<tr align="left" valign="top" id="tr{$k}">
	<td align="center"><input type="checkbox" id="ch{$k}" name="ch[{$l.id}]"{if $l.checked} checked{/if} ></td>
	<td align="center" style="padding-top:7px;">{strip}
	{if $l.poryadok_top}<a id="a1_{$k}" href="{$l.poryadok_top}" style="text-decoration:none;" title="вверх"><b>&uarr;</b></a>{else}<a id="a1_{$k}"></a>{/if}
	{if $l.poryadok_top && $l.poryadok_bottom}&nbsp;{/if}
	{if $l.poryadok_bottom}<a id="a2_{$k}" href="{$l.poryadok_bottom}" style="text-decoration:none;" title="вниз"><b>&darr;</b></a>{else}<a id="a2_{$k}"></a>{/if}
	{/strip}</td>
	<td>{if !$l.visible}<img src="/_img/modules/mail/ico/disabled.gif" width="16" height="16" border="0" align="absmiddle" title="Фильтр отключен" alt="Фильтр отключен" /> {/if}
	<a id="a3_{$k}" href="/{$ENV.section}/{$CONFIG.files.get.editfilter.string}?id={$l.id}">{$l.name}</a></td>
	<td>{$l.cond}</td>
	<td>{$l.action}</td>
</tr>
{/foreach}
{else}
<tr align="center">
	<td colspan="5">Нет фильтров</td>
</tr>
{/if}
</table>


{if $smarty.capture.pageslink!="" }
<br />
{$smarty.capture.pageslink}
<br />
{/if}


<table cellpadding="0" cellspacing="0" border="0">
<tr>
{if count($res.list)>0}
	<td width="80px">
	<button onclick="mod_mail_filter_form_action('filter_delete');" style="width:70px;">Удалить</button>
	</td>
	<td width="190px">
	<button onclick="mod_mail_filter_form_action('filter_visible');" style="width:180px;">Включить / Выключить</button>
	</td>
{/if}
</tr>
</form>
</table>

<br/>

{if $smarty.capture.pageslink!="" }
{$smarty.capture.pageslink}
{/if}

<script type="text/javascript" language="javascript" src="/_scripts/themes/lines.js"></script>
<script type="text/javascript" language="javascript">
<!--
{literal}
lines_params.start = 0;
lines_params.end = {/literal}{$res.i-1|default:0}{literal},
lines_params.tr = 'tr';
lines_params.ch = 'ch';
lines_params.mainch = 'mainch';
lines_params.nobubble = ['a1_', 'a2_', 'a3_'];
lines_class.over = 'lines_over';
lines_class.normal = '';
lines_class.selected = 'lines_selected';
lines_init();
{/literal}
//-->
</script>
<script type="text/javascript" language="javascript">
<!--
{literal}
	var mod_mail_filter_form = document.getElementById('mod_mail_filter_form');
	var mod_mail_filter_col = {/literal}{$res.i|default:0}{literal};
	var mod_mail_filter_start = 0;

	var mod_mail_filter_form_send = false;
	function mod_mail_filter_form_action(act)
	{
		if(mod_mail_filter_form_send)
			return false;
		
		if(act == 'filter_delete' || act == 'filter_visible')
		{
			if(!mod_mail_IsSelected('ch'))
			{
				alert('{/literal}{$UERROR->GetError($smarty.const.ERR_M_MAIL_FILTER_NO_FILTER_SELECTED)}{literal}');
				return false;
			}
		}
		else
		{
			return false;
		}
		
		mod_mail_filter_form.action.value = act;
			
		mod_mail_filter_form_send = true;
		mod_mail_filter_form.submit();
		return true;
	}
	
	function mod_mail_IsSelected(elem)
	{
		if (mod_mail_filter_start>=mod_mail_filter_col)
			return;
		for(var i=mod_mail_filter_start; i < mod_mail_filter_col; i++)
			if( document.getElementById(elem + ''+ i).checked )
				return true;
		return false;
	}
	
//    -->{/literal}
</script>
