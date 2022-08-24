	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
		<tr>
			<th align="left"><span>{$res.title}</span></th>
		</tr>
	</table>

	{foreach from=$res.calendar item=weeks key=monthTS}
	<table class="calendar calendar-bord">
		<tr>
			<th colspan="7">{"%m"|strftime:$monthTS|month_to_string|strtoupper} {"%Y"|strftime:$monthTS}</th>
		</tr>
	</table>
	<table class="calendar" cellpadding="0" cellspacing="0">
		<tr class="head">
			<td class="calendar-item">Пн</td>
			<td class="calendar-item">Вт</td>
			<td class="calendar-item">Ср</td>
			<td class="calendar-item">Чт</td>
			<td class="calendar-item">Пт</td>
			<td class="calendar-item red">Сб</td>
			<td class="calendar-item red">Вс</td>
		</tr>

		{foreach from=$weeks item=week}
		<tr>
			{foreach from=$week item=day key=week_date}
			{if $day}
				<td class="calendar-item {if $week_date<=5}lg{else}red{/if}{if $day == $res.active} active{elseif $day == $res.current} current{/if}">
					{if $day != $res.active && $res.current >= $day}<a href="/{$CURRENT_ENV.section}/{'Y/m/d'|date:$day}/">{'j'|date:$day}</a>{else}{'j'|date:$day}{/if}
				</td>
			{else}
				<td class="calendar-item"></td>
			{/if}
			{/foreach}
		</tr>		
		{/foreach}
	</table>
	{/foreach}

	<table class="calendar" cellpadding="0" cellspacing="0">
		<tr class="head">
			<td style="width: 82%;">
				<form name="f">
					<select style="width: 22%;" name="d">
						<option value="0"> - </option>
					{foreach from=$res.day_arr item=i}
						<option value="{"%02d"|sprintf:$i}" {if $i == $res.current_day}selected="selected"{/if}>{"%02d"|sprintf:$i}</option>
					{/foreach}
					</select>
					<select style="width: 42%;" name="m">
					{foreach from=$res.month_arr item=i key=k}
						<option value="{"%02d"|sprintf:$k}" {if $k == $res.current_month}selected="selected"{/if}>{$i|ucfirst}</option>
					{/foreach}
					</select>
					<select style="width: 30%;" name="y">
					{foreach from=$res.year_arr item=i}
						<option value="{$i}" {if $i == $res.current_year}selected="selected"{/if}>{$i}</option>
					{/foreach}
					</select>
				</form>
			</td>
			<td style="width: 18%;"> 
				<input type="button" onclick="document.location.href='/{$CURRENT_ENV.section}/'+f.y.value+'/'+f.m.value+'/'+( f.d.value > 0 ? f.d.value+'/' : '' )" value="ОК" class="button"/>
			</td>
		</tr>
	</table>