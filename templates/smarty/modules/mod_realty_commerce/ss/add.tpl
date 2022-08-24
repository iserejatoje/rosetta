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
<br/><br/>
    	<form name=frm method="post" enctype="multipart/form-data">
    	<input type=hidden name="action" value="add" />
    		<table align=center cellspacing=1 border=0 class="table2">
    			<tr>
      				<th colspan="2">
      					Добавить объявление
      				</td>
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
      				<td width="300" align="left">
      					<select name="rubric" size="1" type="select-one" style="width:300px">
{assign var=any value=true}
{foreach from=$ENV._arrays.rubrics item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.rubric}{assign var=any value=false}selected="selected"{/if}>{$v}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Тип недвижимости <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
      					<select name="object" onChange="ChangeList(this.value);" style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.objects item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.object}{assign var=any value=false}selected="selected"{/if}>{$v.b}</option>
{/foreach}
<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				{foreach from=$ENV._arrays.types item=v key=k}
				<tr class="bg_color4" {if $ENV._POST.object != $k }style="display: none;"{/if} id="stage_{$k}">
      				<td align=right><b>Тип здания <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
      					<select name="type[{$k}]" style="width:300px">
{assign var=any value=true}
{foreach from=$v item=v2 key=k2}
	<option value="{$k2}" {if $k2 == $ENV._POST.type[$k] && $k == $ENV._POST.object}selected="selected"{assign var=any value=false}{/if}>{$v2}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
						</select>
      				</td>
    			</tr>
				{/foreach}
				<tr class="bg_color4">
      				<td align=right><b>Состояние <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>
{foreach from=$ENV._arrays.status item=v key=k}
	<label for="{$k}_status"><input name=status id="{$k}_status"  type="radio" value="{$k}" {if $k == $ENV._POST.status}checked="checked"{/if}>{$v.b}</label>
{/foreach}
					</td>
    			</tr>
				<tr class="bg_color4">
      				<td align=right><b>Отделка <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left><select name=decoration style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.decoration item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.decoration}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- укажите --</option>
					</select></td>
    			</tr>
				<tr class="bg_color4">
      				<td align=right><b>Адрес <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left><input type="text" name="address" style="width:295px" value="{$ENV._POST.address|strip_tags|htmlspecialchars}" maxlength="255"></td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Площадь помещения <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left nowrap="nowrap"><input type=text name=area_build style=width:265px value="{$ENV._POST.area_build|floatval}"> кв.м.</td>
    			</tr>
    			<tr class="bg_color4">
      				<td align=right><b>Этажность <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left>помещения:
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
      				<td align=right><b>Наличие телефона <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td align=left><select name=phone style=width:300px>
{foreach from=$ENV._arrays.phone item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.phone}selected="selected"{/if}>{$v}</option>
{/foreach}</select>
					</td>
    </tr>

<tr class="bg_color4">
      <td align=right><b>Площадь прилегающего участка <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left>
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
      <td align=left><textarea name=contacts style=width:295px;height:50px>{if $ENV._POST.contacts}{$ENV._POST.contacts|strip_tags}{else}{$page.user.contacts}{/if}</textarea></td>
    </tr>
{*if !$USER->isAuth()*}
{if $page.captcha_path}
<tr class="bg_color4">
      <td align=right><b>Код защиты от роботов <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><img src="{$page.captcha_path}" width="150" height="50" border="0" align="middle" /> &gt;&gt; <input type=text name="captcha_code" style=width:100px value="">
			<br />Введите четырехзначное число, которое Вы видите на картинке</td>
    </tr>
{/if}
{*/if*}
<tr>
      <td align=right class=ssyl><b>Доп. информация:</b></td>
      <td align=left><textarea name=description style=width:295px;height:50px>{$ENV._POST.description|strip_tags}</textarea></td>
    </tr>
    <tr>
      <td align=right><b>Цена:</b></td>
      <td align=left>
      <input type=text name=price style=width:160px value="{$ENV._POST.price|floatval}">
      тыс. руб.
      <select name=price_unit size=1 type=select-one style=width:70px>
{foreach from=$ENV._arrays.price_unit item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.price_unit}selected="selected"{/if}>{$v.s}</option>
{/foreach}
</select>
      </td>
    </tr>
				<tr bgcolor=#FFFFFF>
      				<td align=right class="ssyl"><b>Возраст здания:</b></td>
      				<td align=left><select name=age_build style=width:300px>
{assign var=any value=true}
{foreach from=$ENV._arrays.age_build item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.age_build}selected="selected"{assign var=any value=false}{/if}>{$v.b}</option>
{/foreach}
	<option value="0" {if $any}selected="selected"{/if}>-- не имеет значения --</option>
					</select></td>
    			</tr>
    <tr>
      <td align=right><b>Срок размещения:</b></td>
      <td align=left>
      <select name=period size=1 type=select-one style=width:300px>
{foreach from=$ENV._arrays.adv_period item=v key=k}
	<option value="{$k}" {if $k == $ENV._POST.period}selected="selected"{/if}>{$v.t}</option>
{/foreach}
</select>
      </td>
    </tr>
    <tr>
      <td align=right><b>Фото 1:</b></td>
      <td align=left><input style=width:300px type=file name=img1><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 2:</b></td>
      <td align=left><input style=width:300px type=file name=img2><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 3:</b></td>
      <td align=left><input style=width:300px type=file name=img3><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>

{*{if !$page.user.id}
<tr class="bg_color4">
	<td height=10 colspan="2"></td>
</tr>
<tr>
    <td colspan=2 style=border: 1px solid #CACAB9>
    	<b>Если Вы хотите редактировать это объявление в дальнейшем,<br />необходимо ввести свой email и пароль.<br />
    	Если Вы ранее не регистрировались на сайте {$CURRENT_ENV.site.domain},<br />то Вы будете автоматически зарегистрированы.</b>
	</td>
</tr>
<tr><td height=10 colspan="2"></td></tr>
<tr>
      <td align=right><b>Email:</b></td>
      <td align=left><input type=text name=email style=width:295px value="{$ENV._POST.email|strip_tags}"></td>
</tr>
<tr>
	<td colspan=2 align=right>
		<font class=small>Бесплатный почтовый ящик <b>ваше_имя@{$CURRENT_ENV.site.domain}</b> можно получить
		<a href="/mail/" target="_blank">здесь</a>.</font>
	</td></tr>
<tr>
      <td align=right><b>Пароль:</b></td>
      <td width=200 align=left><input type=password name=password style=width:295px></td>
</tr>
{/if}*}

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