
{if $res.count>0 && !$_nocomment}
<table width=100% cellpadding=3 cellspacing=1 border=0>
{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы: 
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td>
 <table width=100% cellpadding=0 cellspacing=0 border=0>
 <tr><td><img src="/_img/x.gif" width=0 height=10 border=0></td></tr>
 {if $smarty.capture.pageslink!="" }
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 {/if}
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 <tr><td align=center>
	{foreach from=$res.list item=l}
	<TABLE width=100% cellpadding=3 cellspacing=1 border=0>
	<tr class="block_title2">
	{if $l.tcuid>0}
		<th><a href="#addcomment" onclick="touser('{$l.tuname}',document.frmaddcomment.text)">{$l.tuname}</a></th>
	{else}
	        <th>Гость</th>
	{/if}
	<td><a name="c{$l.tcid}"></a>
        	<TABLE width=100% cellpadding=0 cellspacing=0 border=0>
		{capture name=today}{$l.tcdate|simply_date}{/capture}
	        <tr><td><b>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$l.tcdate|date_format:"%e"} {$l.tcdate|date_format:"%m"|month_to_string:2} {$l.tcdate|date_format:"%Y"}{/if}</b> &nbsp;&nbsp;&nbsp;{$l.tcdate|date_format:"%H:%M"}</td>
		{if $l.tcuid}
			<td align=right><a href="{$CONFIG.files.get.journals_record.string}?id={$l.tcuid}" class=s4>Дневник</a>&nbsp;&nbsp;&nbsp;
			{* <a href="{$CONFIG.files.get.journals_profile.string}?id={$l.tcuid}" class=s4>Профиль</a> *}</td>
		{/if}
		</tr>	
		</TABLE>
	</td></tr>
	<tr valign=top bgcolor=#F5F9FA>
		<td align=center width=110>
			{if !$l.AvatarOff && $l.avatar}
				<img src="{$l.avatar}" border="0">
			{/if}
		</td>
		<td>
			{$l.tctext|nl2br|screen_href|mailto_crypt}
		</td>
	</tr>
	{if ($USER->ID==$l.tcuid || $USER->ID==$smarty.get.id) && $USER->isAuth()}
        <tr><td colspan=2 bgcolor=#F5F9FA>
		<TABLE width=100% cellpadding=0 cellspacing=0 border=0><tr>
		<td align=right nowrap>
		{if $USER->isAuth() && $USER->ID==$l.tcuid}
			<a href="{$CONFIG.files.get.journals_comment_edit.string}?id={$smarty.get.id}&rid={$smarty.get.rid}&cid={$l.tcid}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class=s4>Редактировать</a>
		{/if}
		&nbsp;&nbsp;&nbsp;
		{if $USER->isAuth() && $USER->ID == $smarty.get.id}
			<a href="{$CONFIG.files.get.journals_comment_del.string}?id={$smarty.get.id}&rid={$smarty.get.rid}&cid={$l.tcid}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class=s4>Удалить</a>	
		{/if}
		</td>
		</tr>
		</TABLE>
	</td></tr>
	{/if}
	</TABLE><br>
	{/foreach}
 </td></tr>
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
 {if $smarty.capture.pageslink!="" }
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 {/if}
 </table>
</td></tr>
<tr><td><img src="/_img/x.gif" width=0 height=10 border=0></td></tr>
</table>
{/if}