{capture name="typevac"}
	<font class="s1">
	{if $vac.ownvac==1}(вакансия агенства){/if}
	{if $vac.ownvac==2}(прямой работодатель){/if}
	</font>
{/capture}
{capture name="rname"}
{if $vac.page=="putvac"}
	Вы разместили новую вакансию {$vac.id} {$smarty.capture.typevac}
{else}
	Просмотр данных по вакансии {$vac.id} {$smarty.capture.typevac}
{/if}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>
<center><table cellpadding=0 cellspacing=0 border=0 bgcolor='#FFFFFF' width=100%>
<tr><td>
<table cellpadding=4 cellspacing=1 border=0 width=100%>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Город</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.city}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Фирма </td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>
	{if isset($vac.fid) && $vac.fid > 0}<a href="?cmd=firmvac&id={$vac.fid}" title="Полный список вакансий этой компании">{$vac.firm}</a>
				  {if $vac.file_name}<br/><a href="?cmd=firmvac&id={$vac.fid}" title="Полный список вакансий этой компании"><img vspace="2" src="{$vac.file_name}" alt="{$vac.firm}" border="0"/></a>{/if}
				  {else}{$vac.firm}{/if}
	</td>
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
	<td class='t7' align='left' bgcolor='#F6FBFB'>{if $vac.http!=""}<noindex><a href="http://{$vac.http}" target="_blank">{$vac.http|trim:" / "}</a></noindex>{/if}</td>
</tr>
<tr>
	<td class='t1' align='right' bgcolor='#DEE7E7' width=130>Адрес</td>
	<td class='t7' align='left' bgcolor='#F6FBFB'>{$vac.addr}</td>
</tr>
{if $CURRENT_ENV.regid ==74 && $vac.page=="putvac" && ($vac.rid==1 || $vac.rid==11 || $vac.rid==21 || $vac.rid==22)}
<tr>
	<td colspan='2'>
		<p align=center> Вы добавили вакансию в рубрику
&quot;{$vac.jrname}&quot;. Она будет размещена на сайте <a href="http://chel.ru">www.chel.ru</a>.
Посмотреть вакансию можно <a href="http://chel.ru/job/index.php?rid={$vac.rid}&cmd=showvac&id={$vac.id}" target="_blank">здесь</a>.</p>
	</td>
</tr>
{/if}
{if $vac.page!="putvac"}
<tr>
	<td align="left">{if $vac.previd!=0}<a href="?cmd=showvac&id={$vac.previd}{$vac.params}" class="s1">предыдущая</a>{/if}</td>
	<td align="right">{if $vac.nextid!=0}<a href="?cmd=showvac&id={$vac.nextid}{$vac.params}" class="s1">следующая</a>{/if}</td>
</tr>
{/if}
{*if $res.page != "putvac"}
<tr>
	<td align="center" colspan="2"><a class="s1" href="/{$CURRENT_ENV.section}/?cmd=vprint&id={$vac.id}&rid={$vac.rid}" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">версия для печати</a></td>
</tr>
{/if*}
</table></td></tr></table></center><br>
{include file="`$TEMPLATE.midbanner`"}
<br><br>

{*
<center>
<!-- форма mail.ru -->
<script language="JavaScript"> 
{literal}
<!-- 
	var jar=new Date(); 
	var s=jar.getSeconds(); 
	var m=jar.getMinutes(); 
	document.write("<scr"+"ipt language='JavaScript' src='http://r.mail.ru/cgi-bin/banners/js/3020?"+m+s+"'></scr"+"ipt>"); 
//-->
{/literal}
</script>
<!-- end mail.ru-->
</center>
*}