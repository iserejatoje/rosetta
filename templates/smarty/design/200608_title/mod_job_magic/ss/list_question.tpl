
{if is_array($UERROR->ERRORS) && sizeof($UERROR->ERRORS)}
<br/><div align="center" style="color:red"><b>
		{foreach from=$UERROR->ERRORS item=l}
			{$l}<br />
		{/foreach}
	</b></div><br/><br/>
{/if}

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

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table2">
	<tr>
		<td class="text11">Всего вопросов: <b>{$res.count}</b>.</td>
	</tr>
	
	{if $smarty.capture.pageslink!="" }
	<tr>
		<td  class="text11" align="center">
			{$smarty.capture.pageslink}
		</td>
	</tr>
	<tr>
		<td height="5px"></td>
	</tr>
	{/if}
	
	{foreach from=$res.list item=l}
		<tr>
			<td>
				<table cellpadding="5" cellspacing="1" border="0" width="100%" class="table2">
					<tr>
						<td class="bg_color2" valign="top" width="20%" rowspan="2">
							Автор: <a {if $l.email != ""}href="mailto:{$l.email}"{/if}>{$l.name}</a><br />{$l.date}
						</td>
						<td class="bg_color4" valign="top" width="80%">
							<font class="s1"><b>Вопрос:</b></font><br />
							{$l.otziv|nl2br}
						</td>
					</tr>
					<tr>
						<td class="bg_color4" valign="top" width="80%">
							<font class="s1"><b>Ответ:</b></font><br />
							{$l.otvet|nl2br}
						</td>				
					</tr>
				</table>
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