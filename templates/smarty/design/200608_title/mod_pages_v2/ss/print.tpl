<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px;">


{if is_array($page) && $page.id > 0 }

<table cellspacing="0" cellpadding="0" border="0" align="left" width="100%">
<tr>
	<td><span class="title4">{$page.name}</span>
</tr>
</table>
</td></tr>

<tr>
<td style="padding: 10px;">

{$page.text}

<script language="javascript" type="text/javascript">{literal}
	function printit() {
		window.print();
	}
	window.onload = printit;
{/literal}</script>

{else}
	<br /><br /><br /><br />
	<center>
	Материал не найден.<br /><br />
	<a href="/{$ENV.section}/">Список материалов</a>
	</center>
{/if}


</td></tr>
</table>
<p align="center"><a href="javascript:window.close();" class="copy">Закрыть</a></p>
