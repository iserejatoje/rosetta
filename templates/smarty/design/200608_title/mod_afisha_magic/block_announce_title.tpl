<table cellspacing="2" cellpadding="0" border="0" width="100%" style="padding-left: 2px;">
	<tr>
		<td>
			<img height="1" border="0" width="5" alt="" src="/_img/x.gif"/>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td style="width:22px">
			<a class="a16b" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/"><img border="0" src="/_img/design/200608_title/common/icon_afisha_p.gif"/></a></td><td>&nbsp;<a class="a16b" target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/">{if in_array($CURRENT_ENV.regid,array(163,24,55,51,56,76,78,93))}Киноафиша{else}Афиша{/if}:</a>
			</td></tr>
			</table>
		</td>
	</tr>                                                                                                                                                
</table>
<table cellspacing="2" cellpadding="0" border="0" width="100%">
	<tr>
		<td align="left" style="padding-left: 8px;">
			<table cellspacing="0" cellpadding="2" border="0" width="100%">
			{if $res.counts.today.show}
				<tr> 
					<td><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=today">На сегодня</a>{if $res.counts.today.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.today.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{if $res.counts.tomorrow.show}
				<tr> 
					<td><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=tomorrow">На завтра</a>{if $res.counts.tomorrow.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.tomorrow.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{if $res.counts.weekend.show}
				<tr>
					<td><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=weekend">На выходные</a>{if $res.counts.weekend.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.weekend.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{if $res.counts.week.show}
				<tr>
					<td><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/search.php?range=week">На неделю</a>{if $res.counts.week.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$res.counts.week.count}</span>)</span>{/if}</td>
				</tr>
			{/if}
			{foreach from=$res.list item=l}
				<tr> 
					<td><a target="_blank" href="/service/go/?url=http://{$ENV.site.domain}/{$ENV.section}/{$l.name}"{if $CURRENT_ENV.site.domain=='ufa1.ru' && $l.name=='concert'} style="color:red"{/if}>{$l.title}</a>{if $l.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$l.count}</span>)</span>{/if}</td>
				</tr>
			{/foreach}
			{foreach from=$res.groups item=g}
				<tr>
					<td>
						<a target="_blank" href="/service/go/?url={$g.url}" {if $g.id==125}style="color:red"{/if}>{$g.name}</a>{if $g.count}&nbsp;<span class="txt_blue">(<span style="font-size: 11px; font-weight: bold;">{$g.count}</span>)</span>{/if}
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