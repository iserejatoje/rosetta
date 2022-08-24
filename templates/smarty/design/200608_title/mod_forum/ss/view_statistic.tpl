<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td class="ftable_header">Статистика форума</td>
</tr>
{if !empty($res.last_users_messages)}
<tr>
    <td class="fcontrol">За последние 15 минут сообщения оставили: 
{foreach from=$res.last_users_messages item=user name=us}
        <a href="{$user.infourl}" target="_blank">{if $user.type=='moderator'||$user.type=='supermoderator'||$user.type=='helpermoderator'}<font color="red">{$user.login}</font>{else}{$user.login}{/if}</a>{if !$smarty.foreach.us.last}, {/if}
{/foreach}
    </td>
</tr>
{/if}
<tr>
    <td class="fcontrol">Оставлено сообщений сегодня: <b>{$res.today.all|number_format:0:" ":" "}</b> (<b>{$res.today.reg|number_format:0:" ":" "}</b> зарегистрированными пользователями, <b>{$res.today.guest|number_format:0:" ":" "}</b> гостями)
    <br />Оставлено сообщений вчера: <b>{$res.yesterday.all|number_format:0:" ":" "}</b> (<b>{$res.yesterday.reg|number_format:0:" ":" "}</b> зарегистрированными пользователями, <b>{$res.yesterday.guest|number_format:0:" ":" "}</b> гостями)</td>
</tr>
{*<tr>
    <td class="fcontrol">На форуме <b>{$res.messages.all|number_format:0:" ":" "}</b> сообщений.<br />
    Зарегистрировано <b>{$res.users.all|number_format:0:" ":" "}</b> пользователей.</td>
</tr>*}
{if !empty($res.daily.posts.max) || !empty($res.daily.posts.date)}
<tr>
    <td class="fcontrol">Рекордное количество сообщений  <b>{$res.daily.posts.max}</b> было <b>{$res.daily.posts.date|date_format:"%d.%m.%Y"}</b></td>
</tr>
{/if}
<tr>
    <td class="fcontrol">5 самых активных пользователей<br />Вчера:
{foreach from=$res.daily.users[1] item=user name=u1}
        <a href="/passport/info.php?id={$user.id}" target="_blank">{$user.login}</a> (<b>{$user.cnt|number_format:0:" ":" "}</b>) {if !$smarty.foreach.u1.last}, {/if}
{/foreach}
		<br />За прошлую неделю:
{foreach from=$res.daily.users[7] item=user name=u7}
        <a href="/passport/info.php?id={$user.id}" target="_blank">{$user.login}</a> (<b>{$user.cnt|number_format:0:" ":" "}</b>) {if !$smarty.foreach.u7.last}, {/if}
{/foreach}
    </td>
</tr>
{if !empty($res.month.users) || !empty($res.month.themes) || !empty($res.month.messages)}
<tr>
    <td class="fcontrol">За месяц на форуме <b>{$res.month.users|number_format:0:" ":" "}</b> пользователей создали <b>{$res.month.themes|number_format:0:" ":" "}</b> тем и оставили <b>{$res.month.messages|number_format:0:" ":" "}</b> сообщений</td>
</tr>
{/if}

<tr>
	<td class="fcontrol">{*Администрация:
		{include file=$TEMPLATE.ssections.admins} *}
{* if count($res.admins) > 0}
{foreach from=$res.admins item=l}
		<br>&nbsp;&nbsp;&nbsp;&nbsp;<b>{$l.fio}</b>, <a href="mailto:{$l.emailshow}">{$l.emailshow}</a>, ICQ {$l.icq}
{/foreach}
{/if *}
	</td>
</tr>
</table>

