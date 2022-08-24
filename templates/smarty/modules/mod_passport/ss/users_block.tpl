
{* входные параметры *}

{* $userinfo - массив информации о пользователе *}
{* $userid - идентификатор пользователя *}
{* $countries - список стран *}
{* $regions - список регионов/областей *}
{* $cities - список городов *}
{* $canchangeusertype - возможность изменения типа пользоватя, СОЦИАЛЬНАЯ СЕТЬ *}

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
					{if $userinfo.gender==1
					}<img src="/_img/modules/passport/icon_male_s.gif" border="0" width="12" height="12" align="left" style="margin-right:8px">{elseif $userinfo.gender==2
					}<img src="/_img/modules/passport/icon_female_s.gif" border="0" width="9" height="13" align="left" style="margin-right:8px">{
					/if}
					<b><a href="{$userinfo.infourl}">{$userinfo.showname}{*{if $userinfo.lastname || $userinfo.firstname
					}{$userinfo.lastname} {$userinfo.firstname} {$userinfo.midname} ({$userinfo.nickname}){else
					}{$userinfo.nickname}{
					/if}*}</a></b>
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
				
				{if is_array($userinfo.place_list) && sizeof($userinfo.place_list)}
					{if $userinfo.place_type == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION') || $userinfo.place_type == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')}
					<div>Образование<br/>
					{elseif $userinfo.place_type == constant('PlaceSimpleMgr::PT_GENERAL')}
					<div>Место работы<br/>
					{/if}
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
					{foreach from=$userinfo.place_list item=l}
					<tr valign="top">
						<td style="padding-left:40px;">
						<div>
							<div class="profile_div">
							{if $l.TypeID == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION')}
								
								{if $l.UsersCount > 0}
									{if $l.CityText}{$l.CityText}, {/if}<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=2&val={$l.PlaceID}">{$l.Name}</a> <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=2&val={$l.PlaceID}" title="Список пользователей" class="text11"><font color="red">{$l.UsersCount|number_format:0:'':' '}</font></a> </span>
								{else}
									{if $l.CityText}{$l.CityText}, {/if}<b>{$l.Name}</b>
								{/if}
								
								{capture name=place}
									{if $l.Faculty}факультет {$l.Faculty}{if $l.Chair},{/if}{/if}
									{if $l.Chair}кафедра {$l.Chair}{if $l.YearStart},{/if}{/if}
									{if $l.YearStart}{$l.YearStart} - {if $l.YearEnd}{$l.YearEnd} г.{else}по настоящее время{/if}{/if}
								{/capture}
								
								{if trim($smarty.capture.place)}
								({$smarty.capture.place|trim})
								{/if}
							{elseif $l.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')}
								{if $l.UsersCount > 0}
									{if $l.CityText}{$l.CityText}, {/if}<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=3&val={$l.PlaceID}">{$l.Name}</a> <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=3&val={$l.PlaceID}" title="Список пользователей" class="text11"><font color="red">{$l.UsersCount|number_format:0:'':' '}</font></a> </span>
								{else}
									{if $l.CityText}{$l.CityText}, {/if}<b>{$l.Name}</b>
								{/if}

								{capture name=place}
									{if $l.YearStart}{$l.YearStart} - {if $l.YearEnd}{$l.YearEnd} г.,{else}по настоящее время,{/if}{/if}
									{if $l.Class}{$l.Class} класс{/if}
								{/capture}
								
								{if trim($smarty.capture.place)}
								({$smarty.capture.place|trim})
								{/if}
							{elseif $l.TypeID == constant('PlaceSimpleMgr::PT_GENERAL')}
								{if $l.UsersCount > 0}
									<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=1&val={$l.PlaceID}"><b>{$l.Name}</b></a> <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id=1&val={$l.PlaceID}" title="Список пользователей" class="text11"><font color="red">{$l.UsersCount|number_format:0:'':' '}</font></a> </span>
								{else}
									{$l.Name}
								{/if}
								{if $l.CityText} ({$l.CityText}){/if}
								{if $l.Position}<br/>Должность: {$l.Position}{/if}
								{if $l.YearStart} ({$l.YearStart} - {if $l.YearEnd}{$l.YearEnd}{else}по настоящее время{/if}) {/if}
							{/if}
							</div>
						</div>
						</td>
					</tr>
					{/foreach}
					</table>
					</div>
				{/if}
				<div class="tip" id="user_action_{$userid}" style="padding-top:8px;">
				{if $USER->IsAuth() && $userid != $USER->ID && $userinfo.IsFriend && !$userinfo.Approved && $userinfo.IsInvitedFriend}
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
					{elseif $USER->IsAuth() && $userinfo.IsFriend && $userinfo.Approved}
					<div class="tip" id="hide_{$userid}" style="padding-top:5px; width:180px">	
						<a href="/passport/friends/remove.php?id={$userid}" onclick="mod_passport_friends_loader.remove({$userid}, $('#hide_{$userid}'));return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Убрать из друзей" />Убрать из друзей</a>
					</div>
					{/if}
					<div class="tip" style="padding-top:5px; width:180px">	
						<a href="/passport/friends.php?id={$userid}"><img src="/_img/modules/passport/icon_friendslist.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Список друзей" />Список друзей</a>
					</div>
					{* BEGIN: социалка *}
					{if !empty($canchangeusertype) && $userinfo.type!='invited'}
					{if $USER->ID==2 || $USER->ID==8}
					<div class="tip" id="hide_cblacklist_{$userid}" style="padding-top:5px; width:180px;{if $userinfo.type=='blacklist'}display:none;{/if}">
						<a href="javascript:void(0)" onclick="{$userinfo.setblacklistjs}return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Добавить в черный список" />В черный список</a>
					</div>
					{/if}
					<div class="tip" id="hide_cmoderator_{$userid}" style="padding-top:5px; width:180px;{if $userinfo.type=='moderator'}display:none;{/if}">
						<a href="javascript:void(0)" onclick="{$userinfo.setmoderatorjs}return false;"><img src="/_img/modules/passport/icon_addfriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Сделать модератором" />Сделать модератором</a>
					</div>
					<div class="tip" id="hide_cuser_{$userid}" style="padding-top:5px; width:180px;{if $userinfo.type=='user'}display:none;{/if}">
						<a href="javascript:void(0)" onclick="{$userinfo.setuserjs}return false;"><img src="/_img/modules/passport/icon_addfriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Сделать пользователем" />Сделать пользователем</a>
					</div>
					<div class="tip" id="user_caction_exit_{$userid}" style="padding-top:5px; width:180px;">
						<a href="javascript:void(0)" onclick="{$userinfo.exituserjs}return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Исключить из сообщества" />Искл. из сообщества</a>
					</div>
					<div class="tip" id="user_caction_enter_{$userid}" style="padding-top:5px; width:180px;display:none;">
						<font color="red">Пользователь исключен из сообщества</font>
					</div>
					{elseif !empty($canchangeusertype) && $userinfo.type=='invited'}
					<div class="tip" id="hide_crefuse_{$userid}" style="padding-top:5px; width:180px;">
						<a href="javascript:void(0)" onclick="{$userinfo.removeinvitejs}return false;"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Отклонить приглашение" />Отклонить приглашение</a>
					</div>
					{/if}
					{if $userinfo.communityinvitejs}
					<div class="tip" id="hide_cinvite_{$userid}" style="padding-top:5px; width:180px;">
						<a href="javascript:void(0)" onclick="{$userinfo.communityinvitejs}return false;"><img src="/_img/modules/passport/icon_addfriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="left" title="Пригласить в сообщество" />Пригласить в сообщество</a>
					</div>
					{/if}
					{* END: социалка *}
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
				{/if}
			</td>
		</tr>
	</table>
	
	{/if}