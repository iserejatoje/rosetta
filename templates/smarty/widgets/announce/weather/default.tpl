<div align="left" style="width:100%;">
<table cellpadding="1" cellspacing="0" border="0">
	{if is_array($res.current) && sizeof($res.current)}
	<tr>
		<td colspan="3" align="left" style="padding-bottom: 3px;">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="text10 txt_color1"><b>Сейчас: {if $res.current.T > 0}+{/if}{$res.current.T}°C</b></td>
					<td>&#160;{if isset($res.current.PrecipImg)}<img width="20" height="20" class="png" src="{$res.icon_url}small/{$res.current.HourType}/{$res.current.PrecipImg}.png" alt="{$res.current.PrecipText|escape:'quotes'}" style="margin-left:4px;margin-right:4px;" title="{$res.current.PrecipText|escape:'quotes'}" />{/if}&#160;</td>
					<td class="text10 txt_color1">{if $res.current.WindSpeed > 0}Ветер: {$res.current.WindWard[1]} {$res.current.WindSpeed} м/с{else}Ветра нет{/if}</td>
				</tr>
			</table>
		</td>
	</tr>
	{/if}
	{if is_array($res.weather) && count($res.weather) > 0}
	<tr valign="top" align="left">
		{foreach from=$res.weather item=w}
		{capture name=today}{$w.Date|simply_date|replace:" 00:00":""}{/capture}
		<td class="text10 txt_color1" nowrap="nowrap">
			<b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}:{else}{$w.Date|date_format:"%e"} {$w.Date|date_format:"%m"|month_to_string:2}:{/if}</b>
			<br />
			{if isset($w.PrecipImg)}<img width="20" height="20" class="png" src="{$res.icon_url}small/day/{$w.PrecipImg}.png" alt="{$w.PrecipText|escape:'quotes'}"  style="margin-left:4px;margin-right:4px;" title="{$w.PrecipText|escape:'quotes'}" />{/if}
		  <nobr>день: {if $w.TDay>0}+{/if}{$w.TDay}°C</nobr><br /><nobr>ночь: {if $w.TNight>0}+{/if}{$w.TNight}°C</nobr>
		</td>
		{/foreach}
	</tr>
	{/if}
</table>
</div>