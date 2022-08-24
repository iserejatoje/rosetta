{if $res.page == 'mypage' || (is_array($res.list[3]) && sizeof($res.list[3]))}

{if is_array($res.list[3]) && sizeof($res.list[3])}
	{capture name=DEFAULT}{/capture}

	{capture name=PT_HIGHER_EDUCATION}
		{foreach from=$res.list[3] item=l}
			{if $l.TypeID == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION')}			
				<div class="user_info_place">
					{if $l.CityText}
					<div class="field">
						<div class="key">Город</div>
						<div>{$l.CityText}</div>
					</div>
					{/if}
					<div class="field">
						<div class="key">Вуз</div>
						<div>
							<a href="/passport/users_groupmates.php?s=1&place_id={$l.PlaceID}">{$l.Name} {if $l.UsersCount > 0}({$l.UsersCount|number_format:0:'':' '}){/if}</a>
						</div>
					</div>
					{if $l.Faculty}
					<div class="field">
						<div class="key">Факультет</div>
						<div><a href="/passport/users_groupmates.php?s=1&place_id={$l.PlaceID}&faculty_id={$l.Faculty.FacultyID}">{$l.Faculty.Name} {if $l.Faculty.Count > 0}({$l.Faculty.Count|number_format:0:'':' '}){/if}</a></div>
					</div>
					{/if}
					{if $l.Chair}
					<div class="field">
						<div class="key">Кафедра</div>
						<div><a href="/passport/users_groupmates.php?s=1&place_id={$l.PlaceID}&faculty_id={$l.Faculty.FacultyID}&chair_id={$l.Chair.KafedraID}">{$l.Chair.Name} {if $l.Chair.Count > 0}({$l.Chair.Count|number_format:0:'':' '}){/if}</a></div>
					</div>
					{/if}
					{if $l.YearStart}
					<div class="field">
						<div class="key">Начало обучения</div>
						<div>{$l.YearStart}</div>
					</div>
					{/if}
					{if $l.YearEnd}
					<div class="field">
						<div class="key">Окончание обучения</div>
						<div>{$l.YearEnd}</div>
					</div>
					{elseif $l.YearStart}
					<div class="field">
						<div class="key">Окончание обучения</div>
						<div>по настоящее время</div>
					</div>
					{/if}<br clear="both"/>
				</div>
			{/if}
		{/foreach}
	{/capture}

	{capture name=PT_SECONDARY_EDUCATION}
		{foreach from=$res.list[3] item=l}
			{if $l.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')}			
				<div class="user_info_place">
					{if $l.CityText}
					<div class="field">
						<div class="key">Город</div>
						<div>{$l.CityText}</div>
					</div>
					{/if}
					<div class="field">
						<div class="key">Школа</div>
						<div>
							<a href="/passport/users_classmates.php?s=1&place_id={$l.PlaceID}">{$l.Name} {if $l.UsersCount > 0} ({$l.UsersCount|number_format:0:'':' '}){/if}</a>
						</div>
					</div>
					{if $l.Class}
					<div class="field">
						<div class="key">Класс</div>
						<div>{$l.Class}</div>
					</div>
					{/if}
					{if $l.YearStart}
					<div class="field">
						<div class="key">Начало обучения</div>
						<div>{$l.YearStart}</div>
					</div>
					{/if}
					{if $l.YearEnd}
					<div class="field">
						<div class="key">Окончание обучения</div>
						<div>{$l.YearEnd}</div>
					</div>
					{elseif $l.YearStart}
					<div class="field">
						<div class="key">Окончание обучения</div>
						<div>по настоящее время</div>
					</div>
					{/if}
					{if $l.Chair}
					<div class="field">
						<div class="key">Специализация</div>
						<div><a href="/passport/users_classmates.php?s=1&place_id={$l.PlaceID}&spec_id={$l.Chair.ChairID}">{$l.Chair.Name}</a></div>
					</div>
					{/if}<br clear="both"/>
				</div>
			{/if}
		{/foreach}
	{/capture}

{else}
	{*capture name=DEFAULT}
		<div style="width: 100px;" class="subtitle title_rb">
			<div class="left">
				<div>Популярное</div>
			</div>
		</div>
		<div class="content">

			<ul class="list">
				<li>
				{foreach from=$res.list_top[3] item=top name=top}
					<a href="/{$CURRENT_ENV.section}/users_place.php?id={$top.TypeID}&val={$top.PlaceID}{if !empty($res.back_url)}&url={$res.back_url}{/if}" title="Список пользователей">{$top.Name}</a>{if $top.UsersCount > 0} <sup><a href="/{$CURRENT_ENV.section}/users_place.php?id={$top.TypeID}&val={$top.PlaceID}" title="Список пользователей" style="color:red">{$top.UsersCount|number_format:0:'':' '}</a></sup>{/if}
				{/foreach}
				</li>
			</ul>
		</div>

		<div class="content">
			<b><a href="/{$CURRENT_ENV.section}/mypage/education.php">Укажите своё учебное заведение</a></b>
		</div>
	{/capture*}
{/if}

<div class="block_info">

	<div class="title title_lt">
		<div class="left">
			<div class="actions">{if $res.UserID == $USER->ID}<span class="edit"><a href="/{$CURRENT_ENV.section}/mypage/education.php">редактировать</a></span>{/if}</div>
			<div>Образование</div>
		</div>
	</div>

	<div class="widget_content">

		{if $res.page == 'mypage' || trim($smarty.capture.PT_HIGHER_EDUCATION)}
		<div style="width: 100px;" class="subtitle title_rb">
			<div class="left">
				<div>ВУЗ</div>
			</div>
		</div>
		
		<div class="content">

			{$smarty.capture.PT_HIGHER_EDUCATION}
			{if $res.page == 'mypage'}
			<div class="actions_panel">
				<div class="actions_rs">
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.mypage_education.string}">добавить ВУЗ,</a><br/>
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.users_groupmates.string}">найти однокурсников</a><br/>
				</div>
				<br clear="both" />
			</div>
			{/if}
		</div>
		{/if}

		{if $res.page == 'mypage' || trim($smarty.capture.PT_SECONDARY_EDUCATION)}
		<div style="width: 100px;" class="subtitle title_rb">
			<div class="left">
				<div>Школа</div>
			</div>
		</div>
		
		<div class="content">

			{$smarty.capture.PT_SECONDARY_EDUCATION}
			{if $res.page == 'mypage'}
			<div class="actions_panel">
				<div class="actions_rs">
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.mypage_education.string}">добавить школу,</a><br/>
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.users_classmates.string}">найти одноклассников</a><br/>
				</div>
				<br clear="both" />
			</div>
			{/if}
		</div>
		{/if}

		{$smarty.capture.DEFAULT}
	</div>
</div>
{/if}

{* Карьера *}
{if  $res.page == 'mypage' || (is_array($res.list[1]) && sizeof($res.list[1]))}

	{capture name=DEFAULT}{/capture}
	{if is_array($res.list[1]) && sizeof($res.list[1])}
		{capture name=PT_GENERAL}
			{foreach from=$res.list[1] item=l}
				<div class="user_info_place">
					{if $l.CityText}
					<div class="field">
						<div class="key">Город</div>
						<div>{$l.CityText}</div>
					</div>
					{/if}
					<div class="field">
						<div class="key">Место работы</div>
						<div>
							<a href="/passport/users_colleague.php?s=1&place_name={$l.Name}&country=001001000000000000&city={$l.CityCode}">
							{$l.Name}
							{if $l.UsersCount > 0} ({$l.UsersCount|number_format:0:'':' '}){/if}</a>
						</div>
					</div>
					{if $l.YearStart}
					<div class="field">
						<div class="key">Период</div>
						{if $l.YearEnd > 0}
						<div>{$res.months_arr[$l.MonthStart]} {$l.YearStart} - {$res.months_arr[$l.MonthEnd]} {$l.YearEnd}</div>
						{else}
						<div>{$res.months_arr[$l.MonthStart]} {$l.YearStart} - по настоящее время</div>
						{/if}
					</div>
					{/if}
					{if $l.Position}
					<div class="field">
						<div class="key">Должность</div>
						<div>
						<a href="/passport/users_colleague.php?s=1&position={$l.Position}">
						{$l.Position}</a></div>
					</div>
					{/if}
					
					<br clear="both"/>
				</div>
			{/foreach}
		{/capture}
	{else}
		{*capture name=DEFAULT}
			<div class="content">
				<b><a href="/{$CURRENT_ENV.section}/mypage/career.php">Укажите своё место работы</a></b>
			</div>
		{/capture*}
	{/if}

<div class="block_info">

	<div class="title title_lt">
		<div class="left">
			<div class="actions">{if $res.UserID == $USER->ID}<span class="edit"><a href="/{$CURRENT_ENV.section}/mypage/career.php">редактировать</a></span>{/if}</div>
			<div>Карьера</div>
		</div>
	</div>

	<div class="widget_content">

		{if $res.page == 'mypage' || trim($smarty.capture.PT_GENERAL)}
		<div class="content">

			{$smarty.capture.PT_GENERAL}
			{if $res.page == 'mypage'}
			<div class="actions_panel">
				<div class="actions_rs">
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.mypage_career.string}">добавить место работы,</a><br/>
					<a href="/{$CURRENT_ENV.section}/{$res.passport_config.files.get.users_colleague.string}">найти коллег</a><br/>
				</div>
				<br clear="both" />
			</div>
			{/if}
		</div>
		{/if}
		{$smarty.capture.DEFAULT}
	</div>
</div>

{/if}

{* Места *}
{*if  $res.page == 'mypage' || (is_array($res.list[4]) && sizeof($res.list[4]))}

	{capture name=DEFAULT}{/capture}
	{if is_array($res.list[4]) && sizeof($res.list[4])}
		{capture name=PT_OTHERS}
			{foreach from=$res.list[4] item=l}
				<li>{if $l.CityText}{$l.CityText}, {/if}
				{if $l.UsersCount > 0}
					<a href="/{$CURRENT_ENV.section}/users_place.php?id=4&val={$l.PlaceID}">{$l.Name}</a> <sup><a href="/{$CURRENT_ENV.section}/users_place.php?id=4&val={$l.PlaceID}" title="Список пользователей" style="color:red">{$l.UsersCount|number_format:0:'':' '}</a></sup>
				{else}
					<b>{$l.Name}</b>
				{/if}
				</li>
			{/foreach}
		{/capture}
	{else}
		{capture name=DEFAULT}
			<div style="width: 100px;" class="subtitle title_rb">
				<div class="left">
					<div>Популярное</div>
				</div>
			</div>
			<div class="content">

				<ul class="list">
					<li>
					{foreach from=$res.list_top[4] item=top name=top}
						<a href="/{$CURRENT_ENV.section}/users_place.php?id={$top.TypeID}&val={$top.PlaceID}" title="Список пользователей">{$top.Name}</a>{if $top.UsersCount > 0} <sup><a href="/{$CURRENT_ENV.section}/users_place.php?id={$top.TypeID}&val={$top.PlaceID}" title="Список пользователей" style="color:red">{$top.UsersCount|number_format:0:'':' '}</a></sup>{/if}
					{/foreach}
					</li>
				</ul>
			</div>
		
			<div class="content">
				<b><a href="/{$CURRENT_ENV.section}/mypage/others.php">Укажите своё любимое место</a></b>
			</div>
		{/capture}
	{/if}

<div class="block_info">

	<div class="title title_rt">
		<div class="left">
			<div class="actions">{if $res.UserID == $USER->ID}<span class="edit"><a href="/{$CURRENT_ENV.section}/mypage/others.php">редактировать</a></span>{/if}</div>
			<div>Места</div>
		</div>
	</div>

	<div class="widget_content">

		{if trim($smarty.capture.PT_OTHERS)}
		<div class="content">

			<ul class="list">
				{$smarty.capture.PT_OTHERS}
			</ul>

		</div>
		{/if}

		{$smarty.capture.DEFAULT}
	</div>
</div>

{/if*}