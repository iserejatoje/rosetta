{capture name=pages}
{if count($pages.btn) > 0}
{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
{foreach from=$pages.btn item=l}
{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
{/foreach}
{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
{/if}
{/capture}
<script>{literal}
function checkaction()
{
	obj = document.getElementById("action");
	if(obj.options[obj.selectedIndex].value=='')
		return false;
	return true;
}
{/literal}</script>
<form method="post" onsubmit="return checkaction();">
<input type="hidden" name="section_part" value="list_group">
{$SECTION_ID_FORM}
<p><a href="?{$SECTION_ID_URL}&action=new_group">Добавить группу</a></p>
<table width="100%" border="1">
<tr>
	<th>Название (короткое)</th>
	<th>Название</th>
	<th>Порядок</th>
	<th>Видимость</th>
	<th></th>
</tr>
{foreach from=$list item=l}
<tr>
	<td width="50%" nowrap><input type="hidden" name="ids[]" value="{$l.id}">{$l.modname}</td>
	<td width="50%"><a href="?{$SECTION_ID_URL}&action=edit_group&id={$l.id}">{if empty($l.name)}н/д{else}{$l.name}{/if}</a></td>
	<td align="center">{if $l.ord_type!=0}
		{if $l.ord_type>=2}<a href="?{$SECTION_ID_URL}&action=sort_group&type=up&ord={$l.ord}"><img src="/_img/design/200608_title/bullet_arrow_up.gif" border="0" align="absmiddle"></a>{/if}
		{if $l.ord_type<=2}<a href="?{$SECTION_ID_URL}&action=sort_group&type=down&ord={$l.ord}"><img src="/_img/design/200608_title/bullet_arrow_down.gif" border="0" align="absmiddle"></a>{/if}
	{/if}</td>
	<td align="center" bgcolor="#{if $l.visible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_visible_group&id={$l.id}">{if $l.visible==1}Да{else}Нет{/if}</a></td>
	<td><input type="checkbox" name="ids_action[]" value="{$l.id}"></td>
</tr>
{/foreach}
</table><br />
<center>{$smarty.capture.pages}</center><br />
<div align="right"><nobr>
<select name="action" id="action">
<option value="">Выберите действие</option>
<option value="delete_groups">Удалить группы</option>
<option value="hide_groups">Скрыть группы</option>
<option value="show_groups">Показать группы</option>
</select>
<input type="submit" value="Ок" />
</nobr></div>
</form>