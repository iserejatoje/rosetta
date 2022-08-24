<div class="block_weather_search">
<table cellpadding="0" cellspacing="0">
<tr>
	<td>

		<table cellpadding="5" cellspacing="" width="100%">
		<tr>
			<td>
				<a class="weather_title" target="_blank" href="{$res.section_url}{$res.city.TransName}/">Погода в {$res.name_where}</a>
			</td>
			<td>
				<span class="weather_current_t">{if $res.realcurrent.T > 0}+{/if}{$res.realcurrent.T}°C</span>
			</td>
			<td>
				{if isset($res.realcurrent.PrecipImg)}
				<img width="38" height="38" class="png" 
				src="{$res.icon_url}middle/day/{$res.realcurrent.PrecipImg}.png" 
				alt="{$res.realcurrent.PrecipText|escape:'quotes'}" 
				title="{$res.realcurrent.PrecipText|escape:'quotes'}" align="left" style="margin-right: 3px; margin-top: 4px;"/>
				{/if}

			</td>
			<td>
				{$res.realcurrent.PrecipText}
			</td>
		</tr>
		</table>

	</td>
</tr>
<tr>
	<td>
	
		<table cellpadding="0" cellspacing="2" width="100%">
		<tr>
		{if is_array($res.current) && count($res.current) > 0}
			<td class="weather_item">
				<span class="head">сегодня</span>
				<br />{if isset($res.current.PrecipImg)}<img width="20" height="20" class="png" 
						src="{$res.icon_url}small/day/{$res.current.PrecipImg}.png" 
						alt="{$res.current.PrecipText|escape:'quotes'}" 
						title="{$res.current.PrecipText|escape:'quotes'}" align="left" style="margin-right: 7px; margin-top: 4px;"
					/>{/if}
			  {*<span>{if $res.current.T > 0}+{/if}{$res.current.T}°C</span>*}
			   <small>день:</small>  <span class="redtext weather_10days">{if $res.current.TDay>0}+{/if}{$res.current.TDay}°C</span><br />
			   <small>день:</small>  <span class="weather_10days">{if $res.current.TNight>0}+{/if}{$res.current.TNight}°C</span>
			</td>		
		{/if}
		{if is_array($res.weather) && count($res.weather) > 0}
			{foreach from=$res.weather item=w}
			{capture name=today}{$w.Date|simply_date|replace:" 00:00":""}{/capture}
			<td class="weather_item">
				<span class="head">{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$w.Date|date_format:"%e"} {$w.Date|date_format:"%m"|month_to_string:2}{/if}</span>
				<br />{if isset($w.PrecipImg)}<img width="20" height="20" class="png" 
						src="{$res.icon_url}small/day/{$w.PrecipImg}.png" 
						alt="{$w.PrecipText|escape:'quotes'}" 
						title="{$w.PrecipText|escape:'quotes'}" align="left" style="margin-right: 7px; margin-top: 4px;"
					/>{/if}
			  <small>день:</small> <span class="redtext weather_10days">{if $w.TDay>0}+{/if}{$w.TDay}°C</span><br />
			  <small>ночь:</small> <span class="weather_10days">{if $w.TNight>0}+{/if}{$w.TNight}°C</span>
			</td>
			{/foreach}
		{/if}
		</tr>
		</table>
	</td>
</tr>
</table>
{*<a class="weather_more_ref" href="{$res.section_url}{$res.city.TransName}/">прогноз подробно &rarr;</a>*}
</div>