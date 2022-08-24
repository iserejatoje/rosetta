<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<form id="cancel">
{$SECTION_ID_FORM}
</form>

{if isset($path)}
<p><b>
	{foreach from=$path item=p name=path}
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
		{if !$smarty.foreach.path.last} / {/if}
	{/foreach}</b>
</p>
{/if}

<form method="post" name="tree_form" enctype="multipart/form-data">
{$SECTION_ID_FORM}

<input type="hidden" name="action" value="{$action}" />
{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div><br/>
{/if}

<table width="100%" cellspacing="1" class="dTable">
	{if $action != 'append_child' && $action != 'edit_node'}
	<tr>
		<td bgcolor="#F0F0F0">Раздел</td>
		<td width="100%" colspan="2">
			<select name="treeId" class="input_100">
				<option value="0">- - -</option>
				{foreach from=$sectionList key=k item=l}
				<option value="{$k}" {if $treeId==$k} selected="selected"{/if}>{$l}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	{/if}
	{if $UERROR->GetErrorByIndex('Title') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Title')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Название</td>
		<td width="100%" colspan="2">
			<input type="text" name="Title" value="{$Title}" class="input_100">
		</td>
	</tr>

	{if $UERROR->GetErrorByIndex('NameID') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('NameID')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Имя (для ссылки)</td>
		<td width="100%" colspan="2">
			<input type="text" name="NameID" value="{$NameID}" class="input_100"><br/>
			<small>Доступные символы: цифры, буквы латинского алфавита и знак "_" </small>
		</td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('Icon') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Icon')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Иконка</td>
		<td width="100%" colspan="2">
			{if !empty($Icon.f)}
			<img src="{$Icon.f}">
			<input type="checkbox" name="del_icon" value="1"/> удалить<br>
			{/if}
			<input type="file" name="Icon" value="{$Icon}" class="input_100">			
		</td>
	</tr>
	
	<tr>
		<td bgcolor="#F0F0F0">&nbsp;</td>
		<td>
			<input type="checkbox" id="isVisible" name="isVisible" value="1" {if $isVisible==1} checked{/if}>
		</td>
		<td width="100%">
			<label for="isVisible">&nbsp;показывать</label>
		</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">&nbsp;</td>
		<td>
			<input type="checkbox" id="isAnnounce" name="isAnnounce" value="1" {if $isAnnounce==1} checked{/if}>
		</td>
		<td width="100%">
			<label for="isAnnounce">&nbsp;анонсировать в меню</label>
		</td>
	</tr>	
	<tr>
		<td bgcolor="#F0F0F0">Описание</td>		
		<td width="100%" colspan="2"><textarea name="Announce" style="height:300px;" class="mceEditor input_100">{$Announce}</textarea></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">SeoTitle</td>
		<td width="100%" colspan="2">
			<input type="text" name="SeoTitle" value="{$SeoTitle}" class="input_100">
		</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">SeoDescription</td>
		<td width="100%" colspan="2">
			<input type="text" name="SeoDescription" value="{$SeoDescription}" class="input_100">
		</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">SeoKeywords</td>
		<td width="100%" colspan="2">
			<input type="text" name="SeoKeywords" value="{$SeoKeywords}" class="input_100">
		</td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0">Заголовок H1</td>
		<td width="100%" colspan="2">
			<input type="text" name="TitleH1" value="{$TitleH1}" class="input_100">
		</td>
	</tr>
</table>

<center><input type="submit" value="Сохранить" /> <input type="reset" value="Очистить" /> <input type="button" value="Назад" onclick="fcancel();"></center>

</form>