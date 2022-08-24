{capture name=pages}
	{if count($pages.btn) > 0}
		{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
		{foreach from=$pages.btn item=l}
			{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
		{/foreach}
		{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
	{/if}
{/capture}

<form method="post">
{$SECTION_ID_FORM}

<p><a href="?{$SECTION_ID_URL}&action=add_section_group">Добавить группу</a></p>
<p>{$filter}</p>

<table width="100%" border="1" class="dTable">
	<tr>
		<th>Имя</th>
		<th>Разделов</th>
		<th> </th>
	</tr>
	{if is_array($list) && sizeof($list)}
	{foreach from=$list item=l}
	<tr>
		<td width="100%"><input type="hidden" name="ids[]" value="{$l.GroupID}" />
			<a href="?{$SECTION_ID_URL}&action=edit_section_group&id={$l.GroupID}">{$l.Name}</a>
		</td>
		<td align="center">{$l.Count}</td>
		<td><input type="checkbox" name="ids_action[]" value="{$l.GroupID}"></td>
	</tr>
	{/foreach}
	{else}
	<tr>
		<td colspan="4" align="center">
			Нет ни одной группы<br/>
			<a href="?{$SECTION_ID_URL}&action=add_section_group"><b>Добавить</b></a>
		</td>
	</tr>
	{/if}
</table><br />
<center>{$smarty.capture.pages}</center><br />

<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="delete_section_group">Удалить группы</option>

	</select>
	<input type="submit" value="Ок" />
</nobr></div>
</form>