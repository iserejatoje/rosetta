{if $page.message == 'album_not_found'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Альбом не найден!<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'photo_not_found'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Фотография не найдена!<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_view_album'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для просмотра данного альбома<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_view_photo'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для просмотра данной фотографии<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_view_gallery'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для просмотра данной галереи<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_add_album'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для создания альбома<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_add_photo'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для добавления фотографии<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_edit_photo'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для редактирования фотографии<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>


{elseif $page.message == 'cant_delete_album'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для удаления альбома<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_delete_photo'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		У вас нет прав для удаления фотографии<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'cant_upload_photo'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Не удалось загрузить фотографию!<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'photo_album_not_exist'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Изменения сохранены. Но, переместить фотографию в выбранный альбом нельзя,
		т.к. альбом не существует!<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>

{elseif $page.message == 'photo_album_not_this_user'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Изменения сохранены. Но, переместить фотографию в выбранный альбом нельзя,
		т.к. альбом принадлежит другому пользователю!<br>
		<a href="/{$ENV.section}/{if $page.popup}popup/{/if}">Вернуться к галерее</a>
	</td>
</tr>
</table>


{/if}