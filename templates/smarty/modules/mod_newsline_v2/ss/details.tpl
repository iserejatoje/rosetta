{if $page.id }

	{$page.blocks.text}

	{$page.blocks.crossref}

	{if $page.is_otz}
		{$page.blocks.comments}
		{$page.blocks.askform}
	{/if}

{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$SITE_SECTION}/{$page.group}">Последняя статья</a>
	</center>
{/if}
