<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px 10px 10px 10px;">
{if $page.id }
	{$page.blocks.text}

{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$SITE_SECTION}/{$page.group}">Последняя статья</a>
	</center>
{/if}
</td></tr>
</table>