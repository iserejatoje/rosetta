{if count($res.list)>0}
<table cellspacing="0" cellpadding="3" border="0" width="100%">
<tr>
	<td class="bg_color2"><a href="/{$ENV.section}/agency.html">Предложения компаний</a></td>
</tr>
</table>
<br/>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	{foreach from=$res.list item=l key=k}
	{if $l.img_small}
	<td width="20%" align="center">
	<div style="margin:5px">
	<a href="{if $l.url}{$l.url}{else}/{$ENV.section}/{$l.id}.html{/if}"{if $l.url} target="_blank"{/if}>
	<img src="{$l.img_small.file}" width="{$l.img_small.w}" height="{$l.img_small.h}" alt="{$l.firm|escape}" title="{$l.firm|escape}" border="0" style="border: solid 1px #cccccc">
	</a>
	</div>
	</td>
	{if ($k+1)%4==0 && !$smarty.foreach.last}
	</tr><tr>
	{/if}
	{/if}
	{/foreach}
</tr>
</table>
<br/>
{/if}