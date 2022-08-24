{if $page.message == 'citynotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Город не найден.<br>
		</td>
	</tr>
	</table>
{elseif $page.message == 'stationnotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Станция не найдена.<br>
		</td>
	</tr>
	</table>
{elseif $page.message == 'regionnotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Регион не найден.<br>
		</td>
	</tr>
	</table>
{elseif $page.message == 'routenotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Маршрут поезда не найден.<br>
		</td>
	</tr>
	</table>
{elseif $page.message == 'stationfromnotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Не найдена станция отправления.<br>
		</td>
	</tr>
	</table>
{elseif $page.message == 'stationtonotfound'}
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="100px"></td>
	</tr>
	</table>
	<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
	<tr>
		<td>
			Не найдена станция прибытия.<br>
		</td>
	</tr>
	</table>
{/if}