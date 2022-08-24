<br>
<TABLE cellSpacing=0 cellPadding=0 width="100%" align=left border=0>
<TBODY>
<TR>
	<TD class=zag4><A name=comments></A>Горячий опрос:</TD>
</TR>
<TR>
	<TD bgColor=#cccccc height=3><IMG height=3 src="/_img/x.gif" width=1 border=0></TD>
</TR>
</TBODY>
</TABLE>
<br>
<br>
<FONT class=zag1>{$res.list.question.name}</FONT><br>
<TABLE width="100%"  border="0" cellspacing="0" cellpadding="2">
<form name="anketa" action="{$res.module_url}/" method="post" target="pollnews" onsubmit="window.open('about:blank', 'pollnews', 'width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">
<input type="hidden" name="action" value="vote" />
<input type="hidden" name="question_id" value="{$res.list.question.id}" />
{foreach from=$res.list.answers item=l}
	<tr><td width="15"><input {if $res.list.question.manyans==1}type="checkbox" name="answers[]"{else}type="radio" name="answer"{/if} value="{$l.id}" /></td><td><span class="a101">{$l.name}</span></td></tr>
{/foreach}
	<tr><td colspan="2">
		{if $res.list.question.manyans == 1}
		<div class="small" style="color:#AAAAAA"><br>* Можно выбрать несколько вариантов ответа</div>
		{/if}
	</td></tr>
        <tr><td width="15">&nbsp;</td>
            <td><input type="submit" name="submit" value="Проголосовать" class=button>&nbsp;&nbsp;<a href="{$res.module_url}/{$res.list.question.id}.html" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Статистика</a>&nbsp;|&nbsp;<a href="{$res.module_url}/">Все опросы</a><br/>
		</td>
        </tr>
</form>
</TBODY></TABLE>
<br>