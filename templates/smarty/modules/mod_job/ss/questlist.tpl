{capture name="rname"}
	Задать вопрос компании {$res.fname}
{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
<script type="text/javascript" language="javascript" src="/_scripts/modules/job/questlist.js"></script>

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
		<tr><td>
				<table cellpadding=5 cellspacing=1 border=0 width=100% >
				<tr>
				<td class="t7" bgcolor="#DEE7E7" valign="top" width="20%" rowspan="2">
				Автор: <a {if $l.email!=""}href="mailto:{$l.email}"{/if} class="s1">{$l.name}</a><br>{$l.date}
				</td>
				<td class="t7" bgcolor="#f3F8F8" valign="top" width=80%><font class="s1">Вопрос:</font><br>{$l.otziv}</td>
				</tr>
				<tr>
				<td class="t7" bgcolor="#f3F8F8" valign="top" width=80%><font class="s1">Ответ:</font><br>{$l.otvet}</td>				
				</tr>
				</table>
		</td></tr>	
	{/foreach}
	{if $smarty.capture.pageslink!="" }
	<tr><td height="5px"></td></tr>
	<tr><td class="s1" align="center">
		{$smarty.capture.pageslink}
	</td></tr>
	{/if}
</table>

<br>
<a name=add></a>
<font class="t1">Задать вопрос</font><br><br>

<form name=add_new_msg_form method=post onsubmit="return check(this.from_name, this.from_email, this.message);">
<input type=hidden name=cmd value=questform>
<input type=hidden name=uid value={$res.uid}>
<input type=hidden name=fid value={$res.fid}>
<input type=hidden name=pg_cur value=1>
<table>
<tr>
   <td class=t1>Автор:</td>
   <td  class=t7><input class=t7 type=text name=from_name size=20 maxlength=15></td>
</tr>
<tr>
   <td class=t1>E-mail:</td>
   <td class=t7><input class=t7 type=text name=from_email size=20 maxlength=50></td>
</tr>
<tr>
   <td colspan=2 class=t1>Текст вопроса:</td>
</tr>
<tr>
  <td colspan=2 class=t7>
  <textarea class=t7 name=message cols=40 rows=5></textarea><br><br>
  </td>
</tr>
<tr>
  <td align=center colspan=2 class=s3>
  <input class="in" type=submit value="Добавить вопрос">
  </td>
</tr>
</table>
</form>
<br>
<a href="?cmd=firmvac&id={$res.fid}">Вернуться к вакансиям компании</a>
</center>
