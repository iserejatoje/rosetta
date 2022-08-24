{capture name=pageslink}
{if !empty($page.pageslink.btn)}
	<div class="ppageslink">Страницы:
	{if $page.pageslink.back!="" }<a href="{$page.pageslink.back}" class="ppageslink">&lt;&lt;</a>{/if}
	{foreach from=$page.pageslink.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="ppageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="ppageslink_active">&nbsp;{$l.text}&nbsp;</span>
		{/if}
	{/foreach}
	{if $page.pageslink.next!="" }&nbsp;<a href="{$page.pageslink.next}" class="ppageslink">&gt;&gt;</a>{/if}
	</div>
{/if}
{/capture}


<div class="title" style="padding: 5px;">{$page.title|default:"Пользователи"}</div>


{if $page.type == 'search'}

{include file=$TEMPLATE.ssections.search_form search_form=$page.search_form}

{elseif in_array($page.type, array('friends', 'myfriends'))}

	{if $page.menu.count.required > 0}
	<div class="tip" style="padding-top: 5px;">{$page.menu.count.required}
		{word_for_number number=$page.menu.count.required first="человек" second="человека" third="человек"} {word_for_number number=$page.menu.count.required first="подал" second="подали" third="подали"}
		заявку на добавление Вас в друзья. <a href="/{$CURRENT_ENV.section}/friends/refuse.php">Отклонить все заявки</a>
	</div>
	{/if}

{elseif $page.type == 'contacts'}

<div style="margin-top:20px; font-size:10px;">
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}">Входящие</a> ({if $page.menu.count.incoming_new>0}<b>{$page.menu.count.incoming_new|number_format:0:'':' '}</b>/{/if}{$page.menu.count.incoming|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?folder=2">Исходящие ({$page.menu.count.outcoming|number_format:0:'':' '})</a>&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_black_list.string}">Черный список ({$page.menu.count.blacklist|number_format:0:'':' '})</a>&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_contacts.string}"><font color="red">Контакты</font> ({$page.menu.count.contacts|number_format:0:'':' '})</a>
</div>

{/if}

<br/>

{if $page.count > 0}
<div align="left" class="text11">Всего: {$page.count|number_format:0:'':' '}</div>

{if $USER->IsInRole('e_developer') || $CURRENT_ENV.svoi}
{if $page.place !== null && $page.params.canaddplace !== false}
<div style="text-align:right;">
	<div style="float:right;" id="place_id_{$page.place.PlaceID}">
	{if $page.params.id == 1}
		<a href="javascript:void(0);" title="я здесь работаю" onclick="mod_passport.addPlace({$page.params.id}, {$page.place.PlaceID}); return false;"><img src="/_img/modules/svoi/buttons/work.gif" width="108" height="19" border="0" align="top" alt="я здесь работаю" style="margin-left: 5px;" /></a>
	{elseif $page.params.id == 2}
		<a href="javascript:void(0);" title="я здесь учусь" onclick="mod_passport.addPlace({$page.params.id}, {$page.place.PlaceID}); return false;"><img src="/_img/modules/svoi/buttons/learn.gif" width="95" height="19" border="0" align="top" alt="я здесь учусь" style="margin-left: 5px;" /></a>
	{elseif $page.params.id == 4}
		<a href="javascript:void(0);" title="добавить в мои места" onclick="mod_passport.addPlace({$page.params.id}, {$page.place.PlaceID}); return false;"><img src="/_img/modules/svoi/buttons/add-here.gif" width="135" height="18" border="0" align="top" alt="добавить в мои места" style="margin-left: 5px;" /></a>
	{/if}
	</div>
</div>
{/if}
{/if}

{$smarty.capture.pageslink}
{foreach from=$page.data item=l key=UserID}
	{include file=$TEMPLATE.ssections.users_block userinfo=$l countries=$page.countries regions=$page.regions cities=$page.cities userid=$UserID type=$page.type}
{/foreach}
<br/>
{$smarty.capture.pageslink}
{else}
	{if $page.type=='search'}
		<div align="center">По вашему запросу ничего не найдено.</div>
	{elseif $page.type=='myfriends'}
		<div align="center">Друзья не найдены.<br /><br />
			<a href="/{$CURRENT_ENV.section}/users.php?online=1">Найти друзей</a>
		</div>
	{elseif $page.type=='friends' }
		<div align="center">Друзья не найдены.<br /><br />
			<a href="/{$CURRENT_ENV.section}/friends/invite.php?id={$page.params.id}" id="hide_{$page.params.id}" onclick="mod_passport_friends_loader.load({$page.params.id}, $('#hide_{$page.params.id}'));return false;">Добавить в друзья</a>
		</div>
	{else}
		<div align="center">Не найдено пользователей.</div>
	{/if}
{/if}
<br/>
<br/>