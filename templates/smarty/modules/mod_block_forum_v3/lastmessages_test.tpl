{if count($res.messages) > 0}
<input type="hidden" id="showlinkall" value="{$res.showlinkall}">
{if $res.onlytext==false}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left" class="title2_news">
	<a name="comments"></a>Мнение читателей:
</td></tr>
<tr><td id="block_forum_messages">
{/if}
	<div style="padding:10px 0px 10px 0px" class="comment_descr">Всего мнений: {$res.all}. Показано мнений: {$res.showed}</div>
	<div id="block_forum_page_loading" style="display:none;padding-bottom:4px;height:18px;"><table cellspacing="0" cellpadding="0"><tr><td><img src="/_img/modules/block_forum/wait.gif"></td><td>&nbsp;<b>Подождите, идет загрузка</b></td></tr></table></div>
{if is_array($res.pageslink.btn) && sizeof($res.pageslink.btn) != 0}
	<div id="block_forum_pageslink" style="padding-bottom:4px;height:18px;">
		{if $res.pageslink.back!="" }<a href="?p={$res.pageslink.back}&showlinkall={$res.showlinkall}" onclick="return block_forum_get_page_m({$res.pageslink.back},{$res.section_id},{$res.forum_theme});">&lt;&lt;</a>{/if}
		{foreach from=$res.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<span class="pageslink"> <a href="?p={$l.link}&showlinkall={$res.showlinkall}" onclick="return block_forum_get_page_m({$l.link},{$res.section_id},{$res.forum_theme});">{$l.text}</a> </span>
			{else}
				&nbsp;<span class="pageslink_active"> {$l.text} </span>
			{/if}
		{/foreach}
		{if $res.pageslink.next!=""}&nbsp;<a href="?p={$res.pageslink.next}&showlinkall={$res.showlinkall}" onclick="return block_forum_get_page_m({$res.pageslink.next},{$res.section_id},{$res.forum_theme});">&gt;&gt;</a>{/if}
	</div>
{/if}
{foreach from=$res.messages item=l}
		{*<div style="padding:2px 0px 2px 0px;">
			<a name="{$l.id}"></a><span class="title_normal"><b>{$l.login|truncate:20}</b></span>&nbsp;&nbsp;<span class="text11">{$l.created|simply_date:"%f %H:%M":"%d.%m %H:%M"}</span>
			&nbsp;&nbsp;<a href="{$res.url}theme.php?id={$res.theme}&act=last">{$l.message|strip_tags|truncate:50}</a>
		</div>*}
		{*<div class="block_title2">
			<a name="{$l.id}"></a><span class="title_normal">{$l.count}.</span> <span class="comment_name"><b>{$l.login|truncate:20}</b></span>&nbsp;&nbsp;<span class="comment_time">{$l.created|simply_date:"%f":"%d.%m"}</span> <span class="comment_date">{$l.created|simply_date:"%H:%M":"%H:%M"}</span>
		</div>
		<div style="padding-left:20px;">{$l.message|strip_tags|nl2br}</div>*}

		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="otz_item">
		<tr valign="top">
		    {if $l.is_generation === true && $l.avatar.Avatar != ''}
			<td><a href="{$.InfoUrl}" target="_balnk"><img style="margin-right: 5px;" src="{$l.avatar.Url}" width="{$l.avatar.Width}" height="{$l.avatar.Height}" alt="" border="0" /></a></td>
			{/if}
		    <td width="100%">
		<div class="block_title2" style="position:relative;">
			<a name="{$l.id}"></a><span class="title_normal">{$l.count}.</span> <span class="comment_name"><b>{if $l.user > 0}<a href="{$.InfoUrl}" target="_blank">{$l.login|truncate:20}</a>{else}{$l.login|truncate:20}{/if}</b></span>&nbsp;&nbsp;<span class="comment_time">{$l.created|simply_date:"%f":"%d.%m"}</span> <span class="comment_date">{$l.created|simply_date:"%H:%M":"%H:%M"}</span>
			{if $l.is_generation === true}
			<a href="http://74.ru/generation/" target="_blank"><img style="position:absolute;top:2px;right:5px;" src="/_img/modules/generation/logo_s2_{$ENV.regid}.gif" alt="" border="0" /></a>
			{/if}
		</div>
		<div style="padding-left:20px;">{$l.message|strip_tags|nl2br}</div>
		    </td>
		</tr>
		</table>
		<div>&nbsp;</div>
{/foreach}
{if $res.showlinkall && is_array($res.pageslink.btn) && sizeof($res.pageslink.btn) != 0}
		<div style="padding:2px 0px 2px 0px;" align="right">
			<noindex><a href="{$res.url}theme.php?id={$res.theme}">Все мнения</a></noindex>
		</div>
{/if}
{if $res.onlytext==false}
</td></tr>
<tr><td height="20px"></td></tr>
</table>
{/if}
{/if}
