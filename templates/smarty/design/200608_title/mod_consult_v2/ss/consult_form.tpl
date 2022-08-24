<script language="Javascript">{literal}
<!--
	function check(form)
	{
		if (isEmpty(form.name.value))
		{
			alert("Укажите Ваше Имя и Фамилию!");
			form.name.focus();
			return false;
		}
		if (isEmpty(form.otziv.value))
		{
			alert("Вы не написали вопрос!");
			form.otziv.focus();
			return false;
		}

		return true;
	}

	function isEmpty (txt)
	{
		var ch;
		if (txt == "") return true;
		for (var i=0; i<txt.length; i++)
		{
			ch = txt.charAt(i);
			if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
		}
		return true;
	}
//-->
{/literal}</script>
<!-- начало - форма для вопроса -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	<tr><td align="left"bgcolor="#edf6f8" style="padding:3px;padding-left:8px;"><a name="question"></a><font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">Задайте свой вопрос!</font></td></tr>
	<tr>
		<td valign="top">
			{if $UERROR->GetErrorByIndex('question') != ''}<br/>
				<div class="ferror" align="center"><span>{$UERROR->GetErrorByIndex('question')}</span></div>
				<br/>
			{/if}
			<a name="question"></a>
			<form method="post" action="#question" onsubmit="javascript: return check(this)">
			<input type="hidden" name="cid" value="{$res.cid}" />
			<input type="hidden" name="page" value="{$res.page}" />
			<input type="hidden" name="action" value="add_quest" />
			<table cellspacing="2" cellpadding="3" width="580px" border="0">
				<tr>
					<td width="210" align="right"><b>Ваше Имя и Фамилия:</b></td>
					<td width="370px" align="left"><input class="txt" style="width:370px" maxlength="100" size="42" value="{$res.name|escape}" name="name" /></td>
				</tr>
				<tr>
					<td width="210" align="right"><b>Ваш E-mail:</b></td>
					<td width="370px" align="left"><input class="txt" style="width:370px" maxlength="100" size="42" value="{$res.email|escape}" name="email" /></td>
				</tr>
				<tr>
					<td width="210" valign="top" align="right"><b>Текст вопроса:</b></td>
					<td width="370px" align="left"><textarea class="txt" style="width:370px" name="otziv" cols="" rows="8">{$res.otziv}</textarea></td>
				</tr>
				<tr>
			      <td width="210" valign="top" align="right"><b>Код защиты от роботов:</b></td>
			      <td width="370px" align="left"><img src="{$res.captcha_path}" width="150" height="50" border="0" align="middle" /> &gt;&gt; <input type=text name="captcha_code" style=width:100px value="">
						<br />Введите четырехзначное число, которое Вы видите на картинке</td>
			    </tr>
				<tr>
					<td width="210"></td>
					<td align="left" width="370px"><input type="submit" value="Отправить" class="button" />&nbsp;&nbsp;&nbsp; <input type="reset" value="Очистить" class="button"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<!-- конец - форма для отзыва -->
