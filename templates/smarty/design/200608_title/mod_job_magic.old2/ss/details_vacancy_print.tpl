{$res.script}
<script language="JavaScript">
{literal}
<!--
window.print();
-->
{/literal}
</script>
{capture name="typevac"}
	<span class="t13">
	{if $res.ftype==1}(вакансия агенства){/if}
	{if $res.ftype==2}(прямой работодатель){/if}
	</span>
{/capture}

{capture name="rname"}
	Просмотр данных по вакансии {$res.vid} {$smarty.capture.typevac}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`" hide_search=true}

<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
{if $res.city}
<tr>
	<td class="bg_color2" align="right" width="130">Город</td>
	<td class="bg_color4">{$res.city}</td>
</tr>
{/if}
{if $res.region}
<tr>
	<td class="bg_color2" align='right' width="130">Место работы (район)</td>
	<td class="bg_color4">{$res.regions[$res.region].name}</td>
</tr>
{/if}
{if $res.firm}
<tr>
	<td class="bg_color2" align="right" width="130">Фирма </td>
	<td class="bg_color4">{$res.firm}</td>
</tr>
{/if}
{if $res.dolgnost}
<tr>
	<td class="bg_color2" align="right" width="130">Должность</td>
	<td class="bg_color4">{$res.dolgnost}</td>
</tr>
{/if}
{if $res.paysum}
<tr>
	<td class="bg_color2" align="right" width="130">Зарплата, руб.</td>
	<td class="bg_color4">{$res.paysum}</td>
</tr>
{/if}
{if $res.payform}
<tr>
	<td class="bg_color2" align="right" width="130">Форма оплаты</td>
	<td class="bg_color4">{$res.payform}</td>
</tr>
{/if}
{if $res.grafik}
<tr>
	<td class="bg_color2" align="right" width="130">График работы</td>
	<td class="bg_color4">{$res.grafik}</td>
</tr>
{/if}
{if $res.jtype}
<tr>
	<td class="bg_color2" align="right" width="130">Тип работы</td>
	<td class="bg_color4">{$res.jtype}</td>
</tr>
{/if}
{if $res.uslov}
<tr>
	<td class="bg_color2" align="right" width="130">Условия </td>
	<td class="bg_color4">{$res.uslov|nl2br}</td>
</tr>
{/if}
{if $res.treb}
<tr>
	<td class="bg_color2" align="right" width="130">Требования </td>
	<td class="bg_color4">{$res.treb|nl2br}</td>
</tr>
{/if}
{if $res.obyaz}
<tr>
	<td class="bg_color2" align="right" width="130">Обязанности </td>
	<td class="bg_color4">{$res.obyaz|nl2br}</td>
</tr>
{/if}
{if $res.firm_about}
<tr>
	<td class="bg_color2" align="right" width="130">О компании </td>
	<td class="bg_color4">{$res.firm_about|nl2br}</td>
</tr>
{/if}
{if $res.educat}
<tr>
	<td class="bg_color2" align="right" width="130">Образование</td>
	<td class="bg_color4">{$res.educat}</td>
</tr>
{/if}
{if $res.stage}
<tr>
	<td class="bg_color2" align="right" width="130">Стаж</td>
	<td class="bg_color4">{$res.stage}</td>
</tr>
{/if}
{if $res.lang}
<tr>
	<td class="bg_color2" align="right" width="130">Знание языков</td>
	<td class="bg_color4">{$res.lang|nl2br}</td>
</tr>
{/if}
{if $res.comp}
<tr>
	<td class="bg_color2" align="right" width="130">Знание компьютера</td>
	<td class="bg_color4">{$res.comp|nl2br}</td>
</tr>
{/if}
{if $res.baeduc}
<tr>
	<td class="bg_color2" align="right" width="130">Бизнес-образование</td>
	<td class="bg_color4">{$res.baeduc|nl2br}</td>
</tr>
{/if}
{if $res.pol}
<tr>
	<td class="bg_color2" align="right" width="130">Пол</td>
	<td class="bg_color4">{$res.pol}</td>
</tr>
{/if}
{if $res.ability}
<tr>
	<td class="bg_color2" align="right" width="130">Степень ограничения трудоспособности</td>
	<td class="bg_color4">{$res.ability}</td>
</tr>
{/if}
{if $res.phones}
<tr>
	<td class="bg_color2" align="right" width="130">Телефон</td>
	<td class="bg_color4">{$res.phones}</td>
</tr>
{/if}
{if $res.faxes}
<tr>
	<td class="bg_color2" align="right" width="130">Факс</td>
	<td class="bg_color4">{$res.faxes}</td>
</tr>
<tr>
	<td class="bg_color2" align="right" width="130">E-mail</td>
	<td class="bg_color4">{if $res.email!=""}{$res.email}{/if}</td>
</tr>
{/if}
{if $res.http}
<tr>
	<td class="bg_color2" align="right" width="130">http://</td>
	<td class="bg_color4">{if $res.http!=""}<noindex><a href="http://{$res.http|url:false}" target="_blank">{$res.http|url:false}</a></noindex>{/if}</td>
</tr>
{/if}
{if $res.addr}
<tr>
	<td class="bg_color2" align="right" width="130">Адрес</td>
	<td class="bg_color4">{$res.addr}</td>
</tr>
{/if}
</table>

<br/><div style="text-align:center"><a href='javascript:window.close()'>Закрыть</a></div><br/>