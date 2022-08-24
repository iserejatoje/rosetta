<div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Off-line активация пользователя</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>

<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>
	OFF-line активация пользователя
</span></td></tr>
</table>

{if $page.valid}

<br/>
<table width="80%" cellpadding="5" cellspacing="0" border="0" class="bg_color4" align="center">
<tr><td>
<p>Приветствуем Вас на странице off-line активации пользователя.</p>
<p>Ваш код активации верен и Вы можете задать пароль и контрольный вопрос.</p>
</td></tr>
</table>

<form name="mod_mail_reg_form" id="mod_mail_reg_form" method="post" onsubmit="return mod_passport.regSubmit(this);" style="margin:0px;">
<table align="center" width="750px" cellpadding="5" cellspacing="0" border="0">
<input type="hidden" name="action" value="offline_activate">
<tr valign="top" align="center">
	<td colspan="3">&nbsp;</td>
</tr>

{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Пароль <font color="red">*</font>:</td>
	<td><input type="password" name="password" style="width:250px;"
	 onkeyup="checkPassword(this, this.form.password2, this.form.username, 'pass_status', 'pass_quality');" /></td>
	<td width="250px"><span class="tip" id="pass_quality"></span></td>
</tr>
<tr valign="top" align="left">
	<td align="right" width="250px">Повторите пароль <font color="red">*</font>:</td>
	<td><input type="password" name="password2" style="width:100%;"
	 onkeyup="checkPassword(this.form.password, this, this.form.username, 'pass_status', 'pass_quality');" /></td>
	<td width="250px"><span class="tip" id="pass_status"></span></td>
</tr>
<tr valign="top" align="left">
	<td align="right" width="250px"></td>
	<td>&nbsp;</td>
	<td width="250px"></td>
</tr>


<tr align="center" valign="bottom">
	<td height="40px" colspan="3"><b>Если Вы забудете пароль</b></td>
</tr>
{if $UERROR->GetErrorByIndex('question') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('question')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Выберите вопрос <font color="red">*</font>:</td>
	<td>
		<select name="question" id="question" style="width:100%" onchange="mod_passport.changeQuestion();">
		<option value="0">-- выберите вопрос --</option>
		{foreach from=$page.form.question_arr item=l key=k}
		<option value="{$k}"{if $k==$page.form.question} selected{/if}>{$l}</option>
		{/foreach}
		<option value="100"{if 100==$page.form.question} selected{/if}>-- или укажите свой --</option>
		</select>
	</td>
	<td rowspan="2" width="250px"><span class="tip">Oбратите внимание на то, чтобы другим было бы трудно подобрать правильный ответ на этот вопрос,
		а Вам было бы трудно его забыть.
		В случае правильного ответа на данный вопрос, Вам будет предложено установить новый пароль.</span></td>
</tr>
<tr valign="top" align="left">
	<td align="right" width="250px"><span id="q_text_block1" style="visibility:{if $page.form.question==100}visible{else}hidden{/if};">Свой вопрос:</span></td>
	<td><span id="q_text_block2" style="visibility:{if $page.form.question==100}visible{else}hidden{/if};"><input type="text" name="question_text" id="question_text" style="width:100%;" value="{$page.form.question_text}" /></span></td>
</tr>
{if $UERROR->GetErrorByIndex('answer') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('answer')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Ответ на вопрос <font color="red">*</font>:</td>
	<td><input type="text" name="answer" style="width:100%;" value="{$page.form.answer}" /></td>
	<td width="250px" align="right">&nbsp;</td>
</tr>

{if $UERROR->GetErrorByIndex('confirm') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('confirm')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}

<tr align="center" valign="middle">
	<td colspan="3">
	<input type="submit" name="act" value="Активировать" style="width:150px;">
	</td>
</tr>

</table>

<!-- функции работы с паролями -->
<script type="text/javascript" language="javascript" src="/_scripts/themes/password.js"></script>

<script type="text/javascript" language="javascript">
<!--
{literal}
	mod_passport.changeQuestion();
//    -->{/literal}
</script>

{else}

<form method="get">
<table align="center" width="750px" cellpadding="5" cellspacing="0" border="0">
<tr valign="top" align="center">
	<td colspan="3">&nbsp;</td>
</tr>

{if $UERROR->GetErrorByIndex('code') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('code')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Код активации <font color="red">*</font>:</td>
	<td><input type="text" name="code" style="width:100%;" value="{$page.form.code}" /></td>
	<td width="250px" align="right">&nbsp;</td>
</tr>

<tr align="center" valign="middle">
	<td colspan="3">
	<input type="submit" name="act" value="Проверить" style="width:150px;">
	</td>
</tr>

</table>

{/if}