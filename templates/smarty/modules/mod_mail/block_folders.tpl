<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="right">
	<td class="block_title"><span><a href="/{$ENV.section}/{$CONFIG.files.get.folder_list.string}">Папки</a></span></td>
</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
{if count($res.list)>0}
{foreach from=$res.list item=l key=k}
<tr align="right" valign="top"{if $l.sysname==$smarty.get.fld} class="bg_color2"{/if}>
	<td class="text11"><a href="/{$ENV.section}/{$CONFIG.files.get.messages.string}?fld={$l.sysname|urlencode}&p=1"><b>{$l.name}</b></a></td>{*{if $l.count_unseen>0}{else}{$l.name}{/if}*}
	<td class="text11" width="55px"{if $l.count_unseen>0} title="Новых писем: {$l.count_unseen}"{/if}>{if $l.count_unseen>0}<b>{$l.count_unseen}/</b>{/if}{$l.count}</td>
	<td width="10px"></td>
</tr>
{/foreach}
{/if}
</table>
