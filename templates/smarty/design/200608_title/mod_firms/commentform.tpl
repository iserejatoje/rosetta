{if !empty($res.id) AND $res.id != 13648 AND $res.id != 7911} {* Скрыть форму добавления отзыва для Тюменьэнергобанк, Мечел-банк *}
<script language="Javascript">{literal}
<!--
	function check(form)
	{
		if (isEmpty(form.c_name.value))
		{
			alert("Укажите ваше имя или nickname!");
			form.c_name.focus();
			return false;
		}
		if (!isEmpty(form.c_email.value) && !isEmail(form.email.value))
		{
			alert("вы неправильно указали E-mail!");
			form.c_email.focus();
			return false;
		}
		if (isEmpty(form.c_comment.value))
		{
			alert("Вы не оставили сообщение!");
			form.c_comment.focus();
			return false;
		}

		return true;
	}

	function isEmail(email)
	{
		var arr1 = email.split("@");
		if (arr1.length < 2)
			return false;
		if (arr1[0].length < 1)
			return false;
		var arr2 = arr1[1].split(".");
		if (arr2.length < 2)
			return false;
		if (arr2[0].length < 1)
			return false;
		if (arr2[1].length < 1)
			return false;
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
{/literal}
</script>
<!-- начало - форма для отзыва -->
			<form method="post" onSubmit="javascript: return check(this)" action="#question">
			<input type=hidden name=id value="{$res.id}" />
			<input type=hidden name=action value="addcomment" />
			<input type=hidden name=page value="{$res.page}">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	<tr><td align="center">
		<b>Выскажи свое мнение!</b><a name="question">&nbsp;</a>
		{*if $error}<br/><b>{$error}</b>{/if*}
	</td></tr>
	<tr>
		<td>{if $res.error}<div align="center" style="color:red"><b>{$res.error}</b></div><br/><br/>{/if}</td>
	</tr>
	<tr>
		<td valign="top" style="padding: 3px 3px 3px 3px" align="center">
			<table cellSpacing="2" cellPadding="3" align="center" border="0">
				<tr>
					<td align="right" ><b>Автор:</b></td>
					<td><input style="width:370px" maxlength="100" size="42" name="c_name" value="{$c_name|escape:'quotes'}"></td>
				</tr>
				<tr>
					<td align="right" ><b>E-mail:</b></td>
					<td><input style="width:370px" maxlength="100" size="42" name="c_email" value="{$c_email|escape:'quotes'}"></td>
				</tr>
				{if $res.have_rating}
				<tr>
					<td align="right"><b>Рейтинг:</b></td>
					<td>
						<select name="c_rate" type="select-one" size="1" style="width:220px">
							<option value="0">-- оценка компании --</option>
							<option value="1">очень плохо</option>
							<option value="2">плохо</option>
							<option value="3">удовлетворительно</option>
							<option value="4">хорошо</option>
							<option value="5">отлично</option>
						</select>
					</td>
				</tr>
				{/if}
				{*if !empty($res.session_id)}
				<tr>
					<td align="right"><b>Защита от роботов:</b></td>
					<td align="left"><img src="/_ar/pic.gif?{$res.session_id}" width="150" height="50" align="middle" alt="код" border="0"> &gt;&gt; <input type="text" name="antirobot" size="20"  class="TextEdit" style="font-size:12px">
						<br /><small>Введите четырехзначное число, которое Вы видите на картинке</small></td>
				</tr>
				{/if*}
				
				{if isset($res.captcha_path)}
				<tr>
				    <td align=right>Код защиты от роботов</td>
				    <td><img src="{$res.captcha_path}" width="150" height="50" border="0" align="middle" /> &gt;&gt; <input type=text name="captcha_code" style=width:100px value="">
						<br />Введите четырехзначное число, которое Вы видите на картинке</td>
				</tr>
				{/if}
				
				<tr>
					<td valign="top" align="right"><b>Cообщение:</b></td>
					<td><textarea style="width:370px" name="c_comment" rows="8">{$c_comment|escape:"html"}</textarea></td>
				</tr>
				<tr>
					<td ></td>
					<td><input type="submit" value="Отправить">&nbsp;&nbsp;&nbsp; <input type="reset" value="Очистить"></td>
				</tr>
				{$res.session_code}
			</table>
		</td>
	</tr>
	<tr><td height="20px"></td></tr>
	<tr><td>Опубликованные сообщения являются частными мнениями лиц, их написавших.<br/>Редакция сайта за размещенные сообщения ответственности не несет.<br/><a target='_blank' href='http://info74.ru/?view=rule'>Правила модерирования сообщений.</a></td></tr>
</table>
</form>
<!-- конец - форма для отзыва -->
{/if}