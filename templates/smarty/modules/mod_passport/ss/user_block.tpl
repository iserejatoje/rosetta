{* входные параметры *}

{* $userinfo - массив информации о пользователе *}
{* $userid - идентификатор пользователя *}

{if $userinfo.Anonymous}

<table border="0" cellpadding="10" cellspacing="0" width="100%" style="border: 1px solid #E0F3F3; margin-top: 10px;">
	<tr valign="top">
		<td>

			<div style="background: url('/_img/modules/passport/user_unknown.gif') no-repeat center;width:100px;">
			<img border="0" src="/_img/x.gif" width="100" height="100"/></div>
		</td>
		<td width="100%">
			<div>
				<b><a>Анонимный пользователь</a></b>
			</div>				
		</td>
		<td>
		</td>
	</tr>
</table>

{else}

<table border="0" cellpadding="10" cellspacing="0" width="100%" style="border: 1px solid #E0F3F3; margin-top: 10px;">
	<tr valign="top">
		<td>

			<div style="background: 
			{if $userinfo.avatar!='' && $userinfo.avatarurl}
				url('{$userinfo.avatarurl}') 
			{else}
				url('/_img/modules/passport/user_unknown.gif') 
			{/if} no-repeat center;width:100px;">
			<a href="{$userinfo.infourl}"><img border="0" src="/_img/x.gif" width="100" height="100"/></a></div>
		</td>
		<td width="100%">
			<div>
				{if $userinfo.gender==1}
				<img src="/_img/modules/passport/icon_male_s.gif" border="0" width="12" height="12" align="left" style="margin-right:8px">
				{elseif $userinfo.gender==2}
				<img src="/_img/modules/passport/icon_female_s.gif" border="0" width="9" height="13" align="left" style="margin-right:8px">
				{/if}
				<b><a href="{$userinfo.infourl}">{$userinfo.showname}</a></b>
				{if $userinfo.showvisited}
					{ if $userinfo.current_year }
						 <div class="t11_grey" style="padding-top:4px;">{$userinfo.showvisited|user_online:"%f %H:%M":"%d %F":$userinfo.gender}</div>
					{else}
						<div class="t11_grey" style="padding-top:4px;">{$userinfo.showvisited|user_online:"%f %H:%M":"%d %F %G":$userinfo.gender}</div>
					{/if}
				{/if}
			</div>				
			{if $userinfo.citytext}
				<div>
					{$userinfo.citytext}
				</div>
			{/if}
			
			
			<div class="tip" id="user_action_{$userid}" style="padding-top:8px;">
			
			{if $type == 'myfriends' && $USER->IsAuth() && $userid != $USER->ID && !$userinfo.IsFriend}
				<div style='height:25px; margin:0px 10px 0px 0px'>
					{if $userinfo.Message.Text != ''}<div class="t11_grey" style="padding-top:4px;">{$userinfo.Message.Text}<br/><br/></div>{/if}				
					<div class="my_button_inline">
						<div class="my_button" onclick="{$userinfo.friend_approvejs}">
							<a href="/passport/friends/approve.php?id={$userid}" onclick="return false;">добавить в друзья</a>
						</div>
						<div class="my_button" onclick="{$userinfo.friend_refusejs}">
							<a href="/passport/friends/refuse.php?id={$userid}" onclick="return false;">отклонить заявку</a>
						</div>
					</div>
				</div>
			{/if}
			{if !empty($userinfo.capprovejs)}
				<div class="my_button_inline">
					<div class="my_button" onclick="{$userinfo.capprovejs}return false;">
						<a href="javascript:void(0)" onclick="return false;">Принять заявку</a>
					</div>
					<div class="my_button" onclick="{$userinfo.cdeclinejs}return false;">
						<a href="javascript:void(0)" onclick="return false;">Отклонить заявку</a>
					</div>
				</div>
			{/if}
			</div>
		</td>
		<td align="left" class="tip" id="user_functions_{$userid}">
			{if $userid != $USER->ID}
				<div class="tip" style="padding-top:5px; width:180px">
					<a href="javascript:void(0)" onclick="{$userinfo.replyjs}return false;"><img src="/_img/modules/passport/icon_sendmail.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Отправить сообщение" />Отправить сообщение</a>
				</div>
				{if $USER->IsAuth() && !$userinfo.IsFriend}
				<div class="tip" id="hide_{$userid}" style="padding-top:5px; width:180px">	
					<a href="/passport/friends/invite.php?id={$userid}"  onclick="mod_passport_friends_loader.load({$userid}, $('#hide_{$userid}'));return false;"><img src="/_img/modules/passport/icon_addfriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Добавить в друзья" />Добавить в друзья</a>
				</div>
				{elseif $USER->IsAuth() && $userinfo.IsFriend}
				<div class="tip" id="hide_{$userid}" style="padding-top:5px; width:180px">	
					<a href="/passport/friends/remove.php?id={$userid}" onclick="mod_passport_friends_loader.remove({$userid}, $('#hide_{$userid}'));return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Убрать из друзей" />Убрать из друзей</a>
				</div>
				{/if}
				<div class="tip" style="padding-top:5px; width:180px">	
					<a href="/passport/friends.php?id={$userid}"><img src="/_img/modules/passport/icon_friendslist.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Список друзей" />Список друзей</a>
				</div>
			
				{* BEGIN: Black List *}
				{if !empty($blacklist)}
				{if $userinfo.in_blacklist === true}
				<div class="tip" id="blacklist_{$userid}" style="padding-top:5px; width:180px;">
					<a href="javascript:void(0)" onclick="mod_passport_im_loader.black_list({$userid}, 'delete');return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Убрать из черного списка" />Убрать из ЧС</a>
				</div>
				<div class="tip" id="blacklist_del_{$userid}" style="padding-top:5px; width:180px;display:none;">
					<font color="red">Пользователь удален из черного списка</font>
				</div>
				{/if}
				{/if}
				{* END: Black List *}

				{if isset($userinfo.InContacts)}
					{if $userinfo.InContacts === true}
					<div class="tip" id="contactslist_del_{$userid}" style="padding-top:5px; width:180px;">
						<a href="javascript:void(0)" onclick="mod_passport_im_loader.contacts_list({$userid}, 'del');return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Убрать из черного списка" />Убрать из контактов</a>
					</div>
					{/if}
				{/if}
			{/if}
		</td>
	</tr>
</table>

{/if}