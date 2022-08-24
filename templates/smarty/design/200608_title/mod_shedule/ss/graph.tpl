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
	{$res.vehicle.DepartureStation|lower|capitalize:true} &mdash; {$res.vehicle.ArrivalStation|lower|capitalize:true}<br/>
	{$res.year} год
</div>
<br/>

{if !$smarty.get.print}
	<div style="float:left"><a href="/{$ENV.section}/route/{$res.vehicle.VehicleID}.php">станции следования</a>&nbsp;&nbsp;<b>график курсирования</b></div>
	<div align="right" class="text11" style="float:right; padding-bottom:2px">
		<a onclick="window.open('about:blank', 'rprint','width=760,height=500,resizable=1,menubar=0,scrollbars=1').focus();" href="/{$ENV.section}/graph/{$res.vehicle.VehicleID}.php?print=1" target="rprint">Версия для печати</a>
	</div>
	<div style="clear:both">
		<a href="/{$ENV.section}/graph/{$res.vehicle.VehicleID}.php?year={$res.prev_year}">{$res.prev_year} год</a>&nbsp;&nbsp;
		<b>{$res.year} год</b>&nbsp;&nbsp;
		<a href="/{$ENV.section}/graph/{$res.vehicle.VehicleID}.php?year={$res.next_year}">{$res.next_year} год</a>&nbsp;&nbsp;
	</div>
{/if}
<br/>

<table border="0" cellspacing="0" cellpadding="20" width="100%">

{foreach from=$res.months item=month key=m name=list}
	{if ($smarty.foreach.list.iteration-1)%4==0}
		<tr>
	{/if}
	<td class="txt_color1" width="25%" align="center">
		<b>{$month.name}</b>
		<table border="0" cellpadding="2" cellspacing="0" class="calendar">
			<tr class="font-weight:bold; color:#999;"><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th><th class="holiday">сб</th><th class="holiday">вс</th></tr>
			
			{foreach from=$month.days item=d name=month}
				{if ($smarty.foreach.month.iteration-1)%7==0}
					<tr>
				{/if}
				{if $d}
					<td align="right"{if ($smarty.foreach.month.iteration)%7==0 || ($smarty.foreach.month.iteration)%7==6} class="holyday"{/if}>{if $res.graph[$m][$d]}<a href="/{$ENV.section}/route/{$res.year|string_format:"%04d"}-{$m|string_format:"%02d"}-{$d|string_format:"%02d"}/{$res.vehicle.VehicleID}.php">{/if}{$d}{if $res.graph[$m][$d]}</a>{/if}</td>
				{else}
					<td></td>
				{/if}
				{if ($smarty.foreach.month.iteration)%7==0}
					<tr>
				{/if}
			{/foreach}
			
		</table>
	</td>
	{if ($smarty.foreach.list.iteration)%4==0}
		</tr>
	{/if}
{/foreach}


</table>

<br/>
<br/>