<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/treeview/multe_select.js"></script>
<script type="text/javascript" src="/resources/scripts/themes/frameworks/jquery/autocomplete/jquery.autocomplete.js"></script>
<style>
{literal}
.ac_bgframe {
	z-index: 98;
	position: absolute;
	display: block;
	border: 0px;
}
.ac_results {
	padding: 0px;
	border: 1px solid black;
	background-color: white;
	overflow: hidden;
	z-index: 202;
	position: absolute;
}

.ac_results ul {
	width: 100%;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}

.ac_results li {
	margin: 0px;
	padding: 2px 5px;
	cursor: default;
	display: block;
	/* 
	if width will be 100% horizontal scrollbar will apear 
	when scroll mode will be used
	*/
	/*width: 100%;*/
	font: menu;
	font-size: 12px;
	/* 
	it is very important, if line-height not setted or setted 
	in relative units scroll will be broken in firefox
	*/
	line-height: 16px;
	overflow: hidden;
}
.ac_describe{
	font-size: 10px;
	color: #4B4B4B;
}
.ac_loading {
	background: white url('/_img/design/200608_title/upload_mini.gif') no-repeat right 8px;
}

.ac_odd {
	background-color: #eee;
}

.ac_over {
	background-color: #E1ECF5;
	color: black;
}
{/literal}

</style>

<script language="javascript" type="text/javascript">{literal}
	function fcancel()
	{
		document.getElementById('cancel').submit();
	}
{/literal}</script>
<form id="cancel">
{$SECTION_ID_FORM}
</form>

<form method="post" enctype="multipart/form-data">
	{$SECTION_ID_FORM}
	<input type="hidden" name="action" value="{$action}" />
	{if $id}<input type="hidden" name="id" value="{$id}" />{/if}

	<table width="100%" cellspacing="1" class="dTable">
		<tr>
			<td bgcolor="#F0F0F0" nowrap="nowrap">Показывать статью</td>
			<td width="100%">
				<input type="checkbox" name="isVisible" value="1"{if $isVisible==1} checked{/if}>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Закрывать ссылки от поисковых систем</td>
			<td>
				<input type="checkbox" name="hideLinks" value="1" {if $hideLinks} checked="checked"{/if}>
			</td>
		</tr>		
		<tr>
			<td bgcolor="#F0F0F0">Разрешить комментарии</td>
			<td>
				
				<select name="isComments" class="input_100">
					{foreach from=$visibility_comments item=l key=k}
					<option value="{$k}"{if $k==$isComments} selected{/if}>{$l}</option>
					{/foreach}
				</select>				
			</td>
		</tr>		
		<tr>
			<td bgcolor="#F0F0F0">Выделять новость</td>
			<td>
				<input type="checkbox" name="isMarked" value="1" {if $isMarked} checked="checked"{/if}> выделять цветом (только в списке раздела)
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Рейтинг комментариев</td>
			<td>
				<select name="isRating" class="input_100">
					{foreach from=$rating_types item=l key=k}
					<option value="{$k}"{if $k==$isRating} selected{/if}>{$l}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Выводить в RSS</td>
			<td>
				<input type="checkbox" name="isRSS" value="1"{if $isRSS==1} checked{/if}>
			</td>
		</tr>
		
		<tr>
			<td bgcolor="#F0F0F0">Важность</td>
			<td>
				<input type="text" name="Order" value="{$Order}" style="width:50px"> чем больше, тем важнее (0 - обычная важность)
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0" nowrap>Тип материала</td>
			<td>
				<select name="TitleType" class="input_100">
					{foreach from=$types item=l key=k}
					<option value="{$k}"{if $k==$TitleType} selected{/if}>{$l.name} (Шаблон заголовка: {$l.format})</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Название</td>
			<td><input type="text" name="Title" value="{$Title}" class="input_100"></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Краткое название</td>
			<td>
				<input type="text" name="ShortTitle" value="{$ShortTitle}" class="input_100" maxlength="36">
				<small>Максимальная длина текста 36 символов. Текст размещается в две строки по 18 символов.</small>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Автор</td>
			<td><input type="text" name="AuthorName" value="{$AuthorName}" class="input_100"></td>
		</tr>		
		<tr>
			<td bgcolor="#F0F0F0">Дата</td>
			<td>{html_editdate current=$Date with_date="true" with_time="true"}</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Анонс</td>
			<td><textarea name="Anon" style="height:150px;" class="input_100">{$Anon}</textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="Text" class="mceEditor" style="width: 100%;height:550px;">{$Text}</textarea>
			</td>
		</tr>
		
		{if !empty($ThumbnailImg)}
		<tr>
			<td bgcolor="#F0F0F0">Текущее фото<br>(маленькое)</td>
			<td>
				<img src="{$ThumbnailImg.url}"><br />
				<input type="checkbox" name="ThumbnailImgDelete" value="1"> Удалить фотографию
			</td>
		</tr>
		{/if}
		<tr>
			<td bgcolor="#F0F0F0">Фото<br>(маленькое)</td>
			<td><input type="file" name="ThumbnailImg" class="input_100"></td>
		</tr>
						
		<tr>
			<td bgcolor="#F0F0F0">Разделы</td>
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
		<tr>
			<td bgcolor="#F0F0F0">SeoTitle</td>
			<td><input type="text" name="SeoTitle" value="{$SeoTitle}" class="input_100"></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">SeoDescription</td>
			<td><input type="text" name="SeoDescription" value="{$SeoDescription}" class="input_100"></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">SeoKeywords</td>
			<td><input type="text" name="SeoKeywords" value="{$SeoKeywords}" class="input_100"></td>
		</tr>
	</table>

	<center>
		<input type="submit" value="Сохранить" /> 
		<input type="reset" value="Очистить" /> 
		<input type="button" value="Назад" onclick="fcancel();">
	</center>
</form>