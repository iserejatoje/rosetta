{if is_array($page) && $page.id > 0 }

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="title4">{$page.name}</td></tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="justify">
			<!-- Text article -->
			{$page.text|screen_href|mailto_crypt}
			<!-- Text article: end -->
		</td>
	</tr>
	<tr>
		<td height="1px"></td>
	</tr>
</table>
<p align="right"><a href="{$page.link}-print" class="descr" target="print" onclick="window.open('{$page.link}-print', 'print','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus(); return false;">Версия для печати</a></p>

{else}
	<br /><br /><br /><br />
	<center>
	Материал не найден.<br /><br />
	<a href="/{$ENV.section}/">Список материалов</a>
	</center>
{/if}
