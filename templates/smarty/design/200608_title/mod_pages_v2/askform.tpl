<!-- начало - форма для отзыва -->

<table align="center" width="470" cellpadding="0" cellspacing="0" border="0">
<tr><td>
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
	<form name="news_askform" id="news_askform" method="post" onsubmit="return news_askform_check(this)">
	<input type="hidden" name="action" value="addcomment" />
	<input type="hidden" name="id" value="{$res.id}" />
	<tr>
		<td align="left" colspan="2" style="padding:0px">
	<table align=left cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr><td class=zag4><a name=addcomment></a>Выскажи свое мнение!</td></tr>
	<tr><td height=3 bgcolor=#CCCCCC><img src="/_img/x.gif" width=1 height=3 border=0></td></tr>
	</table>
		</td>
	</tr>
{*
	{if !$res.user.id}
	<tr><td align="left" colspan="2" style="padding-left:0px;padding-right:0px;">
	Если вы хотите стать участником клуба <a href="http://74.ru/generation/" target="_blank"><img src="http://74.ru/generation/img/logo_s2.gif" width="90" height="16" border="0" alt='Клуб "Поколение 74"' /></a><br />
	и высказывать свое мнение под своим настоящим именем, то вам необходимо вступить в Клуб.<br />
	</td></tr>
	<tr><td align="right" colspan="2" style="padding-top:5px;padding-right:15px;">
	<a target="_blank" href="http://74.ru/generation/index.php?state=coming" class=ssyl>Вступить в клуб</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="window.open('http://74.ru/generation/index.php?state=login_small','login_win','resizable=0,menubar=0,location=0,status=0,toolbar=0,scrollbars=0,width=500,height=300');return false;" href="http://74.ru/generation/index.php?state=login_small" class="ssyl">Вход для членов Клуба</a>
	</td></tr>
	{else}
	<tr><td align="right" colspan="2" style="padding-top:5px;padding-right:15px;">
	<a target="_blank" href="http://74.ru/generation/index.php?state=invite" class=ssyl>Пригласить в Клуб</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="window.open('http://74.ru/generation/index.php?state=logoff_small','login_win','resizable=0,menubar=0,location=0,status=0,toolbar=0,scrollbars=0,width=500,height=300');return false;" href="http://74.ru/generation/index.php?state=logoff_small" class="ssyl">Выход</a>
	</td></tr>
	{/if}
*}

	<tr>
		<td width="100px" align="right"><b>Автор:</b></td>
		<td width="350px" align="left"><input type="text" name="name" style="width:350px" value="{$res.name}"></td>
	</tr>
	{if !$res.user.id}
	<tr>
		<td width="100px" align="right"><b>E-mail:</b></td>
		<td width="350px" align="left"><input type="text" name="email" style="width:350px" value="{$res.email}"></td>
	</tr>
	{/if}
	{if $res.is_rating}
	<tr>
		<td width="100px" align="right"><b>Рейтинг:</b></td>
		<td width="350px" align="left">
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr>
				<td align="left">
					<select name="score" type="select-one" size="1" style="width:220px">
						<option value="0">-- оценка материала --</option>
						<option value="1">очень плохо</option>
						<option value="2">плохо</option>
						<option value="3">удовлетворительно</option>
						<option value="4">хорошо</option>
						<option value="5">отлично</option>
					</select>
				</td>
				<td align="right"><a href="/{$SITE_SECTION}/{$res.group}{$res.id}-score.html" target="_blank" class=ssyl>Статистика</a></td>
			</tr>
			</table>
		</td>
	</tr>
	{/if}
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
		<input class="button" type="submit" value="Отправить">&nbsp;&nbsp;
		<input class="button" type="reset" value="Очистить">&nbsp;&nbsp;
		</td>
	</tr>
	</form>
	</table>
</td></tr>

<tr><td height="20px"></td></tr>
<tr><td class="small">{#comments_rule#}</td></tr>

<tr><td height="20px"></td></tr>
</table>



<script type="text/javascript" language="javascript">
<!--
{$res.err}
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
