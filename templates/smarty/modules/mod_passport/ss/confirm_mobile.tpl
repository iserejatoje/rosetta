<script language="javascript">{literal}
	function get_code()
	{
		var phone_number = $('#phone').val();
		var reg = /^[\d]{11}$/
		if (reg.test(phone_number) == false)
		{
			alert("Номер телефона должен состоять из 11 цифр");
			return false;
		}

		$('#get_code_button').attr('disabled', 'disabled');
		
		$.ajax({
			url: ".",
			type: "POST",
			dataType: "json",
			data: {
				action: "get_confirm_code",
				phone: phone_number
			},
			success: success_get_code,
			error: error_get_code
		});
		
	}

	function success_get_code(data, textStatus, XMLHttpRequest)
	{
		$('#get_code_button').removeAttr('disabled');
		if (data.status == 'error')
		{
			alert(data.message);
			return false;
		}

		alert(data.message);
		$('#input_phone').html($('#phone').val());
		$('#form_confirm').fadeIn('slow');
		return true;
	}

	function error_get_code(XMLHttpRequest, textStatus, errorThrown)
	{		
		alert("Ошибка при получении кода. Попробуйте поздее");
		$('#get_code_button').removeAttr('disabled');
	}

	function check_code()
	{
		$.ajax({
			url: ".",
			type: "POST",
			dataType: "json",
			data: {
				action: "confirm_phone",
				code: $('#code').val()				
			},
			success: success_check_code,
			error: error_check_code
		});
	}

	function success_check_code(data, textStatus, XMLHttpRequest)
	{	
		if (data.status == 'error')
		{
			alert(data.message);
			return false;
		}

		alert(data.message);
		{/literal}{if $page.url}
		document.location.href = '{$page.url}';
		{/if}{literal}
		return true;
	}

	function error_check_code(XMLHttpRequest, textStatus, errorThrown)
	{		
		alert("Ошибка. Попробуйте поздее");
	}	
{/literal}</script>

<div class="title">Подтверждение номера телефона</div><br/>

Для включения возможности размещать вакансии в разделе "Работа" необходимо
подтвердить свою регистрацию. Подтверждение через SMS-сообщение введено
с целью снижения количества не корректных объявлений, спама и мошенничества.

<br/><br/>
{if $page.phone != ""}
Текущий подтверждённый номер: <b>{$page.phone}</b><br/><br/>
{/if}
<table cellpadding="3">
<tr>
	<td><b>Введите номер вашего<br/>сотового телефона</b></td>
	<td>
		<input type="text" id="phone" value=""><br/>
		<small style="color:#999999">Пример: 79991234567</small>
	</td>
	<td>
		<input type="button" value="Получить код" id="get_code_button" onclick="get_code()">
	</td>
</tr>
</table>
<br/>
Вам будет выслана SMS с кодом подстверждения.<br/>
Входящее SMS с кодом подтверждения бесплатно для вас.
<br/><br/>
<div id="form_confirm" style="display:none; width: 550px; padding: 20px; background-color: #EDF6F8;">
Если Вы не получили от нас SMS с кодом в течение 5 минут, Вы можете повторить<br/>
получение кода или ввести другой номер телефона.<br/>
Если Вы уже получили код на номер <span id="input_phone">79xxxxxxxxx</span>, введите его здесь:
<br/><br/>
<table cellpadding="3">
<tr>
	<td><b>Полученный код</b></td>
	<td>
		<input type="text" id="code" value=""><br/>
		<small style="color:#999999">Пример: 1234567</small>
	</td>
	<td>
		<input type="button" value="Подтвердить" onclick="check_code()">
	</td>
</tr>
</table> 

</div>