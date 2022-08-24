{capture name=pageslink}
{if !empty($page.pages.btn)}
<div class="ppageslink">Страницы:
	{if $page.pages.back!="" }<a href="{$page.pages.back}" class="ppageslink">&lt;&lt;</a>{/if}
	{foreach from=$page.pages.btn item=l}
		{if !$l.active}
	&nbsp;<a href="{$l.link}" class="ppageslink">{$l.text}</a>
		{else}
	&nbsp;<span class="ppageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $page.pages.next!="" }&nbsp;<a href="{$page.pages.next}" class="ppageslink">&gt;&gt;</a>{/if}
</div>
{/if}
{/capture}
<div class="title" style="padding: 5px;">Черный список</div>

<div style="margin-top:20px; font-size:10px;">
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}">{if $page.folder==1}<font color="red">{/if}Входящие{if $page.folder==1}</font>{/if}</a> ({if $page.count.incoming_new>0}<b>{$page.count.incoming_new|number_format:0:'':' '}</b>/{/if}{$page.count.incoming|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?folder=2">{if $page.folder==2}<font color="red">{/if}Исходящие{if $page.folder==2}</font>{/if}</a> ({$page.count.outcoming|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_black_list.string}"><font color="red">Черный список</font></a> ({$page.count.blacklist|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
		{if $page.folder==3}<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}?chain={$page.uchain->ID}"><font color="red">Цепочка с {$page.uchain->Profile.general.ShowName}</font></a> ({$page.count.chain|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;{/if}
	<a class="pmtable_command" href="/{$ENV.section}/{$CONFIG.files.get.im_contacts.string}">Контакты</a> ({$page.count.contacts|number_format:0:'':' '})&nbsp;&nbsp;&nbsp;
</div><br/>


{if sizeof($page.list)}
	{$smarty.capture.pageslink}

<div align="left" class="text11">Всего: {$page.count.blacklist|number_format:0:'':' '}</div>

{foreach from=$page.list item=l}
		{include file=$TEMPLATE.ssections.users_block userinfo=$l.UserInfo userid=$l.UserInfo.UserID countries=$page.countries regions=$page.regions cities=$page.cities blacklist=true}
	{/foreach}
	{$smarty.capture.pageslink}
{else}
<br />
<div class="title">Ваш черный список пуст.</div>
{/if}