<script type="text/javascript" language="javascript">{literal}
	function checkFrom()
	{
		if (document.getElementById("comment_error").value.length> 1000)
		{
			alert("Максимальная длина комментария 1000 символов");
			return false;
		}
		return true;
	}
</script>{/literal}
<style>{literal}
.feedback_header{
	color:#03424A;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:12px;
	font-weight:bold;
}
.feedback_text{
	color:#03424A;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:12px;
	font-weight:normal;
}
.feedback_field{
	color:#000000;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:11px;
	font-weight:normal;
}
.error
{
	color: red;
	padding: 5px;
	font-family: Verdana, Tahoma, Helvetica, Sans-serif;
	font-size: 11px;
}
{/literal}</style>

{if $UERROR->IsError()}
<div class="error">{php}echo UserError::GetErrorsText(){/php}</div>
{/if}

<form method="post" onSubmit="return checkFrom()">
<input type="hidden" name="action" value="error" />
<input type="hidden" name="referer" value="{$page.referer}" />
<input type="hidden" name="error_msg" value="{$page.error_msg}" />
<table border="0" cellpadding="5" cellspacing="0" width="100%" align="center" style="padding-left:10px;padding-right:10px;">
	<tr>
		<td align="center" valign="middle" class="t12">
			<center>
				<font class="feedback_header">Спасибо за внимание к нашим материалам!</font>
			</center>
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" class="t12">
			<span class="feedback_text">Если в выделенном тексте: "<font color="red">{$page.error_msg}</font>" действительно есть ошибка, в ближайшее время её исправят.<br/><br/>
			Обратите внимание: сервис предназначен для исправления ошибок и опечаток в информационных материалах и справочниках. Сообщения об ошибках в отзывах, объявлениях, личном кабинете (в том числе системного характера) в работу не принимаются.</span>
			<br/><br/>
		</td>
	</tr>
	<tr>
		<td align="left" valign="middle" class="t12">
			<span class="feedback_text">Комментировать:</span><br/>
			<textarea name="comment_error" id="comment_error" class="feedback_field" style="width: 100%" col="18" rows="4">{$page.comment}</textarea>
		</td>
	</tr>
	<tr>
		<td align="left" class="feedback_text">Ваш E-mail:
			<input type="text" name="email_from" style="width:100%" value="{$page.email_from}" class="feedback_field">
		</td>
	</tr>
	<tr>
		<td class="feedback_text">
			<img src="{$page.captcha_path}" align="absmiddle" width="150" height="50" alt="число" border="0"> &gt;&gt; <input type="text" name="captcha_code" size="20" maxlength="4" class="txt" style="width:40px;" class="feedback_field"><br/>Введите число, которое вы видите на картинке.
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle" class="t12">
			<input type="submit" class="feedback_field" value="Отправить корректору"/>
		</td>		
	</tr>
</table>
</form>
