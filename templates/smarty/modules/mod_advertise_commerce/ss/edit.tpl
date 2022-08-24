{$page.top}
<script language='Javascript'>
<!--
{literal}
function ChangeList(vt){
{/literal}
{foreach from=$ENV._arrays.types item=v key=k}
	document.getElementById('stage_{$k}').style.display = 'none';
{/foreach}
{literal}	if (document.getElementById('stage_'+vt)) document.getElementById('stage_'+vt).style.display = '';
}{/literal}
-->
</script>
{if $page.errors !== null}
	<div align="center" style="color:red"><b>{$page.errors}</b></div>
{/if}
{if !$page.CLOSED_EDIT}
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td><img src="/_img/x.gif" width=1 height=20 border=0 alt="" /></td>
	</tr>
	<tr>
		<td align=center><br/>
    	<form name=frm method="post" enctype=multipart/form-data>
    	<input type=hidden name="action" value="edit" />
    	<input type=hidden name="id" value="{$page.adv.id}" />
    		<table align=center cellpadding=3 cellspacing=0 border=0>
    			<tr>
      				<td align=left colspan=2 class=s_title style=padding:3px;padding-left:8px;>
      					<font class=zag1>Редактировать объявление</font>
      				</td>
    			</tr>
				<tr bgcolor=#F3FBE9>
      				<td align=right><b>Рубрика:</b></td>
      				<td width=300 align=left>
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
				<tr bgcolor=#F3FBE9>
      				<td align=right><b>Тип недвижимости:</b></td>
      				<td align=left>
      					<select name="object" onChange="ChangeList(this.value);" style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" {if $ENV._POST.action && $k == $ENV._POST.object || !$ENV._POST.action && $k == $page.adv.object}
	{assign var=any value=false}selected="selected"{/if}>{$v.b}</option>  
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				{foreach from=$ENV._arrays.types item=v key=k}
				<tr {if $ENV._POST.action && $ENV._POST.object != $k || !$ENV._POST.action && $k != $page.adv.object}style="display: none;"{/if} id="stage_{$k}" bgcolor="#F3FBE9">
      				<td align=right><b>Тип здания:</b></td>
      				<td align=left>
      					<select name="type[{$k}]" style="width:300px">
{assign var=any value=true}
{foreach from=$v item=v2 key=k2}
	<option value="{$k2}" {if $ENV._POST.action && $k2 == $ENV._POST.type[$k] && $k == $ENV._POST.object
	|| !$ENV._POST.action && $k2 == $page.adv.type && $k == $page.adv.object}selected="selected"{assign var=any value=false}{/if}>{$v2}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				{/foreach}
				<tr bgcolor=#F3FBE9>
      				<td align=right><b>Состояние:</b></td>
      				<td align=left>
{foreach from=$ENV._arrays.status item=v key=k}
	<label for="{$k}_status"><input name=status id="{$k}_status" type=radio value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.status || !$ENV._POST.action && $k == $page.adv.status}
	checked="checked"{/if}>{$v.b}</label>
{/foreach}
					</td>
    			</tr>
				<tr bgcolor=#F3FBE9>
      				<td align=right><b>Отделка:</b></td>
      				<td align=left><select name=decoration style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" {if $ENV._POST.action && $k == $ENV._POST.decoration || !$ENV._POST.action && $k == $page.adv.decoration}
	selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
					</select></td>
    			</tr>
				<tr bgcolor=#F3FBE9>
      				<td align=right><b>Адрес:</b></td>
      				<td align=left><input type="text" name="address" style="width:295px" value="{if $ENV._POST.action}{$ENV._POST.address|strip_tags|htmlspecialchars}{else}{$page.adv.address|strip_tags|htmlspecialchars}{/if}" maxlength="255"></td>
    			</tr>
    			<tr bgcolor=#F3FBE9>
      				<td align=right><b>Площадь помещения:</b></td>
      				<td align=left nowrap="nowrap"><input type=text name=area_build style=width:265px 
      				value="{if $ENV._POST.action}{$ENV._POST.area_build|floatval}{else}{$page.adv.area_build|floatval}{/if}"> кв.м.</td>
    			</tr>
    			<tr bgcolor=#F3FBE9>
      				<td align=right><b>Этажность:</b></td>
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
<tr bgcolor=#F3FBE9>
      				<td align=right><b>Наличие телефона:</b></td>
      				<td align=left><select name=phone style=width:300px>
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $ENV._POST.action && $k == $ENV._POST.phone || !$ENV._POST.action && $k == $page.adv.phone}
	selected="selected"{/if}>{$v}</option>
{/foreach}</select>
					</td>
    </tr>
<tr bgcolor=#F3FBE9>
      <td align=right><b>Площадь участка:</b></td>
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

<tr bgcolor=#F3FBE9>
      <td align=right><b>Доп. информация:</b></td>
      <td align=left><textarea name=description style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.description|strip_tags}{else}{$page.adv.description|strip_tags}{/if}</textarea></td>
    </tr>
    <tr bgcolor=#F3FBE9>
      <td align=right><b>Цена:</b></td>
      <td align=left>
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
    <tr bgcolor=#F3FBE9>
      <td align=right><b>Контакты:</b></td>
      <td align=left><textarea name=contacts style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.contacts|strip_tags}{else}{$page.adv.contacts|strip_tags}{/if}</textarea></td>
    </tr>
    <tr bgcolor=#F3FBE9>
      <td align=right><b>Продлить объявление еще на:</b></td>
      <td align=left>
      <select name="prolong" size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.adv_prolong item=v key=k}
	<option value="{$k}" 
	{if $ENV._POST.action && $k == $ENV._POST.prolong || !$ENV._POST.action && $k == $page.adv.prolong} 
	selected="selected"{/if}>{$v.t}</option>
{/foreach}
</select>
      </td>
    </tr>
    <tr bgcolor=#F3FBE9>
      <td align=right><b>Фото:</b></td>
      <td align=left><input style=width:300px type=file name=img1><br />
      &nbsp;<INPUT type=checkbox name="imgcheck1" {if $ENV._POST.action && $ENV._POST.imgcheck1} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr bgcolor="#F3FBE9">
      <td align="center" colspan=2><b>Текущее фото:</b><br />{$page.adv.img1}</td>
    </tr>

<tr bgcolor=#F3FBE9>
      <td align=center colspan=2>
      <input class=button type=submit value=Сохранить style=width:100px;>&nbsp;
      <input class=button type=reset value=Очистить style=width:100px;>
      </td>
    </tr>
    </table>
    </form>

</td></tr>

	<tr>
		<td><img src="/_img/x.gif" width=1 height=20 border=0 alt="" /></td>
	</tr>
</table>
{/if}