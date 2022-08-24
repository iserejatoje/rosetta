{if sizeof($res.list)>0}
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
<tr><th class="archive">{$CURRENT_ENV.site.title[$ENV.section]}</th></tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#C1211D"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_left">
{foreach from=$res.list item=l}
	<tr><td style="padding-bottom:2px"><div align="center" class="bl_body">
		<a href="/{$ENV.section}/{$l.compid}.php" class="bl_title_news">
			<b>{$l.name}</b>
		</a>
	</div>
	</td></tr>
{/foreach}
</table>
{/if}
