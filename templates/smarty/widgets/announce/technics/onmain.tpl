{if count($res.list)}
<table cellpadding="3" cellspacing="0" border="0" width="100%">
<tr>
	<td bgcolor="#D1E6F0" class="title" style="white-space: nowrap">
		<EM><IMG src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</EM>
	</td>
</tr>
</table>
<table cellpadding="3" cellspacing="0" border="0" width="100%">
<tr>
	<td valign="top">
		<table cellpadding="4" cellspacing="0" border="0">
		{foreach from=$res.list item=l}
		<tr><td><a href="/{$l.item.url}/">{$l.item.title}</a>: <b>{$l.item.name}</b>, {$l.comment.text|truncate:45} <a href="/{$l.item.url}/{$l.comment.item_id}.html?act=last#comment{$l.comment.id}"><img src="/_img/design/200710_2074/list_marker.gif" alt="читать далее" width="7" height="7" border="0" /></a></td></tr>
		{/foreach}
		</table>
	</td>
</tr>
<tr>
	<td style="padding-top: 15px">
		<font class="copy"><font color="#ff9900"><b>Все каталоги</b>:</font></font><br>
{foreach from=$res.list item=l name=tech}
<a href="/{$l.item.url}/" class="copy">{$l.item.title}</a>{if !$smarty.foreach.tech.last}, {/if}
{/foreach}
		<br><br>
	</td>
</tr>
</table>
{/if}