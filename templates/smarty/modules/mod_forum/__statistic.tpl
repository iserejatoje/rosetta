<table width="100%" cellpadding="4">
<tr style="font-size:12px;">
	<td class="ftable_header">Статистика форума</td>
</tr>
<tr>
    <td>За последние {$LAST_PERIODS.online.period} минут форум посетило {$LAST_PERIODS.online.count|number_format:0:" ":" "} {word_for_number number=$LAST_PERIODS.online.count first="человек" second="человека" third="человек"}:</td>
</tr>
<tr>
    <td class="fcontrol">
{foreach from=$LAST_USERS item=user key=id name=us}
        <a href="/{$SITE_SECTION}/profile.html?user={$id}" target="_blank">{if in_array($id,$STAT.modertors_id)}<font color="red">{$user}</font>{else}{$user}{/if}</a>{if !$smarty.foreach.us.last}, {/if}
{/foreach}
    </td>
</tr>
<tr>
    <td class="fcontrol">Оставлено сообщений сегодня: <b>{$STAT.today.all|number_format:0:" ":" "}</b> (<b>{$STAT.today.reg|number_format:0:" ":" "}</b> зарегистрированными пользователями, <b>{$STAT.today.guest|number_format:0:" ":" "}</b> гостями)
    <br />Оставлено сообщений вчера: <b>{$STAT.yesterday.all|number_format:0:" ":" "}</b> (<b>{$STAT.yesterday.reg|number_format:0:" ":" "}</b> зарегистрированными пользователями, <b>{$STAT.yesterday.guest|number_format:0:" ":" "}</b> гостями)</td>
</tr>
<tr>
    <td class="fcontrol">На форуме <b>{$STAT.messages.all|number_format:0:" ":" "}</b> сообщений.<br />
    Зарегистрировано <b>{$STAT.users.all|number_format:0:" ":" "}</b> пользователей.</td>
</tr>
{if !empty($STAT.daily.posts)}
<tr>
    <td class="fcontrol">Рекордное количество сообщений  <b>{$STAT.daily.posts.max}</b> было <b>{$STAT.daily.posts.date}</b></td>
</tr>
{/if}
<tr>
    <td class="fcontrol">5 самых активных пользователей<br />Вчера:
{foreach from=$STAT.daily.users[1] item=user name=u1}
        <a href="/{$SITE_SECTION}/profile.html?user={$user.id}" target="_blank">{if in_array($user.id,$STAT.modertors_id)}<font color="red">{$user.login}</font>{else}{$user.login}{/if}</a> (<b>{$user.cnt|number_format:0:" ":" "}</b>) {if !$smarty.foreach.u1.last}, {/if}
{/foreach}
		<br />За прошлую неделю:
{foreach from=$STAT.daily.users[7] item=user name=u7}
        <a href="/{$SITE_SECTION}/profile.html?user={$user.id}" target="_blank">{if in_array($user.id,$STAT.modertors_id)}<font color="red">{$user.login}</font>{else}{$user.login}{/if}</a> (<b>{$user.cnt|number_format:0:" ":" "}</b>) {if !$smarty.foreach.u7.last}, {/if}
{/foreach}
    </td>
</tr>
<tr>
	<td class="fcontrol">Администрация:
		{include file="design/200608_title/mod_forum/ss/admins.tpl"}
{* if count($STAT.admins) > 0}
{foreach from=$STAT.admins item=l}
		<br>&nbsp;&nbsp;&nbsp;&nbsp;<b>{$l.fio}</b>, <a href="mailto:{$l.emailshow}">{$l.emailshow}</a>, ICQ {$l.icq}
{/foreach}
{/if *}
	</td>
</tr>
</table>
