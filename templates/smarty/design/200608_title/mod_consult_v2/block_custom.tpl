{include file="common/anontitle.tpl" anontitle="`$GLOBAL.title[$ENV.section]`"}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="3"><img src="/_img/x.gif" width="1" height="5"></td></tr>
	{foreach from=$res.list item=l}
	<tr>
		<td width="10">&nbsp;</td>
		<td valign="top">
			<font class="zag2"><a href="/{$ENV.section}/{$l.path}/{if !empty($l.child)}{$l.id}.html{/if}" class="zag2">{$l.name}</a></font><br/>
			{if is_array($l.last_comment) && sizeof($l.last_comment)}
			<font class="dop1">Последний вопрос: </font><font class="dop2">{$l.last_comment.otziv|truncate:50:"...":false}</font> <a href="/{$ENV.section}/{$l.last_comment.path}/{$l.cid}.html#{$l.qid}"><small>&gt;&gt;</small></a><br/>
			{/if}
			<br/>
		</td>
		<td width="11">&nbsp;</td>
	</tr>
	{/foreach}
	{if !empty($res.full_list)}
	<tr>
		<td width="10">&nbsp;</td>
		<td><strong><font class="dop1">Все темы:</font></strong>{foreach from=$res.full_list item=k} <a href="/{$ENV.section}/{$k.path}/{if !empty($k.child)}{$k.id}.html{/if}" class="dop5">{$k.name}</a>{/foreach}</td>
		<td width="11">&nbsp;</td>
	</tr>
	{/if}
</table>
