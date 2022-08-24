<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_work" />
<div class="title" style="padding: 5px;">Работа</div>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('workplace') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('workplace')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2" width="150">Место работы</td>
		<td class="bg_color4"><textarea type="text" name="workplace" style="width:100%;height:60px;">{$page.form.workplace}</textarea></td>
	</tr>
{if $UERROR->GetErrorByIndex('position') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('position')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Должность</td>
		<td class="bg_color4"><textarea type="text" name="position" style="width:100%;height:60px;">{$page.form.position}</textarea></td>
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>