<table cellpadding=2 cellspacing=0 border=0>
<tr><td colspan="3"><img src="/_img/x.gif" height=1 width="1"></td></tr>
<tr>
{if $CURRENT_ENV.params!=$CONFIG.files.get.subs_dnevniki.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td><td class="text11"><a href="{$CONFIG.files.get.subs_dnevniki.string}"><b>Дневники</b></a></td>
{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td><td class="text11"><b>Дневники</b></td>
{/if}
<td>&nbsp;&nbsp;</td>
{if $CURRENT_ENV.params!=$CONFIG.files.get.subs_comments.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td><td class="text11"><a href="{$CONFIG.files.get.subs_comments.string}"><b>Комментарии</b></a></td>
{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td><td class="text11"><b>Комментарии</b></td>
{/if}
</tr>
</table>