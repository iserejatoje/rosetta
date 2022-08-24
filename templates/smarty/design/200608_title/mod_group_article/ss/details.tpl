{if $page.group.GroupID }
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td></td>
			<td align="right" nowrap="nowrap">
				{if !$page.article
				}Весь текст{
				else}<a href="/{$CURRENT_ENV.section}/{$page.group.GroupID}.html">Весь текст</a>{/if
				}{if $page.article} | Постранично{elseif $page.blocks.first_article} | <a href="/{$CURRENT_ENV.section}/{$page.group.GroupID}/{$page.blocks.first_article.ArticleID}.html">Постранично</a>{/if}
			</td>
		</tr>
		<tr>
			<td class="title2_news" width="100%">{$page.group.Name}</td>
			<td align="right" width="120" style="font-size: 12px;" class="title" nowrap="nowrap">
				{$page.group.Date|date_format:"%e"} {$page.group.Date|month_to_string:2} {$res.group.Date|date_format:"%Y"}
			</td>
		</tr>
		<tr>
			<td colspan="2"><img height="10" border="0" width="1" alt="" src="/_img/x.gif"/></td>
		</tr>
		<tr class="title2_news"> 
			<td colspan="2" class="title2_news">{$page.group.Text}</td>
		</tr>
	</table>

	{$page.blocks.list}
	
	{if $page.group.AuthorName}
	<div align="right">
		<b>{if $page.group.AuthorEmail}{$page.group.AuthorName} ({$page.group.AuthorEmail|mailto_crypt}){else}{$page.group.AuthorName}{/if}, <i>специально для {$CURRENT_ENV.site.domain|ucfirst}</i></b>
	</div>
	{/if}

{else}
	<br /><br />
	<center>
		Нет такой статьи.<br /><br />
		<a href="/{$CURRENT_ENV.section}/">Последняя статья</a>
	</center>
{/if}
