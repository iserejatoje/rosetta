<div class="title" style="margin-bottom:10px; margin-top:15px">Предложения компаний</div>

<table border="0" cellspacing="0" cellpadding="0">
<tr>

{foreach from=$page.list item=l key=k}
	<td>
	{if $l.img_big}
	<div style="margin-top: 5px; margin-right: 10px; margin-bottom: 5px;">
	<a href="{if $l.url}{$l.url}{else}/{$ENV.section}/{$l.id}.html{/if}">
	<img src="{$l.img_big.file}" border="0" width="{$l.img_big.w}" height="{$l.img_big.h}" alt="{$l.firm}" title="{$l.firm}" style="border: solid 1px #cccccc">
	</a>
	</div>
	{/if}
	</td>
	<td>
	{if $l.img_big}
	<a href="{if $l.url}{$l.url}{else}/{$ENV.section}/{$l.id}.html{/if}">{$l.firm}&nbsp;({$l.count})</a>
	{/if}
	{if ($k+1)%2==0 && !$smarty.foreach.last}
	</tr><tr>
	{/if}
{/foreach}


</tr>
</table>