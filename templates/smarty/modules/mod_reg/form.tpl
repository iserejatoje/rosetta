<script language="javascript">
{literal}
function changeQuestion()
{
	var objq = document.getElementById('question');
	var ind = objq.selectedIndex;
	if(ind > 0 && objq.options[objq.selectedIndex].value == 100)
	{
		document.getElementById('q_text_block1').style.visibility = 'visible';
		document.getElementById('q_text_block1').focus();
	}
	else
	{
		document.getElementById('q_text_block1').style.visibility = 'hidden';
		document.getElementById('q_text_block1').value = '';
	}	
}
{/literal}
</script>
<div class="h1" align="center">Регистрация сотрудников компании</div>
<form method="post">
<input type="hidden" name="action" value="register">
<table border="0" align="center" width="500">
	<tr>
		<td colspan="2"><p>Уважаемые сотрудники!</p>
{*<p>Данная форма предназначена для тех, кто пользуется:</p>
<ul>
	<li>корпоративным форумом <a href="http://rugion.ru/forum/" target="_blank">http://rugion.ru/forum/</a></li>
	<li>системой администрирования <a href="http://site.rugion.ru" target="_blank">site.rugion.ru</a></li>
</ul>*}
<p>Если вы зарегистрированы в <a href="http://74.ru/passport/" target="_blank">«Паспорте»</a>, то внесите свои данные из «Паспорта». Это позволить  пользоваться единым e-mail и паролем для работы с сайтами и корпоративными ресурсами.</p>
{*<p>Вам будет выслано уведомление на e-mail и вы сможете пользоваться новым e-mail и паролем для входа в корпоратинвый форум <a href="http://rugion.ru/forum/" target="_blank">http://rugion.ru/forum/</a>.</p>*}
<p>Вам будет выслано уведомление на указанный e-mail и вы сможете пользоваться этим e-mail'ом и паролем для входа в корпоративный форум.</p>
<br><br></td>
	</tr>
{if isset($UERROR->ERRORS.Email)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Email}</td>
	</tr>
{/if}
	<tr>
		<td>E-mail</td>
		<td align="right"><input type="text" name="Email" value="{$page.form.Email}" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.Password)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Password}</td>
	</tr>
{/if}
	<tr>
		<td>Пароль</td>
		<td align="right"><input type="password" name="pass1" class="inp"></td>
	</tr>
	<tr>
		<td>Повторите пароль</td>
		<td align="right"><input type="password" name="pass2" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.LastName)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.LastName}</td>
	</tr>
{/if}
	<tr>
		<td>Фамилия</td>
		<td align="right"><input type="text" name="LastName" value="{$page.form.LastName}" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.FirstName)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.FirstName}</td>
	</tr>
{/if}
	<tr>
		<td>Имя</td>
		<td align="right"><input type="text" name="FirstName" value="{$page.form.FirstName}" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.MidName)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.MidName}</td>
	</tr>
{/if}
	<tr>
		<td>Отчество</td>
		<td align="right"><input type="text" name="MidName" value="{$page.form.MidName}" class="inp"></td>
	</tr>
	<tr>
		<td>ICQ (не обязательно)</td>
		<td align="right"><input type="text" name="ICQ" value="{$page.form.ICQ}" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.Region)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Region}</td>
	</tr>
{/if}
	<tr>
		<td>Регион</td>
		<td align="right"><select name="Region" class="inp">
		{foreach from=$page.regions item=l key=k}
			<option value="{$k}"{if $page.form.Region == $k} selected{/if}>{$l}</option>
		{/foreach}
		</select></td>
	</tr>
{if isset($UERROR->ERRORS.Position)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Position}</td>
	</tr>
{/if}
	<tr>
		<td>Должность</td>
		<td align="right"><input type="text" name="Position" value="{$page.form.Position}" class="inp"></td>
	</tr>
{if isset($UERROR->ERRORS.Question)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Question}</td>
	</tr>
{/if}
	<tr valign="top">
		<td>Контрольный вопрос</td>
		<td align="right"><select name="Question" class="inp" onChange="changeQuestion();" id="question">
			<option value="0">-- выберите вопрос --</option>
		{foreach from=$page.questions item=l key=k}
			<option value="{$k}"{if $page.form.Question == $k} selected{/if}>{$l}</option>
		{/foreach}
			<option value="100"{if 100==$page.form.Question} selected{/if}>-- или укажите свой --</option>
		</select>
			<br>
{if isset($UERROR->ERRORS.Question_)}
			<span class="red" align="center">{$UERROR->ERRORS.Question_}</span>
{/if}
			<input type="text" name="Question_" value="{$page.form.Question_}" class="inp" style="visibility:{if $page.form.Question == 100}visible{else}hidden{/if};" id="q_text_block1">
		</td>
	</tr>
{if isset($UERROR->ERRORS.Answer)}
	<tr>
		<td colspan="2" class="red" align="center">{$UERROR->ERRORS.Answer}</td>
	</tr>
{/if}
	<tr>
		<td>Ответ</td>
		<td align="right"><input type="text" name="Answer" value="{$page.form.Answer}" class="inp"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Регистрация"></td>
	</tr>
</table>
</form>