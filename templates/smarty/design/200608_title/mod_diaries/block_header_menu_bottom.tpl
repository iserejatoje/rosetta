
{if !empty($smarty.get.id) || !empty($USER->ID)}
<table cellpadding="0" cellspacing="0" border="0">
<tr align="center" valign="middle">
	{if $CURRENT_ENV.params!=$CONFIG.files.get.journals_profile.string}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/passport/info.php?id={if $smarty.get.id}{$smarty.get.id}{else}{$USER->ID}{/if}"><span>Информация</span></a></td>
	{else}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2_selected"><span>Информация</span></td>
	{/if}
	{if $CURRENT_ENV.params!=$CONFIG.files.get.journals_record.string && $CURRENT_ENV.params!=$CONFIG.files.get.journals_comment.string && $CURRENT_ENV.params!=$CONFIG.files.get.journals_calendar.string}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/{$ENV.section}/{$CONFIG.files.get.journals_record.string}?id={if $smarty.get.id}{$smarty.get.id}{else}{$USER->ID}{/if}"><span>Дневник</span></a></td>
	{else}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2_selected"><span>Дневник</span></td>
	{/if}
	{if $CURRENT_ENV.params!=$CONFIG.files.get.gallery_list.string && $CURRENT_ENV.params!=$CONFIG.files.get.gallery_details.string && $CURRENT_ENV.params!=$CONFIG.files.get.gallery_comment.string && $CURRENT_ENV.params!=$CONFIG.files.get.gallery_addimg.string && $CURRENT_ENV.params!=$CONFIG.files.get.gallery_addfolder.string && $CURRENT_ENV.params!=$CONFIG.files.get.gallery_editgallery.string}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/{$ENV.section}/{$CONFIG.files.get.gallery_list.string}?id={if $smarty.get.id}{$smarty.get.id}{else}{$USER->ID}{/if}"><span>Фотоальбом</span></a></td>
	{else}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2_selected"><span>Фотоальбом</span></td>
	{/if}
{if ($USER->isAuth() && $smarty.get.id==$USER->ID) || ($USER->isAuth() && empty($smarty.get.id))}
	{if $CURRENT_ENV.params!=$CONFIG.files.get.subs_dnevniki.string && $CURRENT_ENV.params!=$CONFIG.files.get.subs_comments.string}	
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><a href="/{$ENV.section}/{$CONFIG.files.get.subs_dnevniki.string}"><span>Подписка</span></a></td>
	{else}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2_selected"><span>Подписка</span></td>
	{/if}
{/if}
</tr>
</table>
{/if}