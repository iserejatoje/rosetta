{capture name="rname"}
	Редактирование вакансии {$data.vid}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
<script language="JavaScript">
{literal}
<!--
  function isempty(str)
  {
    if(str.match(/\S+/) ) {
      return false;
    } else {
      return true;
    }
  }
  function CheckVacForm(frm)
  {
    if(isempty(frm.firm.value)) {
      alert("Поле ФИРМА должно быть заполнено.");
      frm.firm.focus();
      return false;
    }
    if(isempty(frm.dol.value)) {
      alert("Поле ДОЛЖНОСТЬ должно быть заполнено.");
      frm.dol.focus();
      return false;
    }
    if(isempty(frm.pay.value)) {
      alert("Поле ЗАРПЛАТА должно быть заполнено.");
      frm.pay.focus();
      return false;
    }
    if(isempty(frm.phone.value) && isempty(frm.email.value) && isempty(frm.addr.value)) {
      alert("Обязательно заполните одно из полей: ТЕЛЕФОН, EMAIL или АДРЕС.");
      frm.phone.focus();
      return false;
    }
    return true;
  }
function RegForm(str)
{
  window.open("http://74.ru/job/job?cmd=jobreg" + "&forma=" + str, "jreg", "menubar=no, status=no, scrollbars=no, toolbar=no, top=20, left=20, width=400,height=400");
}

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
<form name=edvac method=post>
<input type=hidden name=cmd value=updvac>
<input type=hidden name=id value="{$data.vid}">
<table cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' width=90%>
<tr><td>
<table cellpadding=4 cellspacing=1 border=0 width=100%>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Город</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>{$data.city}</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Фирма:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=firm class=in size=40 value='{$data.firm|escape}' style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Раздел:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="razdel" size="1">{$data.arazdel}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Должность:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=dol class=in size=40 value="{$data.dol|escape}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Зарплата:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=pay class=in size=10 value="{$data.pay}">&nbsp;&nbsp;руб.</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Форма оплаты:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class="in" name="payform" size=1>{$data.apayform}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>График работы:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=grafik size=1>{$data.agrafik}</select></td></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Тип работы:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=type size=1>{$data.atype}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Условия:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=uslov class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.uslov}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Образование:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=educ size=1 style="width:100%">{$data.aeduc}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Стаж от:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=stage class=in size=4 value="{$data.stage}"> лет</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание языков:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=lang class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.lang}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание компьютера:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name=comp class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.comp}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Бизнес-образование:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><textarea name="baeduc" class=in cols=40 rows=4 wrap=virtual style="width:100%">{$data.baeduc}</textarea></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Пол:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=pol size=1>{$data.apol}</select></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Степень ограничения трудоспособности:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=in name=ability size=1>
{foreach from=$data.ability item=a key=_k}
<option value="{$_k}" {if $_k == $data._ability}selected{/if}>{$a}</option>
{/foreach}
</select><br/>
<span style="color:#808080">I степень - физический и умственный труд с небольшими ограничениями;</br>
II степень - физический труд с ограничениями, умственный - без ограничений;<br/>
III степень - невозможно заниматься тяжелым умственным или физическим
трудом;</span>
</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Адрес:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=addr class=in size=40 value="{$data.addr}" style="width:100%"></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Телефон:</td>
<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=phone class=in size=40 value="{$data.phone}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span></td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Факс:</td>
<td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input name=fax class=in size=40 value="{$data.fax}" style="width:100%">
<span style="color:#808080">должен состоять из символов , 0-9, -, ( ) и пробел</span>
</td></tr>
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

<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Размещать&nbsp;до:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'>{$data.vdate}</td></tr>
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Продлить размещение на:</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><select class=t7 name=srok size=1><option value=0>не продлять<option value=7>1 неделя<option value=14>2 недели<option value=31>1 месяц<option value=61>2 месяца</select></td></tr>
{if $data.ftype>0}
<tr><td class='t1' align='right' bgcolor='#DEE7E7' width=130>Не отображать на сайте</td><td colspan="2" class='t7' align='left' bgcolor='#F6FBFB'><input type='checkbox' name='hide' class='in' value="checked" {if $data.hide>0}checked{/if}></td></tr>
{/if}
</table></td></tr></table><br><input type=submit value=Изменить class="in">&nbsp;&nbsp;&nbsp;<input type=reset value=Сброс class="in"></form></center>