<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="30">&nbsp;</td>
		<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.view.string}">главная</a></span></td>
		<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.active.string}"><font color="red">активные дискуссии</font></a></span></td>
		{if $USER->IsAuth() && $res.deny_favorites !== true}<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.selected.string}">избранные темы</a></span></td>{/if}
		<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/help/services/forum/">помощь</a></span></td>
		{*<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.rules.string}">правила</a></span></td>*}
		<td>&nbsp;&nbsp;</td>
	</tr>
</table>