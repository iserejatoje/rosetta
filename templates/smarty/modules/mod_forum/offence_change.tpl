<form method="POST">
<input type="hidden" name="_action" value="_offencechange.html">
<input type="hidden" name="action" value="plus">
<input type="hidden" name="user" value="{$user}">
<input type="hidden" name="message" value="{$message}">
<table width="500" align="center" cellpadding="2" cellspacing="0">
<tr>
	<td class="fheader_text" valign="top" width="150">Уровень наказания</td>
	<td>
		<select name="penalty" style="width:50">
		{foreach from=$penalties item=l}
			<option value="{$l}">{$l}</option>
		{/foreach}
		</select>
	</td>
</tr>
<tr>
	<td class="fheader_text" valign="top">Срок</td>
	<td>
		<input type="text" name="period" style="width:30px"> дней
	</td>
</tr>
<tr>
	<td class="fheader_text" valign="top">Комментарий</td>
	<td>
		<textarea name="comment" style="width:99%;height:50px;"></textarea>
	</td>
</tr>
<tr>
	<td class="fbreakline">&nbsp;</td>
	<td class="fbreakline"><input type="submit" value="Наказание"></td>
</tr>
</table>
</form>