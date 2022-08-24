<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="20">&nbsp;</td>
		<td class="menu_top2{if $res.page == 'city'}_selected{/if}"><a {if $res.page != 'city'}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/city/{$CONFIG.default_city_code}.php"><span>главная</span></a></td>
		<td class="menu_top2{if $res.page == 'country'}_selected{/if}"><a {if $res.page != 'country'}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/country.php"><span>регионы</span></a></td>
	</tr>
</table>