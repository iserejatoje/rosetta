<form method="POST">
<input type="hidden" name="_action" value="_ratingchange.html">
<input type="hidden" name="user" value="{$user}">
<input type="hidden" name="message" value="{$message}">
<table width="500" align="center" cellpadding="2" cellspacing="0">
<tr>
	<td>&nbsp;</td>
	<td><!--{$action}-->
		<input type="radio" name="action" value="plus"{if $action!='minus'} checked{/if}> Увеличение рейтинга<br>
		<input type="radio" name="action" value="minus"{if $action=='minus'} checked{/if}> Уменьшение рейтинга
	</td>
</tr>
<tr><td><img src="/_img/x.gif" width="1" height="2"></td><td><img src="/_img/x.gif" width="1" height="2"></td></tr>
{if !empty($ERROR.comment)}
<tr><td>&nbsp;</td><td class="ferror">&nbsp;{$ERROR.comment}</td></tr>
{/if}</td>
<tr>
	<td class="fheader_text" valign="top">Комментарий</td>
	<td>
		<textarea name="comment" style="width:99%;height:50px;">{$comment}</textarea>
	</td>
</tr>
<tr><td><img src="/_img/x.gif" width="1" height="2"></td><td><img src="/_img/x.gif" width="1" height="2"></td></tr>
<tr>
	<td class="fbreakline">&nbsp;</td>
	<td class="fbreakline"><input type="submit" value="Принять"></td>
</tr>
</table>
</form>