<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_notify" />
<div class="title">Уведомления</div>
<br /><br />
<table border="0" cellpadding="3" cellspacing="2" width="100%">
	<tr>
		<td class="bg_color2">Уведомлять о новых личных сообщениях</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="imnotify" id="imnotify1" value="1"{if $page.form.imnotify==1} checked="checked"{/if} /> <label for="imnotify1">Всегда</label><br />
			<input type="radio" name="imnotify" id="imnotify60" value="60"{if $page.form.imnotify==60} checked="checked"{/if} /> <label for="imnotify60">Не чаще раза в час</label><br />
			<input type="radio" name="imnotify" id="imnotify1440" value="1440"{if $page.form.imnotify==1440} checked="checked"{/if} /> <label for="imnotify1440">Не чаще раза в день</label><br />
			<input type="radio" name="imnotify" id="imnotify10080" value="10080"{if $page.form.imnotify==10080} checked="checked"{/if} /> <label for="imnotify10080">Не чаще раза в неделю</label><br />
			<input type="radio" name="imnotify" id="imnotify0" value="0"{if $page.form.imnotify==0} checked="checked"{/if} /> <label for="imnotify0">Никогда</label><br /><br />
		</td>
	</tr>	
	<tr>
		<td class="bg_color2">Уведомлять, когда Вам предлагают стать друзьями</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="friendinvite" id="friendinvite1" value="1"{if $page.form.friendinvite==1} checked="checked"{/if} /> <label for="friendinvite1">Всегда</label><br />
			<input type="radio" name="friendinvite" id="friendinvite60" value="60"{if $page.form.friendinvite==60} checked="checked"{/if} /> <label for="friendinvite60">Не чаще раза в час</label><br />
			<input type="radio" name="friendinvite" id="friendinvite1440" value="1440"{if $page.form.friendinvite==1440} checked="checked"{/if} /> <label for="friendinvite1440">Не чаще раза в день</label><br />
			<input type="radio" name="friendinvite" id="friendinvite10080" value="10080"{if $page.form.friendinvite==10080} checked="checked"{/if} /> <label for="friendinvite10080">Не чаще раза в неделю</label><br />
			<input type="radio" name="friendinvite" id="friendinvite0" value="0"{if $page.form.friendinvite==0} checked="checked"{/if} /> <label for="friendinvite0">Никогда</label><br /><br />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>