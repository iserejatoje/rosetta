<!-- начало - форма для отзыва -->

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
        <td width="40"></td>
        <td valign="top">
<table align="center" width="470" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" colspan="2" style="padding:0px">
	<table align=left cellpadding=0 cellspacing=0 border=0 width=100%>
	<td class="title2_askform"><a name=addcomment></a>
	Выскажи свое мнение!</td></tr>
	</table>
		</td>
	</tr>
</table>
<table align="center" width="470" cellpadding="0" cellspacing="0" border="0">
<tr><td>
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<form name="news_askform" id="news_askform" method="post" onsubmit="return news_askform_check(this)">
	<input type="hidden" name="action" value="add_comment" />
	<input type="hidden" name="id" value="{$res.id}" />

	<tr>
		<td width="100px" align="right"><b>Автор:</b></td>
		<td width="350px" align="left"><input type="text" name="name" style="width:350px" value="{$res.name}"></td>
	</tr>
	<tr>
		<td width="100px" align="right"><b>E-mail:</b></td>
		<td width="350px" align="left"><input type="text" name="email" style="width:350px" value="{$res.email}"></td>
	</tr>
	<tr valign="top">
		<td width="100px" align="right"><b>Cообщение:</b><br /><br />
		<img src="/_img/design/common/resize_s.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(2, 2, 'news_otziv_', 'otziv', null, 350, 350, 100, 1000);" alt="Уменьшить" title="Уменьшить размер поля для ввода сообщения" /><br />
		<img src="/_img/design/common/resize_b.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(1, 2, 'news_otziv_', 'otziv', null, 350, 350, 100, 1000);" alt="Увеличить" title="Увеличить размер поля для ввода сообщения" /><br />
		</td>
		</td>
		<td width="350px" align="left"><textarea id="otziv" name="otziv" style="width:{$smarty.cookies.news_otziv_w|default:350}px;height:{$smarty.cookies.news_otziv_h|default:150}px">{$res.otziv}</textarea></td>
	</tr>
	<tr>
		<td></td>
		<td align="left">
		<input type="submit" value="Отправить">&nbsp;&nbsp;
		<input type="reset" value="Очистить">&nbsp;&nbsp;
		</td>
	</tr>
	</form>
	</table>
</td></tr>

<tr><td height="20px"></td></tr>
<tr><td class="lit2">{#comments_rule#}</td></tr>

<tr><td height="20px"></td></tr>
</table>

	</td>
	</tr>
</table>


<script type="text/javascript" language="javascript">
<!--
{literal}
	var news_askform_send = false;
	function news_askform_check(form)
	{
		if(news_askform_send)
			return false;

{/literal}
{if !$res.user.id}
{literal}
		if (isEmpty(form.name.value))
		{
			alert("Укажите ваше имя или nickname!");
			form.name.focus();
			return false;
		}

		if (!isEmpty(form.email.value) && !isEmail(form.email.value))
		{
			alert("Вы неправильно ввели E-mail!");
			form.email.focus();
			return false;
		}

{/literal}
{/if}
{literal}
		if (isEmpty(form.otziv.value))
		{
			alert("Вы не написали сообщение!");
			form.otziv.focus();
			return false;
		}

		if (form.otziv.value.length>1000)
		{
			alert("Ваше сообщение слишком большое. Максимальная длина - 1000 знаков.");
			form.otziv.focus();
			return false;
		}

		news_askform_send = true;
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
	function isEmpty (txt)
	{
		var ch;
		if (txt == "") return true;
		for (var i=0; i<txt.length; i++){
			ch = txt.charAt(i);
			if (ch!=" " && ch!="\n" && ch!="\t" && ch!="\r") return false;
		}
		return true;
	}

//    -->{/literal}
</script>
<!-- конец - форма для отзыва -->
