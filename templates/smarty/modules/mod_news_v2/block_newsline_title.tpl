<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="2">
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank">{$ENV.site.title[$ENV.section]}</a></td>{if $withdate}<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>{/if}</tr>
			</table>
		</td>
	</tr>
{*
	<tr>
		<td colspan="2">
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">{$ENV.site.title[$ENV.section]}</td>{if $withdate}<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>{/if}</tr>
				<tr><td align="left" height=1 bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
			</table>
		</td>
	</tr>
*}
{foreach from=$res.list item=l key=y}
	<tr>
		<td width="4" style="padding-top:8px"><img src="/_img/design/200608_title/b3.gif" height="4" width="4"></td>
		<td class="block_content">&nbsp;{capture name=date}{$l.date|date_format:"%Y/%m/%d"}{/capture}
		{if !empty($l.group)}{assign var="_group" value="`$l.group`"}{else}{assign var="_group" value=""}{/if}
<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/`$_group``$smarty.capture.date`/#`$l.id`"|escape:"url"}"  target="_blank">
			{*<a href="http://{$ENV.site.domain}/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}" target="_blank">*}<span style="font-size:11px">{$l.name}</span></a></td>
	</tr>
{/foreach}
{if $ENV.site.domain=="mychel.ru"}
	<tr>
		<td colspan="2" style="padding-top:8px">
		<font class="t11b">Киноафиша:</font> <a class="a11" href="/service/go/?url={"http://www.mychel.ru/afisha/cinema/search.php?range=today"|escape:"url"}" target="_blank">сегодня</a>, <a href="/service/go/?url={"http://www.mychel.ru/afisha/cinema/search.php?range=tomorrow"|escape:"url"}" target="_blank" class="a11">завтра</a>. <a href="/service/go/?url={"http://mychel.ru/afisha/performance"|escape:"url"}" target="_blank" class="a11">Спектакли</a>			
		</td>
	</tr>
{/if}
</table>