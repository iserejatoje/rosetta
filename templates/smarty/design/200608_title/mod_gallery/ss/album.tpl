{if $page.errors.success}
<br/><br/>
<div align="center"><font color="green"><b>{$page.errors.success}</b></font><br/><br/>
<a href="/{$ENV.section}/photo/add.html">Добавить фотографии</a> | <a href="/{$ENV.section}/list/albums/u{$user->id}.html">Мои альбомы</a></div>
{else}
{if $page.errors.global}<div align="center"><font color="red"><b>{$page.errors.global}</b></font></div>{/if}
{if ($page.action == 'edit_album' && $page.album.id) || $page.action == 'add_album'}
<script language="JavaScript" type="text/javascript" src="/_scripts/modules/gallery/checkform.js"></script>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<form name="frm" method="post" enctype="multipart/form-data" onsubmit="return chAlbumtForm(this)">
	<input type="hidden" name="action" value="{$page.action}" />
	<input type="hidden" name="aid" value="{$page.album.id}" />
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" width="100%" colspan="2"><img src="/_img/x.gif" width="1" height="5" border="0" alt=""  /></td>
	</tr>
	<tr>
		<td align="left" valign="top" width="50%">
		<table align="left" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td align="right" valign="top"><b>Название альбома:</b></td>
			<td align="left"><input type="text" maxlength="255" name="name" style="width:295px;" value="{$page.album.name}"></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Тема альбома:</b></td>
			<td align="left">
			<select name="cid" size="1" type="select-one" style="width:300px">
			{foreach from=$page.cList item=cat}
				<option value="{$cat.id}" {if $cat.id == $page.album.cid}selected{/if}>{$cat.name}</option>
			{/foreach}</select></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Режим доступа к альбому:</b></td>
			<td align="left">
			<input id="access0" type="radio" name="access" value="0" {if $page.album.access == 0}"checked"{/if}/><label for="access0">Показывать фото всем пользователям</label><br/>
			<input id="access1" type="radio" name="access" value="1" {if $page.album.access == 1}"checked"{/if}/><label for="access1">Показывать фото только зарегистрированным пользователям</label><br/>
			<input id="access2" type="radio" name="access" value="2" {if $page.album.access == 2}"checked"{/if}/><label for="access2">Показывать фото по паролю</label><br/>
			</td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Пароль к альбому <br/>(в случае, если выбран режим доступа по паролю):</b></td>
			<td align="left"><input type="password" name="pass1" maxlength="50" style="width:295px;" value=""></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Повторите:</b></td>
			<td align="left"><input type="password" name="pass2" maxlength="50" style="width:295px;" value=""></td>
		</tr>
		<tr>
			<td align="right" valign="top"><b>Текстовый комментарий к альбому:</b></td>
			<td align="left"><textarea name="descr" style="width:295px;height:100px">{$page.album.descr}</textarea></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="left"><input class="SubmitBut" type="submit" value=" Сохранить " style="width:100px;"></td>
		</tr>
		<tr>
			<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
		</tr>
		</table>

		</td>
	</tr>
	</form>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
{/if}
{/if}