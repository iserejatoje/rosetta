{if $res.count }
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0 width="100%">
	<tr><td class="zag4"><a name="comments"></a>Мнение читателей:</td></tr>
	<tr><td height=3 bgcolor=#CCCCCC><img src="/_img/x.gif" width=1 height=3 border=0></td></tr>
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
	<td colspan="4">
	{/if}
		<table width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr align="left">
{*		{if $l.user.id }
		<td bgcolor="#CCCCCC" style="width:30px;"><b><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;</b></td>
		<td bgcolor="#DEDEDE" style="width:100px;"><nobr>{$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}&nbsp;&nbsp;</nobr></td>
		<td class="nic" style="width: 100%"><a class="nic" target="_blank" href="{$l.user.link}">{$l.name|truncate:30}</a></td>
		<td align="right" valign="middle" style="width:90px;padding:0px;padding-right:3px;"><a target="_blank" href="http://74.ru/generation/"><img src="http://74.ru/generation/img/logo_s2.gif" width="90" height="16" border="0" alt='Клуб "Поколение 74"' /></a></td>
		{else}
*}
		<td bgcolor="#CCCCCC" style="width:30px;"><b><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;</b></td>
		<td bgcolor="#DEDEDE" style="width:100px;"><nobr>{$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}&nbsp;&nbsp;</nobr></td>
		<td class="nic" style="width: 100%" colspan="2">{if $l.email }<a class="nic" href="mailto:{$l.email}">{$l.name|truncate:30:"..."}</a>{else}{$l.name|truncate:30:"..."}{/if}</td>
{*		{/if}
*}
		</tr>
		<tr><td></td><td align="left" colspan="3">{$l.otziv|with_href}</td></tr>
		</table>
	</td></tr>
	<tr><td colspan="4" height="15px"></td></tr>
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