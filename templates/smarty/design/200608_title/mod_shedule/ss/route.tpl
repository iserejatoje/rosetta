{if $smarty.get.print}
	<script language="javascript">
	{literal}
	<!--
	window.print();
	-->
	{/literal}
	</script>
{/if}

<div class="title">
	Поезд {$res.vehicle.Name|truncate:4:""}<br/>
	{$res.vehicle.DepartureStation|lower|capitalize:true} &mdash; {$res.vehicle.ArrivalStation|lower|capitalize:true}
</div>
<br/>

{if !$smarty.get.print}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td><b>станции следования</b>&nbsp;&nbsp;<a href="/{$ENV.section}/graph/{$res.vehicle.VehicleID}.php">график курсирования</a></td>
	<td align="right" valign="bottom" class="text11">{if $res.date}Отправление: {$res.date}{/if}</td>
</tr>
</table>
<div align="right" class="text11" style="float:right; padding-bottom:2px">
	<a onclick="window.open('about:blank', 'rprint','width=760,height=500,resizable=1,menubar=0,scrollbars=1').focus();" href="/{$ENV.section}/route/{$res.vehicle.VehicleID}.php?print=1" target="rprint">Версия для печати</a>
</div>
{/if}
<br/>

{if isset($res.errors) && is_array($res.errors)}
	<br/><br/>
<div align="center" style="color:red"><b>
		{foreach from=$res.errors item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{else}
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="table2">
<tr>
	<th style="border-right:solid 1px white;" rowspan="2">Станция</th>
	<th align="center" colspan="2" style="border-right:solid 1px white;padding-bottom:0px;" nowrap>Прибытие</th>
	<th style="border-right:solid 1px white;" rowspan="2">Стоянка</th>
	<th align="center" colspan="2" style="border-right:solid 1px white;padding-bottom:0px;" nowrap>Отправление</th>
	<th rowspan="2">Время в пути</th>
</tr>
<tr>
	<th align="right" style="padding-top:0px;" nowrap>(Мск.</th>
	<th align="left" style="border-right:solid 1px white;padding-top:0px;" nowrap>| Местное.)</th>
	<th align="right" style="padding-top:0px;" nowrap>(Мск.</th>
	<th align="left" style="border-right:solid 1px white;padding-top:0px;" nowrap>| Местное.)</th>
</tr>
{excycle values=" ,bg_color4"}
{foreach from=$res.route item=l name=route}
	<tr class="{excycle}">			
		<td style="padding-left:50px; border-right:solid 1px white; background: transparent url(/_img/modules/shedule/icons/station_{if $smarty.foreach.route.first && !$smarty.foreach.route.last}start{$l.CitySign}{/if}{if $smarty.foreach.route.last}end{$l.CitySign}{else}{if !$smarty.foreach.route.first}{$l.CitySign}{/if}{/if}.png) no-repeat scroll 15px 50%;"><a href="/{$ENV.section}/station/{$l.StationID}.php">{$l.Name|lower|capitalize:true}</a></td>
		<td align="right" nowrap>{if $l.ArrivalDate}{$l.ArrivalDate}{/if} {$l.ArrivalTime}</td>
		<td align="left" nowrap>{if $l.ArrivalLocTime}| <span style="color:#999999">{$l.ArrivalLocTime}</span>{/if}</td>
		<td style="border-left:solid 1px white; border-right:solid 1px white;" nowrap>{$l.StationTime}</td>
		<td align="right" nowrap>{if $l.DepartureDate}{$l.DepartureDate}{/if} {$l.DepartureTime}</td>
		<td align="left" nowrap>{if $l.DepartureLocTime}| <span style="color:#999999">{$l.DepartureLocTime}</span>{/if}</td>
		<td style="border-left:solid 1px white;" nowrap>{$l.TimeInPath}</td>
	</tr>
{/foreach}
</table>
{/if}
<br/>
<br/>