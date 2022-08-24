{$page.top}

<br /><br />

    	<form name="frm" action="/{$ENV.section}/list.html" method="get">
    	<input type="hidden" name="search" value="1"/>
    	<table align="center" cellspacing="1" class="table2">
    		<tr>
    			<th colspan="2">Поиск</th>
    		</tr>
			
			<tr>
      			<td align="right" width="240" class="bg_color2"><b>Рубрика:</b></td>
      			<td class="bg_color4">
      				<select name="rubric" type="select-one" style="width:300px">

{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.rubric}selected="selected"{/if}>{$v}</option>  
{/foreach}
					</select>
      			</td>
    		</tr>
			
    		<tr>
      			<td align="right"class="bg_color2"><b>Типы жилья:</b></td>
      			<td class="bg_color4">
					{assign var=i value=1}
					<table cellpadding="0" cellspacing="0" border="0">
					{foreach from=$ENV._arrays.objects item=v key=k}			
						{if !$i}<tr>{/if}
						<td width="30%"><input class="clear_obj_type" name="object[{$k}]" id="object{$k}" type="checkbox" value="1" {if (isset($ENV._params.object[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} /><label for="object{$k}">{$v.b}</label></td>
						{assign var=i value=`$i+1`}	
						{if $i==4}</tr>{assign var=i value=1}{/if}
					{/foreach}
					<tr>
						<td width="30%"/>
						<td width="30%"/>
						<td align="center" width="30%"><a href="#" class="text11" onclick="javascript:$('.clear_obj_type').removeAttr('checked'); return false;">очистить выборку</a></td>
					</tr>
					</table>				
				</td>
			</tr>


				
		    <tr>
      			<td align="right" class="bg_color2"><b>Город:</b></td>
      			<td align="left" class="bg_color4">
					<div style="float:left; margin-right:5px">
						<select name="city_id" id="city" type="select-one" style="width:300px" onchange="mod_realty.requestRegions(true)">
							{assign var=any value=true}
							{foreach from=$ENV._arrays.cities item=v key=k}
							{if ($ENV.site.domain=="mgorsk.ru" && $k==2376) || $ENV.site.domain!="mgorsk.ru"}
							<option value="{$k}" {if $k == $ENV._params.city_id}selected="selected"{assign var=any value=false}{/if}>{$v.name}</option>
							{/if}
							{/foreach}
							<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
						</select>
	{if $CURRENT_ENV.regid == 86}
		&nbsp;<noindex><a href="http://72doma.ru/sale/search/" rel="nofollow" target="_blank">Тюмень</a>
		&nbsp;&nbsp; <a href="http://89.ru/sale/search/" rel="nofollow" target="_blank">ЯНАО</a>
		</noindex>
	{/if}	
	{if $CURRENT_ENV.regid == 89}
		&nbsp;<noindex><a href="http://72doma.ru/sale/search/" rel="nofollow" target="_blank">Тюмень</a>
		&nbsp;&nbsp; <a href="http://86.ru/sale/search/" rel="nofollow" target="_blank">ХМАО</a>
		</noindex>
	{/if}
					</div>
					<div style="display:none" id="e_wait"><img src="/img/design/wait.gif"></div>
						{if $ENV.site.domain=="mgorsk.ru"}			
						<br/><br/><a href="http://domchel.ru/sale/search/" class="text11" target="_blank">Челябинская область</a>
						{/if}
				</td>
			</tr>

		    <tr id="e_region" style="display: {if !is_array($ENV._arrays.regions) || !sizeof($ENV._arrays.regions)}none{/if}">
      			<td align="right" class="bg_color2"><b>Район:</b></td>
	      		<td align="left" class="bg_color4">
					<div id="e_region_list">
						{assign var=i value=1}
						<table cellpadding="0" cellspacing="0" border="0">
						{foreach from=$ENV._arrays.regions item=v key=k}
								{if !$i}<tr>{/if}
								<td width="20%"><input class="clear_regions" name="region[{$k}]" id="region{$k}" type="checkbox" value="1" {if (isset($ENV._params.region[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} /><label for="region{$k}">{$v.name}</label></td>
								{assign var=i value=`$i+1`}	
								{if $i==4}</tr>{assign var=i value=1}{/if}
						{/foreach}
						<tr>
						<td width="20%"/>
						<td width="20%"/>
						<td align="center" width="20%"><a href="#" class="text11" onclick="javascript:$('.clear_regions').removeAttr('checked'); return false;">очистить выборку</a></td>
					</tr>
						</table>
					</div>
	      		</td>
			</tr>
			
		<tbody id="e_addr_descr" style="display: {if !is_array($ENV._arrays.streets) || !sizeof($ENV._arrays.streets)}none{/if}">
			<tr>
      			<td align=right class="bg_color2"><b>Улица:</b></td>
      			<td align=left nowrap="nowrap" class="bg_color4">
					<select id="street" name="street" style="width:300px">
						<option value="0">-- не имеет значения --</option>
					{foreach from=$ENV._arrays.streets key=StreetID item=street}
						<option value="{$StreetID}" {if $ENV._POST.action && $ENV._params.street == $StreetID || !$ENV._POST.action && $StreetID == $ENV._params.street}
						{assign var=_street value=$street.data}selected="selected"{/if}>{$street.name}</option>
					{/foreach}
					</select>
				</td>
    		</tr>
    		<tr>
      			<td align="right"><b>Дом:</b></td>
      			<td align="left"><input name="house" type="text" style="width:30px" value="{$ENV._params.house|strip_tags|htmlspecialchars}" maxlength="3"> - <input name="house_idx" type="text" style="width:18px" value="{$ENV._params.house_idx|strip_tags|htmlspecialchars}" maxlength="2">
				</td>
    		</tr>
		</tbody>
			<tr>
   				<td align="right" class="bg_color2"><b><div id="e_addr_single">{if is_array($ENV._arrays.streets) && sizeof($ENV._arrays.streets)}Доп. информация о месторасположении{else}Адрес{/if}:</div></b></td>
   				<td align="left" class="bg_color4"><input name="address" type="text" style="width:300px" value="{$ENV._params.address|strip_tags|htmlspecialchars}" maxlength="255"></td>
   			</tr>
		
	    	<tr>
	      		<td align="right" class="bg_color2"><b>Серия:</b></td>
	      		<td align="left" class="bg_color4">
					{assign var=i value=1}
					<table cellpadding="0" cellspacing="0" border="0">
					{foreach from=$ENV._arrays.series item=v key=k}			
						{if !$i}<tr>{/if}
						<td width="20%"><input class="clear_series" name="series[{$k}]" id="series{$k}" type="checkbox" value="1" {if (isset($ENV._params.series[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} /><label for="series{$k}">{$v.b}</label></td>
						{assign var=i value=`$i+1`}	
						{if $i==4}</tr>{assign var=i value=1}{/if}
					{/foreach}
					<tr>
						<td width="20%"/>
						<td width="20%"/>
						<td align="center" width="20%"><a href="#" class="text11" onclick="javascript:$('.clear_series').removeAttr('checked'); return false;">очистить выборку</a></td>
					</tr>
					</table>
				</td>
	    	</tr>

			<tr>
	      		<td align="right" class="bg_color2"><b>Цена:</b></td>
	      		<td align="left" class="bg_color4">
	      			от <input type="text" name="price1" style="width:60px" value="{$ENV._params.price1|floatval}">
	      			до <input type="text" name="price2" style="width:60px" value="{if empty($ENV._params.price2)}100000{else}{$ENV._params.price2|floatval}{/if}">
					тыс. руб.
	      				<select name="price_unit" type="select-one" style="width:70px">
						{foreach from=$ENV._arrays.price_unit item=v key=k}
							<option value="{$k}" {if $k == $ENV._params.price_unit}selected="selected"{/if}>{$v.s}</option>
						{/foreach}
						</select>
	      		</td>
	    	</tr>		
			<tr>
				<td colspan="2" align="left">
					<div onclick="ShowHideElement('descr_search'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt; obj=document.getElementById('aExtendedSearch'); if (obj.innerHTML=='Расширенный поиск') obj.innerHTML='Краткий поиск'; else obj.innerHTML='Расширенный поиск';" title="Развернуть" alt="Развернуть" class="sale_descr_search"><a href="#" style="color:red" id="aExtendedSearch" onclick="return true;">Расширенный поиск</a></div>
				</td>
			</tr>
	</table>	
	
<div id="descr_search" style="display:none">
	<table align="center" cellspacing="1" class="table2">
    	<tr>
      		<td align="right" width="240"><b>Тип дома:</b></td>
      		<td align="left">
				{assign var=i value=1}
				<table cellpadding="0" cellspacing="0" border="0">
				{foreach from=$ENV._arrays.build_type item=v key=k}
					{if !$i}<tr>{/if}
					<td width="20%"><input class="clear_build_type" name="build_type[{$k}]" id="build_type{$k}" type="checkbox" value="1" {if (isset($ENV._params.build_type[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} />{$v.b}</td>
					{assign var=i value=`$i+1`}	
					{if $i==4}</tr>{assign var=i value=1}{/if}
				{/foreach}
				<tr>
						<td width="20%"/>
						<td width="20%"/>
						<td align="center" width="20%"><a href="#" class="text11" onclick="javascript:$('.clear_build_type').removeAttr('checked'); return false;">очистить выборку</a></td>
					</tr>
				</table>
      		</td>
    	</tr>
    	<tr>
      		<td align="right"><b>Состояние:</b></td>
      		<td align="left">
      			<select name=status size=1 type="select-one" style="width:300px">
				{assign var=any value=true}
				{foreach from=$ENV._arrays.status item=v key=k}
					<option value="{$k}" {if $k == $ENV._params.status}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
				{/foreach}
					<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Этажность:</b></td>
      		<td align="left">помещения:
      			<select name="floor" type="select-one" style="width:80px">
				{assign var=any value=true} 
				{foreach from=$ENV._arrays.floor item=v}
					<option value="{$v}" {if $v == $ENV._params.floor}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
				{/foreach}
					<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select>, дома:
				<select name="floors" type="select-one" style="width:85px">
				{assign var=any value=true} 
				{foreach from=$ENV._arrays.floors item=v}
					<option value="{$v}" {if $v == $ENV._params.floors}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
				{/foreach}
					<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select>
      		</td>
		</tr>
		<tr>
      		<td align="right"><b>Возраст дома:</b></td>
      		<td align="left">
      			<select name="age_build" type="select-one" style="width:300px">
				{assign var=any value=true}
				{foreach from=$ENV._arrays.age_build item=v key=k}
					<option value="{$k}" {if $k == $ENV._params.age_build}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
				{/foreach}
					<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
    		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Отделка:</b></td>
      		<td align="left">
				{assign var=i value=1}
				<table cellpadding="0" cellspacing="0" border="0">
				{foreach from=$ENV._arrays.decoration item=v key=k}
					{if !$i}<tr>{/if}
					<td width="20%"><input class="clear_decoration" name="decoration[{$k}]" id="decoration{$k}" type="checkbox" value="1" {if (isset($ENV._params.decoration[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} /><label for="decoration{$k}">{$v.b}</label></td>
					{assign var=i value=`$i+1`}	
					{if $i==4}</tr>{assign var=i value=1}{/if}
				{/foreach}
				<tr>
						<td width="20%"/>
						<td width="20%"/>
						<td align="center" width="20%"><a href="#" class="text11" onclick="javascript:$('.clear_decoration').removeAttr('checked'); return false;">очистить выборку</a></td>
					</tr>
				</table>
    		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Санузел:</b></td>
      		<td align="left">
      			<select name="lavatory" type="select-one" style="width:300px">
				{assign var=any value=true}
				{foreach from=$ENV._arrays.lavatory item=v key=k}
					<option value="{$k}" {if $k == $ENV._params.lavatory}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
				{/foreach}
					<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Наличие телефона:</b></td>
      		<td align="left">
      			<select name=phone size=1 type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.phone}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Балкон:</b></td>
      		<td align="left">
      			<select name="balcony" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.balcony}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Лифт:</b></td>
      		<td align="left">
      			<select name="lift" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.lift}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Домофон:</b></td>
      		<td align="left">
      			<select name="comm" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.comm}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
    		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Сигнализация:</b></td>
      		<td align="left">
      			<select name="sign" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.sign}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Мебель:</b></td>
      		<td align="left">
      			<select name="mebel" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.mebel}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Возможность продажи по ипотеке:</b></td>
      		<td align="left">
      			<select name="ipoteka" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.ipoteka item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.ipoteka}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right"><b>Дата:</b></td>
      		<td align="left">
		      <select name="date_show" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.date_show item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.date_show}selected="selected"{/if}>{$v.t}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
      		<td align="right"><label for="photo"><b>C фото?</b></label></td>
			<td align="left"><input  type="checkbox" name="photo" id="photo" {if $ENV._params.photo}checked="checked"{/if}></td>
    	</tr>
		
		
    	<tr id="e_search_next" style="display:none;">
      		<td align="right" ><b>Искать в соседних домах?</b></td>
			<td align="left"><input  type="checkbox" name="next" id="next" {if $ENV._params.next}checked="checked"{/if}></td>
    	</tr>

		
    	<tr>
      		<td align="right"><b>Показать в виде:</b></td>
      		<td align="left">
      			<select name="view" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.view item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.view}selected="selected"{/if}>{$v}</option>
{/foreach}
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right"><b>Сортировать:</b></td>
      		<td align="left">
      			<select name="order" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.order item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.order}selected="selected"{/if}>{$v[1]}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
		<tr>
      		<td align="right"><b>Предложения от:</b></td>
      		<td align="left">
      			<select name="agent" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.agent item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.agent}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
	</table>
</div>
	
	<table align="center" cellspacing="1" class="table2">
    	<tr>
      		<td align="center" colspan="2">
      			<input class="button" type="submit" value="Искать" style="width:100px">&nbsp
      			<input class="button" type="reset" value="Очистить" style="width:100px">
      		</td>
    	</tr>
    </table>
</form>
<br /><br />