<div class="marker_title"><a class="subtitle" href="/weather/">Погода на 10 дней</a></div>
{if is_array($res.current) && count($res.current) > 0}
<table cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td width="45%" align="right">
{if isset($res.current.PrecipImg)}
	<img class="png" 
				src="{$res.icon_url}large/day/{$res.current.PrecipImg}.png" 
				alt="{$res.current.PrecipText|escape:'quotes'}" 
				title="{$res.current.PrecipText|escape:'quotes'}"/>
{/if}
	</td>
	<td width="55%" align="left">
день: <b><span style="color:red">{if $res.current.TDay>0}+{/if}{$res.current.TDay}°C</span></b><br />
ночь: <b>{if $res.current.TNight>0}+{/if}{$res.current.TNight}°C</b>
	</td>
</tr></table>

{/if}
