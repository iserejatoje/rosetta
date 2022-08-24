{foreach from=$res.list item=l}
<br/>
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="text11">
	<tr>
		<td>
			<a name="st{$l.ArticleID}"></a>
			<div align="left" class="title">{$l.Title}</div>
			<div align="justify" class="txt1">
				{$l.Text}
			</div>
		</td>
	</tr>
	<tr>
		<td height="10px"></td>
	</tr>
	{*if $l.AuthorName}
	<tr>
		<td align="right">
			<b>{if $l.AuthorEmail}{$l.AuthorName} ({$l.AuthorEmail|mailto_crypt}){else}{$l.AuthorName}{/if}, <i>специально для {$CURRENT_ENV.site.domain|ucfirst}</i></b>
		</td>
	</tr>
	{/if}
	{if $l.PhotographerName}
	<tr>
		<td align="right">{$l.PhotographerName}</td>
	</tr>
	 {/if*}
</table>
{/foreach}
