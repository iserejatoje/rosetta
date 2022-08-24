
{if $_show_title == true || !isset($_show_title) }
	{include  file="`$TEMPLATE.menu_journals`"}<br />
{/if}

{if $page.err.message}	
	<div>
	
		{include  file="`$TEMPLATE.errors`" errors_list=$page.err.message}
	
	</div><br/><br/><br/>
{/if}

{$page.details}
{$page.list}
{$page.form}