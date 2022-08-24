{capture name=pages}
{if count($res.pages.btn) > 0}
	Страницы: 
	{if !empty($res.pages.back)}<a href="{$res.pages.back}">&lt;&lt;</a>&nbsp;{/if}
	{foreach from=$res.pages.btn item=l}
		{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
	{/foreach}
	{if !empty($res.pages.next)}<a href="{$res.pages.next}">&gt;&gt;</a>{/if}
{/if}
{/capture}



<!-- begin content -->

<div align="left"><br/>{$smarty.capture.pages}</div>
<br/>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
{foreach from=$res.questions item=l}
	<a name="{$l.id}"></a>
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr bgcolor="#edf6f8">
			<td width="70%" style="padding: 2px;">{if !empty($l.email)}<a href="mailto:{$l.email}" >{/if}{$l.name}{if !empty($l.email)}</a>{/if}</td>
			<td align="center" width="30%" style="padding: 2px;">{$l.date|date_format:"%H:%M &nbsp;%d.%m.%Y"}</td>
		</tr>
		<tr bgcolor="#FFFFFF">
			<td colspan="2"><b>Вопрос:</b><br/>{$l.otziv}</td>
		</tr>
		<tr height="2px"><td colspan="2"></td></tr>
		<tr bgcolor="#E5E3E0" height="1"><td colspan="2"></td></tr>
		<tr height="2px"><td colspan="2"></td></tr>
		<tr bgcolor="#FFFFFF">
			<td colspan="2">
				<b>Ответ:</b><br/>{$l.answer}<br/>
				{if $l.user_name}<div align="right"><b>Отвечал:</b> <a href="/{$ENV.section}/user/{$l.uid}.html">{$l.user_name}</a></div>{/if}
			</td>
		</tr>
	</table>
	<br/><br/>
{/foreach}
	</td>
	</tr>
</table>
<!-- end content -->
<br/>