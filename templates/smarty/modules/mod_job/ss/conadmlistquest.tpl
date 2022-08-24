<form method="get">
<table width="100%" class="text11" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" style="padding-left: 15px"><b>Консультант</b>: {$res.name} {$res.io}</td>
		<td align="right" style="padding-right: 15px"><input type="submit" value="Выход" class="SubmitBut"/></td>
	</tr>
</table>
<input type="hidden" name="cmd" value="conadmlogout" />
</form>

<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td bgcolor="#005A52"><img src="/_img/x.gif" width="1" height="1" alt=""/></td>
	</tr>
</table>

{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="/{$CURRENT_ENV.section}/{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="/{$CURRENT_ENV.section}/{$l.link}" class="s1">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="/{$CURRENT_ENV.section}/{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

{if $res.qcnt>0}
<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<tr>
		<td bgcolor="#ffffff" class="t7">Всего вопросов: <b>{$res.qcnt}</b>.</td>
	</tr>
	{if $smarty.capture.pageslink!="" }
	<tr>
		<td class="s1" align="center">{$smarty.capture.pageslink}</td>
	</tr>
	<tr><td height="5px"></td></tr>
	{/if}
	</table>
{/if}

{foreach from=$res.quests item=l}
<form method="post">
<input type="hidden" name="cmd" value="conadmupdate" />
<input type="hidden" name="id" value="{$l.id}" />
<input type="hidden" name="p" value="{$l.p}" />
<table cellpadding="7" cellspacing="0" width="100%" class="text11"> 
	<tr align="left"> 
		<td>&nbsp;<a name="{$l.id}">{$l.c}.</a>&nbsp;<b>{if $l.email!=""}{$l.name}{else}<a href="mailto:{$l.email}">{$l.name}</a>{/if}</b>&nbsp; <font class="copy" color="#FF6701">( {$l.date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"} )</font></td>
	</tr>
	<tr bgcolor="#f6f6f6" align="left">
		<td><b>Вопрос</b>: <br/>{$l.otziv}<br/><br/>
		<b>Ответ</b>: <br/>
		<textarea name="answer" rows="5" style="width: 100%">{$l.answer}</textarea></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellpadding="3" width="100%">
				<tr>
					<td align="center"><input type="checkbox" name="onboard" value="1" {if $l.onboard}checked{/if}/>&nbsp;Опубликовать</td>
					<td align="center"><input type="submit" class="SubmitBut" value="Сохранить изменения" /></td>
					<td align="center"><input type="checkbox" name="is_del" value="1" />&nbsp;Удалить </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
{/foreach}

{if $res.qcnt>0}
<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<tr>
		<td bgcolor="#ffffff" class="t7">Всего вопросов: <b>{$res.qcnt}</b>.</td>
	</tr>
	{if $smarty.capture.pageslink!="" }
	<tr>
		<td class="s1" align="center">{$smarty.capture.pageslink}</td>
	</tr>
	<tr><td height="5px"></td></tr>
	{/if}
	</table>
{/if}