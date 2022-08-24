<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>{*<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a16b"><img src="/img/icon_firms.gif" width="16" height="16" border="0"></a> *}<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a12b">{$ENV.site.title[$ENV.section]}:</a></td></tr>
</table>
<table style="padding-left: 3px;" width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td align="left" style="padding-left: 5px;">
			<table cellspacing="0" cellpadding="2" border="0" width="100%">
			{if $res.counts.today.show}
				<tr> 
					<td><a class="a11" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=today" style="color:red">На сегодня</a>{if $res.counts.today.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.today.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{if $res.counts.tomorrow.show}
				<tr> 
					<td><a class="a11" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=tomorrow" style="color:red">На завтра</a>{if $res.counts.tomorrow.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.tomorrow.count}</span>){/if}</span></td>
				</tr>
			{/if}
			{if $res.counts.weekend.show}
				<tr>
					<td><a class="a11" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=weekend" style="color:red">На выходные</a>{if $res.counts.weekend.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.weekend.count}</span>){/if}</span></td>
				</tr>
			{/if}
			{if $res.counts.week.show}
				<tr>
					<td><a class="a11" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=week" style="color:red">На неделю</a>{if $res.counts.week.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.week.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{foreach from=$res.list item=l}
				<tr> 
					<td><a class="a11" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/{$l.name}"{if $CURRENT_ENV.site.domain=='ufa1.ru' && $l.name=='concert'} style="color:red"{/if}>{$l.title}</a>{if $l.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$l.count}</span>)</span>{/if}</td>
				</tr>
			{/foreach}
			{foreach from=$res.groups item=g}
				<tr>
					<td>
						<a class="a11" target="_blank" href="/service/go/?url={$g.url}" style="color:red">{$g.name}</a>{if $g.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$g.count}</span>)</span>{/if}
					</td>
				</tr>
			{/foreach}
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<img height="6" width="1" src="/_img/x.gif"/>
		</td>
	</tr>
</table>