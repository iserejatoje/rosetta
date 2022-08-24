<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_contacts" />
<div class="title" style="padding: 5px;">Контакты</div>
<br /><br />
<table border="0" cellpadding="3" cellspacing="2" width="550">

{if $UERROR->GetErrorByIndex('icq') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('icq')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="100">ICQ</td>
		<td class="bg_color4"><input type="text" name="icq" value="{$page.form.icq}" style="width:100%"/></td>
		{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
		<td align="right" class="bg_color2" width="50">видно</td>
		<td class="bg_color4" width="80">
			<select name="rights[]">
			<option value="0" >Никому</option>
			<option value="1" {if $USER->Profile.general.ContactRights & 1}selected="selected"{/if}>Всем</option>
			<option value="2" {if $USER->Profile.general.ContactRights & 2}selected="selected"{/if}>Друзьям</option>
			</select>
		</td>{/if}
	</tr>
{if $UERROR->GetErrorByIndex('skype') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('skype')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Skype</td>
		<td class="bg_color4"><input type="text" name="skype" value="{$page.form.skype}" style="width:100%" /></td>
		{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
		<td align="right" class="bg_color2" width="50">видно</td>
		<td class="bg_color4" width="80"><select name="rights[]">
		<option value="0" >Никому</option>
		<option value="4" {if $USER->Profile.general.ContactRights & 4}selected="selected"{/if}>Всем</option>
		<option value="8" {if $USER->Profile.general.ContactRights & 8}selected="selected"{/if}>Друзьям</option>
		</select></td>{/if}
	</tr>
{if $UERROR->GetErrorByIndex('site') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('site')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Сайт</td>
		<td class="bg_color4"><input type="text" name="site" value="{$page.form.site}" style="width:100%" /></td>
		{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
		<td align="right" class="bg_color2" width="50">видно</td>
		<td class="bg_color4" width="80"><select name="rights[]">
		<option value="0" >Никому</option>
		<option value="16" {if $USER->Profile.general.ContactRights & 16}selected="selected"{/if}>Всем</option>
		<option value="32" {if $USER->Profile.general.ContactRights & 32}selected="selected"{/if}>Друзьям</option>
		</select></td>{/if}
	</tr>
{if $UERROR->GetErrorByIndex('phone') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('phone')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Телефон</td>
		<td class="bg_color4"><input type="text" name="phone" value="{$page.form.phone}" style="width:100%" /></td>
		{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
		<td align="right" class="bg_color2" width="50">видно</td>
		<td class="bg_color4" width="80"><select name="rights[]">
		<option value="0" >Никому</option>
		<option value="64" {if $USER->Profile.general.ContactRights & 64}selected="selected"{/if}>Всем</option>
		<option value="128" {if $USER->Profile.general.ContactRights & 128}selected="selected"{/if}>Друзьям</option>
		</select></td>{/if}
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>