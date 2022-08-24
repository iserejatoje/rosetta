<div align="left">
<table cellpadding="1" cellspacing="3" border="0">
	{if is_array($res.current) && sizeof($res.current)}
	<tr>
		<td colspan="3" align="left">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="text10 txt_color1"><b>Сейчас: {if $res.current.t > 0}+{/if}{$res.current.t}°C</b></td>
					<td>&#160;<img src="{$res.current.nebopic}" width="19" height="19" alt="{$res.current.nebocap}" style="margin-right:2px;margin-top:4px;" />&#160;</td>
					<td class="text10 txt_color1">{if $res.current.wind_speed > 0}Ветер: {$res.current.wind_ward} {$res.current.wind_speed} м/с{else}Ветра нет{/if}</td>
			</table>
		</td>
	</tr>
	{/if}
	<tr valign="top" align="left">
		{foreach from=$res.weather item=w}
		{capture name=today}{$w.date|simply_date|replace:" 00:00":""}{/capture}
		<td class="text10 txt_color1" nowrap="nowrap">
			<b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$w.date|date_format:"%e"} {$w.date|date_format:"%m"|month_to_string:2}{/if}</b>
			<br />
			<img src="{$w.nebopic}" width="19" height="19" alt="{$w.nebocap}" align="left" style="margin-right:2px;margin-top:4px;" />
		  <nobr>день: {if $w.tday>0}+{/if}{$w.tday}°C</nobr><br /><nobr>ночь: {if $w.tnight>0}+{/if}{$w.tnight}°C</nobr>
		</td>
		{/foreach}
	</tr>
</table>
</div>