<form method="POST" action="_ratingchange.html">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="user" value="{$user}">
<table width="100%" cellpadding="4">
	<tr>
		<td class="ftable_header">От кого</td>
		<td class="ftable_header">За тему</td>
		<td class="ftable_header">Причина</td>
		<td class="ftable_header">Оценка</td>
		<td class="ftable_header">Дата</td>
		{if $IsModerator}<td class="ftable_header"></td>{/if}
	</tr>
{if empty($ratings)}
	<tr><td colspan="4" align="center">Нет изменения рейтинга</td></tr>
{else}
{foreach from=$ratings item=l}
	<tr>
		<td>{if $l.user.id}<a href="profile.html?user={$l.user.id}">{/if}<b>{$l.user.login}</b>{if $l.user.id}</a>{/if}</td>
		<td><a href="theme.html?id={$l.theme_id}#{$l.message_id}">{$l.theme_name}</a></td>
		<td>{$l.comment}</td>
		<td>{if $l.rating>0}+{else}-{/if}</td>
		<td>{$l.added|date_format:"%d.%m.%Y %H:%M"}</td>
		{if $IsModerator}<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>{/if}
	</tr>
{/foreach}
{/if}
</table>
{if $IsModerator}<div align="center"><input type="submit" value="Удалить"></div>{/if}
</form>