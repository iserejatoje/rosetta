<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>{*<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a16b"><img src="/img/icon_firms.gif" width="16" height="16" border="0"></a> *}<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a12b">{$ENV.site.title[$ENV.section]}:</a></td></tr>
</table>
<table style="padding-left: 3px;" width="100%" cellspacing="0" cellpadding="2" border="0">
{foreach from=$res.list item=l}
	{if !empty($l.child)}
	{foreach from=$l.child item=lc}
	{if !$lc.last_comment.readonly}
	<tr>
		<td align="left" valign="top" style="padding-left:5px">
<font clas="a11"><a href="http://{$ENV.site.domain}/{$ENV.section}/{$lc.path}/" class="a11">{$lc.name}</a> (<b>{if $l.count}{$l.count}{else}0{/if}</b>)</font>
		</td>
	</tr>
	{/if}			
	{/foreach}
	{else}
	{if !$l.last_comment.readonly}
	<tr>
		<td align="left" valign="top" style="padding-left:5px" class="a11">
			{if empty($l.child)}
				<font class="a11"><a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.path}/" class="a11">{$l.name}</a> (<b>{if $l.count}{$l.count}{else}0{/if}</b>)</font>
			{else}
				<font class="a11"><a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.id}.html" class="a11">{$l.name}</a> (<b>{if $l.count}{$l.count}{else}0{/if}</b>)</font>
			{/if}
		</td>
	</tr>
	{/if}
	{/if}
{/foreach}
	<tr><td style="padding-left: 5px;">
		<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a11">Все рубрики</a>
	</td></tr>
</table>
