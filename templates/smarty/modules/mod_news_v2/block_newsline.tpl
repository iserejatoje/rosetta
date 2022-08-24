<table width="100%" class="block_right" cellspacing="3" cellpadding="0" >
	<tr><th><span>
	{if $ENV.site.domain=='mgorsk.ru' && $CURRENT_ENV.regid==74}
		Новости Магнитогорска
	{else}
		{$ENV.site.title[$ENV.section]}
	{/if}
	</span></th></tr>
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr align="right"><td><span>{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</span></td></tr>
	<tr valign="bottom"><td>
{/if}
	<div><span class="bl_date">{$l.date|date_format:"%H:%M"}</span> <span class="bl_title"><a {if $ENV.site.domain!=$CURRENT_ENV.site.domain}target="_blank"{/if} href="http://{$ENV.site.domain}/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}">{$l.name}</a></span></div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
