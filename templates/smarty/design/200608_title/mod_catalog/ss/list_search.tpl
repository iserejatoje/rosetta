{if count($res.list)}
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td align="center" style="font-weight: bold;">Подбор по параметрам</td></tr>
<tr><td height="5px"></td></tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
{foreach from=$res.list item=l key=k}
<tr valign="top" class="{cycle values=",bg_color4"}">
	<td width="150px" align="right">{$l.name}:</td>
	<td align="left">
	{if count($l.array)}
	{assign var="first" value="1"}
	{foreach from=$l.array item=l2 key=k2}{if $first==1}{assign var="first" value="0"}{else}, {/if}
		{if $k2=='other'}<a onclick="mod_catalog_open_window('/{$ENV.section}/{$l.id}_search_cond.html?s={$l2.link_s}{if $res.url_params}&amp;{$res.url_params}{/if}', '{$ENV.section}_search_cond', 300, 400); return false;" href="#" title="Выбрать другое значение...">Еще...</a>{else}
		<a href="?s={$l2.link_s}{if $res.url_params}&amp;{$res.url_params}{/if}">{$l2.name}</a>{if isset($l2.count)}<small>({$l2.count})</small>{/if}{/if}{strip}
	{/strip}{/foreach}
	{/if}
	</td>
</tr>
{/foreach}
</table>
{/if}
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td height="5px"></td></tr>
	{if count($res.params)}
	<tr><td align="left">
	<b>Ваш выбор:</b> 
	{assign var="first" value="1"}
	{foreach from=$res.params item=l key=k}{if $first==1}{assign var="first" value="0"}{else}, {/if}{$l.name}<small><a href="?s={$l.link_s}{if $res.url_params}&amp;{$res.url_params}{/if}" title="убрать это ограничение">(X)</a></small>{/foreach}
	</td></tr>
	{/if}
</table>
