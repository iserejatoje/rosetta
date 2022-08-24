{$page.top}

<script language='Javascript'>
<!--{literal}
function ChangeList(form,vt){
	if (vt==1) {
		document.getElementById('stage').style.display = '';
	} else {
		document.getElementById('stage').style.display = 'none';
	}
}{/literal}
-->
</script>
{if $page.errors !== null}
	<div align="center" style="color:red"><b>{$page.errors}</b></div>
{/if}
<br/><br/>
    	<form name=frm method="post" enctype="multipart/form-data">
    	<input type=hidden name="action" value="add" />
    		<table align=center cellspacing=1 border=0 class="table2" width="563">
    			<tr>
      				<th colspan="2">
      					Добавить объявление
      				</th>
    			</tr>

				{if !$USER->IsAuth()}
<tr class="bg_color4">
    <td colspan=2>
	<b>Если Вы хотите редактировать это объявление в дальнейшем,<br />
вам необходимо пройти <a href="/passport/register.php?url=/{$ENV.section}/add.html">регистрацию</a>.
Если Вы уже зарегистрированы,<br /><a href="/passport/login.php?url=/{$ENV.section}/add.html">войдите</a> в личный кабинет используя E-Mail и пароль.</b>
	</td>
</tr>
{/if}

				<tr class="bg_color4">
      				<td align="right"><b>Рубрика <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td width="323">
      					<select name=rubric size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.rubric}{assign var=any value=false}selected="selected"{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Тип жилья <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>
      					<select name="object" size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.object}{assign var=any value=false}selected="selected"{/if}>{$v.b}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				

				{if is_array($page.cities) && sizeof($page.cities)}
				<tr class="bg_color4">
      				<td align="right"><b>Город <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align="left">
						<div style="float:left; margin-right:5px">
							<select id="city" name="city" style="width:300px" onchange="mod_realty.requestRegions()">
								<option value="0">-- укажите --</option>
							{foreach from=$page.cities key=CityID item=city}
								{if ($ENV.site.domain=="mgorsk.ru" && $CityID==2376) || ($ENV.site.domain=="sterlitamak1.ru" && $CityID==399) || !in_array($ENV.site.domain, array("mgorsk.ru","sterlitamak1.ru"))}
								<option value="{$CityID}" {if (isset($ENV._POST.city) && $ENV._POST.city == $CityID) || (!isset($ENV._POST.city) && $CityID==$page.default_city) }selected="selected"{/if}>{$city.name}</option>
								{/if}
							{/foreach}
							</select>
						</div>
						<div style="display:none" id="e_wait"><img src="/img/design/wait.gif"></div>
						{if $ENV.site.domain=="mgorsk.ru"}			
						<a href="http://domchel.ru/sale/add.html" class="text11" target="_blank">Челябинская область</a>
						{/if}

						{if $CURRENT_ENV.regid == 86}
						&nbsp;<noindex><a href="http://72doma.ru/sale/add.html" rel="nofollow" target="_blank">Тюмень</a>
						&nbsp;&nbsp; <a href="http://89.ru/sale/add.html" rel="nofollow" target="_blank">ЯНАО</a>
						</noindex>
						{/if}	
						{if $CURRENT_ENV.regid == 89}
						&nbsp;<noindex><a href="http://72doma.ru/sale/add.html" rel="nofollow" target="_blank">Тюмень</a>
						&nbsp;&nbsp; <a href="http://86.ru/sale/add.html" rel="nofollow" target="_blank">ХМАО</a>
						</noindex>
						{/if}

						{if $ENV.site.domain=="sterlitamak1.ru"}			
						<a href="http://102metra.ru/sale/add.html" class="text11" target="_blank">Республика Башкортостан</a>
						{/if}
					</td>
    			</tr>
				{/if}
				
			
    			<tr class="bg_color4"id="e_region" style="display: {if !is_array($page.regions) || !sizeof($page.regions)}none{/if}">
      				<td align="right"><b>Район <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>
      					<select name="region" id="region" size="1" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.regions item=v key=k}
	<option value="{$k}" {if $ENV._POST.action && $k == $ENV._POST.region}{assign var=any value=false}selected="selected"{/if}>{$v.name}</option>
{/foreach}
<option value="-1" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
	
				<tbody id="e_addr_descr" style="display: {if !is_array($page.streets) || !sizeof($page.streets)}none{/if}">
				<tr class="bg_color4">
	     				<td align=right><b>Улица:</b></td>
	     				<td>
							<select id="street" name="street" style="width:300px">
								<option value="0">-- укажите --</option>
							{foreach from=$page.streets key=StreetID item=street}
								<option value="{$StreetID}" {if $ENV._POST.action && $ENV._POST.street == $StreetID || !$ENV._POST.action && $StreetID == $page.adv.street}
								{assign var=_street value=$street.data}selected="selected"{/if}>{$street.name}</option>
							{/foreach}
							</select>
						<input class="autocomplete" type="text" name="__address" style="display:none;width:300px" value="{$ENV._POST.__address|strip_tags|htmlspecialchars}" maxlength="255">						
					</td>
	   			</tr>
	   			<tr class="bg_color4">
	     				<td align=right><b>Дом:</b></td>
	     				<td align=left  ><input name="house" type="text" style="width:30px" value="{$ENV._POST.house|strip_tags|htmlspecialchars}" maxlength="3"> - <input name="house_idx" type="text" style="width:18px" value="{$ENV._POST.house_idx|strip_tags|htmlspecialchars}" maxlength="2">
					<span class="tip">Пример: 37, 29-Б, где Б - это корпус.<br/>Указание улицы и номера дома делает поиск по вашим объявлениям эффективнее.</span></td>
	   			</tr>
				</tbody>
				
				<tr class="bg_color4">
      				<td align="right"><b><div id="e_addr_single">{if is_array($page.streets) && sizeof($page.streets)}Доп. информация о месторасположении{else}Адрес{/if}:</div></b></td>
      				<td align="left"><input name="address" type="text" style="width:300px" value="{$ENV._POST.address|strip_tags|htmlspecialchars}" maxlength="40"></td>
    			</tr>

		
    			<tr class="bg_color4">
      				<td align=right><b>Серия <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>
      					<select name=series size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.series item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.series}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Тип дома <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>
      					<select name=build_type size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.build_type item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.build_type}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				<tr class="bg_color4">
      				<td align=right><b>Состояние <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>
{foreach from=$ENV._arrays.status item=v key=k}
	<label for="{$k}_status"><input name=status id="{$k}_status" onClick="ChangeList(frm, this.value);" type=radio value="{$k}" {if $k == $ENV._POST.status}checked="checked"{/if}>{$v.b}</label>
{/foreach}
					</td>
    			</tr>
				<tr {if $ENV._POST.status != 1 }style="display: none;"{/if} id="stage" class="bg_color4">
      				<td align=right><b>Стадия строительства:</b></td>
      				<td>
      					<select name=stage size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.stage item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.stage}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				<tr class="bg_color4">
      				<td align=right><b>Площадь помещения <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td nowrap="nowrap"><input type=text name=area_build style=width:265px value="{$ENV._POST.area_build|floatval}"> кв.м.</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Этажность <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td>помещения:
      					<select name=floor size=1 type=select-one style=width:40px>
{foreach from=$ENV._arrays.floor item=v}
	<option value="{$v}" {if $v == $ENV._POST.floor}selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      , дома:
      <select name=floors size=1 type=select-one style=width:40px>
{foreach from=$ENV._arrays.floors item=v}
	<option value="{$v}" {if $v == $ENV._POST.floors}selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      </td>
    </tr>
	<tr class="bg_color4">
      <td align=right><b>Площадь участка <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td>
      <input type=text name=area_site style=width:230px value="{$ENV._POST.area_site|floatval}">
      <select name="area_site_unit"  style=width:60px>
{foreach from=$ENV._arrays.site_unit key=_k item=v}
	<option value="{$_k}" {if $_k == $ENV._POST.area_site_unit}selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      </td>
    </tr>
    <tr class="bg_color4">
      <td align=right><b>Контакты <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td><textarea name=contacts style=width:300px;height:50px>{if $ENV._POST.contacts}{$ENV._POST.contacts|strip_tags}{else}{$page.user.contacts|strip_tags}{/if}</textarea></td>
    </tr>
{*if !$USER->isAuth()*}
{if $page.captcha_path}
	<tr class="bg_color4">
      <td align="right"><b>Код защиты от роботов <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td><img src="{$page.captcha_path}" width="150" height="50" border="0" align="middle" /> &gt;&gt; <input type=text name="captcha_code" style=width:100px value="">
			<br />Введите четырехзначное число, которое Вы видите на картинке</td>
    </tr>
{/if}
{*/if*}

<tr>
      <td align=right><b>Возможность продажи по ипотеке:</b></td>
      <td>
      <select name=ipoteka size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.ipoteka item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.ipoteka}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
</select>
      </td>
    </tr>
    <tr>
      <td align=right><b>Цена:</b></td>
      <td>
      <input type="text" name="price" style="width:165px" value="{$ENV._POST.price|floatval}">
      тыс. руб.
      <select name=price_unit size=1 type=select-one style=width:70px>
{foreach from=$ENV._arrays.price_unit item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.price_unit}selected="selected"{/if}>{$v.s}</option>
{/foreach}
</select>
      </td>
    </tr>
	<tr bgcolor=#FFFFFF>
      	<td align=right ><b>Возраст здания:</b></td>
		<td align=left>
			<select name=age_build style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.age_build item=v key=k}
				<option value="{$k}" {if $k == $ENV._POST.age_build}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
				<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
			</select></td>
	</tr>
<tr>
      <td align=right><b>Отделка:</b></td>
      <td>
      <select name=decoration size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.decoration}selected="selected"{/if}>{$v.b}</option>
{/foreach}
</select>
      </td>
    </tr>
<tr>
      <td align=right><b>Санузел:</b></td>
      <td>
      <select name=lavatory size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.lavatory item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.lavatory}selected="selected"{/if}>{$v.b}</option>
{/foreach}
</select>
      </td>
    </tr>

<tr>
      <td align=right><b>Телефон:</b></td>
      <td>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=phone value=1 {if $ENV._POST.phone}checked="checked"{/if}></td>
	<td align=right width=100><b>Балкон:</b></td>
	<td><input type=checkbox name=balcony value=1 {if $ENV._POST.balcony}checked="checked"{/if}></td>
	</tr>
	</table>
      </td>
    </tr>

<tr>
      <td align=right><b>Лифт:</b></td>
      <td>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=lift value=1 {if $ENV._POST.lift}checked="checked"{/if}></td>
	<td align=right width=100><b>Домофон:</b></td>
	<td><input type=checkbox name=comm value=1 {if $ENV._POST.comm}checked="checked"{/if}></td>
	</tr>
	</table>
      </td>
    </tr>

<tr>
      <td align=right><b>Сигнализация:</b></td>
      <td>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=sign value=1 {if $ENV._POST.sign}checked="checked"{/if}></td>
	<td align=right width=100><b>Мебель:</b></td>
	<td><input type=checkbox name=mebel value=1 {if $ENV._POST.mebel}checked="checked"{/if}></td>
	</tr>
	</table>
      </td>
    </tr>
    <tr>
      <td align=right><b>Фото 1:</b></td>
      <td><input style=width:300px type=file name=img1><br />
      <font class="small">размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 2:</b></td>
      <td><input style=width:300px type=file name=img2><br />
      <font class="small">размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 3:</b></td>
      <td><input style=width:300px type=file name=img3><br />
      <font class="small">размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
<tr>
      <td align=right><b>Доп. информация:</b></td>
      <td><textarea name=description style=width:300px;height:50px>{$ENV._POST.description|strip_tags}</textarea></td>
    </tr>
    <tr>
      <td align=right><b>Срок размещения:</b></td>
      <td>
      <select name=period size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.adv_period item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.period}selected="selected"{/if}>{$v.t}</option>
{/foreach}
</select>
      </td>
    </tr>
	<tr>
      <td align=right><b>Предложение от:</b></td>
      <td align=left>
{foreach from=$ENV._arrays.agent item=v key=k}
	  <label for="{$k}_agent"><input name=agent id="{$k}_agent"  type=radio value="{$k}" {if $k == $ENV._POST.agent}checked="checked"{/if}>{$v.b}</label>
{/foreach}
	  </td>
    </tr>
{if !$USER->IsAuth()}
<tr>
	<td align="center" colspan="2" class="ssyl">
		<b>С <a href="/{$ENV.section}/rules.html">правилами размещения объявлений</a> согласен <font color="red">*</font>:</b>
		<input name="rules" type="checkbox" value="1" checked="checked" />
	</td>
</tr>
{/if}
<tr>
      <td align="center" colspan="2">
		<br/>Символом <font color="red">*</font> отмечены поля, обязательные для заполнения.<br/><br/>
      <input class="button" type="submit" value="Добавить" style="width:100px;">&nbsp;
      <input class="button" type="reset" value="Очистить" style="width:100px;">
      </td>
    </tr>

    </table>
    </form>

<br/><br/>