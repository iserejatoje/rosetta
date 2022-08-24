{include file="`$TEMPLATE.sectiontitle`" rtitle="Избранные `$res.type` (`$res.count`)"}

{capture name=pageslink}
	{if sizeof($res.pageslink.btn)}
	<br/>{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">[{$l.text}]</a>&nbsp;
		{else}
			[{$l.text}]&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
	<br/>{/if}
{/capture}

{if isset($res.err) && is_array($res.err)}
	<br/><br/><div align="center"><b>
		{foreach from=$res.err item=l key=k}
			{$l}<br />
		{/foreach}
	</b></div><br/>
{/if}

<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
		<td align="center">
			<form method="post" >
			<input type="hidden" name="action" value="favorites_edit_list">
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr bgcolor="#e9efef">
					<th>#</th>
					<th>Дата<br/>разм.</th>
					<th>Автор / Раздел</th>
					<th>Должность</th>
					<th>З/п</th>
					{*<th>Отправить<br/>{if $res.type=='вакансии'}резюме{else}сообщение{/if}</th>*}
					<th>Исключить</th>
				</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.data item=l name=lst}
				<tr class="{excycle}" valign="top">
					<td align="center" class="text11"><a href="/{$ENV.section}/{if $l.type=='vacancy'}vacancy{else}resume{/if}/{$l.id}.html?rid={$l.rid}">{$l.id}</a></td>
					<td align="center">{$l.pdate}</td>
					<td>{$l.author}<br/>{$l.name}</td>
					<td><a href="/{$ENV.section}/{if $l.type=='vacancy'}vacancy{else}resume{/if}/{$l.id}.html?rid={$l.rid}">{if $l.hot}<font color="red">{/if}{$l.dolgnost}{if $l.hot}</font>{/if}</a></td>
					<td>{$l.paysum}</td>
					{*<td align="center">{if $l.type=='vacancy'}<input type="checkbox" name="arr_post_resume[]" value="{$l.id}"/>{else}<input type="checkbox" name="arr_post_message[]" value="{$l.id}"/>{/if}</td>*}
					<td align="center"><input type="checkbox" name="arr_del_{if $l.type=='vacancy'}vacancy{else}resume{/if}[]" value="{$l.id}"/></td>
				</tr>
				{/foreach}
				<tr>
					<td colspan="{if sizeof($res.data) > 1}9{else}8{/if}" align="right" class="text11">{$smarty.capture.pageslink}</td>
				</tr>
			</table>
			<input type="submit" value="Применить" class="in">&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Сброс" class="in">
			</form>
		</td>
	</tr>
</table><br/>
