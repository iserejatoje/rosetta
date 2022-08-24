{if $res.count }
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0>
	<tr><td class="zag"><a name="comments"></a>Мнение читателей:</td></tr>
	<tr><td height=4 bgcolor=#333333><img src="/_img/x.gif" width=1 height=4 border=0></td></tr>
	</table>
</td></tr>
<tr><td height="5px"></td></tr>
<tr><td class="smaller">Всего мнений: {$res.count}</td></tr>
{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>
		{else}
			&nbsp;<span class="pageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}
{if $smarty.capture.pageslink!="" }
<tr><td height="5px"></td></tr>
<tr><td>
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=k}
	<tr align="left" valign="top">
	{if $l.user.img_url}
	<td style="padding-right:3px;" width="{$l.user.img_w}"><a target="_blank" href="{$l.user.link}"><img src="{$l.user.img_url}" width="{$l.user.img_w}" height="{$l.user.img_h}" border="0" alt="{$l.user.name}" /></a></td>
	<td width="100%">
	{else}
	<td colspan="2">
	{/if}
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr align="left" bgcolor="#CCCCCC">
		{if $l.user.id }
		<td width="100%"><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;<a target="_blank" href="{$l.user.link}">{$l.name|truncate:30}</a>&nbsp;&nbsp;{$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}</td>
		<td align="right" valign="middle" style="padding:0px;padding-right:3px;"><a target="_blank" href="http://74.ru/generation/"><img src="http://74.ru/generation/img/logo_s2.gif" width="90" height="16" border="0" alt='Клуб "Поколение 74"' /></a></td>
		{else}
		<td colspan="2"><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;{if $l.email }<a href="mailto:{$l.email}">{$l.name|truncate:30:"..."}</a>{else}{$l.name|truncate:30:"..."}{/if}&nbsp;&nbsp;{$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}</td>
		{/if}
		</tr>
		<tr><td align="left" colspan="2">{$l.otziv|with_href}</td></tr>
		</table>
	</td></tr>
	<tr><td colspan="2" height="15px"></td></tr>
	{/foreach}
	</table>

</td></tr>
{if $smarty.capture.pageslink!="" }
<tr><td height="5px"></td></tr>
<tr><td>
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="20px"></td></tr>
</table>
{/if} {* {if $res.count } *}