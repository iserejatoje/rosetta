<table cellpadding=2 cellspacing=0 border=0>
	<tr>
		<td colspan="6"><img src="/_img/x.gif" height=1 width="1"></td></tr>
	<tr>
	<td>{include  file="`$TEMPLATE.title_diery`"}</td>
	<td>&nbsp;&nbsp;</td>
	
	{if $CURRENT_ENV.params!=$CONFIG.files.get.journals_record.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td>
	<td class="text11"><a href="{$CONFIG.files.get.journals_record.string}?id={$smarty.get.id}"><b>Записи</b></a></td>
	{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td>
	<td class="text11"><b>Записи</b></td>
	{/if}
	
	<td>&nbsp;&nbsp;</td>
	
	{if $CURRENT_ENV.params!=$CONFIG.files.get.journals_calendar.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td>
	<td class="text11"><a href="{$CONFIG.files.get.journals_calendar.string}?id={$smarty.get.id}"><b>Календарь записей</b></a></td>
	{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td>
	<td class="text11"><b>Календарь записей</b></td>
	{/if}

	{if $USER->ID && $USER->ID == $smarty.get.id}
	<td>&nbsp;&nbsp;</td>
		{if $CURRENT_ENV.params!=$CONFIG.files.get.journals_record_add.string}
		<td><img src="/_img/design/200608_title/b1.gif"></td>
		<td class="text11"><a href="{$CONFIG.files.get.journals_record_add.string}?id={$smarty.get.id}"><b>Добавить запись</b></a></td>
		{else}
		<td><img src="/_img/design/200608_title/b2.gif"></td>
		<td class="text11"><b>Добавить запись</b></td>
		{/if}
	{/if}

	{if $USER->ID > 0 && $USER->ID != $smarty.get.id && $smarty.get.rid > 0}
	<td>&nbsp;&nbsp;</td>
	<td><img src="/_img/design/200608_title/b1.gif"></td>
	<td class="text11"><a href="{$CONFIG.files.get.subs_subscribe.string}?type=1&uid={$smarty.get.id}&rid={$smarty.get.rid}"><b>Подписаться на новые записи</b></a></td>
	{/if}
	
	</tr>
</table>