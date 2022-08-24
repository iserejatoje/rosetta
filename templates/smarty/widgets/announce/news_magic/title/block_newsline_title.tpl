<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="2">
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={if $res.sections[0].Link}{$res.sections[0].Link|escape:"url"}{else}{$res.section.Link|escape:"url"}{/if}" target="_blank">
					{$res.title}
					</a></td>{if $withdate}<td>&nbsp;{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</td>{/if}</tr>
			</table>
		</td>
	</tr>
{foreach from=$res.list item=l key=y}
	<tr><td style="padding-top: 8px;" width="4"><img src="/_img/design/200608_title/b3.gif" width="4" height="4"></td>
{capture name="date"}{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}{/capture}
	<td class="block_content">&nbsp;<a target="_blank" href="/service/go/?url={$smarty.capture.date|escape:"url"}" class="t11" {if $l.Order>0}style="color:red;"{/if}>{$l.Title}</a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
	</td>
	</tr>
{/foreach}
{if $CURRENT_ENV.site.domain=="mychel.ru"}
	<tr>
		<td colspan="2" style="padding-top:8px">
		<font class="t11b">Киноафиша:</font> <a class="a11" href="/service/go/?url={"http://www.mychel.ru/afisha/cinema/search.php?range=today"|escape:"url"}" target="_blank">сегодня</a>, <a href="/service/go/?url={"http://www.mychel.ru/afisha/cinema/search.php?range=tomorrow"|escape:"url"}" target="_blank" class="a11">завтра</a>. <a href="/service/go/?url={"http://mychel.ru/afisha/performance"|escape:"url"}" target="_blank" class="a11">Спектакли</a>			
		</td>
	</tr>
{/if}
</table>
