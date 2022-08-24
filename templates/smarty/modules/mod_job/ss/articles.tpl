{include file="`$TEMPLATE.sectiontitle`" rtitle="Аналитика"}
<table width="99%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td class="t7">
			{foreach from=$data.arts item=l}
				<a href="/{$CURRENT_ENV.section}/?cmd=articles&rid={$l.rid}" class="s3">{$l.rname}</a><br>
			{/foreach}
			<br/><br/>
			<p class="t1">{$data.rname}</p>{$data.text}
		</td>
	</tr>
</table>
{include file="`$TEMPLATE.midbanner`"}