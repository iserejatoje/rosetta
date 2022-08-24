<script>{literal}
function checkaction(form)
{
	obj = form.elements['action'];
	if(obj.options[obj.selectedIndex].value=='')
		return false;
	return true;
}
{/literal}</script>

{if !empty($res.sections)}
{if $res.caneditsection}
<form method="POST" onsubmit="return checkaction(this);">
{/if}
<table width="100%" cellpadding="4">
<tr>
	<td class="ftable_header">Разделы</td>
	<td width="50" class="ftable_header" align="center">Тем</td>
	<td width="50" class="ftable_header" align="center">Сооб.</td>
	<td width="280" class="ftable_header" align="center">Последний ответ</td>
	{if $res.caneditsection}
	<td width="13" class="ftable_header">
		<div class="s_divs" id="all_sel" onClick="SetChecks('ids[]', 1, 'all_unsel')" title="Выделить все">+</div><div class="s_divs" id="all_unsel" onClick="SetChecks('ids[]', 0, 'all_sel')" style="display:none;" title="Снять со всех">&mdash;</div>
	</td>
	{/if}
</tr>
{excycle values="frow_first,frow_second"}
{foreach from=$res.sections item=l}
<tr class="{excycle}">
	<td>
		{if $l.visible==0}<font color="blue">Скрытый раздел:</font> {/if}
		<a href="{$CONFIG.files.get.view.string}?id={$l.id}"><b>{$l.name}</b></a><br><span class="fdescription">{$l.descr}</span>
		{if !empty($l.children)}<div class="fsubsection" style="padding-top:8px">
		{foreach from=$l.children item=l2}
        <a href="{$CONFIG.files.get.view.string}?id={$l2.id}">{$l2.name}</a>&nbsp; 
        {/foreach}
        </div>
		{/if}</td>
	<td width="50" align="center" valign="top">{$l.themes|number_format:0:" ":" "|replace:" ":"&nbsp;"}</td>
	<td width="50" align="center" valign="top">{$l.messages|number_format:0:" ":" "|replace:" ":"&nbsp;"}</td>
	<td width="280" class="fsmall" valign="top">{if $l.last_login}{$l.last_date|simply_date}<br>Тема: {if !empty($l.last_theme_id)}<a href="{$CONFIG.files.get.theme.string}?id={$l.last_theme_id}&act=last">{/if}<b>{$l.last_theme}</b>{if !empty($l.last_theme_id)}</a>{/if}{/if}<br>{if !empty($l.last_login)}Ответил: {if $l.last_user}<a href="{$l.last_user_info.infourl}" target="_blank">{/if}{$l.last_login}{if $l.last_user}</a>{/if}{/if}</td>
	{if $res.caneditsection}
	<td width="13" align="center" valign="top"><input type="checkbox" name="ids[]" value="{$l.id}"></td>
	{/if}
</tr>
{/foreach}
</table>
{if $res.caneditsection}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие для раздела -</option>
		<option value="close_section">Закрыть разделы</option>
		<option value="open_section">Открыть разделы</option>
		<option value="hide_section">Скрыть разделы</option>
		<option value="show_section">Показать разделы</option>
	</select>
	<input type="hidden" name="sectionid" value="{$res.section_id}">
	<input type="submit" value="ОК" class="fcontrol">
</div>
</form>
{/if}
{/if}