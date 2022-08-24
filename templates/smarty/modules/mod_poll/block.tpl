<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="right">
	<td class="block_title_obl"><span>ОПРОС</span></td>
</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
<form name="anketa" action="/{$ENV.section}/" method="post" target="stat" onsubmit="window.open('about:blank', 'stat', 'width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">
<input type="hidden" name="action" value="vote" />
<input type="hidden" name="question_id" value="{$BLOCK.res.question.id}" />
	<tr><td align="left" class="text11">
	<b>{$BLOCK.res.question.name}</b>
	<br /><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /><br />
	<font class="text11">
	{foreach from=$BLOCK.res.answers item=l}
	<input {if $BLOCK.res.question.manyans==1}type="checkbox" name="answer[]"{else}type="radio" name="answer"{/if} value="{$l.id}" />{$l.name}<br />
	{/foreach}
	</font>
	{if $BLOCK.res.question.manyans == 1}
	<div class="small" style="color:#AAAAAA"><br>* Можно выбрать несколько вариантов ответа</div>
	{/if}
	</td></tr>
	<tr><td align="center">
	<input style="width:130px" type="submit" name="submit" value="Проголосовать"/><br>
	<img src="/_img/x.gif" width=1 height=3 alt="" /><br/>
	<a href="/{$ENV.section}/{$BLOCK.res.question.id}.html" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Статистика</a>&nbsp;|&nbsp;<a href="/{$ENV.section}/">Все опросы</a><br/>
	<img src="/_img/x.gif" width=1 height=3 alt="" /><br/>
	</td></tr>
</form>
</table>
