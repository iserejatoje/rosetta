{if !empty($res.friend)}
<div align="center" style="padding-top:8px;">
	{include file=$config.templates.users_block user=$res.friend}
    <div style="padding-top:6px;padding-bottom:4px;">{if !empty($res.friend.text)}{$res.friend.text|nl2br|truncate:500}{else}хочет, чтобы вы добавили {if $res.friend.gender==2}ее{else}его{/if} в друзья{/if}</div>
    <div align="center">
		<input type="button" onclick="{$res.friend.approvejs}{$widget.instance}.reload();return false;" value="добавить" />
		<input type="button" onclick="{$res.friend.refusejs}{$widget.instance}.reload();return false;" value="отклонить" />
	</div>
</div>
{elseif !empty($res.invite)}
<div align="center" style="padding-top:8px;">
	<a href="/a{$res.invite.user.id}">{$res.invite.user.name}</a><br/>приглашает Вас вступить в сообщество

    <div style="padding-top:6px;padding-bottom:4px;"><b>&laquo;<a href="/svoi/community/{$res.invite.id}/">{$res.invite.name}</a>&raquo;</b></div>
	
	{if $res.invite.logotype.file}
	<a href="/svoi/community/{$res.invite.id}/"><img src="{$res.invite.logotype.file}" border="0" width="{$res.invite.logotype.w}" height="{$res.invite.logotype.h}" /></a>
	{/if}
    <div style="padding-top:6px;padding-bottom:4px;">{$res.invite.description}</b></div>
	
    <div align="center">
		<input type="button" onclick="{$res.invite.enterjs}return false;" value="вступить" />
		<input type="button" onclick="{$res.invite.refusejs}return false;" value="отклонить" />
	</div>
</div>
{else}
<input type="hidden" class="widgetMessagesMId" value="{$res.lastmessage.MessageID}" />
<table width="100%" cellspacing="4" cellpadding="0" border="0" >
	{if $res.newmessages_count > 0}
	<tr>
		<td class="tip" align="center"><a href="{$res.folders.incoming.url}">Новых сообщений: {if $res.newmessages_count>0}<b>{$res.newmessages_count}</b>{else}0{/if}</a></td>
	</tr>
	{else}
	<tr>
		<td class="tip" align="center"><a href="{$res.folders.incoming.url}">Входящие</a>&nbsp;&nbsp;&nbsp;<a href="{$res.folders.outcoming.url}">Исходящие</a>&nbsp;&nbsp;&nbsp;<a href="{$res.folders.contacts.url}">Контакты</a><br/><br/></td>
	</tr>
	<tr>
		<td align="center">Новых сообщений нет<br/></td>
	</tr>
	{/if}
	{if is_array($res.lastmessage)}
	<tr>
		<td class="tip" align="center">{$res.lastmessage.Created|simply_date}</td>
	</tr>
	<tr>
		<td class="tip" align="center"><b><a href="{$res.userinfo->Profile.general.InfoUrl}">{$res.userinfo->Profile.general.ShowName}{*$res.lastmessage.NickNameFrom*}</a></b></td>
	</tr>
	{if $res.userinfo->ID != 0}
	<tr>
		<td align="center">
			<a class="pcomment" target="_blank" href="{$res.userinfo->Profile.general.InfoUrl}">
			{if $res.userinfo->Profile.general.AvatarUrl!=''}
			<img border="0" src="{$res.userinfo->Profile.general.AvatarUrl}" width="{$res.userinfo->Profile.general.AvatarWidth}" height="{$res.userinfo->Profile.general.AvatarHeight}">
			{else}
			<img border="0" src="/_img/modules/passport/user_unknown.gif" width="90" height="90">
			{/if}
				{*<img border="0" src="{$res.userinfo->Profile.general.AvatarUrl}" width="{$res.userinfo->Profile.general.AvatarWidth}" height="{$res.userinfo->Profile.general.AvatarHeight}">*}
			</a>
		</td>
	</tr>
	{/if}	
	<tr>
		<td>
			<div style="padding-bottom:4px;" class="dop" align="center">{if !empty($res.lastmessage.Type)}<b>{$res.lastmessage.DType}{if !empty($res.lastmessage.RefererTitle)}:{/if}</b>{/if} {if !empty($res.lastmessage.RefererTitle)}{if !empty($res.lastmessage.RefererUrl)}<a href="{$res.lastmessage.RefererUrl}">{/if}{$res.lastmessage.RefererTitle}{if !empty($res.lastmessage.RefererUrl)}</a>{/if}{/if}</div>
			<div align="center" style="padding-bottom:4px;">{$res.lastmessage.Text|truncate:500|with_href|nl2br}</div>
			{if $res.lastmessage.File}
			<div class="tip" align="center">Прикрепленный файл<br /><a href="{$res.lastmessage.File.Url}" target="_blank">{$res.lastmessage.File.NameOriginal|truncate:20}</a><br /><br /></div>
			{/if}
			<div align="center">
				<input type="button" onclick="{$res.replyjs}{$widget.instance}.reload();return false;" value="ответить" />
				<input type="button" onclick="" class="widgetButtonReload" value="закрыть" />
			</div>
		</td>
	</tr>
	{/if}
</table>
{/if}
