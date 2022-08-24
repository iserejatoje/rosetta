<!-- начало - форма для отзыва -->
<a name="question"></a>


<form action="#question" name="interview_askform" id="interview_askform" method="post" onsubmit="return interview_askform_check(this)">
<input type="hidden" name="action" value="new_question" />
<input type="hidden" name="id" value="{$res.id}" />
<table align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td align="left" colspan="2" style="padding:0px">
						<table align="center" cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td class="title2_askform">Напишите свой вопрос!</td>
							</tr>
						</table>
					</td>
				</tr>
				{if $UERROR->GetErrorByIndex('Name') != ''}
				<tr>
					<td width="170px"></td>
					<td width="230px" align="left" style="color:red">{$UERROR->GetErrorByIndex('Name')}</td>
				</tr>
				{/if}
				<tr>
					<td width="170px" align="right" class="medium"><b>Ваше Имя и Фамилия:</b></td>
					<td width="230px" align="left"><input type="text" name="q_name" style="width:230px" value="{$res.q_name}"></td>
				</tr>
				{if $UERROR->GetErrorByIndex('Email') != ''}
				<tr>
					<td width="170px"></td>
					<td width="230px" align="left" style="color:red">{$UERROR->GetErrorByIndex('Email')}</td>
				</tr>
				{/if}
				<tr>
					<td width="170px" align="right" class="medium"><b>Ваш E-mail:</b></td>
					<td width="230px" align="left"><input type="text" name="q_email" style="width:230px" value="{$res.q_email}"></td>
				</tr>
				<tr>
					<td width="170px" align="right" class="medium"><b>Ваш телефон:</b></td>
					<td width="230px" align="left"><input type="text" name="q_phone" style="width:230px" value="{$res.q_phone}"></td>
				</tr>
			</table>

			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				{if $UERROR->GetErrorByIndex('question') != ''}
				<tr>
					<td width="30px"></td>
					<td align="left" class="medium" style="color:red">{$UERROR->GetErrorByIndex('question')}</td>
				</tr>
				{/if}
				<tr>
					<td width="30px">&nbsp;</td>
					<td align="left" class="medium"><b>Ваш вопрос:</b></td>
				</tr>
				<tr valign="top">
					<td width="30px">
						<img src="/_img/design/common/resize_s.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(2, 2, 'interview_otziv_', 'text', null, 370, 370, 100, 1000);" alt="Уменьшить" title="Уменьшить размер поля для ввода сообщения" /><br />
						<img src="/_img/design/common/resize_b.gif" width="21" height="9" style="cursor: pointer; cursor: hand;" onclick="FrmChangeSize(1, 2, 'interview_otziv_', 'text', null, 370, 370, 100, 1000);" alt="Увеличить" title="Увеличить размер поля для ввода сообщения" /><br />
					</td>
					<td width="370px" align="left"><textarea id="text" name="q_text" style="width:{$smarty.cookies.interview_otziv_w|default:370}px;height:{$smarty.cookies.interview_otziv_h|default:150}px">{$res.q_text}</textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input class="button" type="submit" value="Отправить">&nbsp;&nbsp;
						<input class="button" type="reset" value="Очистить">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="20px"></td>
	</tr>
</table>
</form>

<script type="text/javascript" language="javascript">
<!--
{$res.err}
{literal}
	var interview_askform_send = false;
	function interview_askform_check(form)
	{
		if(interview_askform_send)
			return false;
			
{/literal}
{if !$res.user.id}
{literal}
		if (isEmpty(form.q_name.value))
		{
			alert("Укажите Ваше Имя и Фамилию!");
			form.q_name.focus();
			return false;
		}
		
		if (!isEmpty(form.q_email.value) && !isEmail(form.q_email.value))
		{
			alert("Вы неправильно ввели E-mail!");
			form.q_email.focus();
			return false;
		}
		
{/literal}
{/if}
{literal}
		if (isEmpty(form.q_text.value))
		{
			alert("Вы не написали вопрос!");
			form.q_text.focus();
			return false;
		}
		
		if (form.q_text.value.length>1000)
		{
			alert("Ваш вопрос слишком большой. Максимальная длина - 1000 знаков.");
			form.q_text.focus();
			return false;
		}
		
		interview_askform_send = true;
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
