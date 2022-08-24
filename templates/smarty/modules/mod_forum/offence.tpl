{if $IsModerator}<form method="POST" action="_offencechange.html">
<input type="hidden" name="action" value="minus">
<input type="hidden" name="user" value="{$user}">{/if}
<table width="100%" cellpadding="4">
<tr>
	<td class="ftable_header">Модератор</td>
	<td class="ftable_header">Уровень наказания</td>
	<td class="ftable_header">До</td>
	<td class="ftable_header">Комментарий</td>
	{if $IsModerator}<td class="ftable_header"></td>{/if}
</tr>
{if empty($offences)}
<tr><td colspan="4" align="center">Список нарушений пуст</td></tr>
{else}
{foreach from=$offences item=l}
<tr>
	<td>{if $l.moderator.id}<a href="profile.html?user={$l.moderator.id}">{/if}<b>{$l.moderator.login}</b>{if $l.moderator.id}</a>{/if}</td>
	<td>{if $l.penalty==0}Предупреждение{elseif $l.penalty==$max_penalty}Блок{else}{$l.penalty}{/if}</td>
	<td>{$l.still|date_format:"%d.%m.%Y %H:%M"}</td>
	<td>{$l.comment}<br>{$l.themename}</td>
	{if $IsModerator}<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>{/if}
</tr>
{/foreach}
{/if}
</table>
{if $IsModerator}<div align="center"><input type="submit" value="Удалить"></div>
</form>{/if}