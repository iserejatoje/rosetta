<table width="100%" border="0" cellspacing="2" cellpadding="0" style="background: url(/img/design/green_search_bg.gif) repeat-x;">
<tr>
	<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
<tr>
	<td class="block_title_obl" align="left" style="padding-left: 10px;">
	<span>Твоя афиша</span>
	</td>
</tr>
<tr>
	<td align="left" style="padding-left: 10px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	{foreach from=$res.list item=l}
		<tr> 
		<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.name}" class="weis_big"><b>{$l.title}</b></a>{if $l.count}&nbsp;({$l.count}){/if}
		</td>
		</tr>
	{/foreach}
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
{if $res.counts.today.show}
<tr> 
	<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=today"><b>на сегодня</b></a>{if $res.counts.today.count}&nbsp;({$res.counts.today.count}){/if}</td>
</tr>
{/if}
{if $res.counts.tomorrow.show}
<tr> 
	<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=tomorrow"><b>на завтра</b></a>{if $res.counts.tomorrow.count}&nbsp;({$res.counts.tomorrow.count}){/if}</td>
</tr>
{/if}
{if $res.counts.weekend.show}
<tr>
	<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=weekend"><b>на уик-энд</b></a>{if $res.counts.weekend.count}&nbsp;({$res.counts.weekend.count}){/if}</td>
</tr>
{/if}
{if $res.counts.week.show}
<tr>
	<td class="text11"><a href="http://{$ENV.site.domain}/{$ENV.section}/search.php?range=week"><b>на неделю</b></a>{if $res.counts.week.count}&nbsp;({$res.counts.week.count}){/if}</td>
</tr>
{/if}
	</table>
	</td>
</tr>
{if $res.groups}
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
<tr>
	<td align="left" style="padding-left: 10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		{foreach from=$res.groups item=g}
		<tr><td class="text11">
			<a href="{$g.url}"><b>{$g.name}</b></a>{if $g.count}&nbsp;({$g.count}){/if}</td>
		</td></tr>
		{/foreach}
		</table>
	</td>
</tr>
{/if}
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
<tr>
	<td class="otzyv"><a href="mailto:{$CURRENT_ENV.site.domain}%20<{if in_array($CURRENT_ENV.regid,array(74,63,59,16))}kapitova@info74.ru{else}imanova@info74.ru{/if}>?subject=Новое%20событие%20в%20афишу%20{$CURRENT_ENV.site.domain}" style="color:red">Прислать информацию о событии</a></td>
</tr>
</table>