<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_talk" />
<div class="title">Общение</div>
<br /><br />
<table border="0" cellpadding="3" cellspacing="2" width="550">

{if $UERROR->GetErrorByIndex('signature') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('signature')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" width="150" class="bg_color2">Подпись в форумах</td>
		<td class="bg_color4"><input type="text" name="signature" value="{$page.form.signature}" style="width:100%" /></td>
	</tr>
{if $UERROR->GetErrorByIndex('status') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('status')}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" width="150" class="bg_color2">Статусное сообщение на форумах</td>
		<td class="bg_color4">
			<input type="text" name="status" value="{$page.form.status}" style="width:100%"{if !$USER->IsInRole("m_forum_other_show_status")} readonly{/if}/>
			<span class="tip">{if !$USER->IsInRole("m_forum_other_show_status")}Вы сможете установить статусное сообщение, набрав {$CONFIG.limits.min_user_status_messages} сообщений на форуме.{else}Максимум {$CONFIG.limits.max_len_user_status} символов.{/if}</span>
		</td>
	</tr>
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="smileoff" id="smileoff" value="1"{if $page.form.smileoff} checked="checked"{/if} /> <label for="smileoff">Не показывать смайлы</label></td>
	</tr>
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="imageoff" id="imageoff" value="1"{if $page.form.imageoff} checked="checked"{/if} /> <label for="imageoff">Не показывать картинки</label></td>
	</tr>	
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4"><input type="checkbox" name="avataroff" id="avataroff" value="1"{if $page.form.avataroff} checked="checked"{/if} /> <label for="avataroff">Не показывать аватары</label></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>