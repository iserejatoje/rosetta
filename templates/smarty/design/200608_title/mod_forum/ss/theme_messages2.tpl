<script language="javascript" type="text/javascript">
{literal}function doAlert(id,type)
{
	window.open("send_alert.php?id="+id+"&type="+type, "aa", "menubar=no, status=no, scrollbars=no, toolbar=no, top=50, left=50, width=400,height=300");
}{/literal}
</script>
{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div class="fpageslink">Страницы:
	{if $res.pages.back!="" }<a href="{$res.pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="{$res.pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
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
		<div>{$res.theme.question|screen_href|mailto_crypt}</div>
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
{foreach from=$res.messages item=l}
<table width="100%" cellpadding="0" cellspacing="0">
<tr class="fmtable_header">
	<td width="180">&nbsp;{if $l.user_info.type=='moderator'||$l.user_info.type=='supermoderator'||$l.user_info.type=='helpermoderator'}<img src="{$CONFIG.image_url}types/moderator.gif" align="absmiddle">&nbsp;{/if}<a href="{$l.user_info.infourl}" target="_blank" class="fmtable_nickname">{$l.user_info.login}</a></td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td><a name="{$l.id}"></a><span class="fmtable_date">#{counter} {$l.created|simply_date}</span> {if $l.fixed != 0}<font color="green">Закрепленное сообщение</font> {/if}
		{if $l.visible == 0}<font color="blue">Скрытое сообщение</font> {/if}
		{if $l.moderate != 0}<font color="red">Сообщение на предмодерации</font> {/if}</td>
				<td align="right" nowrap="nowrap">
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
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top" width="180">
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
		<span class="fcomment">Чтобы отправить сообщение, <a class="fcomment" href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a class="fcomment" href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span></td>
		<div><img src="/_img/x.gif" width="1" height="4"></div>
		{/if}
		{*<a href="rating.html?user={$l.user}" target="_blank" class="frating">Рейтинг</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}<a href="rating.html?user={$l.user}&action=minus&message={$l.id}" target="_blank" class="frating">-</a> [{/if}{$l.user_info.user_rating}{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}] <a href="rating.html?user={$l.user}&action=plus&message={$l.id}" target="_blank" class="frating">+</a>{/if}</span>*}
		{if $res.canoffence || $l.user_info.offence>0}<br><a href="{$CONFIG.files.get.offence.string}?user={$l.user}" target="_blank" class="frating">Нарушения</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->ID && $res.canoffence}<a href="{$CONFIG.files.get.offence.string}?action=minus&user={$l.user}" target="_blank" class="frating">-</a> [{/if}{if $l.user_info.penalty==true}<font color="red">{/if}{$l.user_info.offence}{if $l.user_info.penalty==true}</font>{/if}{if $l.user!=$USER->ID && $res.canoffence}] <a href="{$CONFIG.files.get.offence_plus.string}?user={$l.user}&message={$l.id}" target="_blank" class="frating">+</a>{/if}</span>{/if}
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
	</td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td valign="top"><br>
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
{/if}</td>
</tr>
</table>
{if !$res.theme.moderate}<div align="right" class="fcomment"><a href="javascript:doAlert({$l.id},2);" class="fcomment">обратить внимание модератора</a></div>{/if}
<br>
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
{if $res.canedittheme}
		<option value="movetheme">Переместить тему</option>
{/if}
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