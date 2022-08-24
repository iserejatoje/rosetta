
<table class="t11" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
{*<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="spec3">{$ENV.site.title[$ENV.section]}</a></td></tr>
</table>*}
<table class="t12" cellpadding="0" cellspacing="0" border="0">
	<tr><td align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://chelyabinsk.ru/advice/election2009/1.html"|escape:"url"}" target="_blank" class="spec3">{$ENV.site.title[$ENV.section]}</a></td></tr>
</table>

</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
<tr><td align="left">
	<table class="t11" width="100%" cellpadding="1" cellspacing="0" border="0">
{foreach from=$res.list item=l}
{foreach from=$l.last_comment item=lotz}
		<tr>
			<td valign="top" class="t11"><font color="#FF6701"><b>{$lotz.name}</b></font>:
			<font class="spec5">{$lotz.otziv|truncate:40:"...":false}</font> <a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/`$lotz.path`/`$lotz.cid`.html#`$lotz.id`"|escape:"url"}" class="a10" target="_blank"><small>&gt;&gt;</small></a>
		</td>
		</tr>
		<tr>
		<td><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td>
		</tr>
{/foreach}
{/foreach}
	</table>
</td></tr>
</table>
