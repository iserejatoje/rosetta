
{if !sizeof($page.list)}
	<center><br/><br/>
	<font color=red><b>Запрашиваемая вами страница не существует.</b></font><br /><br />
	<br /><br />
		[&nbsp;<a href="/{$CURRENT_ENV.section}/">вернуться на главную раздела</a>&nbsp;] 
	</center>
{else}

<br/>
{if $page.list[0].rname && $page.list[0].pname}
<table cellpadding="3" cellspacing="0" width="100%"> 
	<tr>
		<td class="t5gb">
			{$page.list[0].rname} :: <a href="/{$CURRENT_ENV.section}/search/section.html?rid={$page.list[0].rid}&pid={$page.list[0].pid}">{$page.list[0].pname}</a>
		</td>
	</tr> 
</table>
{/if}


{if $page.list[0].name == ''}<br/>
{assign var=start value="1"}
<table cellpadding="5" cellspacing="0" width="100%"> 
	<tr>
		<td class="t5gb">
			{$page.list[0].word}
		</td>
		<td class="t7">{$page.list[0].comment}</td>
	</tr> 
</table><br/><br/>
{else}
{assign var=start value="0"}
{/if}

<br/>
{if sizeof($page.list) > $start}
<table cellpadding="3" cellspacing="0" width="100%"> 
	<tr><td class="t5gb">Толкования читателей</td></tr> 
</table>


<br/>
<table cellpadding="5" cellspacing="0" width="100%"> 
{foreach from=$page.list item=l name=list}
{if $smarty.foreach.list.iteration > $start}
	<tr>
		<td class="otzyv"><em>{if $l.email}<a href="mailto:{$l.email}" style="color:#1F68A0">{$l.name}</a>{else}{$l.name}{/if}</em></td>
		<td width="100%" class="t7">{$l.comment}</td>
	</tr>
	<tr><td colspan="2"><br/></td></tr>
{/if}
{/foreach}
</table>

{/if}

{$page.add_form}

<br/><br/>
<table cellpadding="3" cellspacing="0" width="100%"> 
	<tr>
		<td class="t5gb">Смотрите также</td>
	</tr>
</table>

<table cellpadding="5" cellspacing="0 "border="0">
	<tr>
		{if sizeof($page.words)}
		<td valign="top"><b>Слова:</b></td>
		<td valign="top">
			{foreach from=$page.words item=word}
				<img src="/_img/design/200608_title/b3.gif">&#160;<a href="/{$CURRENT_ENV.section}/show/{$word.did}.html" class="s1">{$word.word}</a><br/>
			{/foreach}
		</td>
		{/if}
		{if sizeof($page.subsections)}
		<td valign="top" style="{if sizeof($page.words) != 0}padding-left:50px{/if}"><b>Подразделы:</b></td>
		<td valign="top">
			{foreach from=$page.subsections item=ss}
				<img src="/_img/design/200608_title/b3.gif">&#160;<a href="/{$CURRENT_ENV.section}/search/section.html?rid={$ss.rid}&pid={$ss.pid}" class="s1">{$ss.pname}</a><br/>
			{/foreach}
		</td>
		{/if}
	</tr>
</table>

{/if}







