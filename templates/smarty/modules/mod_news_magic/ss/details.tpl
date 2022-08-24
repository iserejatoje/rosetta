
{if $page.NewsID }

	{$page.blocks.text}

{else}
	<br /><br />
	<center>
		Нет такой статьи.<br /><br />
		<a href="/{$CURRENT_ENV.section}/">Последняя статья</a>
	</center>
{/if}
