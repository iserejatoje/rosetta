
<script><!--
	
		{literal}$(document).ready(function() {{/literal}
			{if empty($page.form.street)}$('#addr_street').change();{/if}
			{if empty($page.form.city)}$('#addr_city').change();{/if}
			{if empty($page.form.country)}$('#addr_country').change();{/if}		
		{literal}});{/literal}

		
	
	--></script>

<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_person" />
<div class="title">Личная информация</div>

<p>Укажите ваш адрес и найдите своих соседей по дому!</p>
<br>

<table border="0" cellpadding="3" cellspacing="2" width="550">
{if isset($UERROR->ERRORS.firstname)}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->ERRORS.firstname}</span>
		</td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Имя</td>
		<td class="bg_color4" colspan="2"><input id="firstname" type="text" name="firstname" value="{$page.form.firstname}"{if in_array('FirstName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" />
{if sizeof($page.form.name_examples)>0}
			<div class="tip">Выберите имя из списка или укажите фамилию и отчество</div>
			<div style="padding-top:7px"><b>Свободные имена:</b><br />
{foreach from=$page.form.name_examples item=l}
				<div style="margin-top:2px;margin-left:10px;">
					<a href="#" onclick="return mod_passport.setName('{$l.username}')" title="Выбрать">{$l.username|escape:'html'}</a>
				</div>
{/foreach}
			</div>
{/if}</td>
	</tr>
{if isset($UERROR->ERRORS.lastname)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.lastname}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Фамилия</td>
		<td class="bg_color4" colspan="2"><input type="text" name="lastname" value="{$page.form.lastname}"{if in_array('LastName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" /></td>
	</tr>
{if isset($UERROR->ERRORS.midname)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.midname}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Отчество</td>
		<td class="bg_color4" colspan="2"><input type="text" name="midname" value="{$page.form.midname}"{if in_array('MidName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" /></td>
	</tr>
{if isset($UERROR->ERRORS.birthday)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.birthday}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">День рождения</td>
		<td class="bg_color4" colspan="2">
			День
			<select name="birthday_day" width="">
				<option value="0">----</option>
{foreach from=$page.form.days_arr item=l}
				<option value="{$l}"{if $page.form.birthday_day==$l} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
			Месяц
			<select name="birthday_month" width="">
				<option value="0">----</option>
{foreach from=$page.form.months_arr item=l key=k}
				<option value="{$k}"{if $page.form.birthday_month==$k} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
			Год
			<select name="birthday_year" width="">
				<option value="0">----</option>
{foreach from=$page.form.years_arr item=l}
				<option value="{$l}"{if $page.form.birthday_year==$l} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>

{if isset($UERROR->ERRORS.gender)}
        <tr>
                <td>&nbsp;</td>
                <td class="error" colspan="2"><span>{$UERROR->ERRORS.gender}</span></td>
        </tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Пол</td>
		<td class="bg_color4" colspan="2">
			<input type="radio" name="gender" value="1" {if $page.form.gender==1} checked{/if} /> Мужской <br />
			<input type="radio" name="gender" value="2" {if $page.form.gender==2} checked{/if}  /> Женский <br />
		</td>
	</tr>

	{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
	
{if isset($UERROR->ERRORS.height)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.height}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Рост</td>
		<td class="bg_color4" colspan="2"><nobr><input type="text" name="height" value="{$page.form.height}" style="width:50px;" /> см</nobr></td>
	</tr>
	
{if isset($UERROR->ERRORS.weight)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.weight}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Вес</td>
		<td class="bg_color4" colspan="2"><nobr><input type="text" name="weight" value="{$page.form.weight}" style="width:50px;" /> кг</nobr></td>
	</tr>
	
	<tr>
		<td align="right" class="bg_color2">Семейное положение</td>
		<td class="bg_color4" colspan="2">
			<select name="marriad" id="marriad_status" style="width:100%;">
				<option value="0">Не указано</option>
{foreach from=$page.form.marriad_arr[$page.form.gender] item=l key=k}
				<option value="{$k}"{if $k==$page.form.marriad} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
	
	<tr>
		<td align="right" class="bg_color2">Дети</td>
		<td class="bg_color4" colspan="2">
			<select name="children" style="width:100%;">
				<option value="0">Не указано</option>
{foreach from=$page.form.children_arr item=l key=k}
				<option value="{$k}"{if $k==$page.form.children} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>
	
	{/if}
	
	<tr>
		<td align="right" class="bg_color2">Страна<div id="dbg"></div></td>
		<td class="bg_color4" colspan="2">
			<select name="country" id="addr_country" onchange="Address.ChangeCountry('addr_country', 'addr_city');" style="width:382px;">
				<option value="0"> - Выберите страну - </option>
{foreach from=$page.form.country_arr item=l key=k}
				<option value="{$l.Code}"{if $l.Code===$page.form.country} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
				<option value="-1"> - Полный список - </option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right" class="bg_color2">Город</td>
		<td class="bg_color4" colspan="2">
			<select name="city" id="addr_city" onchange="Address.ChangeCity('addr_country', 'addr_city', 'addr_district', 'addr_street', 'addr_house')" style="width:382px;">
				<option value="0"> - Выберите город - </option>
{foreach from=$page.form.city_arr item=l key=k}
				<option value="{$l.Code}"{if $l.Code===$page.form.city} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
				<option value="-1"> - Другой - </option>
			</select>
		</td>
	</tr>
	<tr id="addr_district_cont" {if empty($page.form.district_arr)} style="display: none;"{/if}>
		<td align="right" class="bg_color2">Районы</td>
		<td class="bg_color4">
			<select name="district" id="addr_district" style="width:244px;">
				<option value="0"> - Выберите район - </option>
{foreach from=$page.form.district_arr item=l key=k}
				<option value="{$l.Code}" {if $l.Code===$page.form.district} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
			</select>
		</td>
		<td class="bg_color4" width="130" nowrap>Видно <select name="rights[]">
		<option value="0" >Никому</option>
		<option value="1024" {if $page.form.address_rights & 1024}selected="selected"{/if}>Всем</option>
		<option value="2048" {if $page.form.address_rights & 2048}selected="selected"{/if}>Друзьям</option>
		</select></td>
	</tr>
	<tr id="addr_street_cont" {if  $page.form.street_count <= 0} style="display: none;"{/if}>
		<td align="right" class="bg_color2">Улица</td>
		<td class="bg_color4">
			<select name="street" id="addr_street" onchange="Address.ChangeStreet('addr_city', 'addr_street', 'addr_house')" style="width:244px;{if $page.form.street_count >= 200} display: none;{/if}">
				<option value="0"> - Выберите улицу - </option>
				{if $page.form.street_count >= 50}
				<option value="" disabled="disabled">-------------</option>
				<option value="-2">Поиск по списку</option>
				<option value="" disabled="disabled">-------------</option>
				{/if}
{foreach from=$page.form.street_arr item=l key=k}
				<option value="{$l.Code}"{if $l.Code===$page.form.street} selected="selected"{/if}>{$l.Name}</option>
{/foreach}
			</select>
			{if $page.form.street_count >= 200}
				<input type="text" id="addr_street_suggest" value="" autocomplete="off" style="width:100%;"/>
				<script><!--
					Address.StreetRestSuggest('{$page.form.city}', $('#addr_street'));
				--></script>
			{/if}
		</td>
		<td class="bg_color4" width="130" nowrap>Видно <select name="rights[]">
		<option value="0" >Никому</option>
		<option value="64" {if $page.form.address_rights & 64}selected="selected"{/if}>Всем</option>
		<option value="128" {if $page.form.address_rights & 128}selected="selected"{/if}>Друзьям</option>
		</select></td>
	</tr>
	{if $page.form.street_count && isset($UERROR->ERRORS.house)}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->ERRORS.house}</span></td>
	</tr>
	{/if}
	<tr id="addr_house_cont" {if  $page.form.street_count <= 0} style="display: none;"{/if}>
		<td align="right" class="bg_color2">Дом</td>
		<td class="bg_color4" nowrap="nowrap">
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
		<td class="bg_color4" width="130" nowrap>Видно <select name="rights[]">
		<option value="0" >Никому</option>
		<option value="256" {if $page.form.address_rights & 256}selected="selected"{/if}>Всем</option>
		<option value="512" {if $page.form.address_rights & 512}selected="selected"{/if}>Друзьям</option>
		</select></td>
	</tr>

{if isset($UERROR->ERRORS.about)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.about}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">О себе</td>
		<td class="bg_color4" colspan="2"><textarea name="about"{if in_array('About',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;height:200px;">{$page.form.about}</textarea></td>
	</tr>
{if isset($UERROR->ERRORS.workplace)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.workplace}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Место работы</td>
		<td class="bg_color4" colspan="2" align="center" id="h_workplace">
			<textarea type="text" name="workplace"{if in_array('WorkPlace',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;height:60px;">{$page.form.workplace}</textarea>
		</td>
	</tr>
{if isset($UERROR->ERRORS.position)}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->ERRORS.position}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Должность</td>
		<td class="bg_color4" colspan="2"><textarea type="text" name="position"{if in_array('Position',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;height:60px;">{$page.form.position}</textarea></td>
	</tr>
</table>
<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">

	<tr>
		<td colspan="2" align="center"><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>
