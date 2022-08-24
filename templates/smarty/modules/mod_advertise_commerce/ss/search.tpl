{$page.top}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="center"><br />
    	<form name="frm" action="/{$ENV.section}/list.html" method="get">
    	<input type="hidden" name="search" value="1"/>
    	<table align="center" cellpadding="3" cellspacing="0" border="0">
    		<tr bgcolor="#E9EFEF">
				<td align="left" colspan="2" style="padding:3px;padding-left:8px"><font class="t1">Поиск</font></td>
		    </tr>
			<tr>
      			<td align="right"><b>Рубрика:</b></td>
      			<td width="300" align="left">
      				<select name="rubric" type="select-one" style="width:300px">

{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.rubric}selected="selected"{/if}>{$v}</option>  
{/foreach}
					</select>
      			</td>
    		</tr>
    		<tr>
      			<td align="right"><b>Тип недвижимости:</b></td>
      			<td align="left">
      				<select name="object" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.object}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- любой --</option>
					</select>
      			</td>
    		</tr>
    	<tr>
      		<td align="right"><b>Состояние:</b></td>
      		<td align="left">
      			<select name="status" ype="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.status item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.status}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- любое --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Отделка:</b></td>
      		<td align="left">
      			<select name="decoration" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.decoration}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select>
    		</td>
    	</tr>
<tr>
      		<td align="right"><b>Площадь:</b></td>
      		<td align="left" nowrap="nowrap">
      			<select name="area_range" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.area_range item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.area}selected="selected"{assign var=any value=false}{/if}>{$v.d}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- любая --</option>
				</select> кв.м.
    		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Этажность:</b></td>
      		<td align="left">помещения:
      			<select name="floor" style="width:80px">
{assign var=any value=true} 
{foreach from=$ENV._arrays.floor item=v}
	<option value="{$v}" {if $v == $ENV._params.floor}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- любой --</option>
				</select>
      , дома:
      <select name="floors" style="width:80px">
{assign var=any value=true} 
{foreach from=$ENV._arrays.floors item=v}
	<option value="{$v}" {if $v == $ENV._params.floors}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- любой --</option>
				</select>
      		</td>
		</tr>
		<tr>
      		<td align="right"><b>Наличие телефона:</b></td>
      		<td align="left">
      			<select name="phone" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.phone}selected="selected"{assign var=any value=false}{/if}>{$v}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
				</select>
      		</td>
    	</tr>
		<tr>
      		<td align="right"><b>Цена:</b></td>
      		<td align="left">
      			от <input type="text" name="price1" style="width:60px" value="{$ENV._params.price1|floatval}">
      			до <input type="text" name="price2" style="width:60px" value="{$ENV._params.price2|floatval}">
				тыс. руб.
      				<select name="price_unit" style="width:70px">
{foreach from=$ENV._arrays.price_unit item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.price_unit}selected="selected"{/if}>{$v.s}</option>
{/foreach}
					</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right"><b>Дата:</b></td>
      		<td align="left">
		      <select name="date_show" style="width:300px">
{foreach from=$ENV._arrays.date_show item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.date_show}selected="selected"{/if}>{$v.t}</option>
{/foreach}
				</select>
      		</td>
		</tr>
    	<tr>
      		<td align="right"><b>C фото?</b></td>
			<td align="left"><input type="checkbox" name="photo" {if $ENV._params.photo}checked="checked"{/if}></td>
    	</tr>
    	<tr>
      		<td align="right"><b>Показать в виде:</b></td>
      		<td align="left">
      			<select name="view" style="width:300px">
{foreach from=$ENV._arrays.view item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.view}selected="selected"{/if}>{$v}</option>
{/foreach}
				</select>
      		</td>
    	</tr>
    	<tr>
      		<td align="right"><b>Сортировать:</b></td>
      		<td align="left">
      			<select name="order" style="width:300px">
{foreach from=$ENV._arrays.order item=v key=k}
	<option value="{$k}" {if $k == $ENV._params.order}selected="selected"{/if}>{$v[1]}</option>
{/foreach}
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
	</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>