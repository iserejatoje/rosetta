<div class="title">Результаты поиска</div>
<br/>
{foreach from=$page item=l}
	<a href="/{$ENV.section}/route/{$l.VehicleID}.php">{$l.Name|truncate:4:""}&nbsp;&nbsp;{$l.DepartureStation|lower|capitalize:true} &mdash; {$l.ArrivalStation|lower|capitalize:true}</a><br/>
{/foreach}
<br/>
<br/>