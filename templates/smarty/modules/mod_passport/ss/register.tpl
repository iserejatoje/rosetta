
<h2>Регистрация</h2>

<form name="mod_mail_reg_form" class="register-form" method="post" style="margin:0px;">
<input type="hidden" name="url" value="{$page.form.url}">
<input type="hidden" name="action" value="register">
<table>


{if $UERROR->GetErrorByIndex('email') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('email')}</span></td>	
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Электронный ящик <font color="red">*</font>:</td>
	<td width="250px">
		<input type="text" name="email" style="width:250px" value="{$page.form.email}" />
	</td>	
</tr>
{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Пароль <font color="red">*</font>:</td>
	<td>
		<input type="password" name="password" style="width:250px;"/><br/>
		<span class="tip">Длина пароля от 6 до 20 символов.</span> 
	 </td>	
</tr>
<tr valign="top" align="left">
	<td align="right" width="250px">Пароль ещё раз <font color="red">*</font>:</td>
	<td><input type="password" name="password2" style="width:250px;" /></td>
</tr>

{if $UERROR->GetErrorByIndex('firstname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('firstname')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">ФИО <font color="red">*</font>:</td>
	<td>
		<input type="text" id="firstname" name="firstname" style="width:250px;" value="{$page.form.firstname}" /><br />
	</td>	
</tr>
{*
{if $UERROR->GetErrorByIndex('lastname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('lastname')}</span></td>
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Фамилия <font color="red">*</font>:</td>
	<td>
		<input type="text" name="lastname" style="width:250px;" value="{$page.form.lastname}" /><br />
	</td>
</tr>
*}
{if $UERROR->GetErrorByIndex('midname') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('midname')}</span></td>
	</tr>
{/if}

{*<tr valign="top" align="left">
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
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Пол <font color="red">*</font>:</td>
	<td>
		<label><input type="radio" name="gender" value="1" {if $page.form.gender==1}checked="checked"{/if} />Мужской</label>
		<label><input type="radio" name="gender" value="2" {if $page.form.gender==2}checked="checked"{/if} />Женский</label>
	</td>
</tr>

{if $UERROR->GetErrorByIndex('postcode') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('postcode')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Почтовый индекс <font color="red">*</font>:</td>
	<td>
		<input type="text" name="postcode" style="width:250px;" value="{$page.form.postcode}" /><br/>
		<a style="text-decoration: underline;" target="_blank" href="http://www.ruspostindex.ru/"><small>Узнайте Ваш почтовый индекс здесь.</small></a>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('area') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('area')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Область:</td>
	<td>
		<input type="text" name="area" style="width:250px;" value="{$page.form.area}" /><br/>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('district') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('district')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Район:</td>
	<td>
		<input type="text" name="district" style="width:250px;" value="{$page.form.district}" /><br/>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('city') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('city')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Город <font color="red">*</font>:</td>
	<td>
		<input type="text" name="city" style="width:250px;" value="{$page.form.city}" /><br/>
	 </td>	
</tr>*}
{if $UERROR->GetErrorByIndex('street') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('street')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Улица <font color="red">*</font>:</td>
	<td>
		<input type="text" name="street" style="width:250px;" value="{$page.form.street}" /><br/>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('house') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('house')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Номер дома <font color="red">*</font>:</td>
	<td>
		<input type="text" name="house" style="width:250px;" value="{$page.form.house}" /><br/>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('apartment') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('apartment')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Квартира:</td>
	<td>
		<input type="text" name="apartment" style="width:250px;" value="{$page.form.apartment}" /><br/>
	 </td>	
</tr>
{if $UERROR->GetErrorByIndex('phone') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('phone')}</span></td>		
	</tr>
{/if}
<tr valign="top" align="left">
	<td align="right" width="250px">Номер телефона <font color="red">*</font>:</td>
	<td>
		<input type="text" name="phone" style="width:250px;" value="{$page.form.phone}" /><br/>
		<small>Формат: +71234567890</small>
	 </td>	
</tr>

<tr align="center" valign="bottom">
	<td height="40px" colspan="2"><b>Защита от спама</b></td>
</tr>
{if $UERROR->GetErrorByIndex('captcha') != ''}
	<tr>
		<td width="250px" align="right">&nbsp;</td>
		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('captcha')}</span></td>		
	</tr>
{/if}
<tr align="left" valign="top">
	<td width="250px" align="center">
	<img src="{$page.captcha_path}" width="150" height="50" border="0" />
	</td>
	<td valign="top"> 
	<input type="text" name="captcha_code" value="" style="width:150" /><br />
	<span classs="tip">Введите фразу с картинки</span>
	</td>	
</tr>

<tr valign="top" align="center">
	<td colspan="3">Символом <font color="red">*</font> отмечены поля, обязательные для заполнения.</td>
</tr>

<tr align="center" valign="middle">
	<td colspan="3">
	<input type="submit" name="act" value="Зарегистрироваться" "style="width:180px;">
	</td>
</tr>
</table>
</form>