{include file="`$TEMPLATE.sectiontitle`" rtitle="Новая вакансия"}
<script language="JavaScript">
{literal}
<!--

function addEmailField() {

	var list = document.getElementById('email_list');
	
	fold = document.createElement('span');
	fold.innerHTML = ''+
	'<input name="email[]" class="in" size="40" value="" style="width:95%">'+
	'<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif" hspace="4" border="0" alt="Удалить E-Mail"/></a></br>';
	list.appendChild(fold);
}

//-->
{/literal}
</script>
<center><form name=blankob method=post onSubmit='return CheckVacForm(this)'>
<input type=hidden name=cmd value=putvac>
<table cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' width=90%><tr><td>
<table cellpadding=4 cellspacing=1 border=0 width=100%>
<tr><td class='t1' align='center' bgcolor='#DEE7E7' colspan=3>Информация о вакансии</td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Раздел</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="razdel" size="1">{$data.arazdel}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Должность</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='dol' size=40 class=t7 maxlength=50 style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Зарплата</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='pay' class=t7 size=10 maxlength=22>&nbsp;&nbsp;руб.</td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Форма оплаты</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="payform" size=1>{$data.apayform}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Тип работы</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=type size=1>{$data.atype}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>График работы</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=grafik size=1>{$data.agrafik}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Условия</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name='uslov' class=t7 cols=40 rows=4 wrap=virtual style="width:100%"></textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Образование</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=educ size=1>{$data.aeduc}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Стаж от</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='stage' class=t7 size=4> лет</td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Знание языков</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name='lang' class=t7 cols=40 rows=4 wrap=virtual style="width:100%"></textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Знание компьютера</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea class=t7 name='comp' cols=40 rows=4 wrap=virtual style="width:100%"></textarea></td></tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Бизнес-образование</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea class=t7 name='baeduc' cols=45 rows=4 wrap=virtual style="width:100%"></textarea></td>
</tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Пол</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=pol size=1>{$data.apol}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Степень ограничения трудоспособности</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=ability size=1>
{foreach from=$data.ability item=a key=_k}
<option value="{$_k}" >{$a}</option>
{/foreach}
</select><br/><span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Срок размещения</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=srok size=1>{$data.asrok}</select></td></tr>
<tr><td class='t1' align='center' bgcolor='#DEE7E7' colspan=3>Контактная информация</td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Компания</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=firm class=t7 size=40 value="{$data.fname|escape}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Город</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="city" size="1" style="width:100%">{$data.gor}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Другой</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=gorod class=t7 size=40 value="{$data.acity}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Адрес</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='addr' class=t7 size=40 value="{$data.addr|escape}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Телефон</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='phone' class=t7 size=40 value="{$data.phone|escape}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Факс</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='fax' class=t7 size=40 value="{$data.fax|escape}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#E9EFEF'>http://</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='www' class=t7 size=40 value="{$data.www}" style="width:100%"></td></tr>
<tr>
	<td class='t1' align='right' bgcolor='#E9EFEF' width=130 rowspan="2">E-mail:</td>
	<td bgcolor='#F6FBFB' width="100%" align="right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/img/20061008_2pages/bullet_add.gif" border="0" hspace="4" alt="Добавить E-Mail"/></a></td>
	<td bgcolor='#F6FBFB' nowrap="nowrap"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a></td>
</tr>
<tr>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB' nowrap="nowrap">
	<span id="email_list">
	{if is_array($data.email)}
		{foreach from=$data.email item=mail key=_k}
			<span>
				<input name="email[]" class="in" size="40" value="{$mail|trim}" style="width:95%">{if $_k > 0}<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif" hspace="4" border="0" alt="Удалить E-Mail"/></a>{/if}</br>
			</span>
		{/foreach}
	{else}
		<span>
			<input name="email[]" class="in" size="40" style="width:95%"></br>
		</span>
	{/if}
	</span>
Бесплатный почтовый ящик <font class=s3>ваше_имя@{$GLOBAL.domain}</font> можно получить <a href="http://{$GLOBAL.domain}/mail/reg.php" target=_blank class='s1'>здесь</a>.
	</td>
</tr>
{*<tr><td class='t1' align='right' bgcolor='#E9EFEF'>Защита от роботов</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><img src="/_ar/pic.gif?{$data.ar.sar_id}" align="absmiddle" width='150' height='50' alt='код' border=0> &gt;&gt; <input type='text' name="antirobot" size=20 class="text_edit" style="width:80px;">{$data.ar.sar_code}<br />Введите четырехзначное число, которое Вы видите на картинке</td></tr>*}
</table></td></tr></table><br><input type=submit value='Разместить' class='in' width=150>&nbsp;&nbsp;&nbsp;<input type=reset  value='  Сброс   ' class='in'></form></form></center>
{include file="`$TEMPLATE.midbanner`"}