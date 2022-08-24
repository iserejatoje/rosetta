<form style="margin:0px" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="mypage_photo" />
<div class="title">Фотографии</div>
<br /><br />
<table  border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('avatar') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('avatar')}</span></td>
	</tr>
{/if}
{if $page.form.avatar.file != ''}
	<tr>
		<td align="right" class="bg_color2" width="150">&nbsp;</td>
		<td class="bg_color4">
			<img src="{$page.form.avatar.file}" width="{$page.form.avatar.w}" height="{$page.form.avatar.h}"{if in_array('Avatar',$page.form.bad_fields)} class="profile_moderation_warning"{/if} /><br>
			<input type="checkbox" name="del_avatar" id="del_avatar" value="1"> <label for="del_avatar">удалить фотографию</label>
		</td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Фотография маленькая</td>
		<td class="bg_color4">
			<input type="file" name="avatar" /><br />
			<span class="tip">Размер маленькой фотографии не должен превышать {if floor($page.avatar_file_size / 1048576) > 0}{math equation="size/1048576" size=$page.avatar_file_size}Мб{else}{math equation="size/1024" size=$page.avatar_file_size}Кб{/if}, фотография будет уменьшена до размера {$CONFIG.avatar.img_size.max_width}x{$CONFIG.avatar.img_size.max_height} пикселов.</span>
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('photo') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('photo')}</span></td>
	</tr>
{/if}
{if $page.form.photo.file != ''}
	<tr>
		<td align="right" class="bg_color2">&nbsp;</td>
		<td class="bg_color4">
			<img src="{$page.form.photo.file}" width="{$page.form.photo.w}" height="{$page.form.photo.h}" {if in_array('Photo',$page.form.bad_fields)} class="profile_moderation_warning"{/if} /><br>
			<input type="checkbox" name="del_photo" id="del_photo" value="1"> <label for="del_photo">удалить фотографию</label>
		</td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Фотография большая</td>
		<td class="bg_color4">
			<input type="file" name="photo" /><br />
			<span class="tip">Размер большой фотографии не должен превышать {if floor($page.photo_file_size / 1048576) > 0}{math equation="size/1048576" size=$page.photo_file_size}Мб{else}{math equation="size/1024" size=$page.photo_file_size}Кб{/if}, фотография будет уменьшена до размера {$CONFIG.photo.img_size.max_width}x{$CONFIG.photo.img_size.max_height} пикселов.</span>
		</td>
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">

	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>