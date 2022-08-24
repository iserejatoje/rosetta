
<table class="t11" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">
		<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank">{$ENV.site.title[$ENV.section]}</a>
	</td></tr>
</table>

</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
<tr><td align="left">
	<table class="t11" width="100%" cellpadding="1" cellspacing="0" border="0">
{foreach from=$res.list item=l}
{if $l.last_comment}
		<tr>
			<td valign="top">
			<font class="t11"><font color="#FF6701"><b>{$l.name}</b></font>:
			{$l.last_comment.otziv|truncate:40:"...":false}</font> <a href="/service/go/?url={"http://`$ENV.site.domain`/consult/`$l.last_comment.path`/`$l.last_comment.cid`.html#`$l.last_comment.id`"|escape:"url"}" class="a10" target="_blank"><small>&gt;&gt;</small></a>
		</td>
		</tr>
		<tr>
		<td><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td>
		</tr>
{/if}
{/foreach}
	</table>
</td></tr>
</table>
