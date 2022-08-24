{foreach from=$res.list item=l}
<table border="0" cellspacing="0" cellpadding="2" width="100%">
{if $l.isNow<=2}
<tr><td style="font-size:12px;">
	<font class="txt_blue"><b>
	{if !$l.isNow}
		{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"} онлайн-конференция на {$CURRENT_ENV.site.domain}: 
	{elseif $l.isNow==1}
		Сейчас на {$CURRENT_ENV.site.domain} проходит онлайн-конференция: 
	{elseif $l.isNow==2}
		Завершена онлайн-конференция на {$CURRENT_ENV.site.domain}: 
	{/if}
	</b></font>
	{capture name="link"}{$l.Link}{$l.NameID}.html{/capture}
	<a href="/service/go/?url={"`$smarty.capture.link`"|escape:"url"}" style="color:red;" target="_blank">{$l.TitleArr.name}</a>{if $l.TitleArr.position}, {$l.TitleArr.position}{/if}
	{if $l.isNow<2}
		 <a class="a11" href="/service/go/?url={"`$smarty.capture.link`#question"|escape:"url"}" target="_blank">задать&nbsp;вопрос</a>
	{elseif $l.isNow==2}	
		 <a class="a11" href="/service/go/?url={"`$smarty.capture.link`#questions"|escape:"url"}" target="_blank">читать&nbsp;ответы</a>		
	{/if} 
</td></tr>
</table>
{/if}
{/foreach}