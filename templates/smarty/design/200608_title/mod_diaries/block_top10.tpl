{if is_array($res.list) && sizeof($res.list)>0}
<table width="100%" cellpadding="0" cellspacing="3" border="0">
<tr align="right">
	<td><img src="/_img/x.gif" width="1" height="5"></td>
</tr>
<tr align="right">
	<td class="block_title_obl"><span>Топ-10 записей</span></td>
</tr>
<tr><td>

<table align="center" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF" border="0" width="98%">
	<tr><td><img src="/_img/x.gif" width="0" height="2" border="0"></td></tr>

{foreach from=$res.list item=row key=rid}

	<tr>
	<td class="block_title2"><a class=shop href="{$CONFIG.files.get.journals_record.string}?id={$row.uid}&rid={$row.id}">{$row.nickname}</a></td>
	</tr>

	<tr>
	<td bgcolor="#F5F9FA" class="text11">
		{if $row.name}
			<b><a href="{$CONFIG.files.get.journals_comment.string}?id={$row.uid}&rid={$row.rid}">{$row.name|escape|truncate:50}</a></b><br><img src="/_img/x.gif" height="5" border="0"><br/>
		{else}
			<b><a href="{$CONFIG.files.get.journals_comment.string}?id={$row.uid}&rid={$row.rid}">Без названия</a></b><br><img src="/_img/x.gif" height="5" border="0"><br/>
		{/if}
		{$row.text|truncate:80}<br/><img src="/_img/x.gif" height="5" border="0"><br/>
	</td>
	</tr>

	<tr>
		<td bgcolor="#F5F9FA" class="text11">
			<b>{$row.comment_nickname}, {$row.comment_date|date_format:"%d.%m"}</b>:
			{$row.comment|truncate:80}
		</td>
	</tr>

	<tr>
		<td bgcolor="#F5F9FA" nowrap="nowrap" align="right">
			<a href="{$CONFIG.files.get.journals_comment.string}?id={$row.uid}&rid={$row.rid}&p={$row.p}" class=s4>Комментарии [{$row.cnt}]</a>
		</td>
	</tr>

	<tr>
		<td><img src="/_img/x.gif" width="0" height="5" border="0"></td>
	</tr>

{/foreach}
</table>

</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="12"></td></tr>
</table>
{/if}