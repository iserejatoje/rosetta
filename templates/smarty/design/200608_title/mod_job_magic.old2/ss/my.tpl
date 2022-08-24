{if isset($page.firm_form)}
	{$page.firm_form}
{/if}

{if isset($page.list_vacancy) || isset($page.list_resume)}
	{if isset($page.list_vacancy) && isset($page.list_resume)}
		{include file="`$TEMPLATE.sectiontitle`" rtitle="Размещенные вакансии и резюме"}
	{/if}

	{if isset($page.list_vacancy)}
		{$page.list_vacancy}<br/><br/>
	{/if}

	{if isset($page.list_resume)}
		{$page.list_resume}<br/><br/>
	{/if}
{/if}
