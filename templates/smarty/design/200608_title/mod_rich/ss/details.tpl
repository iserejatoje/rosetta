{if $page.blocks.text}
	<br/>
	{$page.blocks.text}
	<p align="right"><a href="/{$CURRENT_ENV.section}/{if !empty($page.id)}{$page.id}{else}about{/if}-print.html" class="descr" target="print" onclick="window.open('about:blank', 'print','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></p>
{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$ENV.section}/">Последняя статья</a>
	</center>
{/if}
