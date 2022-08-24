{include file="`$TEMPLATE.sectiontitle`" rtitle="Аналитика"}
<table width="99%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td>
			{foreach from=$page.arts item=l}
				<a href="/{$ENV.section}/articles/{$l.rid}.html">{$l.rname}</a><br>
			{/foreach}
			<br/><br/>
			<p class="title">{$page.rname}</p>{$page.text}
		</td>
	</tr>
</table>
{if isset($TEMPLATE.midbanner)}{include file="`$TEMPLATE.midbanner`"}{/if}