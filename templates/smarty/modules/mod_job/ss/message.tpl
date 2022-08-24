{if $rname!=""}
	{capture name="rname"}
		{$rname}
	{/capture}
{else}
	{capture name="rname"}
		Сообщение
	{/capture}
{/if}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
<br/><br/><center><b>{$msgok}</b>
<br/><br/>
<a href="/{$CURRENT_ENV.section}/?cmd=default" class="s1">вернуться на главную</a></center>