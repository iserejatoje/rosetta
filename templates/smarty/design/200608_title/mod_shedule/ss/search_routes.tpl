
{if $res.direct_routes}
	<br/>
	<div class="title">Рейсы {$res.DepartureStation|lower|capitalize:true} &mdash; {$res.ArrivalStation|lower|capitalize:true} на {$res.date|date_format:"%d.%m.%Y"}</div>
	<br/>
	<div class="title2">{$res.DepartureStation|lower|capitalize:true} &rarr; {$res.ArrivalStation|lower|capitalize:true}</div>
	<br/>
	<table class="table2" border="0" cellspacing="1" cellpadding="0" width="100%">
		<tr>
			<th>Номер поезда</th>
			<th>Маршрут</th>
			<th>Отправление</th>
			<th>Прибытие</th>
		</tr>
	{excycle values=" ,bg_color4"}
	{foreach from=$res.direct_routes item=route}
		<tr class="{excycle}">
			<td align="center"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.Name|truncate:4:""}</a></td>
			<td width="100%"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.DepartureStation|lower|capitalize:true} &mdash; {$route.ArrivalStation|lower|capitalize:true}</a></td>
			<td class="text11" nowrap>{if $route.DepartureDate}{$route.DepartureDate}{/if} <span style="color:red"><b>{$route.DepartureTime}</b></span></td>
			<td class="text11" nowrap>{if $route.ArrivalDate}{$route.ArrivalDate}{/if} <span style="color:red"><b>{$route.ArrivalTime}</b></span></td>
		</tr>
	{/foreach}
	</table>
{else}

	{if $res.routes}

		{foreach from=$res.routes item=transfer}
			<br/>
			<div class="title">Рейсы {$res.DepartureStation|lower|capitalize:true} &mdash; {$res.ArrivalStation|lower|capitalize:true} через станцию &laquo;{$transfer.Name|lower|capitalize:true}&raquo; на {$res.date|date_format:"%d.%m.%Y"}</div>
			<br/>
			<div class="title2">{$res.DepartureStation|lower|capitalize:true} &rarr; {$transfer.Name|lower|capitalize:true}</div>
			<br/>
			<table class="table2" border="0" cellspacing="1" cellpadding="0" width="100%">
				<tr>
					<th>Номер поезда</th>
					<th>Маршрут</th>
					<th>Отправление</th>
					<th>Прибытие</th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$transfer.first item=route}
				<tr class="{excycle}">
					<td align="center"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.Name|truncate:4:""}</a></td>
					<td width="100%"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.DepartureStation|lower|capitalize:true} &mdash; {$route.ArrivalStation|lower|capitalize:true}</a></td>
					<td class="text11" nowrap>{if $route.DepartureDate}{$route.DepartureDate}{/if} <span style="color:red"><b>{$route.DepartureTime}</b></span></td>
					<td class="text11" nowrap>{if $route.ArrivalDate}{$route.ArrivalDate}{/if} <span style="color:red"><b>{$route.ArrivalTime}</b></span></td>
				</tr>
			{/foreach}
			</table>
			<br/>
			<div class="title2">{$transfer.Name|lower|capitalize:true} &rarr; {$res.ArrivalStation|lower|capitalize:true}</div>
			<br/>
			<table class="table2" border="0" cellspacing="1" cellpadding="0" width="100%">
				<tr>
					<th>Номер поезда</th>
					<th>Маршрут</th>
					<th>Отправление</th>
					<th>Прибытие</th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$transfer.second item=route}
				<tr class="{excycle}">
					<td align="center"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.Name|truncate:4:""}</a></td>
					<td width="100%"><a href="/{$ENV.section}/route/{$route.VehicleID}.php" title="Станции следования поезда">{$route.DepartureStation|lower|capitalize:true} &mdash; {$route.ArrivalStation|lower|capitalize:true}</a></td>
					<td class="text11" nowrap>{if $route.DepartureDate}{$route.DepartureDate}{/if} <span style="color:red"><b>{$route.DepartureTime}</b></span></td>
					<td class="text11" nowrap>{if $route.ArrivalDate}{$route.ArrivalDate}{/if} <span style="color:red"><b>{$route.ArrivalTime}</b></span></td>
				</tr>
			{/foreach}
			</table>
			<br/><br/>
			<br/><br/>
		{/foreach}
	
		<p>Максимальное время ожидания пересадки: <b>{$CONFIG.max_transfer_time}</b> часов.</p>
	{else}	
		<p>Не найдено ни одного {if $res.get.with_transfer}рейса с одной пересадкой{else}прямого рейса{/if} от станции
		&laquo;<a href="/{$ENV.section}/station/{$res.DepartureStationID}.php" title="Посмотреть расписание станции">{$res.DepartureStation|lower|capitalize:true}</a>&raquo;
		до станции
		&laquo;<a href="/{$ENV.section}/station/{$res.ArrivalStationID}.php" title="Посмотреть расписание станции">{$res.ArrivalStation|lower|capitalize:true}</a>&raquo; на {$res.date|date_format:"%d.%m.%Y"}.</p>
		{if !$res.get.with_transfer}		
			{if $res.nearest_date}
				<p>Ближайший прямой рейс ожидается <a href="/{$ENV.section}/search.php?station_from={$res.DepartureStation}&station_to={$res.ArrivalStation}&date={$res.nearest_date|date_format:'%d.%m.%Y'}{*if $res.get.back}&back=1{/if*}">{$res.nearest_date|simply_date}</a>.</p>
			{/if}		
			<p>Вы также можете <a href="/{$ENV.section}/search.php?station_from={$res.DepartureStation}&station_to={$res.ArrivalStation}&date={$res.date|date_format:'%d.%m.%Y'}&with_transfer=1">поискать маршрут с пересадками</a>.</p>
		{/if}	
	{/if}

{/if}

{if $res.time_exceeded}
	<br/>
	<div align="center" style="color:red">
		<b>Выполнение вашего запроса прервано, т.к. найдено слишком много возможных маршрутов.</b>
	</div>
{/if}
<br/>
<br/>