{$page.top}

<br /><br />

    	<form name="frm" action="/{$ENV.section}/list.html" method="get">
    	<input type="hidden" name="search" value="1"/>
    	<table align="center" cellspacing="1" class="table2">
    		<tr>
				<th colspan="2">Поиск</th>
		    </tr>
			<tr>
      			<td align="right" class="bg_color2">Рубрика:</td>
      			<td width="300" class="bg_color4">
      				<select name="rubric" type="select-one" style="width:300px">

{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.rubric}selected="selected"{/if}>{$v}</option>
{/foreach}
					</select>
      			</td>
    		</tr>
    		<tr>
      			<td align="right" class="bg_color2">Тип недвижимости:</td>
      			<td class="bg_color4">
      				<select name="object" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.object}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
					</select>
      			</td>
    		</tr>
		    <tr>
      			<td align="right" class="bg_color2">Район:</td>
      			<td class="bg_color4">
{assign var=i value=1}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
{foreach from=$ENV._arrays.regions item=v key=k}
	{if !$i}<tr>{/if}
	<td class="ssyl"><input class="clear_region" name="region[{$k}]" id="region{$k}" type="checkbox" value="1" {if (isset($ENV._params.region[$k]) && isset($smarty.get.search)) || (!isset($smarty.get.search))}checked="checked"{/if} />{$v.b}</td>
	{assign var=i value=`$i+1`}
	{if $i==3}</tr>{assign var=i value=1}{/if}
{/foreach}
<tr>
	<td class="ssyl"></td>
	<td class="ssyl" align="center"><a href="#" class="ssyl" onclick="javascript:$('.clear_region').removeAttr('checked'); return false;">очистить выборку</a></td>
</tr>
</table>
{*      				<select name="region" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.regions item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.region}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>*}
      		</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Серия:</td>
      		<td class="bg_color4">
      			<select name="series" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.series item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.series}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
			</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Тип дома:</td>
      		<td class="bg_color4">
      			<select name=build_type type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.build_type item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.build_type}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Состояние:</td>
      		<td class="bg_color4">
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
      		<td align="right" class="bg_color2">Отделка:</td>
      		<td class="bg_color4">
      			<select name="decoration" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.decoration}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
    		</td>
    	</tr>
		<tr>
      		<td align="right" class="bg_color2">Этажность:</td>
      		<td class="bg_color4">помещения:
      			<select name="floor" type="select-one" style="width:80px">
{assign var=any value=true}
{foreach from=$ENV._arrays.floor item=v}
	<option value="{$v}" {if $v == $ENV._params.floor}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select>
      , дома:
      <select name="floors" type="select-one" style="width:80px">
{assign var=any value=true}
{foreach from=$ENV._arrays.floors item=v}
	<option value="{$v}" {if $v == $ENV._params.floors}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select>
      		</td>
		</tr>
		<tr>
      		<td align="right" class="bg_color2">Наличие телефона:</td>
      		<td class="bg_color4">
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
      		<td align="right" class="bg_color2">Наличие мебели:</td>
      		<td class="bg_color4">
      			<select name=furnit size=1 type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.furnit item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.furnit}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right" class="bg_color2">Цена:</td>
      		<td class="bg_color4">
      			от <input type="text" name="price1" style="width:60px" value="{$ENV._params.price1|floatval}">
      			до <input type="text" name="price2" style="width:60px" value="{if empty($ENV._params.price2)}100000000{else}{$ENV._params.price2|floatval}{/if}">
				тыс. руб.
      				<select name="price_unit" type="select-one" style="width:70px">
{foreach from=$ENV._arrays.price_unit item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.price_unit}selected="selected"{/if}>{$v.s}</option>
{/foreach}
					</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Дата:</td>
      		<td class="bg_color4">
		      <select name="date_show" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.date_show item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.date_show}selected="selected"{/if}>{$v.t}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
      		<td align="right" class="bg_color2">C фото?</td>
			<td class="bg_color4"><input  type="checkbox" name="photo" {if $ENV._params.photo}checked="checked"{/if}></td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Показать в виде:</td>
      		<td class="bg_color4">
      			<select name="view" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.view item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.view}selected="selected"{/if}>{$v}</option>
{/foreach}
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right" class="bg_color2">Сортировать:</td>
      		<td class="bg_color4">
      			<select name="order" type="select-one" style="width:300px">
{foreach from=$ENV._arrays.order item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.order}selected="selected"{/if}>{$v[1]}</option>
{/foreach}
				</select>
      		</td>
		</tr>
		<tr>
      		<td align="right" class="bg_color2">Предложения от:</td>
      		<td align="left" class="bg_color4">
      			<select name="agent" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.agent item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.agent}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="center" colspan="2">
      			<input class="button" type="submit" value="Искать" style="width:100px">&nbsp
      			<input class="button" type="reset" value="Очистить" style="width:100px">
      		</td>
    	</tr>
    </table>
	</form>
   <br /><br />