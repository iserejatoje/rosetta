{include file="`$TEMPLATE.sectiontitle`" rtitle="Вопросы от пользователей"}
<center>

{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}" class="s1">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}
<table cellpadding=0 cellspacing=0 border=0 bgcolor="#FFFFFF" width=100%>
	<tr><td bgcolor="#ffffff" class="t7">Всего вопросов: <b>{$res.count}</b>.</td></tr>
	{if $smarty.capture.pageslink!="" }
	<tr><td class="s1" align="center">
		{$smarty.capture.pageslink}
	</td></tr>
	<tr><td height="5px"></td></tr>
	{/if}
	{foreach from=$res.list item=l}
		<form name=add_msg_form{$l.id} method=post>
		<input type="hidden" name="cmd" value="updquest">
		<input type="hidden" name="id" value="{$l.id}">
		<tr><td>
				<table cellpadding=3 cellspacing=0 border=0 width=100% >
				<tr><td class="t7" bgcolor="#DEE7E7">Автор: <a {if $l.email!=""}href="mailto:{$l.email}"{/if} class="s1">{$l.name}</a></td><td class="t7" bgcolor="#DEE7E7" align="right">{$l.date}</td></tr>
				<tr>
				<td colspan="2" class="t7" bgcolor="#f3F8F8" valign="top" width=80%><font class="s1">Вопрос:</font><br>{$l.otziv}</td>
				</tr>
				<tr>
				<td colspan="2" class="t7" bgcolor="#f3F8F8" valign="top" width=80%><font class="s1">Ответ:</font><br><textarea class=t7 name="otvet" cols=40 rows=5 style="width:100%">{$l.otvet}</textarea></td>				
				</tr>
				<tr>
				<td class="t7" bgcolor="#f3F8F8"><input type="checkbox" name="onboard" value="checked" class="in" {if $l.onboard}checked{/if}> <font class="s1">Отображать на сайте</font>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="isdel" value="checked" class="in"> <font class="s1">удалить</font></td>
				<td align="right" bgcolor="#f3F8F8"><input class="in" type=submit value="Сохранить"></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				</table>
		</td></tr>
		</form>	
	{/foreach}
	{if $smarty.capture.pageslink!="" }
	<tr><td height="5px"></td></tr>
	<tr><td class="s1" align="center">
		{$smarty.capture.pageslink}
	</td></tr>
	{/if}
</table>
</center>