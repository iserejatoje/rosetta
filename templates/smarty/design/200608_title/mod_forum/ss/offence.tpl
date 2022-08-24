{$page.header}<br>
Пользователь: <a href="/passport/info.php?id={$page.user->ID}" target="_blank">{$page.user->Profile.general.ShowName}</a><br>
{if $page.canoffence}<form method="POST">
<input type="hidden" name="action" value="offence_minus">
<input type="hidden" name="user" value="{$page.user->ID}">{/if}
<table width="100%" cellpadding="4">
<tr>
	<td class="ftable_header">Модератор</td>
	<td class="ftable_header">Уровень наказания</td>
        <td class="ftable_header">Выставлено</td>
	<td class="ftable_header">До</td>
	<td class="ftable_header">Комментарий</td>
	{if $page.canoffence}<td class="ftable_header"></td>{/if}
</tr>
{if empty($page.offences)}
<tr><td colspan="5" align="center">Список нарушений пуст</td></tr>
{else}
{foreach from=$page.offences item=l}
<tr>
	<td>{if $l.moderator->ID}<a href="/passport/info.php?id={$l.moderator->ID}">{/if}<b>{$l.moderator->NickName}</b>{if $l.moderator->ID}</a>{/if}</td>
	<td>{if $l.penalty==0}Предупреждение{elseif $l.penalty==$CONFIG.max_penalty}Блок{else}{$l.penalty}{/if}</td>
        <td>{$l.date_offence|date_format:"%d.%m.%Y %H:%M"}</td>
	<td>{$l.still|date_format:"%d.%m.%Y %H:%M"}</td>
	<td>
            {$l.comment}<br />
            <small>Тема: <a href="{$l.theme_url}" target="_blank">{$l.themename}</a></small>
        </td>
	{if $page.canoffence}<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>{/if}
</tr>
{/foreach}
{/if}
</table>
{if $page.canoffence}<div align="center"><input type="submit" value="Удалить"></div>
</form>{/if}