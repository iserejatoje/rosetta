<table cellpadding="0" cellspacing="0" border="0">
<tr align="center" valign="middle">
	<td class="gl"><a href="/{$CURRENT_ENV.section}/" id="mapLink">Ссылка на эту страницу</a></td>
	<td class="gl" width="20px"></td>
	<td class="gl"><a target="mapLinkPrint" href="/{$CURRENT_ENV.section}/print.php" id="mapLinkPrint"
	onclick="window.open(this.href, 'mapLinkPrint','width=640,height=740,resizable=1,menubar=0,scrollbars=1').focus();">Печать</a></td>
	{if !empty($BLOCKS.header.menu_small_feedback)}
	<td class="gl" width="20px"></td>
	<td class="gl">{$BLOCKS.header.menu_small_feedback}</td>
	{/if}
</tr>
</table>
