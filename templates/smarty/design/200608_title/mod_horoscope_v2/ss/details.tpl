{if $UERROR->IsError()}
<div class="error">
{php}echo UserError::GetErrorsText(){/php}
</div>
{else}
<br />
{capture name="nav"}
{if $res.type.period==0}
	{if $res.prev}<a  href="/{$ENV.section}/{$res.prev|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.prev|date_format:"%e"} {$res.prev|date_format:"%m"|month_to_string:2} {$res.prev|date_format:"%Y"} г.</a>{/if}
	{if $res.prev} | {/if}
	<font class="t_dw">{$res.date.time_start|date_format:"%e"} {$res.date.time_start|date_format:"%m"|month_to_string:2}</font>
	{if $res.next} | {/if}
	{if $res.next}<a  href="/{$ENV.section}/{$res.next|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.next|date_format:"%e"} {$res.next|date_format:"%m"|month_to_string:2} {$res.next|date_format:"%Y"} г.</a>{/if}
{elseif $res.type.period==1}
	{if $res.prev}<a  href="/{$ENV.section}/{$res.prev|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.prev|date_format:"%e"} {$res.prev|date_format:"%m"|month_to_string:2} {$res.prev|date_format:"%Y"} г.</a>{/if}
	{if $res.prev} | {/if}
	<font class="t_dw">{$res.date.time_start|date_format:"%e"} {$res.date.time_start|date_format:"%m"|month_to_string:2} - 
	{$res.date.time_end|date_format:"%e"} {$res.date.time_end|date_format:"%m"|month_to_string:2} {$res.date.time_end|date_format:"%Y"} г.</font>
	{if $res.next} | {/if}
	{if $res.next}<a  href="/{$ENV.section}/{$res.next|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.next|date_format:"%e"} {$res.next|date_format:"%m"|month_to_string:2} {$res.next|date_format:"%Y"} г.</a>{/if}
{elseif $res.type.period==2}
	{if $res.prev}<a  href="/{$ENV.section}/{$res.prev|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.prev|date_format:"%m"|month_to_string:1} {$res.prev|date_format:"%Y"} г.</a>{/if}
	{if $res.prev} | {/if}
	<font class="t_dw">{$res.date.time_start|date_format:"%m"|month_to_string:1} {$res.date.time_end|date_format:"%Y"} г.</font>
	{if $res.next} | {/if}
	{if $res.next}<a  href="/{$ENV.section}/{$res.next|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.next|date_format:"%m"|month_to_string:1} {$res.next|date_format:"%Y"} г.</a>{/if}
{*{elseif $res.type.period==3}
	{if $res.prev}<a  href="/{$ENV.section}/{$res.prev|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.prev|date_format:"%Y"} г.</a>{/if}
	{if $res.prev} | {/if}
	<font class="t_dw">{$res.date.time_end|date_format:"%Y"} г.</font>
	{if $res.next} | {/if}
	{if $res.next}<a  href="/{$ENV.section}/{$res.next|date_format:"%Y-%m-%d"}/{$res.type.path}/">{$res.next|date_format:"%Y"} г.</a>{/if}*}
{/if}
{/capture}
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
		<td colspan="2" align="center" >
{$smarty.capture.nav}
		</td>
	</tr>
{foreach from=$res.date.values item=l key=k}
	{if $l.descr!=""}
{*	{if $k}
	<tr>
		<td width="35" align="center"><img src="{$l.img}" width="100" height="100" alt="{$l.title}"></td>
		<td align="left" width="100%"><span class="t_dw">{$l.title}</span> <span class="text11">({$l.diap})</span></td>
	</tr>
	{/if}*}
	<tr>
		<td colspan="2" align="justify">
			{if $k}
			<img src="{$l.img}" width="100" height="100" alt="{$l.title}" align="left">
			<a name="z{$k}"></a><span class="t_dw">{$l.title}</span> <span class="text11">({$l.diap})</span><br/>
			{/if}
			{$l.descr}
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="30" border="0" /></td>
	</tr>
	{/if}
{/foreach}
{if $res.prev || $res.next}
	<tr>
		<td colspan="2" align="center" >
{$smarty.capture.nav}
		</td>
	</tr>
{/if}
{if $res.type.link_url}
	<tr>
		<td colspan="2" class="text11">
			Информация предоставлена <noindex><a href="http://{$res.type.link_url|replace:"http://":""}" target="_blank" rel="nofollow">{$res.type.link_name}</a></noindex></font><br/>
		</td>
	</tr>
{/if}
</table>
{/if}