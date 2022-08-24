{$page.top}
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
				<tr class="bg_color4">
      <td align=right class=ssyl><b>Схема обмена:</b></td>
      <td align=left><input name=scheme type="text" style=width:295px; value="{if $ENV._POST.action}{$ENV._POST.scheme|strip_tags|addslashes}{else}{$page.adv.scheme|strip_tags|addslashes}{/if}"/></td>
    </tr>
<tr class="bg_color4">
      <td align=right class=ssyl><b>Имеется:</b></td>
      <td align=left><textarea name=have style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.have|strip_tags}{else}{$page.adv.have|strip_tags}{/if}</textarea></td>
    </tr>
<tr class="bg_color4">
      <td align=right class=ssyl><b>Требуется:</b></td>
      <td align=left><textarea name=need style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.need|strip_tags}{else}{$page.adv.need|strip_tags}{/if}</textarea></td>
    </tr>
<tr>
      <td align=right class=ssyl><b>Доп. информация:</b></td>
      <td align=left><textarea name=description style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.description|strip_tags}{else}{$page.adv.description|strip_tags}{/if}</textarea></td>
    </tr>
    <tr class="bg_color4">
      <td align=right><b>Контакты:</b></td>
      <td align=left><textarea name=contacts style=width:295px;height:50px>{if $ENV._POST.action}{$ENV._POST.contacts|strip_tags}{else}{$page.adv.contacts|strip_tags}{/if}</textarea></td>
    </tr>
    <tr>
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
    <tr>
      <td align=right class=ssyl><b>Фото 1:</b></td>
      <td align=left><input style=width:300px type=file name=img1><br />
      &nbsp;<INPUT type=checkbox name="imgcheck1" {if $ENV._POST.action && $ENV._POST.imgcheck1} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2><b>Текущее фото:</b><br />{$page.adv.img1}</td>
    </tr>
    <tr>
      <td align=right class=ssyl><b>Фото 2:</b></td>
      <td align=left><input style=width:300px type=file name=img2><br />
      &nbsp;<INPUT type=checkbox name="imgcheck2" {if $ENV._POST.action && $ENV._POST.imgcheck2} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2><b>Текущее фото:</b><br />{$page.adv.img2}</td>
    </tr>
    <tr>
      <td align=right class=ssyl><b>Фото 3:</b></td>
      <td align=left><input style=width:300px type=file name=img3><br />
      &nbsp;<INPUT type=checkbox name="imgcheck3" {if $ENV._POST.action && $ENV._POST.imgcheck3} checked="checked"{/if}>
       Удалить текущее фото<br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align="center" colspan=2><b>Текущее фото:</b><br />{$page.adv.img3}</td>
    </tr>

<tr>
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