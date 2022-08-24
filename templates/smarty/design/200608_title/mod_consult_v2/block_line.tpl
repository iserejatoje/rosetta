{if is_array($res.firm)}
<table class="t12" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 4px;">
<tr><td>
{if !empty($res.firm.rub_name)}<font class="txt_blue"><b>{$res.firm.rub_name}{*{$ENV.site.title[$ENV.section]}*}:</b></font> {/if}
{if !empty($res.firm.io) || !empty($res.firm.name)}
	<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank"><font color="red">{$res.firm.io} {$res.firm.name}</font></a>, {$res.firm.employment}
{else}
	<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank">{*<font color="red">*}{$res.firm.name}{*</font>*}</a>{if !empty($res.firm.employment)}, {$res.firm.employment}{/if}
{/if}
</td></tr>
</table>
{/if}