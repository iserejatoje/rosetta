{if $res !== null}
<div class="weather">
	<div class="current">
		<table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="now" style="text-align:left">
					<span class="title">{$res.country.Name}</span><br/>
					{$res.city.Name}
				</td>
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
					<div class="precip">
						{$res.weather.PrecipText}<br/>
						<a href="{$res.section_url}{$res.city.TransName}/" class="action">подробная погода</a>
					</div>
				</td>
			</tr>

		</table>
	</div>
</div>
<br clear="both"/>
{/if}