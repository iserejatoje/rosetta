{if $USER->IsInRole('e_developer') || in_array($USER->ID, array(3,1,7,8))}
<style>
{literal}
#system_message {
	background-color:#ff8796;
	color:#FFFFFF;
	font-size:12px;
	text-align:center;
	position:fixed;
	_position:absolute;
	right:0px;
	top:0px;
	_top: eval(document.body.scrollTop) + "px";
	width:200px;
	z-index:2000;
	padding:10px;
}
</style>

{/literal}

<div id="system_message" style="display:none;"></div>
{/if}

<a name="comments"></a>
<div id="block_comment_messages">

<br />
{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div style="padding-bottom:4px;height:18px;" class="comment_pageslink ppageslink">
	Страницы:
	{if $res.pages.back!="" }<a href="#" class="ppageslink" onClick="return comment_get_page('{$res.pages.back}', '{$res.UniqueID}', '{$res.url}');">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="#" class="ppageslink" onClick="return comment_get_page('{$l.link}', '{$res.UniqueID}', '{$res.url}');">{$l.text}</a>
		{else}
			&nbsp;<span class="ppageslink_active">{$l.text}</span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="#" class="ppageslink" onClick="return comment_get_page('{$res.pages.next}', '{$res.UniqueID}', '{$res.url}');">&gt;&gt;</a>{/if}
	</div>
{/if}
{/capture}

{if sizeof($res.best) > 0 && sizeof($res.data) > 1}
<div class="title2_news" align="left">Лучший комментарий</div>
<div>&nbsp;</div>
<div style="background-color:#FF0000; padding:2px;">
<div style="background-color:#FFFFFF;">

<table width="100%" cellpadding="2" cellspacing="0" border="0" class="bg_color2">
<tr valign="middle">
	<td>
		<b>{if $res.best.UserID > 0}<a href="{$res.best.user.InfoUrl}" target="_blank">{$res.best.user.Name}</a>{elseif trim($res.best.Name) != ''}{$res.best.Name}{else}Гость{/if}</b>&nbsp;&nbsp;<span class="comment_date">{$res.best.Created|simply_date}</span>
	</td>
	<td width="100" class="tip">
		Рейтинг: <b><span id="count_votes_best_{$res.best.CommentID}">{$res.best.VoteCount}</span></b>
	</td>
	<td width="30" class="tip">
		<div id="comm_vote_best_{$res.best.CommentID}">
		{if $res.best.CanVoted === true}
			<a
			href="javascript:void(0);" onClick="return comment_add_vote('{$res.best.VoteUrl}', {$res.best.CommentID}, 1)" title="поддерживаю"><img src="/_img/modules/svoi/buttons/plus1.gif" width="12" height="12" alt="поддерживаю" border="0" style="margin-right: 3px;" /></a><a
			href="javascript:void(0);" onClick="return comment_add_vote('{$res.best.VoteUrl}', {$res.best.CommentID}, -1)"  title="не поддерживаю"><img src="/_img/modules/svoi/buttons/minus1.gif" width="12" height="12" alt="не поддерживаю" border="0" style="margin-right: 3px;" /><br /></a>
		</div>
		{/if}
	</td>
</tr>
</table>
<div style="padding: 3px;">{$res.best.Text|strip_tags|with_href|nl2br}</div>
<div>&nbsp;</div>
{* старый вариант
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="otz_item">
<tr valign="top">
<td width="100%">
<div class="block_title2" style="padding-bottom:4px">
	<div style="float:left; vertical-align:middle;"><a name="{$l.CommentID}"></a>
	<b>{if $res.best.UserID > 0}<a href="{$res.best.user.InfoUrl}" target="_blank">{$res.best.user.Name}</a>{elseif trim($res.best.Name) != ''}{$res.best.Name}{else}Гость{/if}</b>&nbsp;&nbsp;<span class="comment_date">{$res.best.Created|simply_date}</span>
	</div>
	<div style="float:right; padding-right:5px;" class="tip">
		<table>
		<tr>
			<td class="tip">Рейтинг:</td>
			<td align="left" class="tip" width="20"><b><div id="count_votes_best_{$res.best.CommentID}" style=" display:inline;">{$res.best.VoteCount}</div></b></td>
			<td width="30" align="right">
		<div style="display:inline;vertical-align:middle" id="comm_vote_best_{$res.best.CommentID}" class="tip">
		{if $res.best.CanVoted === true}
		<a href="javascript:void(0);" onClick="return comment_add_vote('{$res.best.VoteUrl}', {$res.best.CommentID}, 1)" title="поддерживаю"><img src="/_img/modules/svoi/buttons/plus1.gif" width="12" height="12" alt="поддерживаю" border="0"></a>
		<a href="javascript:void(0);" onClick="return comment_add_vote('{$res.best.VoteUrl}', {$res.best.CommentID}, -1)" title="не поддерживаю"><img src="/_img/modules/svoi/buttons/minus1.gif" width="12" height="12" alt="не поддерживаю" border="0"></a>
		{/if}
		</div>
			</td>
		</tr>
		</table>
	</div>
	<br style="clear:both;">
</div>
<div style="padding-left:20px;">{$res.best.Text|strip_tags|with_href|nl2br}</div>
	</td>
</tr>
</table>
<div>&nbsp;</div>
*}

</div>
</div>
<br><br>
{/if}
{if sizeof($res.data) > 0}
<div class="title2_news" align="left">Комментарии</div>
<div class="comment_descr" style="padding: 10px 0px;">Всего комментариев: {$res.Count}. Показано комментариев: {$res.CountShowComments}</div>
{/if}
<div class="comment_page_loading" style="display:none;padding-bottom:4px;height:18px;"><table cellspacing="0" cellpadding="0"><tr><td><img src="/_img/modules/block_forum/wait.gif"></td><td>&nbsp;<b>Подождите, идет загрузка</b></td></tr></table></div>
{$smarty.capture.pageslink}
<br>
{foreach from=$res.data item=l}

<table width="100%" cellpadding="2" cellspacing="0" border="0" class="bg_color2">
<tr valign="middle">
	<td>
		<a name="comment{$l.CommentID}"></a>
		{$l.count}.
		<b>{if $l.UserID > 0}<a href="{$l.user.InfoUrl}" target="_blank">{$l.user.Name}</a>{elseif trim($l.Name) != ''}{$l.Name}{else}Гость{/if}</b>&nbsp;&nbsp;<span class="comment_date">{$l.Created|simply_date}</span>
	</td>
	{if $l.candelete === true}
	<td width="30" class="tip">
		<a href="javascript:void(0);" onClick="return comment_delete('{$l.VoteUrl}', {$l.CommentID}, {$res.page}, {$res.UniqueID})" title="Удалить комментарий">удалить</a>
	</td>
	{/if}
	{if $l.Rating == 1 || $l.Rating == 2}
	<td width="100" class="tip">
		Рейтинг: <b><span id="count_votes_{$l.CommentID}">{$l.VoteCount}</span></b>
	</td>
	<td width="30" class="tip">
		<div id="comm_vote_{$l.CommentID}">
		{if $l.CanVoted === true}
			<a
			href="javascript:void(0);" onClick="return comment_add_vote('{$l.VoteUrl}', {$l.CommentID}, 1)" title="поддерживаю"><img src="/_img/modules/svoi/buttons/plus1.gif" width="12" height="12" alt="поддерживаю" border="0" style="margin-right: 3px;" /></a><a
			href="javascript:void(0);" onClick="return comment_add_vote('{$l.VoteUrl}', {$l.CommentID}, -1)"  title="не поддерживаю"><img src="/_img/modules/svoi/buttons/minus1.gif" width="12" height="12" alt="не поддерживаю" border="0" style="margin-right: 3px;" /><br /></a>
		</div>
		{/if}
	</td>
	{/if}
</tr>
</table>
<div style="padding: 3px;">{$l.Text|strip_tags|with_href|nl2br}</div>
<div>&nbsp;</div>
{/foreach}
<br/>
{$smarty.capture.pageslink}
<div class="comment_page_loading" style="display:none;padding-bottom:4px;height:18px;"><table cellspacing="0" cellpadding="0"><tr><td><img src="/_img/modules/block_forum/wait.gif"></td><td>&nbsp;<b>Подождите, идет загрузка</b></td></tr></table></div>
</div>