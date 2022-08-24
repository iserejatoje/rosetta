{include file="`$TEMPLATE.sectiontitle`" rtitle="Вопросы от пользователей"}
<center>

{capture name=pageslink}
	{if $page.pageslink.back!="" }<a href="{$page.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$page.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}" class="s1">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $page.pageslink.next!="" }<a href="{$page.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
	<tr>
		<td class="text11">Всего вопросов: <b>{$page.count}</b>.</td>
	</tr>
	{if $smarty.capture.pageslink!="" }
	<tr>
		<td class="text11" align="center">
			{$smarty.capture.pageslink}
		</td>
	</tr>
	<tr>
		<td height="5px"></td>
	</tr>
	{/if}

	{foreach from=$page.list item=l}

		<tr>
			<td>
				<form name="add_msg_form{$l.id}" method="post">
				<input type="hidden" name="action" value="question_update">
				<input type="hidden" name="id" value="{$l.id}">

				<table cellpadding="5" cellspacing="1" border="0" width="100%" class="table2">
					<tr>
						<td class="bg_color2">Автор: <a {if $l.email!=""}href="mailto:{$l.email}"{/if} class="s1">{$l.name}</a></td>
						<td class="bg_color2"align="right">{$l.date}</td>
					</tr>
					<tr>
						<td colspan="2" class="bg_color4" valign="top" width="80%"><font class="s1"><b>Вопрос:</b></font><br>{$l.otziv|nl2br}</td>
					</tr>
					<tr>
						<td colspan="2" class="bg_color4" valign="top" width="80%"><font class="s1"><b>Ответ:</b></font><br /><textarea class=t7 name="otvet" cols=40 rows=5 style="width:100%">{$l.otvet}</textarea></td>
					</tr>
					<tr>
						<td class="bg_color4">
							<input style="vertical-align: middle" type="checkbox" id="ob{$l.id}" name="onboard" value="checked" {if $l.onboard}checked{/if}> <label for="ob{$l.id}">Отображать на сайте</label>&nbsp;&nbsp;&nbsp;&nbsp;<input style="vertical-align: middle" type="checkbox" name="isdel" id="id{$l.id}" value="checked" class="in"> <label for="id{$l.id}">удалить</label>
						</td>
						<td class="bg_color4" align="right"><input type="submit" value="Сохранить"></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>

	{/foreach}

	{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="5px"></td>
	</tr>
	<tr>
		<td class="text11" align="center">
			{$smarty.capture.pageslink}
		</td>
	</tr>
	{/if}

</table>
</center>