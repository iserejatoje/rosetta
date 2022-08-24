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
<p>
	{$smarty.capture.pageslink}
</p>
{/if}


<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr> 
	<td colspan="3"><img src="/_img/x.gif" alt="" height="12" width="5"></td>
</tr>

{if $res.count>0}
{foreach from=$res.list item=l}
<tr valign="top"> 
	<td width="20px"><img src="/_img/design/200710_auto/bull-spis.gif" alt="" border="0" height="12" vspace="3" width="12"></td>
	<td style="padding-left: 3px;"><a href="/{$ENV.section}/{$l.compid}.php"><b>{$l.name}</b></a></td> 
</tr>
{/foreach}
{/if}

{if $CURRENT_ENV.section != 'claim'}
<tr valign="top"> 
	<td width="20px"><img  src="/_img/design/200710_auto/bull-spis.gif" alt="" border="0" height="12" vspace="3" width="12"></td>
	<td style="padding-left: 3px;"><a href="/{$ENV.section}/result/"><b>Они уже победили, а ты?</b></a></td> 
</tr>
{/if}
</table>


{if $smarty.capture.pageslink!="" }
<p>
	{$smarty.capture.pageslink}
</p>
{/if}
