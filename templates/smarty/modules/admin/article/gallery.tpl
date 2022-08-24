
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
<input type="hidden" name="section_part" value="gallery">
<input type="hidden" name="id" value="{$newsid}">
{$SECTION_ID_FORM}

<p><a href="?{$SECTION_ID_URL}&action=new_photo&id={$newsid}&albumid={$albumid}">Добавить фото</a></p><br/>

<table width="100%" border="1" class="dTable">
	<tr>
		<th>Фото</th>
		<th>Описание</th>
		<th>Позиция</th>
		<th>Видимость</th>
		<th></th>
	</tr>
	{foreach from=$photos item=l}
	<tr>
		<td align="center">
			<a href="?{$SECTION_ID_URL}&action=edit_photo&id={$newsid}&photoid={$l.id}"><img src="{$l.thumb.url}" width="{$l.thumb.width}" height="{$l.thumb.height}"/><br/>{$l.title}</a>
		</td>
		<td width="100%" align="center">{if $l.descr}{$l.descr}{else}-{/if}</td>
		<td width="100%" align="center"><input size="3" type="text" style="text-align: center;" name="order[{$l.id}]" value="{$l.order}"></td>
		<td align="center" bgcolor="#{if $l.visible==1}66FF66{else}FF6666{/if}"><a href="?{$SECTION_ID_URL}&action=toggle_visible_photo&id={$newsid}&photoid={$l.id}">{if $l.visible==1}Да{else}Нет{/if}</a></td>
		<td><input type="checkbox" name="ids_action[]" value="{$l.id}"></td>
		
	</tr>
{/foreach}
</table><br />
<center>{$smarty.capture.pages}</center><br />

<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="update_photo">Обновить</option>
		<option value="delete_photo">Удалить фото</option>

		<option value="hide_photo">Скрыть фото</option>
		<option value="show_photo">Показать фото</option>

	</select>
	<input type="submit" value="Ок" />
</nobr></div>
</form>
