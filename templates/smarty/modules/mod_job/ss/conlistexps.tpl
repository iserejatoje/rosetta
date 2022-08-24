{include file="`$TEMPLATE.sectiontitle`" rtitle="`$res.title`"}
<table cellspacing="10" cellpadding="0" class="text11">
	<tr>
		<td align="center" class="text14" colspan="2"><b>Архив {if $res.year} за {$res.year} год{/if}</b><br/></td>
	</tr>
{if count($res.list)>0}
	{foreach from=$res.list item=l}
	<tr valign="top">
		<td>{if $l.photo.file}
			{if !$l.readonly}
				<a href="/{$CURRENT_ENV.section}/?cmd=conquest&id={$l.id}" title="Задать вопрос"><img src="{$l.photo.file}" width="{$l.photo.w}" height="{$l.photo.h}" alt="Задать вопрос" border="0" /></a>
			{else}
				<a href="/{$CURRENT_ENV.section}/?cmd=conquest&id={$l.id}" title="Далее"><img src="{$l.photo.file}" width="{$l.photo.w}" height="{$l.photo.h}" alt="Далее" border="0" /></a>		
			{/if}
		{/if}
		</td>
		<td>
			<a href="/{$CURRENT_ENV.section}/?cmd=conquest&id={$l.id}" title="{if !$l.readonly}Задать вопрос{else}Далее{/if}"><b>{$l.name} {$l.io}</b></a><br/> 
		{$l.employ} <br/><br/>
		{if !$l.readonly}<a href="/{$CURRENT_ENV.section}/?cmd=conquest&id={$l.id}">Задать вопрос</a>{/if}
		{if $l.lquest.otziv}
			<br/><br/><font class="info"><b>Последний вопрос</b>:<br/> <font color="#FF6701"><b>{$l.lquest.name|truncate:30:"...":false},&nbsp;{$l.lquest.date|date_format:"%e.%m"}</b>:</font>
			&nbsp;{$l.lquest.otziv|truncate:50:"...":false}&nbsp;<a href="/{$CURRENT_ENV.section}/?cmd=conquest&amp;id={$l.id}#{$l.lquest.id}" class="info">Далее</a></font>
		{/if}
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" width="1" /></td>
	</tr>		
	{/foreach}
{else}
	<tr><td colspan="2" align="center">Нет ни одного консультанта</td></tr>
{/if}
</table>