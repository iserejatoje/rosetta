{if $comment.count > 0}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0>
	<tr><td class="zag7"><a name="comments"></a><b>Мнение читателей:</b></td></tr>
	</table>
</td></tr>
<tr><td height="5px"></td></tr>
<tr><td><small>Всего мнений: {$comment.count}</small></td></tr>
{capture name=pageslink}
	{if $comment.pages.back!="" }<span class="gl"><a href="{$comment.pages.back}">&lt;&lt;</a>{/if}
	{foreach from=$comment.pages.btn item=l}
		{if !$l.active}
			&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>
		{else}
			&nbsp;<span class="pageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $comment.pages.next!="" }&nbsp;<a href="{$comment.pages.next}">&gt;&gt;</a>{/if}
</span>{/capture}
{if $smarty.capture.pageslink!="" }
<tr><td height="5px"></td></tr>
<tr><td>
	{$smarty.capture.pageslink}
</td></tr>
{/if}
<tr><td height="10px"></td></tr>
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{excycle values="#FFFFFF,#E5E3E0"}
	{foreach from=$comment.list item=l key=k}
	<tr align="left" valign="top" >
	<td style="padding-right:3px;" width="{$l.user.img_w}"><a target="_blank" href="{$l.user.link}"><img src="{$l.user.img_url}" width="{$l.user.img_w}" height="{$l.user.img_h}" border="0" alt="{$l.user.name}" /></a></td>
	<td width="100%">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr align="left" bgcolor="{excycle}">
		<td colspan="2"><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;<b>{if $l.email }<a href="mailto:{$l.email}" class="dop1">{$l.name}</a>{else}{$l.name}{/if}</b>&nbsp;&nbsp;{$l.date|date_format:"%H:%M&nbsp;&nbsp;%e.%m.%Y"}</td>
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
<tr><td>&nbsp;</td></tr>
</table>
{/if} {* !empty($comment) *}