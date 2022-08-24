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
<input type="hidden" name="section_part" value="list">
{$SECTION_ID_FORM}
<p><a href="?{$SECTION_ID_URL}&action=poll_new">Добавить опрос</a></p>
<p>{$filter}</p>
<table width="100%" border="1">
<tr>
	<th>{if $sort_field=='date'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=date">Дата</a></th>
	<th>{if $sort_field=='name'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=name">Вопрос</a></th>
	<th>{if $sort_field=='visible'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=visible">Видимость</a></th>
	<th></th>
</tr>
{foreach from=$list item=l}
<tr>
	<td nowrap><input type="hidden" name="ids[]" value="{$l.PollId}">{$l.Date}</td>
	<td width="100%">
		<a href="?{$SECTION_ID_URL}&action=poll_edit&id={$l.PollId}">{if empty($l.Name)}н/д{else}{$l.Name}{/if}</a>
	</td>
	<td align="center" bgcolor="#{if $l.Visible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_poll_visible&id={$l.PollId}">{if $l.Visible==1}Да{else}Нет{/if}</a></td>
	<td><input type="checkbox" name="ids_action[]" value="{$l.PollId}"></td>
</tr>
{/foreach}
</table><br />
<center>{$smarty.capture.pages}</center><br />
<div align="right"><nobr>
<select name="action" id="action">
<option value="">Выберите действие</option>
<option value="poll_delete">Удалить опрос</option>
<option value="poll_hide">Скрыть опрос</option>
<option value="poll_show">Показать опрос</option>
</select>
<input type="submit" value="Ок" />
</nobr></div>
</form>