<html>
<head>
<title>Погода {$page.cities[$page.cid][0]} - Прогноз на {$page.upmenu[$page.days].title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="/_styles/design/200608_title/common/styles.css" />
<link rel="stylesheet" type="text/css" href="/_styles/mod_weather.css" />
</head>
<body bgcolor="#FFFFFF" text="#666666" leftmargin="10" topmargin="5" marginwidth="10" marginheight="5" onload="window.print();">
<div style="padding: 5px 10px 5px 10px;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="place_title"><span>{$page.cities[$page.cid][0]}</span></td>
</tr>
</table>
<br>
{if $page.cur.t!=""}
<table cellpadding=4 cellspacing=1 border=0 width="400">
<tr><td align="left" colspan="2" class="block_title2"><span>&nbsp;&nbsp;Сейчас</span></td></tr>
<tr><td class="bg_color2" width="120" align="right">Облачность:</td><td>{$page.cur.nebocap}</td></tr>
<tr><td class="bg_color2" width="120" align="right">Температура:</td><td><font class="{if $page.cur.t>=0}t_red{else}t_black{/if}"><b>{if $page.cur.t>0}+{/if}{$page.cur.t}</b></font></td></tr>
<tr><td class="bg_color2" width="120" align="right">Ветер:</td><td>{$page.cur.wind_ward}<br>{$page.cur.wind_speed} м/с</td></tr>
<tr><td class="bg_color2" width="120" align="right">Влажность:</td><td>{$page.cur.humidity}%</td></tr>
</table>
{/if}
<br><br>
<table cellpadding=4 cellspacing=1 border=0 bgcolor="#FFFFFF" width=550>
<tr bgcolor="#4F9AA4">
<td class="block_title2" width="400"><span>&nbsp;&nbsp;Прогноз погоды на {$page.upmenu[$page.days].title}</span></td>
</tr>
</table>
<table class="table" cellpadding=4 cellspacing=1 border=0 width=550 bgcolor="#FFFFFF">
<tr class="block_title2" align="center"><th rowspan="2">Дата</th><th rowspan="2">Осадки</th><th colspan=2>Средняя температура, &deg;С</th></tr>
<tr class="block_title2" align="center"><th>День</th><th>Ночь</th></tr>
{foreach from=$page.temp item=l}
<tr align="center"><td><font class="t_dw">{$l.date|dayofweek:1}</font><font class="t_dt">, {$l.date|date_format:"%e"} {$l.date|date_format:"%m"|month_to_string:2}</font></td><td><img src="{$l.nebopic}" width="19" width="19" alt="{$l.nebocap}" title="{$l.nebocap}" /></td><td><b><font class="{if $l.tday>=0}t_red{else}t_black{/if}">{if $l.tday>0}+{/if}{$l.tday}</font></b></td><td><font class="{if $l.tnight>=0}t_red{else}t_black{/if}"><b>{if $l.tnight>0}+{/if}{$l.tnight}</b></font></td></tr>
{/foreach}
</table>
<br>
<p align="left">
<font class="text11">1) Данные обновляются несколько раз в сутки.</font><br/>
<font class="text11">2) Источник данных: метеоспутники <a class="copy" href="http://{$page.src}/" target="_blank">{$page.src}</a>, <a class="copy" href="http://www.yahoo.com/" target="_blank">www.yahoo.com</a></font>
</p>
</div>
</body>
</html>