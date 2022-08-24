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
{$SECTION_ID_FORM}

<table width="100%" border="1" class="dTable">
	<tr>
		<th width="10%">Дата</th>
		<th width="10%">Автор</th>
		<th width="10%">Назавние</th>
		<th width="35%">Текст</th>
		<th width="35%">Ответ</th>
		<th></th>
		<th></th>
	</tr>
	{foreach from=$list item=l}
	<tr>
		<td align="center">
			<input type="hidden" name="ids[]" value="{$l->ID}" />{$l->Created}
		</td>
		<td>
			<input type="text" name="Author[{$l->ID}]" value="{$l->Author}" style="width:90%">
			{$l->Email}
		</td>
		<td>
			<input type="text" name="Title[{$l->ID}]" value="{$l->Title}" style="width:90%">
		</td>
		<td>
			<textarea name="Text[{$l->ID}]" style="width:90%">{$l->Text}</textarea>
		</td>
		<td>
			<textarea name="AnswerText[{$l->ID}]" style="width:90%">{$l->AnswerText}</textarea>
		</td>
		<td align="center" bgcolor="#{if $l->IsVisible==1}66FF66{else}FF6666{/if}">
			<a href="?{$SECTION_ID_URL}&action=toggle_visible&id={$l->ID}">{if $l->IsVisible==1}Да{else}Нет{/if}</a>
		</td>
		<td>
			<input type="checkbox" name="ids_action[]" value="{$l->ID}">
		</td>
	</tr>
{/foreach}
</table><br />
<center>{$smarty.capture.pages}</center><br />

<div align="right"><nobr>
	<select name="action" id="action">
		<option value="">Выберите действие</option>
		<option value="save">Сохранить</option>
		<option value="visible">Показать</option>
		<option value="hide">Скрыть</option>
		<option value="delete">Удалить</option>
	</select>
	<input type="submit" value="Ок" />
</nobr></div>
</form>
