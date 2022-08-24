<br/><div align="center">
<a name="add"></a>
<form method="post" action="#add" onSubmit="return checkformadd(this)">
<input type="hidden" name="action" value="add"/>
{if $res.word != ''}<input type="hidden" name="word" value="{$res.word}"/>{/if}
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td colspan="2" class="t5gb" align="left">
			Добавить свое толкование сна
		</td>
	</tr> 
	{if $res.errors}
	<tr>
		<td colspan="2" align="center" style="color:#FF0000">{$res.errors}<br/><br/></td>
	</tr>
	{/if}
	{if $res.word == ''}
	<tr>
		<td align="right" class="t1"><font color="red">*</font> <b>Ключевое слово:</b></td>
		<td><input class="txt" type="text" name="word" style="width:350px" value="{$res.params.word}"></td>
	</tr>
	{/if}
	<tr>
		<td align="right" class="t1"><font color="red">*</font> <b>Автор:</b></td>
		<td><input class="txt" type="text" name="name" style="width:350px" value="{$res.params.name}"></td>
	</tr>		
	<tr>
		<td align="right" class="t1"><b>E-mail:</b></td>
		<td><input class="txt" type="text" name="email" style="width:350px" value="{$res.params.email}"></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="t1"><font color="red">*</font> <b>Толкование:</b></td>
		<td><textarea class="txt" name="text" style="width:350px;height:150px">{$res.params.text}</textarea></td>
	</tr>
	<tr>
		<td></td>
		<td class="t7"><font color="red">*</font> - поля обязательные для заполнения</td>
	</tr>
	<tr>
		<td></td>
		<td align="left"><input type="submit" value="Добавить" class="txt">&nbsp;&nbsp;<input type="reset" value="Очистить" class="txt">&nbsp;&nbsp;
		</td>
	</tr>
</table>
</form>
</div>