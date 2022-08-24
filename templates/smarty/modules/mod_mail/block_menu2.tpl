<table cellpadding="0" cellspacing="0" border="0">
<tr align="center" valign="middle">
{if $res.is_auth}
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2_red"><span><a href="/{$ENV.section}/{$CONFIG.files.get.checkmail.string}">Проверить почту</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/{$ENV.section}/{$CONFIG.files.get.message_new.string}">Написать письмо</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="#" onclick="mod_mail_clear_trash(); return false;">Очистить корзину</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/{$ENV.section}/{$CONFIG.files.get.addressbook.string}">Адреса</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/passport/profile/mail.php">Настройки</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/help/mail/">Помощь</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/passport/logout.php{if isset($CONFIG.mail_services[$res.mail_services])}?url={$CONFIG.mail_services[$res.mail_services].url_logout|urlencode}{/if}">Выход</a></span></td>
{else}
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/passport/login.php">Вход</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/passport/reg.php">Регистрация</a></span></td>
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/help/mail/">Помощь</a></span></td>
{/if}
</tr>
</table>
