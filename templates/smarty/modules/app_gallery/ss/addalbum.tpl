{include file="`$TEMPLATE.sectiontitle`" type="2"}

{*<div class="title" style="padding: 5px">Добавить альбом</div>*}

<form method="POST">
<input type="hidden" name="gallery" value="{$page.gallery}" />
<input type="hidden" name="action" value="{$page.form.action}" />
<table cellspacing="2" cellpadding="3" border="0" align="center" width="550">
	{if isset($UERROR->ERRORS.title)}
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->ERRORS.title}</span></td>
	</tr>
	{/if}
	<tr>
		<td class="bg_color2" align="right" width="150">Название <font color="red">*</font></td>
		<td class="bg_color4"><input type="text" name="title" style="width:400px" value="{$page.form.title|escape:'html'}" /></td>
	</td>
	{if isset($UERROR->ERRORS.descr)}
	<tr>
		<td align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->ERRORS.descr}</span></td>
	</tr>
	{/if}
	<tr>
		<td class="bg_color2" align="right" width="150">Описание</td>
		<td class="bg_color4"><textarea name="descr" style="width:400px;height:100px;">{$page.form.descr|escape:'html'}</textarea></td>
	</td>
	<tr>
		<td colspan="2" align="center"><br/><input type="submit" value="{if $page.form.action == 'addalbum'}Создать{else}Сохранить{/if}" style="width:100px">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Отмена" onclick="document.location.href='/{$ENV.section}/gallery/{$page.gallery}/'" style="width:100px"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br/>Символом <font color="red">*</font> отмечены поля, обязательные для заполнения.</td>
	</tr>
</table>
</form>