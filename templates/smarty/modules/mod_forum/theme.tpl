<script language="javascript" type="text/javascript">
{literal}function doAlert(id,type)
{
	window.open("addalert.html?id="+id+"&type="+type, "aa", "menubar=no, status=no, scrollbars=no, toolbar=no, top=50, left=50, width=400,height=300");
}{/literal}
</script>
{capture name=pageslink}
{if !empty($pages.btn)}
	<div class="fpageslink">Страницы:
	{if $pages.back!="" }<a href="{$pages.back}" class="fpageslink">&lt;&lt;</a>{/if}
	{foreach from=$pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="{$l.link}" class="fpageslink">{$l.text}</a>
		{else}
			&nbsp;<span class="fpageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $pages.next!="" }&nbsp;<a href="{$pages.next}" class="fpageslink">&gt;&gt;</a>{/if}
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
{/literal}</script>
<form method="POST" onsubmit="return checkaction(this);">
<input type="hidden" name="_action" value="_mmessage.html">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td>{$smarty.capture.pageslink}</td>
<td align="right">{if $USER->IsAuth()}<a href="_addsubscribe.html?id={$parent_id}&type=1" class="fpageslink" target="_blank">Подписаться на тему</a>{/if}</td>
</tr></table>
{counter start=$start print=false}
{foreach from=$messages item=l}
<table width="100%" cellpadding="0" cellspacing="0">
<tr class="fmtable_header">
	<td width="180" class="fmtable_nickname">&nbsp;{if $l.user_info.type=='moderator'}<img src="{$ImgPath}types/moderator.gif" align="absmiddle">&nbsp;{/if}{$l.user_info.login}</td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td><a name="{$l.id}"></a><span class="fmtable_date">#{counter} {$l.created|simply_date}</span> {if $l.fixed != 0}<font color="green">Закрепленное сообщение</font> {/if}
		{if $l.visible == 0}<font color="blue">Скрытое сообщение</font> {/if}
		{if $l.moderate != 0}<font color="red">Сообщение на предмодерации</font> {/if}</td>
				<td align="right" nowrap="nowrap">
					<table cellpadding="0" cellspacing="6"><tr>
{if $canaddmessage}
					<td><img src="/_img/modules/forum/soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="javascript:answer('{$l.user_info.login}');" class="fmtable_command" title="скопировать имя в окно редактирования">ответить</a></b></td>
					{* вот тут я потом и поюзаю ajax *}
					<td><img src="/_img/modules/forum/soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="javascript:quote();" class="fmtable_command" title="выделите текст и нажмите на эту ссылку для цитирования выделенного текста">цитировать</a></b></td>{/if}
{if $IsModerator || ($l.user_info.id==$USER->ID && $l.user_info.id!=0)}
					<td><img src="/_img/modules/forum/soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="editmessage.html?id={$l.id}&p={$page}" class="fmtable_command" title="редактировать сообщение">редактировать</a></b></td>
					<td><img src="/_img/modules/forum/soob_new_l.gif" width="10" height="10" align="baseline"></td>
					<td><b><a href="_deletemessage.html?id={$l.id}" class="fmtable_command" title="удалить сообщение">удалить</a></b></td>
{/if}
{if $IsModerator}
					<td>{if $IsModerator}<input type="checkbox" name="ids[]" value="{$l.id}"> {/if}</td>
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
		{if !empty($l.user_info.avatar)}<a href="profile.html?user={$l.user}" class="fcomment" target="_blank"><img src="{$l.user_info.avatar}" border="0" border="0"></a>{/if}
		<br>{foreach from=$l.user_info.message_stars item=ls}<img src="{$ImgPath}rating/chel.gif">{/foreach}<br>
        {if !empty($l.user_info.message_rating)}<span class="fstatus">{$l.user_info.message_rating}</span><br>{/if}
		<span class="frating">Сообщений</span>: <span class="frating2">{$l.user_info.messages}</span>
		{if array_key_exists($l.user, $LAST_USERS)}
        <div class="fmtable_date">online</div>
        {/if}
		<div><img src="/_img/x.gif" width="1" height="4"></div>
        <a href="profile.html?user={$l.user}" class="fcomment" target="_blank">профиль</a>
		<div><img src="/_img/x.gif" width="1" height="4"></div>
		{*<a href="rating.html?user={$l.user}" target="_blank" class="frating">Рейтинг</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}<a href="rating.html?user={$l.user}&action=minus&message={$l.id}" target="_blank" class="frating">-</a> [{/if}{$l.user_info.user_rating}{if $l.user!=$USER->Id && $USER->IsAuth() && ($USER->Rating_m >=2 || $IsModerator)}] <a href="rating.html?user={$l.user}&action=plus&message={$l.id}" target="_blank" class="frating">+</a>{/if}</span>*}
		{if $IsModerator || $l.user_info.offence>0}<br><a href="offence.html?user={$l.user}" target="_blank" class="frating">Нарушения</a>: <span class="frating" style="font-weight:bold">{if $l.user!=$USER->Id && $IsModerator}<a href="offence.html?action=minus&user={$l.user}" target="_blank" class="frating">-</a> [{/if}{if $l.user_info.penalty==true}<font color="red">{/if}{$l.user_info.offence}{if $l.user_info.penalty==true}</font>{/if}{if $l.user!=$USER->Id && $IsModerator}] <a href="offence.html?action=plus&user={$l.user}&message={$l.id}" target="_blank" class="frating">+</a>{/if}</span>{/if}
		{*{if $IsModerator}
		<br><span class="fip">IP: [<a href="block.html?id={$l.id}" target="_blank" class="fip">{$l.ip}</a>]</span>
		<br><span class="fip">IP FW: [<a href="block.html?id={$l.id}" target="_blank" class="fip">{$l.ip_fw}</a>]</span>
		{/if}*}
		{else}
		<span class="fstatus"><b>гость</b></span>
		{*{if $IsModerator}
		<br><span class="fip">IP: [<a href="block.html?id={$l.id}" target="_blank" class="fip">{$l.ip}</a>]</span>
		<br><span class="fip">IP FW: [<a href="block.html?id={$l.id}" target="_blank" class="fip">{$l.ip_fw}</a>]</span>
		{/if}*}
		{/if}
	</td>
	<td><img src="/_img/x.gif" width="1" height="25"></td>
	<td valign="top"><br><div>{$l.message|screen_href|mailto_crypt}</div>
{if !empty($images[$l.id])}
	<br>
	<table>
		<tr>
	{foreach from=$images[$l.id] item=img}
	<td width="200">{if !empty($img.file)}<a href="{$img.file}" target="_blank">{/if}{if !empty($img.thumb)}<img src="{$img.thumb}" border="0" width="{$img.t_width}" height="{$img.t_height}" alt="{$img.origin}">{/if}{if !empty($img.file)}</a><br><span class="fimagecomment">{$img.origin|truncate:30}<br>размеры: {$img.s_width}x{$img.s_height} {$img.s_size|number_format:"2":".":" "} кб</span>{/if}</td>
	{/foreach}
		</tr>
	</table>
{/if}
{if !empty($l.user_info.signature)}
	<div><img src="/_img/x.gif" width="1" height="4"></div>
	<div class="fbreakline"><img src="/_img/x.gif" width="1" height="2"></div>
	<div><img src="/_img/x.gif" width="1" height="4"></div>
	<div class="fsignature">{$l.user_info.signature}</div>
{/if}</td>
</tr>
</table>
{if !$theme.moderate}<div align="right" class="fcomment"><a href="javascript:doAlert({if $l.is_theme!=0}{$parent_id},1{else}{$l.id},2{/if});" class="fcomment">обратить внимание модератора</a></div>{/if}
<br>
{/foreach}
{$smarty.capture.pageslink}
<div align="right">
	<select id="changesection" class="fcontrol">
		<option value="">- Перейти в раздел -</option>
		{foreach from=$sections item=l}
		<option value="{$l.id}"{if $section_id==$l.id} selected{/if}>&nbsp;&nbsp;{$l.data.title|indent:$l.level:"&nbsp;&nbsp;&nbsp;"}</option>
		{/foreach}
	</select>
	&nbsp;&nbsp;<input type="button" value="перейти" class="fcontrol" onclick="obj=document.getElementById('changesection');if(obj.options[obj.selectedIndex].value!='') location.href='view.html?id='+obj.options[obj.selectedIndex].value;">
</div>
{if $IsModerator}
<br>
<div align="right">
	<select name="action" class="fcontrol">
		<option value="">- Действие -</option>
		<option value="movetheme">Переместить тему</option>
{*		<option value="explode">Разделить тему</option>*}
		<option value="offpremod">Подтвердить сообщения</option>
{*		<option value="show">Показать сообщения</option>
		<option value="hide">Скрыть сообщения</option>*}
		<option value="fix">Закрепить сообщения</option>
		<option value="unfix">Открепить сообщения</option>
		<option value="delete">Удалить сообщения</option>
	</select>
	<input type="hidden" name="p" value="{$page}">
	<input type="hidden" name="theme" value="{$parent_id}">
	<input type="submit" value="ОК" class="fcontrol">
</div>
{/if}
</form>