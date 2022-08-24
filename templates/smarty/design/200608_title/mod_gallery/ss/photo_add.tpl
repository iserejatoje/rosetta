{if $page.errors.success}
<br/><br/>
<div align="center"><font color="green"><b>{$page.errors.success}</b></font><br/><br/>
<a href="/{$ENV.section}/photo/add.html">Добавить фотографии</a> | <a href="/{$ENV.section}/list/albums/u{$user->id}.html">Мои альбомы</a></div>
{else}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<form name="frm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="add_photo" />
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td colspan="2">
              <ul>
                <li>За один раз Вы можете добавить не более 3 фотографий</li>
                <li>Поддерживаются фотографии форматов JPEG, GIF и PNG</li>
                <li>Размер каждой фотографии не должен превышать {$page.photo_max_size} мегабайта</li>
                <li>Размер фотографий будет автоматически изменен, в случае если размеры оригинала превышают допустимые</li>
                <li>Альбомы, содержащие эротические и порнографические фотографии удаляются модератором без предупреждения</li>
                <li>Помните о том, что размещенные фотографии не должны нарушать <strong>Российское законодательство</strong></li>    
              </ul>
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	{if $page.errors.global}<tr><td align="center" colspan="2"><font color="red"><b>{$page.errors.global}</b></font><br/><br/></td></tr>{/if}
	{foreach from=$page.photos item=photo key=key}	
	<tr>
		<td align="left" valign="top" width="100%" colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt=""  /></td>
	</tr>
	<tr>
		<td align="left" valign="top" width="100%" colspan="2">
			<font color="#005A52"><b>Фотография {$key+1}</b></font>
		</td>
	</tr>
	{assign var=_key value="image_error_$key"}
	{if $page.errors[$_key]}<tr><td align="center" colspan="2"><font color="red"><b>{$page.errors[$_key]}</b></font><br/><br/></td></tr>{/if}
	<tr>
		<td align="left" valign="top" width="50%">
		<table align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right" valign="top"><b>Фотография:</b></td>
			<td colspan="2">
				<input type="file" name="adv_photo[]" size="37" /><br/>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input id="d{$key}" type="checkbox" name="delete[]" {if $photo.delete}checked{/if} value="1"></td>
			<td><label for="d{$key}">Я не против, если эту фотографию удалят через 2 месяца <br/>(пожалуйста, отнеситесь к этой опции серьезно!)</label></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Альбом:</b></td>
			<td colspan="2">
				<select name="aid[]" size="1" type="select-one" style="width:300px">
					{foreach from=$page.aList item=album}
						<option value="{$album.id}" {if $photo.aid == $album.id}selected{/if}>{$album.name}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Название фотографии:</b></td>
			<td colspan="2"><input type="text" name="name[]" maxlength="255" style="width:295px;" value="{$photo.name}"></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Комментарий к фотографии:</b></td>
			<td colspan="2"><textarea name="descr[]" style="width:295px;height:100px">{$photo.descr}</textarea></td>
		</tr>
		<tr>
			<td colspan="3"><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
		</tr>
		</table>

		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	{/foreach}
	<tr>
		<td align="center" style="padding-top:5px;">
		<input class="SubmitBut" type="submit" value="Сохранить" style="width:100px;">&nbsp;
		</td>
	</tr>
	</form>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>

{/if}