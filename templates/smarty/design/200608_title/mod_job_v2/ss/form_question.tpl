

<br />
<a name="add"></a>

<form method="post">
<input type="hidden" name="action" value="question_add">
<input type="hidden" name="uid" value="{$res.juid}">
<input type="hidden" name="fid" value="{$res.fid}">

<table align="center" cellpadding="0" cellspacing="2" border="0" width="450px" class="table2">
	<tr>
		<th colspan="2">Задать вопрос</th>
	</tr>
	<tr>
		<td class="bg_color2" width="125" align="right">Автор:</td>
		<td class="bg_color4"><input type="text" name="from_name" style="width:100%" maxlength="250"></td>
	</tr>
	<tr>
		<td class="bg_color2" width="125" align="right">E-mail:</td>
		<td class="bg_color4"><input type="text" name="from_email" style="width:100%" maxlength="250"></td>
	</tr>
	<tr>
		<td class="bg_color2" width="125" align="right">Вопрос:</td>
		<td class="bg_color4">
			<textarea name="message" style="width:100%" rows="6"></textarea><br /><br />
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><input type="submit" value="Добавить вопрос" /></td>
	</tr>
</table>

</form>