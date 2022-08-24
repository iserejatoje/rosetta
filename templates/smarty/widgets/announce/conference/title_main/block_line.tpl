{if count($res.list)}
{foreach from=$res.list item=l}
{if $l.isNow <= 2}
<div class="announce">
	<div class="item">
		<span class="title">
		{if !$l.isNow}
			{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"} онлайн-конференция на {$CURRENT_ENV.site.domain}: 
		{elseif $l.isNow==1}
			Сейчас на {$CURRENT_ENV.site.domain} проходит онлайн-конференция: 
		{elseif $l.isNow==2}
			Завершена онлайн-конференция на {$CURRENT_ENV.site.domain}: 
		{/if}
		</span>
		{capture name="link"}{$l.Link}{$l.NameID}.html{/capture}
		<a class="redtext" href="/service/go/?url={"`$smarty.capture.link`"|escape:"url"}" target="_blank">{$l.TitleArr.name}</a>{if $l.TitleArr.position}, {$l.TitleArr.position}{/if}
		{if $l.isNow < 2}
			 <a class="service" href="/service/go/?url={"`$smarty.capture.link`#question"|escape:"url"}" target="_blank">задать&nbsp;вопрос</a>
		{elseif $l.isNow==2}
			 <a class="service" href="/service/go/?url={"`$smarty.capture.link`#questions"|escape:"url"}" target="_blank">читать&nbsp;ответы</a>
		{/if}
	</div>
</div>
{/if}
{/foreach}
{/if}