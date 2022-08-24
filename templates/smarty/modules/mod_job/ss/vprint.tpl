{$block_script}
<script language="JavaScript">
{literal}
<!--
window.print();
-->
{/literal}
</script>
{capture name="typevac"}
	<font class="s1">
	{if $vac.ownvac==1}(вакансия агенства){/if}
	{if $vac.ownvac==2}(прямой работодатель){/if}
	</font>
{/capture}
{capture name="rname"}
	<b>Просмотр данных по вакансии {$vac.id}</b> {$smarty.capture.typevac}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}

<table cellpadding=0 cellspacing=0 border=0 align="center" width=100%>
<tr><td>
<table cellpadding=4 cellspacing=1 border=0 width=100%>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Город</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.city}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Фирма </td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.firm}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Должность</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.dol}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Зарплата, руб.</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.pay}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Форма оплаты</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.pform}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>График работы</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.grafik}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Тип работы</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.type}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Условия </td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.uslov}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Образование</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.educ}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Стаж</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.stage}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание языков</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.lang}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Знание компьютера</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.comp}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Бизнес-образование</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.baeduc}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Пол</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.pol}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Степень ограничения трудоспособности</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.ability}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Телефон </td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.phone}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Факс  </td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.fax}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Е-мейл</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{if $vac.email!=""}{$vac.email}{/if}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>http://</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{if $vac.http!=""}<a href="http://{$vac.http}" target="_blank">{$vac.http|trim:" / "}</a>{/if}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Адрес</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.addr}</td>
</tr>
</table></td></tr></table>
<p align=center><a href='javascript:window.close()'>Закрыть</a></p><br>