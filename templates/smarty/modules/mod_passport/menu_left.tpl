 {if $USER->IsAuth()}
	{if strpos($res.page, 'profile') === 0}
		<table style="margin-bottom: 1px;" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr align="right">
				<td class="block_title"><span><a href="/{$ENV.section}/{$CONFIG.files.get.profile.string}">Настройки</a></span></td>
			</tr>
		</table>
		<table cellpadding="4" cellspacing="0" width="100%">
			{foreach from=$CONFIG.profiles item=l}
			{*if !in_array($l.key,array('profile_notify')) || ($USER->IsInRole('e_developer') || $CURRENT_ENV.svoi)*}
			{*if $USER->IsInRole('e_developer') || $CURRENT_ENV.svoi*}
			<tr{if $res.page == $l.key} class="bg_color2"{/if}>
				<td class="text11" style="padding-right: 6px;" align="right">
				{if $l.key == 'split'}
					&nbsp;
				{else}
					{if $res.page == $l.key}
						<b>{$l.name}</b>
					{else}
					<b><a href="/{$ENV.section}/{$CONFIG.files.get[$l.key].string}">{$l.name}</a></b>
				{/if}			
				{/if}
				</td>
			</tr>
			{*/if*}
			{/foreach}
		</table>
	{else}
		<table style="margin-bottom: 1px;" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr align="right">
				<td class="block_title" style="padding-right:6px;"><span><a href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}">Моя страница</a></span></td>
			</tr>
		</table>
		<table cellpadding="4" cellspacing="0" width="100%">
			{foreach from=$res.menu item=l}
			<tr{if $res.page == $l.key} class="bg_color2"{/if}>
				<td class="text11" style="padding-right: 6px;" align="right">
		{if $l.key == 'split'}
					&nbsp;
		{else}
		{if $res.page == $l.key}
					<b>{$l.name}</b>
		{elseif $l.url}
			<b><a href="{$l.url}" {if $l.target}target="{$l.target}"{/if}>{$l.name}</a></b>
		{else}
					<b><a href="/{$ENV.section}/{$CONFIG.files.get[$l.key].string}">{$l.name}</a></b>
		{/if}			
		{/if}
				</td>
			</tr>
			{/foreach}
		</table>
	{/if} 
{/if}
