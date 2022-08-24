{if !empty($res.friend)}
<div class="sticker">
	<div class="top"></div>
	<div class="bottom"></div>
	<div class="content">
<div class="events">
	<div class="image" style="background-image: url('{if $res.friend.avatarurl!=''}{$res.friend.avatarurl}{else}/_img/modules/passport/user_unknown.gif{/if}')"><a href="{$res.friend.infourl}"><img src="/_img/x.gif" width="100" height="100" /></a></div>
	<div class="name"><a href="{$res.friend.infourl}">{$res.friend.showname}</a></div>
	{if $res.friend.showvisited}
	<div class="visited">{$res.friend.showvisited|user_online:"%f %H:%M":"%d %F":$res.friend.gender}</div>
	{/if}
	<div class="text">
		{if !empty($res.friend.text)}{$res.friend.text|nl2br|truncate:500}{else}хочет, чтобы вы добавили {if $res.friend.gender==2}ее{else}его{/if} в друзья{/if}
	</div>
	<div class="buttons">
		<a href="javascript:void(0);" onclick="{$res.friend.approvejs}{$widget.instance}.reload();return false;">Добавить</a>
		&nbsp;&nbsp;
		<a href="javascript:void(0);" onclick="{$res.friend.refusejs}{$widget.instance}.reload();return false;">Отклонить</a>
	</div>
</div>
	</div>
</div>
{elseif !empty($res.invite)}
<div class="sticker">
	<div class="top"></div>
	<div class="bottom"></div>
	<div class="content">
<div class="events">
	<div class="title"><a href="/a{$res.invite.user.id}">{$res.invite.user.name}</a><br />приглашает Вас вступить в сообщество</div>
	<div class="name"><b>&laquo;<a href="/svoi/community/{$res.invite.id}/">{$res.invite.name}</a>&raquo;</b></div>

	{if $res.invite.logotype.file}
	<div class="image" style="background-image: url('{$res.invite.logotype.file}')"><a href="/svoi/community/{$res.invite.id}/"><img src="/_img/x.gif" width="100" height="100" /></a></div>
	{/if}
	<div class="text">
		{$res.invite.description}
	</div>
	<div class="buttons">
		<a href="javascript:void(0);" onclick="{$res.invite.enterjs}return false;">Принять</a>
		&nbsp;&nbsp;
		<a href="javascript:void(0);" onclick="{$res.invite.refusejs}return false;">Отклонить</a>
	</div>
</div>
	</div>
</div>
{elseif is_array($res.lastmessage)}
<div class="sticker">
	<div class="top"></div>
	<div class="bottom"></div>
	<div class="content">
<div class="events">
<input type="hidden" class="widgetMessagesMId" value="{$res.lastmessage.MessageID}" />

		<div class="date">{$res.lastmessage.Created|simply_date}</div>
		<div class="title">Вам новое сообщение от</div>
		{if $res.userinfo->ID != 0}
			<div class="image" style="background-image: url('{if $res.userinfo->Profile.general.AvatarUrl!=''}{$res.userinfo->Profile.general.AvatarUrl}{else}/_img/modules/passport/user_unknown.gif{/if}')"><a href="{$res.userinfo->Profile.general.InfoUrl}"><img src="/_img/x.gif" width="100" height="100" /></a></div>
			<div class="name"><a href="{$res.userinfo->Profile.general.InfoUrl}">{$res.userinfo->Profile.general.ShowName}</a></div>
			{if $res.userinfo->Profile.general.showvisited}
			<div class="visited">{$res.userinfo->Profile.general.showvisited|user_online:"%f %H:%M":"%d %F":$res.userinfo->Profile.general.gender}</div>
			{/if}
		{/if}	
		<div class="text">
			{$res.lastmessage.Text|with_href|nl2br|truncate:500}
		</div>
		<div class="buttons">
			<a href="javascript:void(0);" onclick="{$res.replyjs}{$widget.instance}.reload();return false;">Ответить</a>
			&nbsp;&nbsp;
			<a href="javascript:void(0);" class="widgetButtonReload">Закрыть</a>
		</div>
			<br/>	
			<div style="padding-bottom:4px;" class="dop" align="center">{if !empty($res.lastmessage.Type)}<b>{$res.lastmessage.DType}{if !empty($res.lastmessage.RefererTitle)}:{/if}</b>{/if} {if !empty($res.lastmessage.RefererTitle)}{if !empty($res.lastmessage.RefererUrl)}<a href="{$res.lastmessage.RefererUrl}">{/if}{$res.lastmessage.RefererTitle}{if !empty($res.lastmessage.RefererUrl)}</a>{/if}{/if}</div>
			{if $res.lastmessage.File}
			<div class="text" align="center">Прикрепленный файл<br /><a href="{$res.lastmessage.File.Url}" target="_blank">{$res.lastmessage.File.NameOriginal|truncate:20}</a><br /><br /></div>
			{/if}
				
</div>
	</div>
</div>
{/if}
