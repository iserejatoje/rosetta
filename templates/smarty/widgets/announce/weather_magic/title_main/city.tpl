<div class="title">
	<a target="_blank" href="{$res.section_url}{$res.city.TransName}/"><span>Погода</span> (на 10 дней)</a>
</div>

<table class="table" cellpadding="1" cellspacing="0">
<tr>
{if is_array($res.current) && count($res.current) > 0}
	<td>
		<span class="head">сегодня</span>
		<br />{if isset($res.current.PrecipImg)}<img width="20" height="20" class="png"
				src="{$res.icon_url}small/day/{$res.current.PrecipImg}.png" 
				alt="{$res.current.PrecipText|escape:'quotes'}" 
				title="{$res.current.PrecipText|escape:'quotes'}" align="left" style="margin-right: 3px; margin-top: 4px;"
			/>{/if}
	  {*<span>{if $res.current.T > 0}+{/if}{$res.current.T}°C</span>*}
	  день: <span class="redtext">{if $res.current.TDay>0}+{/if}{$res.current.TDay}°C</span><br />
	  ночь: <span>{if $res.current.TNight>0}+{/if}{$res.current.TNight}°C</span>
	</td>		
{/if}
{if is_array($res.weather) && count($res.weather) > 0}
	{foreach from=$res.weather item=w}
	{capture name=today}{$w.Date|simply_date|replace:" 00:00":""}{/capture}
	<td>
		<span class="head">{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$w.Date|date_format:"%e"} {$w.Date|date_format:"%m"|month_to_string:2}{/if}</span>
		<br />{if isset($w.PrecipImg)}<img width="20" height="20" class="png" 
				src="{$res.icon_url}small/day/{$w.PrecipImg}.png" 
				alt="{$w.PrecipText|escape:'quotes'}" 
				title="{$w.PrecipText|escape:'quotes'}" align="left" style="margin-right: 3px; margin-top: 4px;"
			/>{/if}
	  {if $smarty.capture.today=="завтра"}{/if}день: <span class="redtext">{if $w.TDay>0}+{/if}{$w.TDay}°C{if $smarty.capture.today=="завтра"}{/if}</span><br />
	  ночь: <span>{if $w.TNight>0}+{/if}{$w.TNight}°C</span>
	</td>
	{/foreach}
{/if}
</tr>
</table>