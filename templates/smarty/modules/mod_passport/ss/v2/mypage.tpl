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
	<td class="block_title4" style="padding-left:6px;"><span>Личная информация</span></td>
	<td class="block_title4" style="padding-right: 10px;" align="right"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_person.string}" style="font-size:10px;"><b>Редактировать</b></a></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr valign="top">
	<td>
			<div style="position:relative;">
			{if ($page.form.photo.file!='')}
			 	<img src="{$page.form.photo.file}" border="0" alt="{$page.form.showname}" height="{$page.form.photo.h}" width="{$page.form.photo.w}" />
			{elseif ($page.form.avatar.file!='')}
				 	<img src="{$page.form.avatar.file}" border="1" height="{$page.form.avatar.h}" width="{$page.form.avatar.w}">
			{else}
				<img src="/_img/modules/passport/user_unknown.gif" width="90" height="90" />
			{/if}
			{if $page.form.photo.file=='' && $page.form.avatar.file == ''}
				<div style="padding: 20px 0px 20px 0px;"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_photo.string}"><font color="red">Загрузить фото</font></a></div>
			{/if}
			<div style="padding:10px" align="center">
			<a href="/user/{$USER->ID}/gallery/">Фотогалерея</a>
			</div>
			</div>
		</td>
	<td width="100%" style="padding-left:20px;">

		{php}
			if (preg_match('/(\d+)/', $this->_tpl_vars['page']['form']['showname'], $_match))
				$this->_tpl_vars['_show_bad_name_message'] = (($_match[1] < 1900 && $num > 1000) || $_match[1] > 2009);
		{/php}
		
		<div class="title">{if $page.form.gender==1}<img src="/_img/modules/passport/icon_male_s.gif" border="0" width="12" height="12" align="bottom" style="margin-right:5px" />{elseif $page.form.gender==2}<img src="/_img/modules/passport/icon_female_s.gif" border="0" width="9" height="13" align="bottom" style="margin-right:5px;" />{/if}{$page.form.showname}{if $_show_bad_name_message} *{/if}</div>
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
			<div class="profile_div"><img src="{$page.form.zodiac.icon_sm_path}" style="margin-right:5px;" border="0" align="absmiddle" alt="{$page.form.zodiac.title}" title="{$page.form.zodiac.title}" /><b>{$page.form.zodiac.title}</b>{if $page.form.static.zodiac.count > 0} <span class="tipsup"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.form.static.zodiac.type}&val={$page.form.static.zodiac.value}" title="Список пользователей" class="text11"><font color="red">{$page.form.static.zodiac.count|number_format:0:'':' '}</font></a></span>{/if}.<br><span class="t11_grey">Гороскоп: <a href="http://{$CURRENT_ENV.site.regdomain}/horoscope/{$smarty.now|date_format:"%Y-%m-%d"}/zday/#z{$page.form.zodiac.id}" target="_blank">на день</a>, <a href="http://{$CURRENT_ENV.site.regdomain}/horoscope/2009-01-01/zall/#z{$page.form.zodiac.id}" target="_blank">на год</a></span></div>{/if}
		{if (isset($page.form.country_arr[$page.form.country]) || isset($page.form.region_arr[$page.form.region]) || $page.form.city_text != '' || isset($page.form.city_arr[$page.form.city])) && (!$USER->IsInRole('e_developer') && !$CURRENT_ENV.svoi)}
		<div class="profile_div">
			{if isset($page.form.country_arr[$page.form.country]) && $page.form.country!=1}<b>{$page.form.country_arr[$page.form.country].name}</b>,{/if} 
			{if isset($page.form.region_arr[$page.form.region]) && $page.form.city!=$page.form.default_city}<b>{$page.form.region_arr[$page.form.region].name}</b>,{/if} 
			{if ($page.form.city_text != '')}<b>{$page.form.city_text}</b>{else}<b>{$page.form.city_arr[$page.form.city].name}</b>{/if}
		</div>
		{/if}
		
		<div class="profile_div">{$page.form.about|nl2br}</div>
		<div class="profile_div t11_grey">
			Адрес: 
			{if !$page.user_domain}
				<a href="http://{$CURRENT_ENV.site.regdomain}/a{$USER->ID}">http://{$CURRENT_ENV.site.regdomain}/a{$USER->ID}</a>
			{else}
				<a href="http://{$page.user_domain.Name}.{$page.user_domain.Domain}/">http://{$page.user_domain.Name}.{$page.user_domain.Domain}/</a>
			{/if}
			
			{if $page.can_choice_domain !== false}
				{if !$page.user_domain}
				&nbsp;<a href="/passport/domain.php"><font color="red">Выбери себе адрес!</font></a> Например: <a href="/passport/domain.php?d={$page.user_name_variant}">{$page.user_name_variant}.{$CURRENT_ENV.site.regdomain}</a>
				{else}
				&nbsp;<a href="/passport/domain.php">Изменить адрес</a>.
				{/if}
			{/if}
		</div>
	</td>
</tr>
</table>

{* Место жительства *}
{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && is_array($page.form.user_address) && sizeof($page.form.user_address)}
<br />

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Место жительства</span></td>
	<td class="block_title4" style="padding-right: 10px;" align="right"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_person.string}" style="font-size:10px;"><b>Редактировать</b></a></td>

</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
{section name=addr loop=$page.form.user_address step=2}
{assign var=index value=$smarty.section.addr.index+1}
<tr valign="top">
	<td style="padding-left:6px;">
		{if isset($page.form.user_address[$smarty.section.addr.index])}
		<div class="profile_div">
			{if $page.form.user_address[$smarty.section.addr.index].static_type}
				<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_static.string}?id={$page.form.user_address[$smarty.section.addr.index].static_type.type}&val={$page.form.user_address[$smarty.section.addr.index].static_type.value}">
			{elseif $page.form.user_address[$smarty.section.addr.index].userscount > 0}
				<a href="/svoi/users/address/{$page.form.user_address[$smarty.section.addr.index].id}/">
			{/if}
			{$page.form.user_address[$smarty.section.addr.index].name}{if $page.form.user_address[$smarty.section.addr.index].static_type || $page.form.user_address[$smarty.section.addr.index].userscount > 0}</a>{/if}
			
			{if $page.form.user_address[$smarty.section.addr.index].static_type}
				<span class="tipsup"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_static.string}?id={$page.form.user_address[$smarty.section.addr.index].static_type.type}&val={$page.form.user_address[$smarty.section.addr.index].static_type.value}"><font color="red">{$page.form.user_address[$smarty.section.addr.index].static_type.count|number_format:0:'':' '}</font></a></span>
			{elseif $page.form.user_address[$smarty.section.addr.index].userscount > 0}
				<span class="tipsup"><a href="/svoi/users/address/{$page.form.user_address[$smarty.section.addr.index].id}/"><font color="red">{$page.form.user_address[$smarty.section.addr.index].userscount|number_format:0:'':' '}</font></a></span>
			{/if}
			
			{if $page.form.user_address[$smarty.section.addr.index].name}
				{if $page.form.user_address[$smarty.section.addr.index].right == 2} - <span class="tip">доступно друзьям</span>
				{elseif $page.form.user_address[$smarty.section.addr.index].right == 1} - <span class="tip">доступно всем</span>
				{else} - <span class="tip">доступно только мне</span>{/if}
			{/if}
		</div>
		{/if}
	</td>
	<td style="padding-left:6px;">
		{if isset($page.form.user_address[$index])}
		<div class="profile_div">
			{if $page.form.user_address[$index].static_type}
				<a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_static.string}?id={$page.form.user_address[$index].static_type.type}&val={$page.form.user_address[$index].static_type.value}">
			{elseif $page.form.user_address[$index].userscount > 0}
				<a href="/svoi/users/address/{$page.form.user_address[$index].id}/">
			{/if}
			{$page.form.user_address[$index].name}{if $page.form.user_address[$index].static_type || $page.form.user_address[$index].userscount > 0}</a>{/if}
			
			{if $page.form.user_address[$index].static_type}
				<span class="tipsup"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_static.string}?id={$page.form.user_address[$index].static_type.type}&val={$page.form.user_address[$index].static_type.value}"><font color="red">{$page.form.user_address[$index].static_type.count|number_format:0:'':' '}</font></a></span>
			{elseif $page.form.user_address[$index].userscount > 0}
				<span class="tipsup"><a href="/svoi/users/address/{$page.form.user_address[$index].id}/"><font color="red">{$page.form.user_address[$index].userscount|number_format:0:'':' '}</font></a></span>
			{/if}

			{if $page.form.user_address[$index].name}
				{if $page.form.user_address[$index].right == 2} - <span class="tip">доступно друзьям</span>
				{elseif $page.form.user_address[$index].right == 1} - <span class="tip">доступно всем</span>
				{else} - <span class="tip">доступно только мне</span>{/if}
			{/if}
		</div>
		{/if}
	</td>
</tr>
{/section}
</table>
{/if}

{if ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Контакты</span></td>
	<td class="block_title4" style="padding-right: 10px;" align="right"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_contacts.string}" style="font-size:10px;"><b>Редактировать</b></a></td>
</tr>
</table>
<div style="margin-bottom:30px; padding-left:6px;">
	{if $page.form.icq != ''}<div><span class="t11_grey">ICQ:</span> <b>{$page.form.icq}</b>
	{if $USER->Profile.general.ContactRights & 2} - <span class="tip">доступно друзьям</span>
	{elseif $USER->Profile.general.ContactRights & 1} - <span class="tip">доступно всем</span>
	{else} - <span class="tip">доступно только мне</span>{/if}
	</div>{/if}
	
	{if $page.form.skype != ''}<div><span class="t11_grey">Skype:</span> <b>{$page.form.skype}</b>
	{if $USER->Profile.general.ContactRights & 8} - <span class="tip">доступно друзьям</span>
	{elseif $USER->Profile.general.ContactRights & 4} - <span class="tip">доступно всем</span>
	{else} - <span class="tip">доступно только мне</span>{/if}</div>{/if}
	
	{if $page.form.site != ''}<div><span class="t11_grey">Сайт:</span> <b><a href="{$page.form.site|url}" target="_blank">{$page.form.site|url:false}</a></b>
	{if $USER->Profile.general.ContactRights & 32} - <span class="tip">доступно друзьям</span>
	{elseif $USER->Profile.general.ContactRights & 16} - <span class="tip">доступно всем</span>
	{else} - <span class="tip">доступно только мне</span>{/if}</div>{/if}
	
	{if $page.form.phone != ''}<div><span class="t11_grey">Телефон:</span> <b>{$page.form.phone}</b>
	{if $USER->Profile.general.ContactRights & 128} - <span class="tip">доступно друзьям</span>
	{elseif $USER->Profile.general.ContactRights & 64} - <span class="tip">доступно всем</span>
	{else} - <span class="tip">доступно только мне</span>{/if}</div>{/if}
</div>
{/if}

{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $page.interest}{$page.interest}{/if}

{if $_show_bad_name_message}
<div style='margin-left: 28px; margin-bottom:20px;'>
* Вы можете поменять имя на странице <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_person.string}">Личная информация</a>
</div>
{/if}
{*{if !($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)}
<div style='margin-bottom:5px;'>
<ol> 	
<li class='tip' style=' color:#999999;'>Теперь вы можете обмениваться сообщениями друг с другом прямо на сайте.
<p class='tip' style=' color:#999999;'>Написать человеку можно, кликнув по его фотографии.</p>
<p class='tip' style=' color:#999999;'>О поступившем сообщении узнаете из уведомления на почту либо в правом верхнем блоке появится красная ссылка 
"у вас 1 новое сообщение"</p></li>
<li class='tip' style=' color:#999999;'>На вашей странице ("<a href='/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage.string}'>Моя страница</a>") появилась информация 
о ваших данных из других разделов.

<p class='tip' style=' color:#999999;'><b>"Моя работа"</b>: позволяет выводить последние вакансии (резюме), избранные вакансии (резюме)</p>

<p class='tip' style=' color:#999999;'><b>"Мои объявления"</b>: позволяет выводить избранные и ваши объявления из разделов авто и недвижимость.</p>

<p class='tip' style=' color:#999999;'><b>"Мои сообщения"</b>: показывает последнее поступившее сообщение</p>

<p class='tip' style=' color:#999999;'><b>"Мои форумы":</b> показываются ваши темы и избранные темы</p>

<p class='tip' style=' color:#999999;'>Если у вас есть почта на сайте, то выводится блок <b>"Моя почта"</b>: количество новых писем и ссылки на 
"проверить почту", "написать письмо"</p>
</li>
</ol>
</div>
{/if}*}


{*

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">

<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Контакты</span></td>
	<td class="block_title4" align="right"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_contacts.string}" style="font-size:10px;"><b>Редактировать</b></a></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr valign="top">
	<td style="padding-left:20px;">
	<div>
		{if $page.form.icq != ''}<div class="profile_div">ICQ: {$page.form.icq}</div>{/if}
		{if $page.form.skype != ''}<div class="profile_div">Skype: {$page.form.skype}</div>{/if}
		{if $page.form.site != ''}<div class="profile_div">Сайт: <a href="{$page.form.site|url}" target="_blank">{$page.form.site|url:false}</a></div>{/if}
		{if $page.form.phone != ''}<div class="profile_div">Телефон: {$page.form.phone}</div>{/if}
	</div>
	</td>
</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Место работы</span></td>
	<td class="block_title4" align="right"><a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_person.string}" style="font-size:10px;"><b>Редактировать</b></a></td>

</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr valign="top">
	<td style="padding-left:20px;">
	<div>
		{if $page.form.workplace != ''}<div class="profile_div">Место работы: {$page.form.workplace}</div>{/if}
		{if $page.form.position != ''}<div class="profile_div">Должность: {$page.form.position}</div>{/if}
	</div>
	</td>
</tr>
</table>

*}

