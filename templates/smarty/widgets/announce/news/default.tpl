{if is_array($res)}
<table width="100%" cellpadding="0" cellspacing="2" border="0" >
{if is_array($res.data)}
{foreach from=$res.data item=l}
<tr>
	<td class="text11"><b><a href="/community/{$res.obj_id}/news/{$l.NewsID}.php">{$l.Title}</a></b></td>
</tr>
<tr>
	<td class="tip" style="padding-bottom:4px;">{$l.Text|truncate:60}</td>
</tr>
{/foreach}
{/if}
<tr>
	<td class="tip" style="padding-bottom:4px;"><br />
		<a href="/community/{$res.obj_id}/news/last.php">Все события</a>
{if $res.can_add=== true}
		&nbsp;&nbsp;
		<a href="/community/{$res.obj_id}/news/edit.php">Добавить</a>
{/if}
	</td>
</tr>
</table>

{/if}
