<div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Off-line регистрация</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>

<table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>
	Off-line регистрация
</span></td></tr>
</table>

<form name="mod_mail_reg_form" id="mod_mail_reg_form" method="post" onsubmit="return mod_passport.regSubmit(this);" style="margin:0px;">
<input type="hidden" name="url" value="{$page.form.url}">
{if isset($smarty.get.noemail) && $smarty.get.noemail > 10}
<input type="hidden" name="noemail" value="{$smarty.get.noemail}"> 
{/if}
<input type="hidden" name="url" value="{$page.form.url}"> 
<table align="center" width="750px" cellpadding="5" cellspacing="0" border="0">
<input type="hidden" name="action" value="register_offline">
<tr valign="top" align="center">
	<td colspan="3">&nbsp;</td>
</tr>

{if $UERROR->GetErrorByIndex('secret_key') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('secret_key')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Секретный ключ<font color="red">*</font>:</td>
	<td><input type="password" name="secret_key" style="width:250px;" value="{$page.form.secret_key}" /></td>
	<td width="250px"><span class="tip" id="pass_quality"></span></td>
</tr>

{if $UERROR->GetErrorByIndex('email') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('email')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Электронная почта <font color="red">*</font>:</td>
	<td width="250px">
		<div id="email_form_old">
			<input type="text" name="email" style="width:100%" value="{$page.form.email}" /><br /><br />
{if $UERROR->GetErrorByIndex('email_reg') != ''}
			<div class="error"><span>{$UERROR->GetErrorByIndex('email_reg')}</span></div>
{/if}

{if sizeof($page.form.email_examples)>0}
			<div style="padding-top:7px"><b>Свободные имена:</b><br />
{foreach from=$page.form.email_examples item=l}
				<div style="margin-top:2px;margin-left:10px;">
					<a href="#" onclick="return mod_passport.setEMail('{$l.username}', '{$l.domain}', '_reg')" title="Выбрать">{$l.username}@{$l.domain}</a>
				</div>
{/foreach}
			</div>
{/if}
		</div>
	</td>
	<td width="250px"><span class="tip">Почтовый ящик должен состоять из символов A-z, 0-9, <span id="email_info_old" style="display:none">@, </span>., - и содержать не более {$CONFIG.limits.max_len_email} символов</span></td>
</tr>

{if $UERROR->GetErrorByIndex('firstname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('firstname')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Имя <font color="red">*</font>:</td>
	<td>
		<input type="text" id="firstname" name="firstname" style="width:100%;" value="{$page.form.firstname}" /><br />
{if sizeof($page.form.name_examples)>0}
			<div class="tip">Выберите имя из списка или укажите фамилию и отчество</div>
			<div style="padding-top:7px"><b>Свободные имена:</b><br />
{foreach from=$page.form.name_examples item=l}
				<div style="margin-top:2px;margin-left:10px;">
					<a href="#" onclick="return mod_passport.setName('{$l.username}')" title="Выбрать">{$l.username|escape:'html'}</a>
				</div>
{/foreach}
			</div>
{/if}
	</td>
	<td width="250px">{*<span class="tip">Имя должно состоять из символов русского, латинского алфавита, знак _, "пробел" и содержать не более {$CONFIG.limits.max_len_name} символов.</span>*}</td>
</tr>

{if $UERROR->GetErrorByIndex('lastname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('lastname')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Фамилия:</td>
	<td>
		<input type="text" name="lastname" style="width:100%;" value="{$page.form.lastname}" /><br />
	</td>
	<td width="250px"></td>
</tr>

{if $UERROR->GetErrorByIndex('midname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('midname')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Отчество:</td>
	<td>
		<input type="text" name="midname" style="width:100%;" value="{$page.form.midname}" /><br />
	</td>
	<td width="250px"></td>
</tr>

<tr valign="top" align="left">
	<td align="right" width="250px">День рождения:</td>
	<td>
		<select name="birthday_day" width="">
			<option value="0">----</option>
{foreach from=$page.form.days_arr item=l}
			<option value="{$l}"{if $page.form.birthday_day==$l} selected="selected"{/if}>{$l}</option>
{/foreach}
		</select>
.
		<select name="birthday_month" width="">
			<option value="0">----</option>
{foreach from=$page.form.months_arr item=l key=k}
			<option value="{$k}"{if $page.form.birthday_month==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
		</select>
.
		<select name="birthday_year" width="">
			<option value="0">----</option>
{foreach from=$page.form.years_arr item=l}
			<option value="{$l}"{if $page.form.birthday_year==$l} selected="selected"{/if}>{$l}</option>
{/foreach}
		</select>
	</td>
</tr>

{if $UERROR->GetErrorByIndex('gender') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('gender')}</span></td>
		<td width="250px" align="right">&nbsp;</td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Пол <font color="red">*</font>:</td>
	<td>
		<label><input type="radio" name="gender" value="1" {if $page.form.gender==1}checked="checked"{/if} />Мужской</label>
		<label><input type="radio" name="gender" value="2" {if $page.form.gender==2}checked="checked"{/if} />Женский</label>
	</td>
</tr>

<tr valign="top" align="left">
	<td align="right" width="250px">Город:</td>
	<td>
		<input type="hidden" name="country" id="addr_country" value="{$page.form.country}" />
		<select name="city" id="addr_city" onchange="Address.ChangeCity('addr_country', 'addr_city', 'addr_district', 'addr_street', 'addr_house')" style="width:100%;">
			<option value="0"> - Выберите город - </option>
{foreach from=$page.form.city_arr item=l key=k}
			<option value="{$l.Code}"{if $l.Code===$page.form.city} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
			<option value="-1"> - Другой - </option>
		</select>
	</td>
</tr>

<tr valign="top" align="left" id="addr_district_cont" {if empty($page.form.district_arr)} style="display: none;"{/if}>
	<td align="right" width="250px">Районы:</td>
	<td>
		<select name="district" id="addr_district" style="width:244px;">
			<option value="0"> - Выберите район - </option>
{foreach from=$page.form.district_arr item=l key=k}
			<option value="{$l.Code}" {if $l.Code===$page.form.district} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
		</select>
	</td>
</tr>
<tr valign="top" align="left" id="addr_street_cont" {if  $page.form.street_count <= 0} style="display: none;"{/if}>
	<td align="right" width="250px">Улица:</td>
	<td>
		<select name="street" id="addr_street" onchange="Address.ChangeStreet('addr_city', 'addr_street', 'addr_house')" style="width:100%;{if $page.form.street_count >= 200} display: none;{/if}">
			<option value="0"> - Выберите улицу - </option>
			{if $page.form.street_count >= 50}
			<option value="" disabled="disabled">-------------</option>
			<option value="-2">Поиск по списку</option>
			<option value="" disabled="disabled">-------------</option>
			{/if}
			{assign var=street_set value=false}
{foreach from=$page.form.street_arr item=l key=k}
			<option value="{$l.Code}"{if $l.Code===$page.form.street}{assign var=street_set value=true} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
		</select>
		{if $page.form.street_count >= 200}
			<input type="text" id="addr_street_suggest" value="" autocomplete="off" style="width:100%;"/>
			<script><!--
				Address.StreetRestSuggest('{$page.form.city}', $('#addr_street'));
			--></script>
		{/if}
	</td>
</tr>
{if $page.form.street_count && isset($UERROR->ERRORS.house)}
<tr>
	<td>&nbsp;</td>
	<td class="error"><span>{$UERROR->GetErrorByIndex('house')}</span></td>
</tr>
{/if}
<tr valign="top" align="left" id="addr_house_cont" {if  $page.form.street_count <= 0 || !$page.form.street || !$street_set} style="display: none;"{/if}>
	<td align="right" width="250px">Дом:</td>
	<td nowrap="nowrap">
		<select name="house" id="addr_house" style="width:100%;display: none;">
			<option value="0"> - Выберите дом - </option>
{foreach from=$page.form._house_arr item=l key=k}
			<option value="{$l.Code}">{$l.Name}</option>
{/foreach}
		</select>
		<div id="addr_house_simple">
			<input type="text" name="house" value="{$page.form.house}" maxlength="8" style="width:208px;"/> - 
			<input type="text" name="house_index" value="{$page.form.house_index}" style="width:23px" maxlength="2" />
			<br/><small>Пример: 37, 29-Б</small>
		</div>
	</td>
</tr>


<tr valign="top" align="center">
	<td colspan="3">Символом <font color="red">*</font> отмечены поля, обязательные для заполнения.</td>
</tr>

<tr align="center" valign="middle">
	<td colspan="3">
	<input type="submit" name="act" value="Регистрация" style="width:150px;">
	</td>
</tr>
</table>
</form>

<!-- функции работы с паролями -->
<script type="text/javascript" language="javascript" src="/_scripts/themes/password.js"></script>