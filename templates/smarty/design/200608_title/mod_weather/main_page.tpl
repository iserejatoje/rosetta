<table class="t9" width="180" cellpadding="1" cellspacing="0" border="0">
<tr><td align="center" colspan="2"><a href="/weather/" target="_blank" class="a12b"><span style="font-size:16px;font-weight:bold">Погода</span> (на 10 дней)</a></td></tr>
<tr valign="top" align="left">
		{capture name=today}{$WEATHER[0].date|simply_date|replace:" 00:00":""}{/capture}
		<td class="t9"><b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$WEATHER[0].date|date_format:"%e"} {$WEATHER[0].date|date_format:"%m"|month_to_string:2}{/if}</b><br />
		<img src="{$WEATHER[0].nebopic}" width="19" height="19" alt="{$WEATHER[0].nebocap}" align="left" style="margin-right:2px;margin-top:4px;" />
		  <nobr>день: {if $WEATHER[0].tday>0}+{/if}{$WEATHER[0].tday}°C</nobr><br /><nobr>ночь:. {if $WEATHER[0].tnight>0}+{/if}{$WEATHER[0].tnight}°C</nobr>
		</td>
		{capture name=today}{$WEATHER[1].date|simply_date|replace:" 00:00":""}{/capture}
		<td class="t9"><b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$WEATHER[1].date|date_format:"%e"} {$WEATHER[1].date|date_format:"%m"|month_to_string:2}{/if}</b><br />
		<img src="{$WEATHER[1].nebopic}" width="19" height="19" alt="{$WEATHER[1].nebocap}" align="left" style="margin-right:2px;margin-top:4px;" />
		  <nobr>день: {if $WEATHER[1].tday>0}+{/if}{$WEATHER[1].tday}°C</nobr><br /><nobr>ночь: {if $WEATHER[1].tnight>0}+{/if}{$WEATHER[1].tnight}°C</nobr>
		</td>
</tr>
</table>