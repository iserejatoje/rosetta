{*
<table class="t12" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td align="left">
									<table class="t12" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">
											Афиша</td>
										</tr>
										<tr>
											<td align="left" bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td>
										</tr> 
									</table>
								</td>
							</tr>
							<tr>
								<td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td>
							</tr>
</table> *}
<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="http://{$ENV.site.domain}/{$ENV.section}" target="_blank">{if count($res.today_list)>0}Киноафиша{else}Афиша{/if}</a></td></tr>
</table>

<table>							
<tr>
<td align="left" valign=top style="padding-right: 20px;">
<table class="t11" width="100%" align="center" cellpadding="5" cellpadding="0" border="0">
{if $res.counts.today.show}
<tr nowrap> 
	<td nowrap><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=today"><b>на сегодня</b></a>&nbsp;<span class="t11">(<b>{$res.counts.today.count}</b>)</span></td>
</tr>
{/if}
{if $res.counts.tomorrow.show}
<tr nowrap> 
	<td nowrap><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=tomorrow"><b>на завтра</b></a>&nbsp;<span class="t11">(<b>{$res.counts.tomorrow.count}</b>)</span></td>
</tr>
{/if}
{if $res.counts.weekend.show}
<tr nowrap>
	<td nowrap><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=weekend"><b>на уик-энд</b></a>&nbsp;<span class="t11">(<b>{$res.counts.weekend.count}</b>)</span></td>
</tr>
{/if}
{if $res.counts.week.show}
<tr>
	<td  nowrap><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=week"><b>на неделю</b></a>&nbsp;<span class="t11">(<b>{$res.counts.week.count}</b>)</span></td>
</tr>
{/if}
</table>
</td>
<td align="left" valign="top" style="padding-left: 20px;">
			<table class="t11" width="100%" align="center"  cellpadding="5" cellpadding="0" border="0">
	{foreach from=$res.today_list item=l}
		<tr> 
		<td class="text11">{*<a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.name}" class="weis_big">*}<a href="{$l.url}">{$l.title}</a>&nbsp;
		</td>
		</tr>
	{/foreach}
	{foreach from=$res.list item=l}
		<tr> 
		<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.name}" style="color:red;">Все фильмы</a>&nbsp;<span class="t11">(<b style="font-size: 11px;">{$l.count}</b>)</span>
		</td>
		</tr>
	{/foreach}
	</table>
		</td>
	</tr>
</table>
