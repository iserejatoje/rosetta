{if !empty($BLOCK.url)}
	{assign var=res_url value=$BLOCK.url}
{else}
	{assign var=res_url value=""}
{/if}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<table border=0 cellpadding="0" cellspacing="3" width=100%>
			<tr><td align="left" class="block_title_obl" style="padding-left: 15px;"><span>АФИША</span></td></tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="/_img/x.gif" width="1" height="8"></td>
				</tr>
{foreach from=$BLOCK.list item=l}
				<tr>
					<td style="padding-left:8px;"><a href="/service/go/?url={"`$res_url`/afisha/afisha.php?cmd=list&type=`$l.id`"|escape:"url"}" target="_blank"><strong>{$l.name}</strong></a> ({$l.cnt})</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="4"></td>
				</tr>
{/foreach}
			</table>
		</td>
	</tr>
</table>
