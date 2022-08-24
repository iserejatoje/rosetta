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
{if !$page.CLOSED_EDIT}
<br/><br/>  
    	<form name=frm method="post" enctype=multipart/form-data>
    	<input type=hidden name="action" value="edit" />
    	<input type=hidden name="id" value="{$page.adv.id}" />
    		<table align=center cellspacing=1 class="table2">
    			<tr>
      				<th colspan="2">Редактировать объявление</th>
    			</tr>
				<tr class="bg_color4">
      				<td align="right"><b>Рубрика <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td width="300" width="323" align="left">
      					<select name=rubric size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.rubric || !$ENV._POST.action && $k == $page.adv.rub}
	{assign var=any value=false}selected="selected"{/if}>{$v}</option>  
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Тип жилья <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
      					<select name="object" size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.object || !$ENV._POST.action && $k == $page.adv.object}
	{assign var=any value=false}selected="selected"{/if}>{$v.b}</option>  
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				


			{if is_array($page.cities) && sizeof($page.cities)}
				<tr class="bg_color4">
      				<td align=right><b>Город <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left nowrap="nowrap">
						<div style="float:left; margin-right:5px">
							<select id="city" name="city" style="width:300px" onchange="mod_realty.requestRegions()">
								<option value="0">-- укажите --</option>
							{foreach from=$page.cities key=CityID item=city}
								{if ($ENV.site.domain=="mgorsk.ru" && $CityID==2376) || $ENV.site.domain!="mgorsk.ru"}
								<option value="{$CityID}" {if ($ENV._POST.action && $ENV._POST.city == $CityID) || (!$ENV._POST.action && $CityID == $page.adv.city_id)}
								{assign var=_city value=$city.data}selected="selected"{/if}>{$city.name}</option>
								{/if}
							{/foreach}
							</select>
						</div>
						<div style="display:none" id="e_wait"><img src="/img/design/wait.gif"></div>
					</td>
    			</tr>
			{/if}


	    		<tr class="bg_color4" id="e_region" style="display: {if !is_array($page.regions) || !sizeof($page.regions)}none{/if}">
	      			<td align="right"><b>Район <font style="color: red; font-weight: normal;">*</font>:</b></td>
	      			<td align="left" width="323">
	      				<select name="region" id="region" size="1" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.regions item=v key=k}
		<option value="{$k}" 
		{if $ENV._POST.action && $k == $ENV._POST.region || !$ENV._POST.action && $k == $page.adv.region}
		{assign var=any value=false}selected="selected"{/if}>{$v.name}</option>  
{/foreach}
<option value="-1" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
	      			</td>
	    		</tr>
					
				
			<tbody id="e_addr_descr" style="display: {if !is_array($page.streets) || !sizeof($page.streets)}none{/if}">
				<tr class="bg_color4">
      				<td align=right width="30%"><b>Улица:</b></td>
      				<td align=left nowrap="nowrap">
						<select id="street" name="street" style="width:300px">
							<option value="0">-- укажите --</option>
						{foreach from=$page.streets key=StreetID item=street}
							<option value="{$StreetID}" {if $ENV._POST.action && $ENV._POST.street == $StreetID || !$ENV._POST.action && $StreetID == $page.adv.street}
							{assign var=_street value=$street.data}selected="selected"{/if}>{$street.name}</option>
						{/foreach}
						</select>
						<input class="autocomplete" type="text" name="__address" style="display:none;width:295px" value="{$_street}" maxlength="255">
					</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Дом:</b></td>
      				<td align=left><input name="house" type="text" style="width:30px" value="{if $ENV._POST.action}{$ENV._POST.house|strip_tags|htmlspecialchars}{else}{$page.adv.house|strip_tags|htmlspecialchars}{/if}" maxlength="3"> - <input name="house_idx" type="text" style="width:18px" value="{if $ENV._POST.action}{$ENV._POST.house_idx|strip_tags|htmlspecialchars}{else}{$page.adv.house_idx|strip_tags|htmlspecialchars}{/if}" maxlength="2">
					<small>Пример: 37, 29-Б, где Б - это корпус.<br/>Указание улицы и номера дома делает поиск по вашим объявлениям эффективнее.</small>
					</td>
    			</tr>
			</tbody>
				<tr class="bg_color4">
      				<td align=right><b><div id="e_addr_single">Адрес:</div></b></td>
      				<td align=left><input type="text" name="address" style="width:300px" value="{if $ENV._POST.action}{$ENV._POST.address|strip_tags|htmlspecialchars}{else}{$page.adv.address|strip_tags|htmlspecialchars}{/if}" maxlength="255"></td>
    			</tr>
					
	    			<tr class="bg_color4">
	      				<td align=right><b>Серия <font style="color: red; font-weight: normal;">*</font>:</b></td>
	      				<td align=left>
	      					<select name=series size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.series item=v key=k}
		<option value="{$k}" 
		{if $ENV._POST.action && $k == $ENV._POST.series || !$ENV._POST.action && $k == $page.adv.series}
		selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
		<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
							</select>
	      				</td>
	    			</tr>
					
    			<tr class="bg_color4">
      				<td align="right"><b>Тип дома <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align="left" width="323">
      					<select name=build_type size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.build_type item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.build_type || !$ENV._POST.action && $k == $page.adv.build_type}
	selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				<tr class="bg_color4">
      				<td align=right><b>Состояние <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
{foreach from=$ENV._arrays.status item=v key=k}
	<label for="{$k}_status"><input name=status id="{$k}_status" 
	onClick="ChangeList(frm, this.value);" type=radio value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.status || !$ENV._POST.action && $k == $page.adv.status}
	checked="checked"{/if}>{$v.b}</label>
{/foreach}
					</td>
    			</tr>
				<tr
				{if $ENV._POST.action && 1 != $ENV._POST.status || !$ENV._POST.action && 1 != $page.adv.status}
				style="display: none;"{/if} id="stage" class="bg_color4">
      				<td align=right><b>Стадия строительства <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
      					<select name=stage size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.stage item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.stage || !$ENV._POST.action && $k == $page.adv.stage}
	selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
								
   			<tr class="bg_color4">
      				<td align=right><b>Площадь помещения <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left nowrap="nowrap"><input type=text name=area_build style=width:265px 
      				value="{if $ENV._POST.action}{$ENV._POST.area_build|floatval}{else}{$page.adv.area_build|floatval}{/if}"> кв.м.</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Этажность <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>помещения:
      					<select name=floor size=1 type=select-one style=width:40px>
{foreach from=$ENV._arrays.floor item=v}
	<option value="{$v}" 
	{if $ENV._POST.action && $v == $ENV._POST.floor || !$ENV._POST.action && $v == $page.adv.floor}
	selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      , дома:
      <select name=floors size=1 type=select-one style=width:40px> 
{foreach from=$ENV._arrays.floors item=v}
	<option value="{$v}" 
	{if $ENV._POST.action && $v == $ENV._POST.floors || !$ENV._POST.action && $v == $page.adv.floors}
	selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      </td>
    </tr>
<tr class="bg_color4">
      <td align=right><b>Площадь участка <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left>
      <input type=text name=area_site style=width:230px 
      value="{if $ENV._POST.action}{$ENV._POST.area_site|floatval}{else}{$page.adv.area_site|floatval}{/if}">
      <select name="area_site_unit"  style=width:60px>
{foreach from=$ENV._arrays.site_unit key=_k item=v}
	<option value="{$_k}" 
	{if $ENV._POST.action && $_k == $ENV._POST.area_site_unit || !$ENV._POST.action && $_k == $page.adv.area_site_unit}
	selected="selected"{/if}>{$v}</option>
{/foreach}
</select>
      </td>
    </tr>
    <tr class="bg_color4">
      <td align=right><b>Контакты <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><textarea name=contacts style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.contacts|strip_tags}{else}{$page.adv.contacts|strip_tags}{/if}</textarea></td>
    </tr>
<tr>
      <td align=right class=ssyl><b>Возможность продажи по ипотеке:</b></td>
      <td align=left>
      <select name=ipoteka size=1 type=select-one style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.ipoteka item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.ipoteka || !$ENV._POST.action && $k == $page.adv.ipoteka} 
	selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
</select>
      </td>
    </tr>
    <tr>
      <td align=right ><b>Цена:</b></td>
      <td align=left >
      <input type=text name=price style=width:160px value="{if $ENV._POST.action}{$ENV._POST.price|floatval}{else}{$page.adv.price|floatval}{/if}">
      тыс. руб.
      <select name=price_unit size=1 type=select-one style=width:70px>
{foreach from=$ENV._arrays.price_unit item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.price_unit || !$ENV._POST.action && $k == $page.adv.price_unit} 
	selected="selected"{/if}>{$v.s}</option>
{/foreach}
</select>
      </td>
    </tr>
    <tr bgcolor=#FFFFFF>
      <td align=right class=ssyl><b>Возраст дома:</b></td>
      <td align=left>
      <select name=age_build size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.age_build item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.age_build || !$ENV._POST.action && $k == $page.adv.age_build}
	selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
</select>
      </td>
    </tr>
    <tr>
      <td align=right class=ssyl><b>Отделка:</b></td>
      <td align=left>
      <select name=decoration size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.decoration || !$ENV._POST.action && $k == $page.adv.decoration}
	selected="selected"{/if}>{$v.b}</option>
{/foreach}
</select>
      </td>
    </tr>
<tr>
      <td align=right class=ssyl><b>Санузел:</b></td>
      <td align=left>
      <select name=lavatory size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.lavatory item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.lavatory || !$ENV._POST.action && $k == $page.adv.lavatory}
	selected="selected"{/if}>{$v.b}</option>
{/foreach}
</select>
      </td>
    </tr>

<tr>
      <td align=right class=ssyl><b>Телефон:</b></td>
      <td align=left>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=phone value=1 
	{if $ENV._POST.action && $ENV._POST.phone == 1 || !$ENV._POST.action && $page.adv.phone == 1} checked="checked"{/if}></td>
	<td align=right class=ssyl width=100><b>Балкон:</b></td>
	<td><input type=checkbox name=balcony value=1 {if $ENV._POST.action && $ENV._POST.balcony == 1 || !$ENV._POST.action && $page.adv.balcony == 1}checked="checked"{/if}></td>
	</tr>
	</table>	
      </td>
    </tr>

<tr>
      <td align=right class=ssyl><b>Лифт:</b></td>
      <td align=left>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=lift value=1 
	{if $ENV._POST.action && $ENV._POST.lift == 1 || !$ENV._POST.action && $page.adv.lift == 1}checked="checked"{/if}></td>
	<td align=right class=ssyl width=100><b>Домофон:</b></td>
	<td><input type=checkbox name=comm value=1 
	{if $ENV._POST.action && $ENV._POST.comm == 1 || !$ENV._POST.action && $page.adv.comm == 1}checked="checked"{/if}></td>
	</tr>
	</table>	
      </td>
    </tr>

<tr>
      <td align=right class=ssyl><b>Сигнализация:</b></td>
      <td align=left>
	<table cellpadding=0 cellspacing=0 width=100% border=0>
	<tr>
	<td width=50><input type=checkbox name=sign value=1 
	{if $ENV._POST.action && $ENV._POST.sign == 1 || !$ENV._POST.action && $page.adv.sign == 1}checked="checked"{/if}></td>
	<td align=right class=ssyl width=100><b>Мебель:</b></td>
	<td><input type=checkbox name=mebel value=1 
	{if $ENV._POST.action && $ENV._POST.mebel == 1 || !$ENV._POST.action && $page.adv.mebel == 1}checked="checked"{/if}></td>
	</tr>
	</table>	
      </td>
    </tr>
    <tr>
      <td align=right ><b>Фото 1:</b></td>
      <td align=left ><input style=width:300px type=file name=img1><br />
      &nbsp;<INPUT type=checkbox name="imgcheck1" {if $ENV._POST.action && $ENV._POST.imgcheck1} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=ssyl>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2 ><b>Текущее фото:</b><br />{$page.adv.img1}</td>
    </tr>
    <tr>
      <td align=right ><b>Фото 2:</b></td>
      <td align=left ><input style=width:300px type=file name=img2><br />
      &nbsp;<INPUT type=checkbox name="imgcheck2" {if $ENV._POST.action && $ENV._POST.imgcheck2} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=ssyl>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2 ><b>Текущее фото:</b><br />{$page.adv.img2}</td>
    </tr>
    <tr>
      <td align=right ><b>Фото 3:</b></td>
      <td align=left ><input style=width:300px type=file name=img3><br />
      &nbsp;<INPUT type=checkbox name="imgcheck3" {if $ENV._POST.action && $ENV._POST.imgcheck3} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=ssyl>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2 ><b>Текущее фото:</b><br />{$page.adv.img3}</td>
    </tr>
	<tr>
      <td align=right class=ssyl><b>Доп. информация:</b></td>
      <td align=left><textarea name=description style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.description|strip_tags}{else}{$page.adv.description|strip_tags}{/if}</textarea></td>
    </tr>
    <tr>
      <td align=right ><b>Объявление размещается до:</b></td>
      <td align=left >{$page.adv.date_end|date_format:"%d-%m-%Y %H:%M"}</td>
    </tr>
    <tr>
      <td align=right ><b>Продлить объявление еще на:</b></td>
      <td align=left>
      <select name="prolong" size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.adv_prolong item=v key=k}
	<option value="{$k}" 
	{if (!empty($ENV._POST.action) && $k == $ENV._POST.prolong) || ($k==1 && empty($ENV._POST.action))} 
	selected="selected"{/if}>{$v.t}</option>
{/foreach}
</select>
      </td>
    </tr>
				<tr>
      				<td align=right><b>Предложение от:</b></td>
      				<td align=left>
{foreach from=$ENV._arrays.agent item=v key=k}
	<label for="{$k}_agent"><input name=agent id="{$k}_agent" type=radio value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.agent || !$ENV._POST.action && $k == $page.adv.agent}
	checked="checked"{/if}>{$v.b}</label>
{/foreach}
					</td>
    			</tr>
<tr>
      <td align=center colspan=2>
      <input class=button type=submit value=Сохранить style=width:100px;>&nbsp;
      <input class=button type=reset value=Очистить style=width:100px;>
      </td>
    </tr>
    </table>
    </form>
<br/><br/>  
{/if}
