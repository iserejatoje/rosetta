{*изменено по требованию Россвязьнадзор*}
{include file="`$TEMPLATE.sectiontitle`" rtitle="Новое резюме"}
<script language="JavaScript">
{literal}
<!--

function addEmailField() {

	var list = document.getElementById('email_list');
	
	fold = document.createElement('span');
	fold.innerHTML = ''+
	'<input name="email[]" class="in" size="40" value="" style="width:95%">'+
	'<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif"  hspace="4" border="0" alt="Удалить E-Mail"/></a></br>';
	list.appendChild(fold);
}

//-->
{/literal}
</script>
<center>
<form name=blankob method=post onSubmit='return CheckResForm(this)' {if $uid!=0}enctype="multipart/form-data"{/if}>
<input type=hidden name=cmd value=putres>
<table cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' width=90%>
<tr><td><table cellpadding=4 cellspacing=1 border=0 width=100% >
<tr>
	<td class='t1' align='center' bgcolor='#DEE7E7' colspan=3>Информация о резюме</td>
</tr>
<tr>	
	<td class='t1' align='right' bgcolor='#e9efef'>Город</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="city" size="1">{$data.gor}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Другой</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=gorod class=t7 size=40 maxlength=255 value="{$data.acity}" style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Имя{*ФИО*}</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input class=t7 type=text name=fio value="{$data.fio|escape}" size=40 maxlength=255 style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Раздел</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="razdel" size="1">{$data.arazdel}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Претендуемая должность</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='dol' size=40 class=t7 maxlength=50 style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Зарплата</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='pay' class=t7 size=10 maxlength=22>&nbsp;&nbsp;руб.</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>График работы</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=grafik size=1>{$data.agrafik}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Тип работы</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=type size=1>{$data.atype}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Образование</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=educ size=1>{$data.aeduc}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Учебное заведение</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input class=t7 type=text name=uzav size=40 maxlength=255 style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Стаж</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='stage' class=t7 size=4> лет</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Предыдущая работа</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea class=t7 name=prab cols=45 rows=7 wrap=virtual style="width:100%"></textarea></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Знание языков</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name='lang' class=t7 cols=45 rows=4 wrap=virtual style="width:100%"></textarea></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Знание компьютера</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea class=t7 name='comp' cols=45 rows=4 wrap=virtual style="width:100%"></textarea></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Бизнес-образование</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea class=t7 name='baeduc' cols=45 rows=4 wrap=virtual style="width:100%"></textarea></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Дополнительные сведения</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=dsved class=t7 cols=45 rows=5 wrap=virtual style="width:100%">{$data.dopsv}</textarea></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Важность</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>
	<select class=in name=imp_type size=1>
<option value="0" {if $data.imp_type == 0}selected{/if}>Нет</option>
<option value="1" {if $data.imp_type == 1}selected{/if}>Срочно</option>
<option value="2" {if $data.imp_type == 2}selected{/if}>Не очень срочно</option>
<option value="3" {if $data.imp_type == 3}selected{/if}>Сейчас работаю, но интересный вариант готов рассмотреть</option>
</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Пол</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=pol size=1>{$data.apol}</select></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Степень ограничения трудоспособности</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=ability size=1>{foreach from=$data.ability item=a key=_k}
<option value="{$_k}" >{$a}</option>
{/foreach}</select><br/><span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Возраст</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input type=text class=t7 name=age size=3 maxlength=3></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Адрес</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='adres' class=t7 value="{$data.addr|escape}" size=40 maxlength=255 style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Телефон домашний</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input type=text class=t7 name=teld value="{$data.phoneh|escape}" size=40 maxlength=255 style="width:100%">
	<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Телефон рабочий</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input type=text class=t7 name=telr value="{$data.phoner|escape}" size=40 maxlength=255 style="width:100%">
	<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Факс</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='fax' class=t7 size=40 value="{$data.fax|escape}" maxlength=255 style="width:100%">
	<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>http://</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name='www' class=t7 value="{$data.www}" size=40 maxlength=255 style="width:100%"></td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#e9efef' width=130 rowspan="2">E-mail:</td>
	<td bgcolor='#F6FBFB' width="100%" align="right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/img/20061008_2pages/bullet_add.gif" hspace="4" border="0" alt="Добавить E-Mail"/></a></td>
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
	{/if}</span>
		Бесплатный почтовый ящик <font class=s3>ваше_имя@{$GLOBAL.domain}</font> можно получить <a href='http://{$GLOBAL.domain}/mail/reg.php' target=_blank class='s1'>здесь</a>.
	</td>
</tr>
{if $uid!=0}
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Фото (JPG файл размером не более 1,5Мб)</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input size=30 type=file name="photo" value="" style="width:100%"></td>
</tr>
{/if}
<tr>
	<td class='t1' align='right' bgcolor='#e9efef'>Срок размещения</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=srok size=1>{$data.asrok}</select></td>
</tr>
{*<tr>
	<td class='t1' align='right' bgcolor='#E9EFEF'>Защита от роботов</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><img src="/_ar/pic.gif?{$data.ar.sar_id}" align="absmiddle" width='150' height='50' alt='код' border=0> &gt;&gt; <input type='text' name="antirobot" size=20 class="text_edit" style="width:80px;">{$data.ar.sar_code}<br />Введите четырехзначное число, которое Вы видите на картинке</td>
</tr>*}

</table></td></tr></table><br>
<input type=submit value='Разместить' class='in' width=150>&nbsp;&nbsp;&nbsp;<input type=reset  value='  Сброс   ' class='in'>
</form><br></center>
{include file="`$TEMPLATE.midbanner`"}