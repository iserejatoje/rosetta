<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_mail" />
<div class="title">Почта</div>
<br /><br />
<table border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('signature') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('signature')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" width="150" class="bg_color2">Подпись</td>
		<td class="bg_color4"><textarea name="signature" style="width:100%; height:100px;">{$page.form.signature}</textarea></td>
	</tr>
{if $UERROR->GetErrorByIndex('replyto') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('replyto')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Обратный адрес</td>
		<td class="bg_color4"><input type="text" name="replyto" value="{$page.form.replyto}" style="width:100%" /></td>
	</tr>
{if $UERROR->GetErrorByIndex('messagecolpp') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('messagecolpp')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Количество писем<br> на страницу</td>
		<td class="bg_color4">
			<select name="messagecolpp" style="width:155px;">
{foreach from=$page.form.counts_arr item=l}
				<option value="{$l}"{if $page.form.messagecolpp==$l} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('addresscolpp') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('addresscolpp')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Количество адресов <br>на страницу</td>
		<td class="bg_color4">
			<select name="addresscolpp" style="width:155px;">
{foreach from=$page.form.counts_arr item=l}
				<option value="{$l}"{if $page.form.addresscolpp==$l} selected="selected"{/if} style="width:155px;">{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('messagesortord') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('messagesortord')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Сортировка писем</td>
		<td class="bg_color4">
			<select name="messagesortord" style="width:155px;">
{foreach from=$page.form.messagesortord_arr key=k item=l}
				<option value="{$k}"{if $page.form.messagesortord==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>&nbsp;
			<select name="messagesortfield" style="width:155px;">
{foreach from=$page.form.messagesortfield_arr key=k item=l}
				<option value="{$k}"{if $page.form.messagesortfield==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('addresssortord') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('addresssortord')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" class="bg_color2">Сортировка адресов</td>
		<td class="bg_color4">
			<select name="addresssortord" style="width:155px;">
{foreach from=$page.form.addresssortord_arr key=k item=l}
				<option value="{$k}"{if $page.form.addresssortord==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>&nbsp;
			<select name="addresssortfield" style="width:155px;">
{foreach from=$page.form.addresssortfield_arr key=k item=l}
				<option value="{$k}"{if $page.form.addresssortfield==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
	<tr valign="top">
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="saveinsent" id="saveinsent" value="1"{if $page.form.saveinsent} checked="checked"{/if} /> <label for="saveinsent">Cохранять копии писем в папке Отправленные</label></td>
	</tr>
{*
	<tr valign="top">
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="logoutcleartrash" id="logoutcleartrash" value="1"{if $page.form.logoutcleartrash} checked="checked"{/if} /> <label for="logoutcleartrash">Очищать папку Корзина при выходе</label></td>
	</tr>	
*}
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>