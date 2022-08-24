<table width="100%" cellpadding="0" cellspacing="0" border="0">
        <TR>
          <TD class="block_caption_main"><a href="http://{$ENV.site.domain}/poll/" target="_blank">Опрос</a></TD>
        </TR>
</table>
<table width="100%" cellpadding="1" cellspacing="0" border="0" class="t12">
<form name="anketa" action="/{$ENV.section}/" method="post" target="stat" onsubmit="window.open('about:blank', 'stat', 'width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">
<input type="hidden" name="action" value="vote" />
<input type="hidden" name="question_id" value="{$BLOCK.res.question.id}" />
<tr>
	<td align="left" class="t12" style="padding-top: 3px;">  
	<b>{$BLOCK.res.question.name}</b>
	<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
	</td>
</tr>
	{foreach from=$BLOCK.res.answers item=l}
<tr>
	<td class="t12">
	<input {if $BLOCK.res.question.manyans==1}type="checkbox" name="answer[]"{else}type="radio" name="answer"{/if} value="{$l.id}" />&nbsp;{$l.name}
	</td>
</tr>
	{/foreach}
<tr>
	<td class="t11"><b>
	<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
	<input style="width:130px" type="submit" name="submit" value="Проголосовать" class="button" />
	&nbsp;&nbsp;&nbsp;[&nbsp;<a href="/{$ENV.section}/{if $smarty.session.group!=""}{$smarty.session.group}/{/if}{$BLOCK.res.question.id}.html" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" style="font-size:11px;"><b>Статистика</b></a>&nbsp;|&nbsp;<a href="/{$ENV.section}/{if $smarty.session.group!=""}{$smarty.session.group}/{/if}" style="font-size:11px;"><b>Все опросы</b></a>&nbsp;]</b>
	</td>
</tr>
{if $BLOCK.res.question.manyans == 1}
<tr>
	<td class="t11">
	* Можно выбрать несколько вариантов ответа
	</td>
</tr>
{/if}
</form>
</table>