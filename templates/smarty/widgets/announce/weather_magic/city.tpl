<div align="center" style="width:100%">
<table class="t9" width="270" cellpadding="1" cellspacing="0" border="0">
	<tr>
		<td align="center" colspan="3">
			<a class="a12b" target="_blank" href="{$res.section_url}{$res.city.TransName}/"><span style="font-size: 16px; font-weight: bold;">Погода</span> (на 10 дней)</a>
		</td>
	</tr>
	<tr valign="top" align="left">
	{if is_array($res.current) && count($res.current) > 0}
		<td class="t9" nowrap="nowrap">
			<b>сегодня{*сейчас*}</b>
			<br />{if isset($res.current.PrecipImg)}<img width="20" height="20" class="png" 
					src="{$res.icon_url}small/day/{$res.current.PrecipImg}.png" 
					alt="{$res.current.PrecipText|escape:'quotes'}" 
					title="{$res.current.PrecipText|escape:'quotes'}" align="left" style="margin-right:3px;margin-top:4px;"
				/>{/if}
		  {*<nobr><b>{if $res.current.T > 0}+{/if}{$res.current.T}°C</b></nobr>*}
		  <nobr>день: <b><span style="color:red">{if $res.current.TDay>0}+{/if}{$res.current.TDay}°C</span></b></nobr><br /><nobr>ночь: <b>{if $res.current.TNight>0}+{/if}{$res.current.TNight}°C</b></nobr>
		</td>		
	{/if}
	{if is_array($res.weather) && count($res.weather) > 0}
		{foreach from=$res.weather item=w}
		{capture name=today}{$w.Date|simply_date|replace:" 00:00":""}{/capture}
		<td class="t9" nowrap="nowrap">
			<b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$w.Date|date_format:"%e"} {$w.Date|date_format:"%m"|month_to_string:2}{/if}</b>
			<br />{if isset($w.PrecipImg)}<img width="20" height="20" class="png" 
					src="{$res.icon_url}small/day/{$w.PrecipImg}.png" 
					alt="{$w.PrecipText|escape:'quotes'}" 
					title="{$w.PrecipText|escape:'quotes'}" align="left" style="margin-right:3px;margin-top:4px;"
				/>{/if}
		  <nobr>{if $smarty.capture.today=="завтра"}{/if}день: <b><span style="color:red">{if $w.TDay>0}+{/if}{$w.TDay}°C</span></b>{if $smarty.capture.today=="завтра"}{/if}</nobr><br /><nobr>ночь: <b>{if $w.TNight>0}+{/if}{$w.TNight}°C</b></nobr>
		</td>
		{/foreach}
	{/if}
	</tr>
</table>
</div>