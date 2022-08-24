{$page.top}

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
      				<td align=right><b>Рубрика <font style="color: red; font-weight: normal;">*</font>:</b></td>
      				<td width=300 align=left>
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
      <td align=right class=ssyl><b>Схема обмена <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><input name=scheme type="text" style="width:295px;" value="{$ENV._POST.scheme|strip_tags|addslashes}"/></td>
    </tr>
<tr class="bg_color4">
      <td align=right class=ssyl><b>Имеется <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><textarea name=have style="width:295px;height:50px">{$ENV._POST.have|strip_tags}</textarea></td>
    </tr>
<tr class="bg_color4">
      <td align=right class=ssyl><b>Требуется <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><textarea name=need style="width:295px;height:50px">{$ENV._POST.need|strip_tags}</textarea></td>
    </tr>
<tr>
      <td align=right class=ssyl><b>Доп. информация:</b></td>
      <td align=left><textarea name=description style="width:295px;height:50px">{$ENV._POST.description|strip_tags}</textarea></td>
    </tr>
    <tr class="bg_color4">
      <td align=right><b>Контакты <font style="color: red; font-weight: normal;">*</font>:</b></td>
      <td align=left><textarea name=contacts style="width:295px;height:50px">{if $ENV._POST.contacts}{$ENV._POST.contacts|strip_tags}{else}{$page.user.contacts}{/if}</textarea></td>
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
      <td align=left><input style="width:300px" type=file name=img1><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 2:</b></td>
      <td align=left><input style="width:300px" type=file name=img2><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
    </tr>
    <tr>
      <td align=right><b>Фото 3:</b></td>
      <td align=left><input style="width:300px" type=file name=img3><br />
      <font class=small>размер фото не должен превышать {$page.img_size} Кб.</font></td>
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
		<a href="/mail/" target=_blank>здесь</a>.</font>
	</td></tr>
<tr>
      <td align=right><b>Пароль:</b></td>
      <td width=200 align=left><input type=password name=password style=width:295px></td>
</tr>
{/if}*}

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