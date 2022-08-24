{if !$smarty.get.print}
	{include file="`$TEMPLATE.sectiontitle`"}
{else}
	<script language="javascript">
	{literal}
	<!--
	window.print();
	-->
	{/literal}
	</script>
{/if}

<div class="title">Расписание поездов для станции &laquo;{$res.station.Name|lower|capitalize:true}&raquo;</div>

<br/>
<table border="0" cellspacing="1" cellpadding="3">
{if $res.station.Address}<tr><td class="bg_color2">Адрес</td><td class="bg_color4">{$res.station.Address}</td></tr>{/if}
{*if $res.station.GoogleMapsUrl}<tr><td class="bg_color2"></td><td class="bg_color4"><a href="{$res.station.GoogleMapsUrl}" target="_blank">Показать на карте</a></td></tr>{/if*}
{if $res.station.Phones}<tr><td class="bg_color2">Телефон</td><td class="bg_color4">{$res.station.Phones}</td></tr>{/if}
</table>
<br/>

{if !$smarty.get.print}
<div>
	{if $res.date!=$res.today}<a href="/{$ENV.section}/station/{$res.today}/{$res.station.StationID}.php" title="Показать расписание движения на сегодня">{else}<b>{/if}сегодня{if $res.date!=$res.today}</a>{else}</b>{/if}&nbsp;&nbsp;
	{if $res.date!=$res.tomorrow}<a href="/{$ENV.section}/station/{$res.tomorrow}/{$res.station.StationID}.php" title="Показать расписание движения на завтра">{else}<b>{/if}завтра{if $res.date!=$res.tomorrow}</a>{else}</b>{/if}&nbsp;&nbsp;
	{if $res.date!=$res.aftertomorrow}<a href="/{$ENV.section}/station/{$res.aftertomorrow}/{$res.station.StationID}.php" title="Показать расписание движения на послезавтра">{else}<b>{/if}послезавтра{if $res.date!=$res.aftertomorrow}</a>{else}</b>{/if}&nbsp;&nbsp;
</div>
{/if}
<br/>

{if isset($res.errors) && is_array($res.errors)}
	<br/><br/><div align="center" style="color:red"><b>
		{foreach from=$res.errors item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{else}
<table border="0" cellspacing="0" cellpadding="5" width="100%">
	<tr>
		{if !$smarty.get.print}
			{if $smarty.get.act=="arrival"}
			<td class="shedule_tab" id="tab_departure"><a href="/{$ENV.section}/station/{$res.station.StationID}.php?act=departure" onclick="mod_shedule.actTab('departure'); return false;">Отправление</a></td>
			<td class="shedule_tab_selected" id="tab_arrival"><a href="/{$ENV.section}/station/{$res.station.StationID}.php?act=arrival" onclick="mod_shedule.actTab('arrival'); return false;">Прибытие</a></td>
			{else}
			<td class="shedule_tab_selected" id="tab_departure"><a href="/{$ENV.section}/station/{$res.station.StationID}.php?act=departure" onclick="mod_shedule.actTab('departure'); return false;">Отправление</a></td>
			<td class="shedule_tab" id="tab_arrival"><a href="/{$ENV.section}/station/{$res.station.StationID}.php?act=arrival" onclick="mod_shedule.actTab('arrival'); return false;">Прибытие</a></td>
			{/if}
		{/if}
		<td class="shedule_tab" width="100%" align="right"><span class="text11">{if $smarty.get.act=='departure'}Отправление: {elseif $smarty.get.act=='arrival'}Прибытие: {/if}{$res.date|date_format:"%d.%m.%Y"}</span></td>
	</tr>
	<tr>
		<td class="shedule_panel" colspan="3">
			<div id="shedule_table_departure"{if $smarty.get.act=="arrival"} style="display:none"{/if}>
				{if !$smarty.get.print}
					<div align="right" class="text11" style="padding-bottom:2px">
						<a onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();" href="/{$ENV.section}/station/{$res.station.StationID}.php?act=departure&print=1" target="rprint">Версия для печати</a>
					</div>
				{/if}
				<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table2">
					<tr>
						<th>Номер поезда</th>
						<th>Маршрут</th>
						<th>Отправление</th>
					</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.shedule.departure item=l}
					{if $smarty.get.all || !$l.Old}
					<tr class="{excycle}">
						<td align="center"><a href="/{$ENV.section}/route/{$l.VehicleID}.php" title="Станции следования поезда">{if $l.Old==1}<span class="shedule_old">{/if}{$l.Name}{if $l.Old==1}</span>{/if}</a></td>
						<td width="100%"><a href="/{$ENV.section}/route/{$l.VehicleID}.php" title="Станции следования поезда">{if $l.Old==1}<span class="shedule_old">{/if}{$l.DepartureStation|lower|capitalize:true} &mdash; {$l.ArrivalStation|lower|capitalize:true}{if $l.Old==1}</span>{/if}</a></td>
						<td class="text11" align="right" nowrap>
							{if $l.Old==1}<span class="shedule_old">{/if}{$l.DepartureDate}{if $l.Old==1}</span>{/if} <span {if $l.Old==1}<span class="shedule_old"{else}style="color:red"{/if}><b>{$l.DepartureTime}</b></span>
						</td>
					</tr>
					{/if}
				{/foreach}
				</table>
			</div>
			<div id="shedule_table_arrival"{if $smarty.get.act=="arrival"} style="display:block"{else} style="display:none"{/if}>
				{if !$smarty.get.print}
					<div align="right" class="text11" style="padding-bottom:2px">
						<a onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();" href="/{$ENV.section}/station/{$res.station.StationID}.php?act=arrival&print=1" target="rprint">Версия для печати</a>
					</div>
				{/if}
				<table border="0" cellspacing="1" cellpadding="0" width="100%" class="table2">
					<tr>
						<th>Номер поезда</th>
						<th>Маршрут</th>
						<th>Прибытие</th>
					</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.shedule.arrival item=l}
					{if $smarty.get.all || !$l.Old}
					<tr class="{excycle}">
						<td align="center"><a href="/{$ENV.section}/route/{$l.VehicleID}.php" title="Станции следования поезда">{if $l.Old==1}<span class="shedule_old">{/if}{$l.Name}{if $l.Old==1}</span>{/if}</a></td>
						<td width="100%"><a href="/{$ENV.section}/route/{$l.VehicleID}.php" title="Станции следования поезда">{if $l.Old==1}<span class="shedule_old">{/if}{$l.DepartureStation|lower|capitalize:true} &mdash; {$l.ArrivalStation|lower|capitalize:true}{if $l.Old==1}</span>{/if}</a></td>
						<td class="text11" align="right" nowrap>
							{if $l.Old==1}<span class="shedule_old">{/if}{$l.ArrivalDate}{if $l.Old==1}</span>{/if} <span {if $l.Old==1}<span class="shedule_old"{else}style="color:red"{/if}><b>{$l.ArrivalTime}</b></span>
						</td>
					</tr>
					{/if}
				{/foreach}
				</table>
			</div>
		</td>
	</tr>
</table>
{/if}
<br/>
<br/>