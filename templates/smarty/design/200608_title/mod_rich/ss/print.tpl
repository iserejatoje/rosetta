<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px 10px 10px 10px;">
{if $page.blocks.text}
<script language="javascript" type="text/javascript">{literal}
	function printit() {
		window.print();
	}
	window.onload = printit;
{/literal}</script>
	<br/><br/>{$page.blocks.text}

{else}
	<br /><br />
	<center>
	Нет такой статьи.<br /><br />
	<a href="/{$SITE_SECTION}/{$page.group}">Последняя статья</a>
	</center>
{/if}
</td></tr>
</table>
<p align=center class="copy"><a href='javascript:window.close()'>Закрыть</a></p>