<table style="margin-right: 8px" cellSpacing="0" cellPadding="0" border="0">
<tr valign="center" align="middle">
<td width="30"> </td>
<td class="menu_top2" onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);"><a href="/svoi/"><span>сообщества</span></a></td>
{if $USER->IsAuth() && $res.deny_favorites !== true}<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.active.string}"><span><font color="red">активные дискуссии</font></span></a></td>
<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.selected.string}"><span>избранные темы</span></a></td>{/if}
<td class="menu_top2" onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);"><a href="/passport/rules.html"><span>правила</span></a></td>
<td class="menu_top2" onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);"><a href="/help/passport/"><span>помощь</span></a></td>
<td class="menu_top2" onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);"><a href="/passport/users_online.php" style="color:#FF0000;"><span>нас {$res.user_count|number_format:0:'':' '}</span></a></td>
</tr>
</table>