{if (count($page) == 0)}
<br /><br />
	<br />
	<div class="title">Запрашиваемый Вами пользователь не существует.</div>

{else}

{if isset($page.IsDel) && $page.IsDel === true}

<br /><br />
	<br />
	<div class="title">Пользователь удалил свою страницу.</div>

{else}

{literal}
<style>
.profile_div {
	padding-top:8px;
	padding-bottom:8px;
}
</style>
<script language="javascript" type="text/javascript">
function show_photo()
{
	var obj = document.getElementById('photo');
	if (obj.style.visibility == 'hidden')
		obj.style.visibility = 'visible';
	else
		obj.style.visibility = 'hidden';
}
</script>
{/literal}

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4"><span>Личная информация</span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr valign="top">
	<td>
			<div style="position:relative;">
			
			{if ($page.form.photo.file!='')}
			 	<img src="{$page.form.photo.file}" border="0" alt="{$page.form.showname}" height="{$page.form.photo.h}" width="{$page.form.photo.w}" />
			{else}
				{if ($page.form.avatar.file!='')}
				 	<img src="{$page.form.avatar.file}" border="1" height="{$page.form.avatar.h}" width="{$page.form.avatar.w}">
				{else}
				 	<img src="/_img/modules/passport/user_unknown.gif" width="90" height="90" />
				{/if}
			{/if}
			
			{if !empty($page.Gallery)}
			<div style="padding:10px" align="center">
			<a href="/user/{$page.UserID}/gallery/">Фотогалерея</a>
			</div>
			{/if}
			
			{*/if*}
			</div>
		</td>
	<td width="100%" style="padding-left:20px;">
		<div class="title">{if $page.form.gender==1}<img src="/_img/modules/passport/icon_male_s.gif" border="0" width="12" height="12" align="bottom" style="margin-right:5px" />{elseif $page.form.gender==2}<img src="/_img/modules/passport/icon_female_s.gif" border="0" width="9" height="13" align="bottom" style="margin-right:5px;" />{/if}{$page.form.showname}</div>
		{if $page.form.showvisited}
		<div class="t11_grey">{$page.form.showvisited|user_online:"%f %H:%M":"%d %F":$page.form.gender}</div>
		{/if}
      
		{if $page.form.birthday_day != 0 || $page.form.birthday_month != 0 || $page.form.birthday_year != 0 || $page.form.height != 0 || $page.form.weight != 0}
		<div class="profile_div">
		{if $page.form.birthday_day != 0 || $page.form.birthday_month != 0 || $page.form.birthday_year != 0}
			<span class="t11_grey">Дата рождения:</span>
				{if $page.form.birthday_day!=0 && $page.form.birthday_month!=0}
					<b>{$page.form.birthday_day} </b>
					<b>{$page.form.birthday_month|month_to_string:2
					}</b>{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $page.form.static.birthday_month_day.count > 0}<span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.birthday_month_day.type}&val={$page.form.static.birthday_month_day.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.birthday_month_day.count|number_format:0:'':' '}</font></a></span>{/if}
				{else}
					{if $page.form.birthday_day!=0}<b>{$page.form.birthday_day}</b>{/if} 
					{if $page.form.birthday_month!=0}
						<b>{$page.form.birthday_month|month_to_string:2
						}</b>{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $page.form.static.birthday_month.count > 0}<span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.birthday_month.type}&val={$page.form.static.birthday_month.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.birthday_month.count|number_format:0:'':' '}</font></a></span>{/if}
					{/if} 
				{/if}{if $page.form.birthday_year != 0}
					<b>{$page.form.birthday_year}</b>
					{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $page.form.static.birthday_year.count > 0}<span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.birthday_year.type}&val={$page.form.static.birthday_year.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.birthday_year.count|number_format:0:'':' '}</font></a></span>{/if}
				{/if}.
		{/if}
		{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $page.form.height != 0}
			<br><span class="t11_grey">Рост:</span> <b>{$page.form.height} см</b>{if $page.form.static.height.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.height.type}&val={$page.form.static.height.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.height.count|number_format:0:'':' '}</font></a></span>{/if}.
		{/if}
		{if v && $page.form.weight != 0}
			<br><span class="t11_grey">Вес:</span> <b>{$page.form.weight} кг</b>{if $page.form.static.weight.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.weight.type}&val={$page.form.static.weight.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.weight.count|number_format:0:'':' '}</font></a></span>{/if}.
		{/if}
		</div>
		{/if}
		{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && ($page.form.children != 0)}
		<div class="profile_div">
			{if $page.form.marriad != 0}
				<span class="t11_grey">Семейное положение:</span> <b>{$page.form.marriad_arr[$page.form.gender][$page.form.marriad]}</b>{if $page.form.static.marriad.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.marriad.type}&val={$page.form.static.marriad.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.marriad.count|number_format:0:'':' '}</font></a></span>{/if}.
			{/if}
			{if $page.form.children != 0}
				<br><span class="t11_grey">Дети:</span> <b>{$page.form.children_arr[$page.form.children]}</b>{if $page.form.static.children.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.children.type}&val={$page.form.static.children.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.children.count|number_format:0:'':' '}</font></a></span>{/if}.
			{/if}
		</div>
		{/if}
		{if $page.form.zodiac}
			<div class="profile_div"><img src="{$page.form.zodiac.icon_sm_path}" style="margin-right:5px;" border="0" align="absmiddle" alt="{$page.form.zodiac.title}" title="{$page.form.zodiac.title}" /><b>{$page.form.zodiac.title}</b>{if $page.form.static.zodiac.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.zodiac.type}&val={$page.form.static.zodiac.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.zodiac.count|number_format:0:'':' '}</font></a></span>{/if}.<br><span class="t11_grey">Гороскоп: <a href="http://{$CURRENT_ENV.site.regdomain}/horoscope/day/{$page.form.zodiac.id}.html">на день</a>, <a href="http://{$CURRENT_ENV.site.regdomain}/horoscope/week/{$page.form.zodiac.id}.html">на неделю</a></span></div>{/if}
		{if (isset($page.form.country_arr[$page.form.country]) || isset($page.form.region_arr[$page.form.region]) || $page.form.city_text != '' || isset($page.form.city_arr[$page.form.city])) && (!$USER->IsInRole('e_developer') && !$CURRENT_ENV.svoi)}
		<div class="profile_div">
			{if isset($page.form.country_arr[$page.form.country]) && $page.form.country!=1}<b>{$page.form.country_arr[$page.form.country].name}</b>,{/if} 
			{if isset($page.form.region_arr[$page.form.region]) && $page.form.city!=$page.form.default_city}<b>{$page.form.region_arr[$page.form.region].name}</b>,{/if} 
			{if ($page.form.city_text != '')}<b>{$page.form.city_text}</b>{else}<b>{$page.form.city_arr[$page.form.city].name}</b>{/if}
		</div>
		{/if}
		
		<div class="profile_div">{$page.form.about|nl2br}</div>
		
		{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
		
		<div class="my_button_inline">
		<div onclick="{$page.replyjs}" style="float:left;cursor:pointer;">
			<img src="/_img/modules/svoi/buttons/send-soob.gif" width="135" height="19" border="0" style="margin-right: 5px;" align="top" title="Отправить сообщение" />
		</div>
		{if isset($page.friendsjs)}
		<div id="user_action_{$page.UserID}" onclick="{$page.friendsjs}return false;" style="float:left;">
			<a href="/{$CURRENT_ENV.section}/friends/invite.php?id={$page.UserID}"  onclick="return false;"><img src="/_img/modules/svoi/buttons/add-frend.gif" width="120" height="19" border="0" style="margin-right: 5px;" align="top" title="Добавить в друзья" /></a>
		</div>
		{/if}
		{if $page.isfriend}
		<div id="user_action_{$page.UserID}" onclick="{$page.friendsjs}return false;" style="float:left;">
			<a onclick="mod_passport_friends_loader.remove({$page.UserID}, $('#user_action_{$page.UserID}'));return false;" href="/passport/friends/remove.php?id={$page.UserID}"><img src="/_img/modules/svoi/buttons/del-frend.gif" width="112" height="19" border="0" style="margin-right: 5px;" align="top" title="Убрать из друзей" /></a>
		</div>
		{/if}
		</div>		
		<br><br>
		{if $page.form.UserInfo.Blocked != 1}
			<div class="profile_div t11_grey">
				Адрес: 
				{if !$page.user_domain}
					<a href="http://{$CURRENT_ENV.site.regdomain}/a{$page.UserID}">http://{$CURRENT_ENV.site.regdomain}/a{$page.UserID}</a>
				{else}
					<a href="http://{$page.user_domain.Name}.{$page.user_domain.Domain}/">http://{$page.user_domain.Name}.{$page.user_domain.Domain}/</a>
				{/if}
			</div>
		{/if}
		
		{else}
		
		<div class="my_button_inline">
		<div class="my_button" onclick="{$page.replyjs}">
			<img src="/_img/modules/passport/icon_sendmail.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="top" title="Отправить сообщение" />отправить сообщение
		</div>
		{if isset($page.friendsjs)}
		<div class="my_button" id="user_action_{$page.UserID}" onclick="{$page.friendsjs}return false;">
			<a href="/{$CURRENT_ENV.section}/friends/invite.php?id={$page.UserID}"  onclick="return false;"><img src="/_img/modules/passport/icon_addfriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="top" title="Добавить в друзья" />добавить в друзья</a>
		</div>
		{/if}
		{if $page.isfriend}
		<div class="my_button" id="user_action_{$page.UserID}" onclick="{$page.friendsjs}return false;">
			<a onclick="mod_passport_friends_loader.remove({$page.UserID}, $('#user_action_{$page.UserID}'));return false;" href="/passport/friends/remove.php?id={$page.UserID}"><img src="/_img/modules/passport/icon_removefriend.gif" width="17" height="16" border="0" style="margin-right: 5px;" align="top" title="Убрать из друзей" />убрать из друзей</a>
		</div>
		{/if}
		</div>
		
		{/if}
	</td>
</tr>
</table>





{* Место жительства *}
{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && is_array($page.form.user_address) && sizeof($page.form.user_address)}


<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Место жительства</span></td>
	<td class="block_title4">&#160;</td>
</tr>
</table>
<div style="margin-bottom:30px; padding-left:6px;">
{section name=addr loop=$page.form.user_address step=2}
{assign var=index value=$smarty.section.addr.index+1}
		{if isset($page.form.user_address[$smarty.section.addr.index])}
		<span class="profile_div" style="margin-left:5px;">
			
			{if $page.form.user_address[$smarty.section.addr.index].static_type}
				<a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.user_address[$smarty.section.addr.index].static_type.type}&val={$page.form.user_address[$smarty.section.addr.index].static_type.value}">
			{elseif $page.form.user_address[$smarty.section.addr.index].userscount > 0}
				<a href="/svoi/users/address/{$page.form.user_address[$smarty.section.addr.index].id}/">
			{/if}
			{if $smarty.section.addr.last}<b>{/if}{$page.form.user_address[$smarty.section.addr.index].name}{if $smarty.section.addr.last}</b>{/if}{if $page.form.user_address[$smarty.section.addr.index].static_type || $page.form.user_address[$smarty.section.addr.index].userscount > 0}</a>{/if}
			
			{if $page.form.user_address[$smarty.section.addr.index].static_type}
				<span class="tipsup"><a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.user_address[$smarty.section.addr.index].static_type.type}&val={$page.form.user_address[$smarty.section.addr.index].static_type.value}"><font color="red">{$page.form.user_address[$smarty.section.addr.index].static_type.count|number_format:0:'':' '}</font></a></span>
			{elseif $page.form.user_address[$smarty.section.addr.index].userscount > 0}
				<span class="tipsup"><a href="/svoi/users/address/{$page.form.user_address[$smarty.section.addr.index].id}/"><font color="red">{$page.form.user_address[$smarty.section.addr.index].userscount|number_format:0:'':' '}</font></a></span>
			{/if}
		</span>
		{/if}
		{if isset($page.form.user_address[$index])}
		<span class="profile_div" style="margin-left:5px;">
			{if $page.form.user_address[$index].static_type}
				<a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.user_address[$index].static_type.type}&val={$page.form.user_address[$index].static_type.value}">
			{elseif $page.form.user_address[$index].userscount > 0}
				<a href="/svoi/users/address/{$page.form.user_address[$index].id}/">
			{/if}
			{if $smarty.section.addr.last}<b>{/if}{$page.form.user_address[$index].name}{if $smarty.section.addr.last}</b>{/if}{if $page.form.user_address[$index].static_type || $page.form.user_address[$index].userscount > 0}</a>{/if}
			
			{if $page.form.user_address[$index].static_type}
				<span class="tipsup"><a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.user_address[$index].static_type.type}&val={$page.form.user_address[$index].static_type.value}"><font color="red">{$page.form.user_address[$index].static_type.count|number_format:0:'':' '}</font></a></span>
			{elseif $page.form.user_address[$index].userscount > 0}
				<span class="tipsup"><a href="/svoi/users/address/{$page.form.user_address[$index].id}/"><font color="red">{$page.form.user_address[$index].userscount|number_format:0:'':' '}</font></a></span>
			{/if}
		</span>
		{/if}
{/section}
</div>
{/if}



{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi )}
{if $page.form.icq != '' || $page.form.skype != '' || $page.form.site != '' || $page.form.phone != ''}

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Контакты</span></td>
	<td class="block_title4" align="right">&#160;</td>
</tr>
</table>
<div style="margin-bottom:30px; padding-left:6px;">
		{if $page.form.icq != ''}{if $page.UserID == $USER->ID || ($page.user_is_friend && $page.UserInfo->Profile.general.ContactRights & 2) || $page.UserInfo->Profile.general.ContactRights & 1}<div><span class="t11_grey">ICQ:</span> <b>{$page.form.icq}</b></div>{/if}{/if}
		
		{if $page.form.skype != ''}{if $page.UserID == $USER->ID || ($page.user_is_friend && $page.UserInfo->Profile.general.ContactRights & 8) || $page.UserInfo->Profile.general.ContactRights & 4}<div><span class="t11_grey">Skype:</span> <b>{$page.form.skype}</b></div>{/if}{/if}
		
		{if $page.form.site != ''}{if $page.UserID == $USER->ID || ($page.user_is_friend && $page.UserInfo->Profile.general.ContactRights & 32) || $page.UserInfo->Profile.general.ContactRights & 16}<div><span class="t11_grey">Сайт:</span> <b><a href="{$page.form.site|url}" target="_blank">{$page.form.site|url:false}</a></b></div>{/if}{/if}
		
		{if $page.form.phone != ''}{if $page.UserID == $USER->ID || ($page.user_is_friend && $page.UserInfo->Profile.general.ContactRights & 128) || $page.UserInfo->Profile.general.ContactRights & 64}<div><span class="t11_grey">Телефон:</span> <b>{$page.form.phone}</b></div>{/if}{/if}
</div>
{/if}
{/if}


{$page.friends_records}

<div style="margin-top:30px;">
{$page.Gallery}
</div>

<br />

{/if}
{/if}