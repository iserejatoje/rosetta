<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="20">&nbsp;</td>
	{if $USER->IsAuth()}
		{if $res.can_switch_user===true}
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.switch.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.switch.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.switch.string}">переключиться</a></span></td>
		{/if}
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.mypage.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.mypage.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}">моя страница</a></span></td>
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.profile.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.profile.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.profile.string}">настройки</a></span></td>
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.rules.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.rules.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.rules.string}">правила</a></span></td>
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.search.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.search.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.search.string}">пользователи</a></span></td>
		
		{*<td class="menu_top2"><span><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$ENV.section}/{$CONFIG.files.get.logout.string}">выход</a></span></td>*}
	{else}
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.login.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.login.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.login.string}">вход</a></span></td>
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.register.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.register.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.register.string}">регистрация</a></span></td>
		<td class="menu_top2{if $CURRENT_ENV.params == $CONFIG.files.get.rules.string}_selected{/if}"><span><a {if $CURRENT_ENV.params != $CONFIG.files.get.rules.string}onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);"{/if} href="/{$ENV.section}/{$CONFIG.files.get.rules.string}">правила</a></span></td>
	{/if}
		{*{if !empty($res.back_url)}
		<td class="menu_top2"><span><a title="вернуться{if !empty($res.section_name)} на:{$res.section_domain} - {$res.section_name}{/if}" onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="{$res.back_url}">вернуться
			{if !empty($res.section_name)}
			на: {$res.section_domain}{if strlen($res.section_name) < 16} - {$res.section_name}{/if}
			{/if}
		</a></span></td>
		{/if}*}
		{if !empty($res.back_url)}
		<td class="menu_top2"><span><a title="вернуться" onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="{$res.back_url}">вернуться
		</a></span></td>
		{/if}
		<td>&nbsp;&nbsp;</td>
	</tr>
</table>
