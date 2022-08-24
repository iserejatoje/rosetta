<div id="block_comment_messages">
<div>&nbsp;</div>
{capture name=pageslink}
{if !empty($res.pages.btn)}
	<div id="comment_pageslink" style="padding-bottom:4px;height:18px;" class="ppageslink">
	Страницы:
	{if $res.pages.first!="" }<a href="{$res.pageslink.first}">первая</a>&nbsp;{/if}
	{if $res.pages.back!="" }<a href="#" class="ppageslink" onClick="return comment_get_page('{$res.pages.back}', '{$res.UniqueID}', '{$res.url}');">&lt;&lt;</a>{/if}
	{foreach from=$res.pages.btn item=l}
		{if !$l.active}
			&nbsp;<a href="#" class="ppageslink" onClick="return comment_get_page('{$l.link}', '{$res.UniqueID}', '{$res.url}');">{$l.text}</a>
		{else}
			&nbsp;<span class="ppageslink_active">{$l.text}</span>
		{/if}
	{/foreach}
	{if $res.pages.next!="" }&nbsp;<a href="#" class="ppageslink" onClick="return comment_get_page('{$res.pages.next}', '{$res.UniqueID}', '{$res.url}');">&gt;&gt;</a>{/if}
	{if $res.pages.last!="" }&nbsp;<a href="{$res.pageslink.last}">последняя</a>{/if}
	</div>
{/if}
{/capture}
<div id="comment_page_loading" style="display:none;padding-bottom:4px;height:18px;"><table cellspacing="0" cellpadding="0"><tr><td><img src="/_img/modules/block_forum/wait.gif"></td><td>&nbsp;<b>Подождите, идет загрузка</b></td></tr></table></div>
{$smarty.capture.pageslink}
<br>
{foreach from=$res.data item=l}
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="otz_item">
<tr valign="top">
<td width="100%">
<div class="block_title2" style="position:relative;">
	<a name="{$l.CommentID}"></a><span class="title_normal">{$l.count}.</span> <span class="comment_name"><b>{if $l.UserID > 0}<a href="{$l.user.InfoUrl}" target="_blank">{$l.user.Name}</a>{elseif trim($l.Name) != ''}{$l.Name}{else}Гость{/if}</b></span>&nbsp;&nbsp;<span class="comment_date">{$l.Created|simply_date}</span>
</div>
<div style="padding-left:20px;">{$l.Text|strip_tags|nl2br}</div>
	</td>
</tr>
</table>
<div>&nbsp;</div>
{/foreach}
</div>