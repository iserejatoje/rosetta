<script language="javascript" type="text/javascript">
{literal}function doAlert(id,type)
{
	window.open("send_alert.php?id="+id+"&type="+type, "aa", "menubar=no, status=no, scrollbars=no, toolbar=no, top=50, left=50, width=400,height=300");
}{/literal}
</script>
{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div class="fpageslink">Страницы:
	{if $res.pages.first!="" }<a href="{$res.pages.first}" class="fpageslink">первая</a>{/if}
	{if $res.pages.back!="" }<a href="{$res.pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="{$res.pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
	{if $res.pages.last!="" }&nbsp;<a href="{$res.pages.last}" class="fpageslink">последняя</a>{/if}
	</div>
{/if}
{/capture}
<script>{literal}
function checkaction(form)
{
	obj = form.elements['action'];
	if(obj.options[obj.selectedIndex].value=='')
		return false;
	return true;
}

function checkCanVote(obj)
{
	if ( obj.type=='radio')
	{
		$('#btn_vote').attr('disabled','');
		return;
	} else {
		for ( i=1; i<=$('.answer').length; i++)
		{
			if ( $('#answer'+i).get(0).checked )
			{
				$('#btn_vote').attr('disabled','');
				return;
			}
		}
		$('#btn_vote').attr('disabled','disabled');
	}
}
{/literal}</script>

<div style="margin-bottom:4px">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>{$smarty.capture.pageslink}&nbsp;</td>
			<td align="right" width="200" class="fpageslink">{if $USER->IsAuth() && $res.deny_favorites !== true}
			{if $res.is_selected}
			<a href="{$CONFIG.files.get.edit_selected.string}?action=del&id={$res.theme.id}&p={$res.page}" title="Вы сможете быстро найти тему через меню <избранные темы> или на странице <моя страница>">Удалить из избранного</a>
			{else}
			<a href="{$CONFIG.files.get.edit_selected.string}?action=add&id={$res.theme.id}&p={$res.page}" title="Вы сможете быстро найти тему через меню <избранные темы> или на странице <моя страница>">Добавить тему в избранное</a>
			{/if}
			{/if}</td>
		</tr>
	</table>
</div>

{if $res.theme.type > 0 && ($res.theme.show_type==0 || $USER->IsAuth())}
<table width="100%" cellpadding="4" cellspacing="0">
<tr class="fmtable_header">
	<td colspan="2" class="fheader_poll">Голосование</td>
</tr>
{if $UERROR->GetErrorByIndex('poll') != ''}
<tr>
	<td class="ferror" colspan="2" align="center"><br/><b>{$UERROR->GetErrorByIndex('poll')}</b><br/><br/></td>
</tr>
{/if}
<tr>
	<td valign="top" width="180">
		<span class="frating">Всего проголосовало</span>: <span class="frating2">{$res.theme.votes}</span>
	</td>
	<td>
		<br/>
		<div>{$res.theme.question|wordwrap:80:' ':true|screen_href|mailto_crypt}</div>
		<br/>
		{if $res.canvote}
			<form method="POST">
			<input type="hidden" value="vote" name="action"/>
			<input type="hidden" name="theme" value="{$res.theme.id}"/>
			{foreach from=$res.theme.answers item=answer name=answers}
				<input id="answer{$smarty.foreach.answers.iteration}" class="answer" name="answer[]" value="{$answer.id}" type="{if $res.theme.maxvote > 1}checkbox{else}radio{/if}" onclick="checkCanVote(this);" /> <label for="answer{$smarty.foreach.answers.iteration}">{$answer.answer}</label><br/>
			{/foreach}
			<br/>
			<input id="btn_vote" type="submit" value="Проголосовать" disabled>&nbsp;&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.theme.string}?id={$res.theme.id}&viewresults=1">Смотреть результаты</a><br/>
			</form>
		{else}
			<table border="0" cellspacing="4" cellpadding="0" width="100%">
			{foreach from=$res.theme.answers item=answer}
				<tr>
					<td valign="top" width="30%">{$answer.answer}</td>
					<td valign="top">
						<table border="0" cellpadding="0" cellspacing="0" width="{if $res.votestotal > 0}{math equation="ceil(cnt/total*100)" cnt=$answer.votes total=$res.votestotal}%{else}2px{/if}">
							<tr><td class="fpoll_bar" width="4"><img src="/_img/x.gif" width="2" height="1" /></td>
							<td class="fpoll_bar">
								<div style="float:right;background-color:#fff;padding-left:2px"><b>{$answer.votes}</b></div>
							</td></tr>
						</table>
					</td>
				</tr>
			{/foreach}
			</table>
		{/if}
		<br/>
	</td>
</tr>
</table>
{/if}

<form method="POST" onsubmit="return checkaction(this);">
<input type="hidden" name="theme" value="{$res.theme.id}">
<input type="hidden" name="p" value="{$res.page}">
{counter start=$res.start print=false}
{foreach from=$res.messages item=l name=formes}
<table width="100%" cellpadding="0" cellspacing="0" style="padding-top: 2px;">
<tr class="fmtable_header">
	<td width="180">
	{if !$l.user_info.isdel}
		&nbsp;<a href="{$l.user_info.infourl}" target="_blank" class="fmtable_nickname">{$l.user_info.login}</a> {if $l.user_info.type=='moderator'||$l.user_info.type=='supermoderator'||$l.user_info.type=='helpermoderator'}<img src="{$CONFIG.image_url}types/moderator-social.gif" align="absmiddle">{/if}
	{else}
		<div class="fmtable_nickname">&nbsp;{$l.user_info.login}</div>
	{/if}
	</td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td><a name="{$l.id}"></a><span class="fmtable_date"><noindex><a href="/{$ENV.section}/{$CONFIG.files.get.theme.string}?id={$res.theme.id}&act=message&mid={$l.id}">#{counter}</a></noindex> {$l.created|simply_date}</span> {if $l.fixed != 0}<font color="green">Закрепленное сообщение</font> {/if}
		{if $l.visible == 0}<font color="blue">Скрытое сообщение</font> {/if}
		{if $l.moderate != 0}<font color="red">Сообщение на предмодерации</font> {/if}</td>
				<td align="right" nowrap="nowrap">
				{if $l.action_type!=$CONFIG.actions.messages.delete}
					<table cellpadding="0" cellspacing="6"><tr>
					{if $res.canaddmessage}
					<td><img src="{$CONFIG.image_url}soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="javascript:answer('{$l.user_info.login}');" class="fmtable_command" title="скопировать имя в окно редактирования">ответить</a></b></td>
					{* вот тут я потом и поюзаю ajax *}
					<td><img src="{$CONFIG.image_url}soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="javascript:quote();" class="fmtable_command" title="выделите текст и нажмите на эту ссылку для цитирования выделенного текста">цитировать</a></b></td>{/if}
					{if $l.canedit}
					<td><img src="{$CONFIG.image_url}soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="{$CONFIG.files.get.edit_message.string}?id={$l.id}&p={$res.page}" class="fmtable_command" title="редактировать сообщение">редактировать</a></b></td>
					<td><img src="{$CONFIG.image_url}soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="{$CONFIG.files.get.delete_message.string}?id={$l.id}&theme={$res.theme.id}&p={$res.page}" class="fmtable_command" title="удалить сообщение">удалить</a></b></td>
					{/if}
					{if ($res.caneditmessage && !$l.is_theme) || ($res.canedittheme && $l.is_theme)}
					<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>
					{/if}
					</tr>
					</table>
				{/if}
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top" width="180">
	{if $l.user_info.isdel}
		{if !empty($l.user_info.avatar)}<img src="{$l.user_info.avatar}" border="0" border="0">{/if}
		<div class="fstatus"><b>удален</b></div>
		{if $res.isshowip}
		<br><span class="fip">IP: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip}</a>]</span>
		<br><span class="fip">IP FW: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip_fw}</a>]</span>
		{/if}
	{else}
		{if !empty($l.user_info.id)}
		{if !empty($l.user_info.avatar)}<a href="{$l.user_info.infourl}" class="fcomment" target="_blank"><img src="{$l.user_info.avatar}" border="0" border="0"></a>{/if}
		<br>{foreach from=$l.user_info.message_stars item=ls}<img src="{$CONFIG.image_url}rating/chel.gif">{/foreach}<br>
        {if !empty($l.user_info.message_rating)}<span class="fstatus">{$l.user_info.message_rating}</span><br>{/if}
		<span class="frating">Сообщений</span>: <span class="frating2">{$l.user_info.messages}</span>
	
		{if $l.user_info.showvisited}
		<div class="fmtable_date">{$l.user_info.showvisited|user_online:"%f %H:%M":"%d %F":$l.user_info.gender}</div>
		{/if}
		<div><img src="/_img/x.gif" width="1" height="4"></div>
        {*<a href="{$l.user_info.infourl}" class="fcomment" target="_blank">профиль</a>*}
		<div><img src="/_img/x.gif" width="1" height="4"></div>
		{if !empty($l.user_info.replyjs)}
		<a href="#" onclick="{$l.user_info.replyjs};return false;" class="fcomment">отправить личное сообщение</a>
		<div><img src="/_img/x.gif" width="1" height="4"></div>
		{elseif !($USER->IsAuth())}
		<span class="fcomment">Чтобы отправить сообщение, <a class="fcomment" href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a class="fcomment" href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span>
		<div><img src="/_img/x.gif" width="1" height="4"></div>
		{/if}
		{*<a href="rating.html?user={$l.user}" target="_blank" class="frating">Рейтинг</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}<a href="rating.html?user={$l.user}&action=minus&message={$l.id}" target="_blank" class="frating">-</a> [{/if}{$l.user_info.user_rating}{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}] <a href="rating.html?user={$l.user}&action=plus&message={$l.id}" target="_blank" class="frating">+</a>{/if}</span>*}
		{if $res.canoffence || $l.user_info.offence>0}<br><a href="{$CONFIG.files.get.offence.string}?user={$l.user}" target="_blank" class="frating">Нарушения</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->ID && $res.canoffence}<a href="{$CONFIG.files.get.offence.string}?action=minus&user={$l.user}" target="_blank" class="frating">-</a> [{/if}{if $l.user_info.penalty==true}<font color="red">{/if}{$l.user_info.offence}{if $l.user_info.penalty==true}</font>{/if}{if $l.user!=$USER->ID && $res.canoffence}] <a href="{$CONFIG.files.get.offence_plus.string}?user={$l.user}&message={$l.id}&theme={$res.theme.id}" target="_blank" class="frating">+</a>{/if}</span>{/if}
		{if $res.isshowip}
		<br><span class="fip">IP: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip}</a>]</span>
		<br><span class="fip">IP FW: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip_fw}</a>]</span>
		{/if}
		{else}
		<span class="fstatus"><b>гость</b></span>
		{if $res.isshowip}
		<br><span class="fip">IP: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip}</a>]</span>
		<br><span class="fip">IP FW: [<a href="{$CONFIG.files.get.block.string}?id={$l.id}" target="_blank" class="fip">{$l.ip_fw}</a>]</span>
		{/if}
		{/if}
	{/if}
	</td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td valign="top">
		{*if in_array($USER->ID, array(782423))*}
			{if $l.action_type==$CONFIG.actions.messages.delete}
				<br/><span class="fmessagedeleted">УДАЛЕНО</span>
			{else}
				<br>
				{if $l.show_type==0 || $USER->IsAuth()}
					<div>{$l.message|screen_href|mailto_crypt}</div>
				{else}
					<div class="fhidden">Просмотр этого сообщения доступен только зарегистрированным пользователям<br /><a href='/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}'>Войти</a>&nbsp;&nbsp;<a href='/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}'>Зарегистрироваться</a><div>
				{/if}
				{if !empty($res.images[$l.id])}
					<br>
					<table>
						<tr>
					{foreach from=$res.images[$l.id] item=img}
					<td width="200">{if !empty($img.file)}<a href="{$img.file}" target="_blank">{/if}{if !empty($img.thumb)}<img src="{$img.thumb}" border="0" width="{$img.t_width}" height="{$img.t_height}" alt="{$img.origin}">{/if}{if !empty($img.file)}</a><br><span class="fimagecomment">{$img.origin|truncate:30}<br>размеры: {$img.s_width}x{$img.s_height} {$img.s_size|number_format:"2":".":" "} кб</span>{/if}</td>
					{/foreach}
						</tr>
					</table>
				{/if}
				{if !empty($l.user_info.signature)}
					<!--div class="fbreakline" style="overflow:hidden;height:1px;margin:30px 0px 4px 0px;width:30%"> </div-->
					<div class="fbreakline" style="overflow:hidden;height:1px;margin:30px 0px 4px 0px;width:30%"> </div>
					<div class="fsignature" style="float:left">{$l.user_info.signature}</div>
				{/if}
			{/if}
		{*else}
			<br>
			{if $l.show_type==0 || $USER->IsAuth()}
				<div>{$l.message|screen_href|mailto_crypt}</div>
			{else}
				<div class="fhidden">Просмотр этого сообщения доступен только зарегистрированным пользователям<br /><a href='/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}'>Войти</a>&nbsp;&nbsp;<a href='/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}'>Зарегистрироваться</a><div>
			{/if}
			{if !empty($res.images[$l.id])}
				<br>
				<table>
					<tr>
				{foreach from=$res.images[$l.id] item=img}
				<td width="200">{if !empty($img.file)}<a href="{$img.file}" target="_blank">{/if}{if !empty($img.thumb)}<img src="{$img.thumb}" border="0" width="{$img.t_width}" height="{$img.t_height}" alt="{$img.origin}">{/if}{if !empty($img.file)}</a><br><span class="fimagecomment">{$img.origin|truncate:30}<br>размеры: {$img.s_width}x{$img.s_height} {$img.s_size|number_format:"2":".":" "} кб</span>{/if}</td>
				{/foreach}
					</tr>
				</table>
			{/if}
			{if !empty($l.user_info.signature)}
				<!--div class="fbreakline" style="overflow:hidden;height:1px;margin:30px 0px 4px 0px;width:30%"> </div-->
				<div class="fbreakline" style="overflow:hidden;height:1px;margin:30px 0px 4px 0px;width:30%"> </div>
				<div class="fsignature" style="float:left">{$l.user_info.signature}</div>
			{/if}

		{/if*}

</td>
</tr>
</table>
{*if in_array($USER->ID, array(782423))*}
	{if $l.action_type > 0}
		{if $l.action_type==$CONFIG.actions.messages.edit}
		<div align="left" class="factioncomment">Сообщение отредактировано {if $l.action_user->ID == $l.user}автором{else}модератором {$l.action_user->Profile.general.ShowName}{/if} {$l.action_date|simply_date}</div>
		{elseif $l.action_type==$CONFIG.actions.messages.delete}
		<div align="left" class="factioncomment">Сообщение удалено {if $l.action_user->ID == $l.user}автором{else}модератором {$l.action_user->Profile.general.ShowName}{/if} {$l.action_date|simply_date}</div>
		{/if}
	{/if}
	{if $l.action_type!=$CONFIG.actions.messages.delete}
		{if !$res.theme.moderate && $USER->IsAuth()}<div align="right" class="fcomment"><a href="javascript:doAlert({$l.id},2);" class="fcomment">обратить внимание модератора</a></div>{/if}
	{/if}
{*else}
	{if !$res.theme.moderate && $USER->IsAuth()}<div align="right" class="fcomment"><a href="javascript:doAlert({$l.id},2);" class="fcomment">обратить внимание модератора</a></div>{/if}
{/if*}
<div style="clear: both"></div>
<br>
{if $smarty.foreach.formes.first}
{if in_array($CURRENT_ENV.site.domain,array("74.ru","ufa1.ru","116.ru","v1.ru","59.ru","63.ru","72.ru","161.ru","mgorsk.ru","164.ru"))}
<center>
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#d7e8ea">
	<td><img src="/_img/x.gif" width="1" height="3"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<div id='directcode'></div>
<div id='ya_direct'></div>
<script type="text/javascript">{literal}
<!--
//$(document).ready(function() {
{/literal}
{if $CURRENT_ENV.site.domain=="74.ru"}
yandex_partner_id = 45973;
{elseif $CURRENT_ENV.site.domain=="63.ru"}
yandex_partner_id = 46288;
{elseif $CURRENT_ENV.site.domain=="59.ru"}
yandex_partner_id = 46287;
{elseif $CURRENT_ENV.site.domain=="72.ru"}
yandex_partner_id = 46289;
{elseif $CURRENT_ENV.site.domain=="116.ru"}
yandex_partner_id = 46284;
{elseif $CURRENT_ENV.site.domain=="161.ru"}
yandex_partner_id = 19348;
{elseif $CURRENT_ENV.site.domain=="ufa1.ru"}
yandex_partner_id = 19327;
{elseif $CURRENT_ENV.site.domain=="v1.ru"}
yandex_partner_id = 46285;
{elseif $CURRENT_ENV.site.domain=="mgorsk.ru"}
yandex_partner_id = 44222;
{elseif $CURRENT_ENV.site.domain=="164.ru"}
yandex_partner_id = 56298;
{/if}
{literal}
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.8;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 4;
yandex_direct_header_bg_color = 'd7e8ea';
yandex_direct_title_color = '005A52';
yandex_direct_url_color = '006600';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'C6E4E2';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//-->
//});
{/literal}</script>
<!-- /Яндекс.Директ --></center>
{/if}
{if $CURRENT_ENV.site.domain=="autochel.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1336;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 4;
yandex_direct_header_bg_color = 'CCCCCC';
yandex_direct_title_color = '0F5185';
yandex_direct_url_color = '013D6C';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'DFDFDF';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}
{if $CURRENT_ENV.site.domain=="2074.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1350;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'DDDDDD';
yandex_direct_title_color = '0C6E9F';
yandex_direct_url_color = '003D63';
yandex_direct_all_color = '0C6E9F';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'FF9900';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}
{if $CURRENT_ENV.site.domain=="domchel.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#F4FAE9">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1342;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_border_type = 'block';
yandex_direct_limit = 3;
yandex_direct_bg_color = 'FFFFFF';
yandex_direct_border_color = 'EEF9DF';
yandex_direct_title_color = '02737E';
yandex_direct_url_color = '555555';
yandex_direct_all_color = 'FFFFFF';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = '71C100';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}

{if $CURRENT_ENV.site.domain=="chel.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1359;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'F9F5E2';
yandex_direct_title_color = '003D63';
yandex_direct_url_color = '555555';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = 'D4D0C8';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}

{if $CURRENT_ENV.site.domain=="cheldiplom.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1352;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'F3F3F3';
yandex_direct_title_color = '0C466E';
yandex_direct_url_color = '555555';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = '555555';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}

{if $CURRENT_ENV.site.domain=="cheldoctor.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 46298;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'F3F3F3';
yandex_direct_title_color = '0C466E';
yandex_direct_url_color = '555555';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = '555555';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}

{if $CURRENT_ENV.site.domain=="chelfin.ru"}
<table width="100%" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC">
	<td><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>
<!-- Яндекс.Директ -->
<script type="text/javascript">{literal}
//<![CDATA[
yandex_partner_id = 1338;
yandex_site_bg_color = 'FFFFFF';
yandex_site_charset = 'windows-1251';
yandex_ad_format = 'direct';
yandex_font_size = 0.9;
yandex_direct_type = 'horizontal';
yandex_direct_limit = 3;
yandex_direct_header_bg_color = 'F3F3F3';
yandex_direct_title_color = '0C466E';
yandex_direct_url_color = '555555';
yandex_direct_all_color = '000000';
yandex_direct_text_color = '000000';
yandex_direct_hover_color = '555555';
yandex_direct_place = 'ya_direct';
document.write('<sc'+'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc'+'ript>');
//]]>
{/literal}</script>
<div id='ya_direct'></div>
{/if}

{/if}
{/foreach}
{$smarty.capture.pageslink}
{if count($res.sections_list) > 0}
<div align="right">
	<select id="changesection" class="fcontrol">
		<option value="">- Перейти в раздел -</option>
		{foreach from=$res.sections_list item=l}
		<option value="{$l.id}"{if $res.theme.sec_id==$l.id} selected{/if}>&nbsp;&nbsp;{$l.data.title|indent:$l.level:"&nbsp;&nbsp;&nbsp;"}</option>
		{/foreach}
	</select>
	&nbsp;&nbsp;<input type="button" value="перейти" class="fcontrol" onclick="obj=document.getElementById('changesection');if(obj.options[obj.selectedIndex].value!='') location.href='{$CONFIG.files.get.view.string}?id='+obj.options[obj.selectedIndex].value;">
</div>
{/if}
{if $res.caneditmessage || $res.canedittheme}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие -</option>
{*if $res.canedittheme}
		<option value="movetheme">Переместить тему</option>
{/if*}
{if $res.caneditmessage}
		<option value="apply_message">Подтвердить сообщения</option>
		<option value="fix_message">Закрепить сообщения</option>
		<option value="unfix_message">Открепить сообщения</option>
		<option value="delete_message">Удалить сообщения</option>
{/if}
	</select>
	<input type="submit" value="ОК" class="fcontrol">
</div>
{/if}
</form>