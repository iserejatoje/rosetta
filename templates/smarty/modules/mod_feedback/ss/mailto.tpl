{* if $smarty.get.debug>9}{debug}{/if *}
<script type="text/javascript" language="javascript">{literal}
<!--

	var email_empty = 1;

	function checkfrmaddouternews(form){
	var show = (document.getElementById('cont').style.display != 'none');
	  if (isEmpty(form.theme.value)&&show){
		alert("Вы не заполнили поле \"Тема письма\"!");
		form.theme.focus();
		return false;
	  }
	  if (isEmpty(form.text.value)&&show){
		alert("Вы не заполнили поле \"Текст\"!");
		form.text.focus();
		return false;
	  }
	  if(form.method[0].checked) {
	  	email_empty = isEmpty(form.conts.value);
	      if (email_empty || !isEmail(form.conts.value)){
			if(email_empty)
				alert("Вы не заполнили поле \"E-mail\"!");
			else alert("Вы неправильно заполнили поле \"E-mail\"!");
    	    form.conts.focus();
        	return false;
	      }
	  }
	  if(isEmpty(form.captcha_code.value)) {
		alert("Поле \"Число\" должно быть заполнено.");
		form.captcha_code.focus();
		return false;
	  }
	  return true;
	}


	function isEmpty (txt){
	  var ch;
	  if (txt == "") return true;
	  for (var i=0; i<txt.length; i++){
		ch = txt.charAt(i);
		  if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
	  }
	  return true;
	}

	function isEmail(email)
	{
		var arr1 = email.split("@");
		if (arr1.length != 2) return false;
		else if (arr1[0].length < 1) return false;
		var arr2 = arr1[1].split(".");
		if (arr2.length < 2) return false;
		else if (arr2[0].length < 1) return false;
		return true;
	}

	function ShowHideBlockMailTo()
	{
		if(document.getElementById('method_send').checked)
		{
			document.getElementById('cont').style.display = 'block';
			document.getElementById('sub').value = 'Отправить';
		}
		else
		{
			document.getElementById('cont').style.display = 'none';
			document.getElementById('sub').value = 'Показать';
		}
	}
//-->
</script>

<style>
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
</style>{/literal}

<table border="0" cellpadding="20" cellspacing="0" width="100%" height="100%" align="center">
	<tr>
		<td align="center" valign="middle" class="t12">
			<form name="formaddNews" method="post" style="margin:0px" onSubmit="return checkfrmaddouternews(this)" enctype="multipart/form-data">
			<center>
				<input type="radio" value="send" name="method" id="method_send" onclick="ShowHideBlockMailTo();"{if $page.form.method=='send'} checked{/if} />
				<font class="feedback_header"><label for="method_send"> Отправить письмо</label></font>&nbsp;&nbsp;&nbsp;
				<input type="radio" value="show" name="method" id="method_show" onclick="ShowHideBlockMailTo();"{if $page.form.method=='show'} checked{/if} />
				<font class="feedback_header"><label for="method_show"> Показать e-mail</label></font>
			</center>

{if $UERROR->IsError()}
<div class="error">{php}echo UserError::GetErrorsText(){/php}</div>
{/if}

			<input type="hidden" name="action" value="mailto" />
			<input type="hidden" name="referer" value="{$page.form.referer}" />
			<input type="hidden" name="m" value="{$page.form.m}" />
			<input type="hidden" name="u" value="{$page.form.u}" />
			<div id="cont">
				<table align="center" cellpadding="2" cellspacing="0" border="0" width="100%" id="cont">
					<tr valign="top">
						<td align="left" class="feedback_text">Тема письма:
							<input type="text" name="theme" value="{$page.form.theme}" style="width:100%" class="feedback_field">
						</td>
					</tr>
					<tr valign="top">
						<td align="left" class="feedback_text">Текст:
							<textarea name="text" style="width:100%;height:120px" class="feedback_field">{$page.form.text}</textarea>
						</td>
					</tr>
					<tr valign="top">
						<td align="left" class="feedback_text">Файл (размером не более 1МБ):
							<INPUT type="file" name="file"  style="width:100%" class="feedback_field">
						</td>
					</tr>
					<tr>
						<td align="left" class="feedback_text">Ваш E-mail:
							<input type="text" name="conts" style="width:100%" value="{$page.form.conts}" class="feedback_field">
						</td>
					</tr>
				</table>
			</div>
				<table align="center" cellpadding="2" cellspacing="0" border="0" width="100%">
					<tr>
						<td class="feedback_text">
							<img src="{$page.form.captcha_path}" align="absmiddle" width="150" height="50" alt="число" border="0"> &gt;&gt; <input type="text" name="captcha_code" size="20" maxlength="4" class="txt" style="width:40px;" class="feedback_field"><br/>Введите число, которое вы видите на картинке.
						</td>
					</tr>
					<tr>
						<td align="center">
						<input type="submit" value="Отправить" style="width:130px" class="feedback_field" name="sub" id="sub">
						</td>
					</tr>
				</table>
			</form>
			<p align=center><a href="javascript:window.close();" class="feedback_header">Закрыть</a></p>
		</td>
	</tr>
</table>
<script type="text/javascript" language="javascript">
<!--
ShowHideBlockMailTo();
//-->
</script>
