<script type="text/javascript" language="javascript" src="/_scripts/modules/job/conadmlogform.js"></script>
{capture name=rtitle}
	Вход в раздел &laquo;{$res.title}&raquo; для экспертов	
{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rtitle`"}
<form method="post" onSubmit="return check(this)">
<input type="hidden" name="cmd" value="conadmlogin" />

<table cellpadding="5" cellspacing="1" align="center">
	<tr>
		<td class="text11" align="right" bgcolor="#F5F5F5"><font color="red">*</font> <b>E-mail</b>:</td>
		<td class="text11" align="left"><input type="text" name="email" size="35" class="TextEdit" /></td>
	</tr>
	<tr>
		<td class="text11" align="right" bgcolor="#F5F5F5"><font color=red>*</font> <b>Пароль</b>:</td>
		<td class="text11" align="left"><input type="password" name="pass" size="35" class="TextEdit" /></td>
	</tr>
</table>
<center>
<br/>
<input type="submit" value="     Войти     " class=SubmitBut />
<p class="text11"><font color="red">*</font> - обозначены поля, обязательные для заполнения.</p>
</center>
</form>