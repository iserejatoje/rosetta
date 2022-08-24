<br/><table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="title">
			{$res.data.Title}
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="justify">
		<!-- Text article -->
			{$res.data.Text}
		<!-- Text article: end -->
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	{if $res.data.AuthorName}
	<tr>
		<td align="right">
			<b>{if $res.data.AuthorEmail}{$res.data.AuthorName} ({$res.data.AuthorEmail|mailto_crypt}){else}{$res.data.AuthorName}{/if}, <i>специально для {$CURRENT_ENV.site.domain|ucfirst}</i></b>
		</td>
	</tr>
	{/if}
	{if $res.data.PhotographerName}
	<tr>
		  <td align="right">{$res.data.PhotographerName}</td>
	</tr>
	{/if}
	<tr>
		<td height="10px"></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="10" border="0">
	<tr>
		{if $res.prev.ArticleID}
		<td align="left">
			<a href="/{$CURRENT_ENV.section}/{$res.GroupID}/{$res.prev.ArticleID}.html"><b>предыдущая страница</b></a>
		</td>
		{/if}
		{if $res.next.ArticleID}
		<td align="right">
			<a href="/{$CURRENT_ENV.section}/{$res.GroupID}/{$res.next.ArticleID}.html"><b>следующая страница</b></a>
		</td>
		{/if}
	</tr>
</table>