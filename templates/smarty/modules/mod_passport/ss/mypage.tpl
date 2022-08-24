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
					<b>{$page.form.birthday_month|month_to_string:2}</b>					
				{else}
					{if $page.form.birthday_day!=0}<b>{$page.form.birthday_day}</b>{/if} 
					{if $page.form.birthday_month!=0}<b>{$page.form.birthday_month|month_to_string:2}</b>						
					{/if} 
				{/if}{if $page.form.birthday_year != 0}
					<b>{$page.form.birthday_year}</b>
				{/if}.
		{/if}
		</div>
		{/if}
		
		{if $page.form.zodiac}
			{capture name="site_name"}{if $CURRENT_ENV.regid==74}mychel.ru{elseif $CURRENT_ENV.regid==2}102vechera.ru{elseif $CURRENT_ENV.regid==16}116vecherov.ru{elseif $CURRENT_ENV.regid==61}161vecher.ru{elseif $CURRENT_ENV.regid==34}34vechera.ru{elseif $CURRENT_ENV.regid==59}afisha59.ru{elseif $CURRENT_ENV.regid==63}freetime63.ru{elseif $CURRENT_ENV.regid==72}72afisha.ru{else}{$CURRENT_ENV.site.regdomain}{/if}{/capture}
			<div class="profile_div"><img src="{$page.form.zodiac.icon_sm_path}" style="margin-right:5px;" border="0" align="absmiddle" alt="{$page.form.zodiac.title}" title="{$page.form.zodiac.title}" /><b>{$page.form.zodiac.title}</b>.<br><span class="t11_grey">Гороскоп. <a href="http://{$smarty.capture.site_name}/horoscope/{$smarty.now|date_format:"%Y-%m-%d"}/zday/#z{$page.form.zodiac.id}" target="_blank">на день</a>, <a href="http://{$smarty.capture.site_name}/horoscope/{$smarty.now|date_format:"%Y-01-01"}/zall{$smarty.now|date_format:"%y"}/#z{$page.form.zodiac.id}" target="_blank">на год</a></span></div>
		{/if}
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


{if $_show_bad_name_message}
<div style='margin-left: 28px; margin-bottom:20px;'>
* Вы можете поменять имя на странице <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.mypage_person.string}">Личная информация</a>
</div>
{/if}


{if $page.Blogs}{$page.Blogs}{/if}

