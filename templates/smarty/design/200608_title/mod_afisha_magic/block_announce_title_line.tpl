<table class="t12" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/">Афиша</a></td></tr>
</table>
<table cellspacing="2" cellpadding="0" border="0" width="100%">
	<tr>
		<td align="left" style="padding-left: 8px;">
			<table cellspacing="0" cellpadding="2" border="0" width="100%">
				<tr> 
					<td nowrap><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" align="middle" />&nbsp;<a class="a12" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=today" style="color:red">На сегодня</a>{if $res.counts.today.count}&nbsp;(<font class="t11">{$res.counts.today.count}</font>){/if}</td>
					<td nowrap><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" align="middle" />&nbsp;<a class="a12" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=tomorrow">На завтра</a>{if $res.counts.tomorrow.count}&nbsp;(<font class="t11">{$res.counts.tomorrow.count}</font>){/if}</td>
				</tr>
			{foreach from=$res.list item=l name=events}
				{if $smarty.foreach.events.iteration%2}<tr>{/if}
					<td nowrap><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" align="middle" />&nbsp;<a target="_blank" class="a12" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/{$l.name}"{if $CURRENT_ENV.site.domain=='ufa1.ru' && $l.name=='concert'} style="color:red"{/if}>{$l.title}</a>{if $l.count}&nbsp;(<font class="t11">{$l.count}</font>){/if}</td>
				{if !$smarty.foreach.events.iteration%2}</tr>{/if}
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