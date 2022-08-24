<div class="user_info_additional"><div class="content">
	{php}
		if (preg_match('/(\d+)/', $this->_tpl_vars['page']['form']['showname'], $_match))
			$this->_tpl_vars['_show_bad_name_message'] = (($_match[1] < 1900 && $num > 1000) || $_match[1] > 2009);
	{/php}

	<div class="field">
		<div class="key">Пол</div>
		<div>{if $res.form.gender==1}мужской{elseif $res.form.gender==2}женский{/if}</div>
	</div>

	{if $res.form.birthday_day != 0 || $res.form.birthday_month != 0 || $res.form.birthday_year != 0}
	<div class="field">
		<div class="key">День рождения</div>
		<div>{if $res.form.birthday_day!=0 && $res.form.birthday_month!=0}
				{$res.form.birthday_day} {$res.form.birthday_month|month_to_string:2}
			{else}
				{if $res.form.birthday_day!=0}{$res.form.birthday_day}{/if} 
				{if $res.form.birthday_month!=0}
					{$res.form.birthday_month|month_to_string:2}
				{/if} 
			{/if}{if $res.form.birthday_year != 0}
				{$res.form.birthday_year}
			{/if}
		</div>
	</div>
	{/if}

	{if $res.form.marriad != 0}
		<div class="field">
			<div class="key">Семейное положение</div>
			<div><a href="/passport/search.php?s=1&marriad={$res.form.marriad}">
				{$res.form.marriad_arr[$res.form.gender][$res.form.marriad]}
			</a></div>
		</div>
	{/if}

	{*
	{if $res.form.children != 0}
		<div class="field">
			<div class="key">Дети</div>
			<div>{$res.form.children_arr[$res.form.children]}{if $res.form.static.children.count > 0} (<a href="/passport/users_static.php?id={$res.form.static.children.type}&val={$res.form.static.children.value}&url={$res.form.back_url}" title="Список пользователей">{$res.form.static.children.count|number_format:0:'':' '}</a>){/if}</div>
		</div>
	{/if}


	{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $res.form.height != 0}
		<div class="field">
			<div class="key">Рост</div>
			<div>{$res.form.height} см{if $res.form.static.height.count > 0} (<a href="/passport/users_static.php?id={$res.form.static.height.type}&val={$res.form.static.height.value}&url={$res.form.back_url}" title="Список пользователей">{$res.form.static.height.count|number_format:0:'':' '}</a>){/if}</div>
		</div>
	{/if}
	{if  ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi) && $res.form.weight != 0}
		<div class="field">
			<div class="key">Вес</div>
			<div>{$res.form.weight} кг{if $res.form.static.weight.count > 0} (<a href="/passport/users_static.php?id={$res.form.static.weight.type}&val={$res.form.static.weight.value}&url={$res.form.back_url}" title="Список пользователей">{$res.form.static.weight.count|number_format:0:'':' '}</a>){/if}</div>
		</div>
	{/if}
	*}

	{if $res.form.citytext}
	<div class="field">
		<div class="key">Город</div>
		<div>{$res.form.citytext}</div>
	</div>
	{/if}

	{if $res.form.phone != ''}
	<div class="field">
		<div class="key">Телефон</div>
		<div>
			{$res.form.phone}
			{*if $USER->Profile.general.ContactRights & 128} - доступно друзьям
			{elseif $USER->Profile.general.ContactRights & 64} - доступно всем
			{else} - доступно только мне{/if*}
		</div>
	</div>
	{/if}

	{if $res.form.icq != ''}
	<div class="field">
		<div class="key">ICQ</div>
		<div>
			{$res.form.icq}
			{*if $USER->Profile.general.ContactRights & 2} - доступно друзьям
			{elseif $USER->Profile.general.ContactRights & 1} - доступно всем
			{else} - доступно только мне{/if*}
		</div>
	</div>
	{/if}

	{if $res.form.zodiac}
	<div class="field">
		<div class="key">Знак зодиака</div>
		<div>{$res.form.zodiac.title}
	</div>
	{/if}

	<div class="field">
		<div class="key">Гороскоп</div>
		<div><a href="{$res.form.horoscope_url}{$smarty.now|date_format:"%Y-%m-%d"}/zday/#z{$res.form.zodiac.id}" target="_blank">на день</a>, <a href="{$res.form.horoscope_url}{$smarty.now|date_format:"%Y-01-01"}/zall{$smarty.now|date_format:"%y"}/#z{$res.form.zodiac.id}" target="_blank">на год</a></div>
	</div>

	<div class="field">
		<div class="key">Адрес</div>
		<div>
			{if !$res.form.user_domain}
				<a href="http://{$ENV.site.regdomain}/a{$res.form.userid}">http://{$ENV.site.regdomain}/a{$res.form.userid}</a>
			{else}
				<a href="http://{$res.form.user_domain.Name}.{$res.form.user_domain.Domain}/">http://{$res.form.user_domain.Name}.{$res.form.user_domain.Domain}/</a>
			{/if}
			{if $ENV.section_page == 'mypage' && $res.form.can_choice_domain !== false}
				{if !$res.form.user_domain}
				&nbsp;<a href="/passport/domain.php">Выбери себе адрес!</a> Например: <a href="/passport/domain.php?d={$res.form.user_name_variant}">{$res.form.user_name_variant}.{$ENV.site.regdomain}</a>
				{else}
				&nbsp;<a href="/passport/domain.php">Изменить адрес</a>
				{/if}
			{/if}
		</div>
	</div>

	{*if strlen(trim($res.form.about)) > 0}
	<div class="field" style="width:60%">
		<div class="key">О Себе</div>
		<div>{$res.form.about}</div>
	</div>
	{/if*}
</div></div>