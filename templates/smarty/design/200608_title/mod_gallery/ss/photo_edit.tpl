{if $page.errors.global}
<br/><br/><div align="center"><font color="red"><b>{$page.errors.global}</b></font></div>
{else}
<form name="frm" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="edit_photo" />
<input type="hidden" name="pid" value="{$page.photo.id}" />
<table width="100%" cellpadding="3" cellspacing="0" border="0">
	<tr>
		<td colspan="3"><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3" align="left" valign="top" width="100%" colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt=""  /></td>
	</tr>
	<tr>
		<td nowrap="nowrap"><b>Название фотографии:</b></td>
		<td><input type="text" name="name" maxlength="255" style="width:295px;" value="{$page.photo.name}"></td>
		<td width="100%" rowspan="2">
		{if !empty($page.photo.image)}
			<img src="{$page.photo.image}" {$page.photo.image_size} style="border: #005A52 solid 1px" alt="{$page.photo.name}"  title="{$page.photo.name}" />				
		{else}
			<img src="/_img/design/200608_title/none.jpg" style="border: #005A52 solid 1px" alt="Нет фото"  title="Нет фото" />				
		{/if}
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap="nowrap"><b>Комментарий к фотографии:</b></td>
		<td><textarea name="descr" style="width:295px;height:100px">{$page.photo.descr}</textarea></td>
	</tr>
	<tr>
		<td colspan="3"><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td></td>
		<td style="padding-top:5px;">
			<input class="SubmitBut" type="submit" value=" Сохранить " style="width:150px;">&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="3"><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
</form>
{/if}