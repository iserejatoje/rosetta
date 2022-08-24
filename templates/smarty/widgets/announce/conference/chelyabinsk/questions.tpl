{if $res.count }

{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>
		{else}
			&nbsp;<span class="pageslink_active"> {$l.text} </span>
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left">
			<table align=left cellpadding=0 cellspacing=0 border=0 width=100%>
				<tr>
					<td class="zag4"><a name="questions"></a>Вопросы читателей:</td>
				</tr>
				<tr>
					<td height=3 bgcolor=#CCCCCC><img src="/_img/x.gif" width=1 height=3 border=0></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="5px"></td>
	</tr>
	<tr>
		<td class="smaller">Всего вопросов: {$res.count_questions}</td>
	</tr>
	<tr>
		<td class="smaller">Всего ответов: {$res.count_answers}</td>
	</tr>

{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="5px"></td>
	</tr>
	<tr>
		<td>{$smarty.capture.pageslink}</td>
	</tr>
{/if}
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td>

	{foreach from=$res.list item=l key=k}
		<table width="100%" align="center" cellpadding="3" cellspacing="1" border="0" bgcolor="#BBBBC4">
			<tr bgcolor="#EFEFF1">
				<td width="70%"><a name="question{$l.QuestionID}"></a>{if $l.Email }<a href="mailto:{$l.Email}">{$l.Name|truncate:30:"..."}</a>{else}{$l.Name|truncate:30:"..."}{/if}</td>
				<td align="center" width="30%">{$l.Date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}</td>
			</tr>
			{if $l.Text!=""}
			<tr bgcolor="#F5F5F5">
				<td colspan="2" style="text-align: justify"><b>Вопрос:</b><br>{$l.Text|with_href}</td>
			</tr>
			{/if}
			{if is_array($l.Questions) && sizeof($l.Questions)}
				{foreach from=$l.Questions item=lquest key=kquest}			
					{if $lquest.Text != ''}
						<tr class="left_menu_back">
							<td align="left"  width="70%" class="small">
								<b>{if $lquest.Email }<a href="mailto:{$lquest.Email}" class="a11">{$lquest.Name|truncate:30:"..."}</a>{else}{$lquest.Name|truncate:30:"..."}{/if}</b>
							</td>
							<td align="center" width="30%" class="small">{$lquest.Date|date_format:"<b>%H:%M</b>&nbsp;%e.%m.%Y"}</td>
						</tr>
						<tr bgcolor="#F5F5F5">
							<td colspan="2" style="text-align: justify" class="small">
								<b>Вопрос:</b><br/>{$lquest.Text|with_href}
							</td>
						</tr>
					{/if}				
				{/foreach}
			{/if}
		
			{if $l.Answer!=""}
			<tr bgcolor="#FFFFFF">
				<td colspan="2" style="text-align: justify">
					<b>Ответ:</b>
					<br/>{$l.Answer|nl2br|with_href}
				</td>
			</tr>
			{/if}
		</table><br/>
	{/foreach}

		</td>
	</tr>

{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="5px"></td>
	</tr>
	<tr>
		<td>
			{$smarty.capture.pageslink}
		</td>
	</tr>
{/if}
	<tr>
		<td height="20px"></td>
	</tr>
</table>
{/if}