{if $res.count>0}

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


<table cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td align="center"><font class="zag5">{$res.title}</font></td>
</tr>
</table>
{if $smarty.capture.pageslink!="" }
<p>
	{$smarty.capture.pageslink}
</p>
{/if}

{foreach from=$res.list item=l}
<table cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td><font class="zag5">{$l.name}</font></td>
</tr>
<tr>
	<td bgcolor="#1f68a0"><img src="/_img/x.gif" alt="" height="2" width="1"></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
<tr valign="top"> 
	<td><img src="/_img/x.gif" alt="" height="1" width="2"></td>
	<td></td> 
	<td width="100%">{$l.resulttext}</td> 
</tr>
</table>
<br><br>
{/foreach}


{if $smarty.capture.pageslink!="" }
<p>
	{$smarty.capture.pageslink}
</p>
{/if}

{else}
	<center>Нет конкурсов.</center>
{/if}