<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_id" />
<div class="title">Идентификация</div>
<table border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('email') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('email')}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="150">E-Mail</td>
		<td class="bg_color4"><input type="text" name="email" value="{$page.form.email}" style="width: 100%;" /></td>
	</tr>
{if $page.form.activation != '0' && !empty($page.form.activation)}
	<tr>
		<td class="bg_color2" align="right" width="150">Внимание!</td>
		<td class="bg_color4">Требуется подтверждение, для изменения E-mail на <b>{$page.form.activation}</b>.<br>Чтобы повторно выслать код активации, нажмите <a href="/{$CURRENT_ENV.section}/ractivation.php">здесь</a></td>
	</tr>
{/if}
{if $UERROR->GetErrorByIndex('nickname') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('nickname')}</span></td>
	</tr>
{/if}
	{if $page.form.ouremail != $page.form.email}
	<tr>
		<td class="bg_color2" align="right">Дополнительный E-Mail</td>
{if !empty($page.form.ouremail)}
		<td class="bg_color4">{$page.form.ouremail|escape:'html'} &nbsp;&nbsp; <a href="{$page.form.ouremail_link}">Читать почту</a></td>
{else}
		<td class="bg_color4">
{if $UERROR->GetErrorByIndex('email_reg') != ''}
			<div class="error"><span>{$UERROR->GetErrorByIndex('email_reg')}</span></div>
{/if}
			<input type="checkbox" name="reg" id="reg" value="1"{if $page.form.reg==1} checked="checked"{/if} />
			<label for="reg">Создать дополнительный E-mail</label>
			</div><br/>
{if sizeof($page.form.mail_services) > 1}
			{strip}<nobr>
				<input type="text" name="username_reg" id="username_reg" style="width:120px" value="{$page.form.username_reg}" />
				<span style="font-size:16px;"><b>@</b></span>
				<select name="domain_reg" id="domain_reg" style="width:110px">
					{foreach from=$page.form.mail_services item=d key=k}
					<option value="{$k}"{if $k==$page.form.domain_reg} selected{/if}>{$d.name|escape:'html'}</option>
					{/foreach}
				</select>
			</nobr><br />{/strip}
{else}
			{strip}
			<input type="text" name="username_reg" id="username_reg" style="width:120px" value="{$page.form.username_reg}" />
			<span style="font-size:16px;"><b>@{$page.form.mail_default_service|escape:'html'}</b></span><br />
			{/strip}
{/if}
{if sizeof($page.form.email_examples)>0}
			<div style="padding-top:7px"><b>Свободные имена:</b><br />
{foreach from=$page.form.email_examples item=l}
				<div style="margin-top:2px;margin-left:10px;">
					<a href="#" onclick="return mod_passport.setEMail('{$l.username|escape:'html'}', '{$l.domain|escape:'html'}', '_reg')" title="Выбрать">{$l.username|escape:'html'}@{$l.domain|escape:'html'}</a>
				</div>
{/foreach}
			</div>
{/if}

		<br><span class="tip">Почтовый ящик должен состоять из символов A-z, 0-9, <span id="email_info_old" style="display:none">@, </span>., - и содержать не более {$CONFIG.limits.max_len_email} символов</span></td>
{/if}
	</tr>
	{/if}
	
{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right">Пароль</td>
		<td class="bg_color4" ><input type="password" name="password" />
		<br/><span class="tip">Введите текущий пароль</span></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>

</table>
</form>

<div style="padding-top:150px;">
<form method="post" onsubmit="return confirm('Вы уверены, что хотите удалить свою учетную запись?');">
<input type="hidden" name="action" value="delete_profile" />
<div class="title">Удаление аккаунта</div>
<br />

{if $UERROR->GetErrorByIndex('del') != ''}
<div class="error"><span>{$UERROR->GetErrorByIndex('del')}</span></div>
{/if}
<input type="checkbox" name="del" value="1" style="vertical-align:middle;" /> Я хочу удалить свою учетную запись и все данные связанные с ней.<br />
<span class="tip">В дальнейшем вы не сможете пользоваться нашими сервисами под этой регистрацией.</span><br />
<table border="0" cellpadding="3" cellspacing="2">
{if $UERROR->GetErrorByIndex('password_delete') != ''}
	<tr>		
		<td class="error"><span>{$UERROR->GetErrorByIndex('password_delete')}</span></td>
	</tr>
{/if}
	<tr>		
		<td class="bg_color4" ><input type="password" name="password" />
		<br/><span class="tip">Введите текущий пароль</span></td>
	</tr>
</table><br/>
<br /><input type="submit" value="Удалить" />
</form>
</div>
<br>
<br>