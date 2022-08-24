{capture name=pages}
	{if count($pages.btn) > 0}
		{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
		{foreach from=$pages.btn item=l}
			{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
		{/foreach}
		{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
	{/if}
{/capture}

<script>
{literal}
	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;

		return true;
	}
{/literal}
</script>

<form method="post" onsubmit="return checkaction();">
<input type="hidden" name="section_part" value="list">
{$SECTION_ID_FORM}

<p><a href="?{$SECTION_ID_URL}&action=new">Добавить статью</a></p>
<p>{$filter}</p>

<table width="100%" border="1" class="dTable">
	<tr>
		<th>{if $sort_field=='date'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=date">Дата</a></th>
		<th>{if $sort_field=='title'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=title">Название</a></th>
		<th>{if $sort_field=='isvisible'}<img src="/_img/design/200710_fin/{$sort_order|lower}.gif">&nbsp;{/if}<a href="?{$SECTION_ID_URL}&sort=isvisible">Видимость</a></th>
		<th>Фото</th>
		<th>Отзывы</th>
		<th>Предросмотр</th>
		<th></th>
	</tr>
	{foreach from=$list item=l}
	<tr>
		<td align="center">
			<input type="hidden" name="ids[]" value="{$l.NewsID}" />{$l.Date|date_format:"%e.%m.%Y"}
			<br>{$l.Date|date_format:"%H:%M:%S"}
		</td>
		<td width="100%">
			<a href="?{$SECTION_ID_URL}&action=edit&id={$l.NewsID}">{if empty($l.Title)}н/д{else}{$l.Title}{/if}</a>
			{if $l.add_material>0}<font style="color:red;"><b>({$add_materials[$l.add_material]})</b></font>{/if}
			{if $l.Order>0}<br><font style="color:red;font-size:18px;">Важность: {$l.Order}</font>{/if}
		</td>
		<td align="center" bgcolor="#{if $l.isVisible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_visible&id={$l.NewsID}">{if $l.isVisible==1}Да{else}Нет{/if}</a></td>
		<td align="center"><a href="?{$SECTION_ID_URL}&action=gallery&id={$l.NewsID}">Фото</a></td>
		<td align="center" nowrap><a href="?{$SECTION_ID_URL}&action=comments&id={$l.NewsID}">Отзывы ({$l.comments})</a></td>
		<td nowrap="nowrap">
			{*<a href="http://74.ru/sitehome.php?debugdate={$l.Date}" target="_blank">на главной 74</a><br>
			<a href="{$SITE_URL}/{$SECTION_PATH}/{$l.NewsID}.html?debugdate={$l.Date}" target="_blank">в разделе</a><br>
			<a href="{$SITE_URL}/sitehome.php?debugdate={$l.Date}" target="_blank">на главной</a>*}
			<a href="{$SITE_URL}/{$SECTION_PATH}/{$l.NewsID}.html?preview=1" target="_blank">в разделе</a><br>
		</td>
		<td align="center" nowrap><a href="?{$SECTION_ID_URL}&action=copy&id={$l.NewsID}">Копировать</a></td>
		<td><input type="checkbox" name="ids_action[]" value="{$l.NewsID}"></td>
	</tr>
{/foreach}
</table><br />
<center>{$smarty.capture.pages}</center><br />

<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="delete_articles">Удалить статьи</option>

		<option value="hide_articles">Скрыть статьи</option>
		<option value="show_articles">Показать статьи</option>

	</select>
	<input type="submit" value="Ок" />
</nobr></div>
</form>
