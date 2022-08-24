
<h1 class="title">Активация</h1>


{if isset($smarty.get.code)}
<p class="title">Ошибка активации.</p>
<p>Возможные ошибки:</p>
<ul>
	<li>Вы ранее уже активировали свою запись.</li>
	<li>Вы ввели неверный код активации.</li>
	<li>Ваш код активации был автоматически удален, т.к. вы не перешли по ссылке в течение 24 часов.</li>
</ul>
<p>Попробуйте ввести код активации еще раз в форму, расположенную ниже:</p>
{else}
<p>Введите код активации в форму, расположенную ниже:</p>
{/if}

	<form method="get" name="activation_form">
	<table>
	<tr>
		<td align="right">Код:</td>
		<td width="250px" align="left">
			<input type="text" tabindex="1" name="code" style="width:250px" />
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2">
			<span class="button2"><a href="javascript:void(0)" onclick="document.forms.activation_form.submit()">Подтвердить</a></span>
		</td>
	</tr>
	</table>
	</form>
	