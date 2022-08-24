{if $res.count }
<br/>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0 width="100%">
	<tr><td class="title2_askform"><a name="comments"></a>Мнение читателей:</td></tr>
	</table>
</td></tr>
<tr><td height="5px"></td></tr>
<tr><td class="comment_descr">Всего мнений: {$res.count}</td></tr>
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
	<tr align="left" valign="top"><td>
		<table width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr align="left" class="block_title2">
		<td style="width:30px;"><b><a name="{$l.id}"></a>{$k}.&nbsp;&nbsp;</b></td>
		<td style="width: 100%"><span class="comment_name"><b>{if $l.email }<a class="nic" href="mailto:{$l.email}">{$l.name|truncate:30:"..."}</a>{else}{$l.name|truncate:30:"..."}{/if}</b></span>
		 <nobr>&nbsp;&nbsp;<span class="comment_date">{$l.date|simply_date:"%f":"%d.%m"}</span> <span class="comment_time">{$l.date|simply_date:"%H:%M":"%H:%M"}</span></nobr></td>
		</tr>
		<tr><td></td><td align="left" colspan="2">{$l.otziv|with_href|nl2br}</td></tr>
		</table>
	</td></tr>
	<tr><td height="15px"></td></tr>
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