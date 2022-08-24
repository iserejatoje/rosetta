{include file="`$TEMPLATE.sectiontitle`" rtitle="Подписка"}
<br/><br/>
	<table border="0" cellpadding="0" cellspacing="0" width="580" align="center">
	<tr>
		<td>
			<form method="post">
				<input type="hidden" name="action" value="subscribe_notify" />
				<p><input id="cb_notify" type="checkbox" name="notify" value="1" {if $page.notify}checked="checked"{/if} /> <label for="cb_notify">Получать уведомления об объявлениях</label></p>
				<p><input type="submit" value="Сохранить" /></p>
			</form>
		</td>
	</tr>
	</table>
<br/>
{$page.list_subscribe}