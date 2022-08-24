
<div class="current">
<span class="title">{$res.city.Name}</span>
{if $res.page != 'print'}
	<a href="{$res.links.other_city}" class="action">другой город</a>
{/if}<br/><br/>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="65" class="now">Сейчас</td>
		<td width="75" valign="top" align="center">
			{if isset($res.weather.PrecipImg)}
				<img width="70" height="70" class="png" 
					src="{$res.icon_url}large/{$res.weather.HourType}/{$res.weather.PrecipImg}.png" 
					alt="{$res.weather.PrecipText|escape:'quotes'}" 
					title="{$res.weather.PrecipText|escape:'quotes'}" 
				/>
			{/if}
		</td>
		<td class="title">
			{if $res.weather.T > 0}+{/if}{$res.weather.T}&nbsp;°C&nbsp;
			<div class="precip">{$res.weather.PrecipText}</div>
		</td>
		<td class="vline"><img width="2" height="1" alt="2" src="/_img/x.gif"/></td>
		<td class="desc">
			Ветер <span>{if !$res.weather.WindWard}-{else}{$res.weather.WindWard[1]} {if $res.weather.WindSpeed > 0}{$res.weather.WindSpeed} м/с{/if}{/if}</span><br/>
			Давление <span>{if $res.weather.Barometer > 0}{$res.weather.Barometer} мм рт.ст.{else}-{/if}</span><br/>
			Влажность <span>{if $res.weather.Humidity > 0}{$res.weather.Humidity}%{else}-{/if}</span>
		</td>
		<td class="vline"><img width="2" height="1" alt="2" src="/_img/x.gif"/></td>
		<td class="desc">
			Восход <span>{if $res.weather.Sunrise}{$res.weather.Sunrise}{else}-{/if}</span><br/>
			Заход <span>{if $res.weather.Sunset}{$res.weather.Sunset}{else}-{/if}</span><br/>
			Долгота дня <span>{if $res.weather.LongDay}
				{$res.weather.LongDay[0]}&nbsp;{word_for_number number=$res.weather.LongDay[0] first="час" second="часа" third="часов"}
				{$res.weather.LongDay[1]}&nbsp;{word_for_number number=$res.weather.LongDay[1] first="минута" second="минуты" third="минут"}
			{else}-{/if}</span>
		</td>
	</tr>

</table>
</div>
{if $res.describe}
	<br/><div class="desc">{$res.describe}</div></br>
{/if}