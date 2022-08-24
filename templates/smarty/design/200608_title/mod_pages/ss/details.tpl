{if $page.id }

	 {$page.blocks.text}

{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$SITE_SECTION}/{$page.group}">Последняя статья</a>
	</center>
{/if}
