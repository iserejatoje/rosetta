{*изменено по требованию Россвязьнадзор*}
{capture name="rname"}
	Редактирование резюме {$data.resid}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
<script language="JavaScript">
{literal}
<!--
function addEmailField() {

	var list = document.getElementById('email_list');
	
	fold = document.createElement('span');
	fold.innerHTML = ''+
	'<input name="email[]" class="in" size="40" value="" style="width:95%">'+
	'<a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif" border="0" alt="Удалить E-Mail"/></a></br>';
	list.appendChild(fold);
}

//-->
{/literal}
</script>
<center>
    <form name=editresume method=post enctype="multipart/form-data">
    <input type=hidden name=cmd value=updres>
    <input type=hidden name=id value='{$data.resid}'>
    <table cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' width=90%>
    <tr><td>
    <table cellpadding=4 cellspacing=1 border=0 width=100%>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Город</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>{$data.city}</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Имя{*ФИО*}:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=fio class=in size=40 value='{$data.fio}' style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Раздел:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="razdel" size="1" style="width:100%">{$data.arazdel}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Претендуемая должность:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=dol class=in size=40 value="{$data.dol}"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Зарплата:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=pay class=in size=10 value="{$data.pay}">&nbsp;&nbsp;руб.</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>График работы:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=grafik size=1>{$data.agrafik}</select></td></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Тип работы:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=type size=1>{$data.atype}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Образование:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=educ size=1>{$data.aeduc}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Учебное заведение:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=uzav class=in size=40 value='{$data.uzav}' style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Стаж от:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=stage class=in size=4 value="{$data.stage}"> лет</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Места предыдущей работы:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=prab class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.prab}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание языков:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=lang class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.lang}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание компьютера:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=comp class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.comp}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Бизнес-образование:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name="baeduc" class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.baeduc}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Дополнительные сведения:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=dsved class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.dsved}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Важность:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>
<select class=in name=imp_type size=1>
<option value="0" {if $data.imp_type == 0}selected{/if}>Нет</option>
<option value="1" {if $data.imp_type == 1}selected{/if}>Срочно</option>
<option value="2" {if $data.imp_type == 2}selected{/if}>Не очень срочно</option>
<option value="3" {if $data.imp_type == 3}selected{/if}>Сейчас работаю, но интересный вариант готов рассмотреть</option>
</select>
</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Пол:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=pol size=1>{$data.apol}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Степень ограничения трудоспособности:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=ability size=1>
{foreach from=$data.ability item=a key=_k}
<option value="{$_k}" {if $_k == $data._ability}selected{/if}>{$a}</option>
{/foreach}
</select><br/><span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Возраст:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=age class=in size=40 value='{$data.age}'></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Адрес:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=addr class=in size=40 value="{$data.addr}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Телефон дом.:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=teld class=in size=40 value="{$data.teld}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Телефон раб.:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=telr class=in size=40 value="{$data.telr}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Факс:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=fax class=in size=40 value="{$data.fax}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>http://</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=www class=in size=40 value="{$data.http}" style="width:100%"></td></tr>

<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130 rowspan="2">E-mail:</td>
	<td bgcolor='#F6FBFB' width="100%" align="right"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><img src="/img/20061008_2pages/bullet_add.gif" border="0" alt="Добавить E-Mail"/></a></td>
	<td bgcolor='#F6FBFB' nowrap="nowrap"><a href="javascript:void(0)" onclick="addEmailField()" title="Добавить E-Mail"><small>Добавить&#160;E-Mail</small></a></td>
</tr>
<tr>
	<td colspan="2" id="email_list" class='t7' align='left' bgcolor='#F6FBFB' nowrap="nowrap">
		{if is_array($data.email)}
		{foreach from=$data.email item=mail}
			<span>
				<input name="email[]" class="in" size="40" value="{$mail|trim}" style="width:95%"><a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif" border="0" alt="Удалить E-Mail"/></a></br>
			</span>
		{/foreach}
	{else}
		<span>
			<input name="email[]" class="in" size="40" value="{$mail|trim}" style="width:95%"><a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" title="Удалить E-Mail"><img src="/img/20061008_2pages/bullet_delete.gif" border="0" alt="Удалить E-Mail"/></a></br>
		</span>
	{/if}
	</td>
</tr>

<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7'>Фото</td>
	<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>{if !empty($data.photo.file)}<img src="{$data.photo.file}" alt="{$data.fio}" width="{$data.photo.w}" height="{$data.photo.h}" align="left"><input type="checkbox" class="in" name="delphoto" value="checked">&nbsp;&nbsp;Удалить<br/><br/>{/if}<input size=30 type=file name="photo" value=""><br>JPG файл размером не более 1,5Мб</td>
</tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Размещать&nbsp;до:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>{$data.vdate}</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Продлить размещение на:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=t7 name=srok size=1><option value=0>не продлять<option value=7>1 неделя<option value=14>2 недели<option value=31>1 месяц<option value=61>2 месяца</select></td></tr>
</table>
    </td></tr></table>
    <br><input type=submit value=Изменить class="in">&nbsp;&nbsp;&nbsp;
    <input type=reset value=Сброс class="in">
    </form>
    </center>
