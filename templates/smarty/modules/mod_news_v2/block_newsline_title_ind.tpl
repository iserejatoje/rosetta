<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="2">
			<table class="txt1" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="txt1" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="txt1">{$ENV.site.title[$ENV.section]}</a></td>{if $withdate}<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>{/if}</tr>
			</table>
		</td>
	</tr>
{foreach from=$res.list item=l key=y}
	<tr>
		<td width="4" style="padding-top:8px"><img src="/img/kriz/bullet3.gif" height="5" width="5"></td>
		<td class="block_content">&nbsp;{capture name=date}{$l.date|date_format:"%Y/%m/%d"}{/capture}
		{if !empty($l.group)}{assign var="_group" value="`$l.group`"}{else}{assign var="_group" value=""}{/if}
<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/`$_group``$smarty.capture.date`/#`$l.id`"|escape:"url"}"  target="_blank" class="txt5">
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