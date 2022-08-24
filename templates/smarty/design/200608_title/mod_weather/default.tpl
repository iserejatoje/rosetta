{if $page.error==""}
<table cellpadding=4 cellspacing=0 border="0">
<tr><td width="320" valign="top">
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{if !isset($page.cityName)}{$page.cities[$page.cid][0]}{else}{$page.cityName}{/if}</span></td>
		</tr>
	</table>
	<br>
	<table cellpadding=4 cellspacing=1 border=0>
		<tr><td align="left" colspan="2" class="block_title2"><span>&nbsp;&nbsp;Сейчас</span></td></tr>
		<tr><td class="bg_color2" width="120" align="right">Облачность:</td><td>{$page.cur.nebocap}</td></tr>
		<tr><td class="bg_color2" width="120" align="right">Температура:</td><td><font class="{if $page.cur.t>=0}t_red{else}t_black{/if}"><b>{if $page.cur.t>0}+{/if}{$page.cur.t}</b></font></td></tr>
		{if !empty($page.cur.wind_ward) || !empty ($page.cur.wind_speed)}<tr><td class="bg_color2" width="120" align="right">Ветер:</td><td>{if !empty($page.cur.wind_ward)}{$page.cur.wind_ward}<br>{/if}{if !empty($page.cur.wind_speed)}{$page.cur.wind_speed} м/с{/if}</td></tr>{/if}
		{if !empty($page.cur.humidity)}<tr><td class="bg_color2" width="120" align="right">Влажность:</td><td>{$page.cur.humidity}%</td></tr>{/if}
	</table>
</td>
<td align="right">
	{if $page.draw!=""}
	<table cellpadding=2 cellspacing=0 border="0">
		<tr><td class="text11 t_dw" align="center"><b>Прогноз изменения температуры</b></td></tr>
		<tr><td><img src="{$page.draw}" alt="" width="{$page.size.width}" height="{$page.size.height}" /></td></tr>
		<tr><td align="center" class="text11">
		{foreach from=$page.legend item=l}
			<img src="{$page.leg_dir}i_leg{$l.color}.png">&nbsp;{$l.caption}&nbsp;&nbsp;&nbsp;&nbsp;
		{/foreach}
		</td></tr>
	</table>
	{/if}
</td>
</tr>
<tr><td colspan="2">
	<br>
	<table cellpadding=4 cellspacing=1 border=0 bgcolor="#FFFFFF" width=95%>
		<tr bgcolor="#4F9AA4">
		{if !isset($page.cityName)}
		<td class="block_title2" width="500"><span>&nbsp;&nbsp;Погода в {$page.cities[$page.cid][1]} - прогноз на {$page.upmenu[$page.days].title}</span></td>
		{else}
		<td class="block_title2" width="500"><span>&nbsp;&nbsp;{$page.cityName} - прогноз на {$page.upmenu[$page.days].title}</span></td>
		{/if}
		{foreach from=$page.upmenu item=l key=k}
			{if $l.linked}
				<td bgcolor="#FFFFFF" align="center"><a href="/{$ENV.section}/weather{$k}/{$page.cid}.html">{$l.title}</a></td>
			{/if}
		{/foreach}
		</tr>
	</table>
	<table class="table" cellpadding=4 cellspacing=1 border=0 width=95% bgcolor="#FFFFFF">
		<tr class="block_title2" align="center"><th rowspan="2">Дата</th><th rowspan="2">Осадки</th><th colspan=2>Средняя температура, &deg;С</th><!--<th rowspan="2">Ветер</th>--></tr>
		<tr class="block_title2" align="center"><th>День</th><th>Ночь</th></tr>
		{excycle values="#F5F9FA,#FFFFFF"}
		{foreach from=$page.temp item=l}
			{capture name=today}{$l.date|simply_date|replace:" 00:00":""}{/capture}
			<tr align="center" bgcolor="{excycle}">
				<td><font class="t_dw">{$l.date|dayofweek:1}</font><font class="t_dt">, {if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$l.date|date_format:"%e"} {$l.date|date_format:"%m"|month_to_string:2}{/if}</font></td>
				<td><img src="{$l.nebopic}" width="19" width="19" alt="{$l.nebocap}" title="{$l.nebocap}" /></td>
				<td class="temp"><b><font class="{if $l.tday>=0}t_red{else}t_black{/if}">{if $l.tday>0}+{/if}{$l.tday}</font></b></td>
				<td class="temp"><font class="{if $l.tnight>=0}t_red{else}t_black{/if}"><b>{if $l.tnight>0}+{/if}{$l.tnight}</b></font></td>
				<!--<td></td>-->
			</tr>
		{/foreach}
	</table>
</td></tr>
</table>


<br><br>
&nbsp;&nbsp;<a href="/{$ENV.section}/weather{$page.days}/{$page.cid}-print.html" target="print{$page.cid}" onclick="window.open('about:blank', 'print{$page.cid}','width=600,height=670,resizable=1,menubar=0,scrollbars=1').focus();"><font color="red">Версия для печати</font></a>
<br><br>
<p align="left">
<font class="text11">1) Данные обновляются несколько раз в сутки.</font><br/>
{*<font class="text11">2) Прогнозы на 5 и 10 дней готовятся с использованием различных моделей атмосферы, поэтому возможны расхождения.</font><br/>*}
<font class="text11"><noindex>2) Источник данных: метеоспутники <a class="copy" href="http://{$page.src}/" target="_blank" rel="nofollow">{$page.src}</a>, <a class="copy" href="http://www.yahoo.com/" target="_blank" rel="nofollow">www.yahoo.com</a></noindex></font>
</p><br/><br/>
{else}
	<br>
	<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="3px" class="bg_color_red"><img src="/_img/x.gif" width="3" height="1" border="0" /></td>
		<td align="left" style="padding-left: 10px;">
		<b>Ошибка!</b><br /><br />
		{$page.error}
		<br />
		</td>
	</tr>
	</table>
{/if}