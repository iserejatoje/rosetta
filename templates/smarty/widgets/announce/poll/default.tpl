{if is_array($res)}


<table width="100%" cellpadding="0" cellspacing="1" border="0" >
{if is_array($res.data)}
{foreach from=$res.data item=l}
<tr>
	<td class="text11"><b>{$l.Title}</b></td>
</tr>
<tr>
	<td class="tip" style="padding-bottom:4px;">
{if $l.IsVoted === false}
	<div id="VoteDiv{$l.PollID}">
	<form method="post" id="PollForm{$l.PollID}">
	<input type="hidden" name="action" value="vote" id="PollAction">
	<input type="hidden" name="PollID" value="{$l.PollID}" id="PollID">
	<input type="hidden" name="PollType" value="{$l.Type}" id="PollType">
	<input type="hidden" name="UniqueID" value="{$l.UniqueID}">
	<input type="hidden" id="MultiMin" value="{$l.MultiMin}">
	<input type="hidden" id="MultiMax" value="{$l.MultiMax}">
	<input type="hidden" id="Type" value="{$l.Type}">
	{foreach from=$l.Answer item=a}
	<div class="tip">
		<input type="{if $l.Type==1}radio{elseif $l.Type==2}checkbox{/if}" name="answer{if $l.Type==2}[]{/if}" value="{$a.PollAnswerID}" id="ans-{$a.PollAnswerID}" onClick="CountAnswers(this)"><label for="ans-{$a.PollAnswerID}"> {$a.Text}</label>
	</div>
	{/foreach}
	{if $l.Type == 2}
	<div class="tip" style="padding-top:3px; padding-bottom:3px;">Вы можете выбрать от <b>{$l.MultiMin}</b> до <b>{$l.MultiMax}</b> вариантов ответов. Осталось <b id="CountAnswer">{$l.MultiMax}</b>.</div>
	{/if}
	<br>
	<input type="button" id="button" value="Проголосовать" onClick="return AddVote({$l.PollID})" disabled />	
	</form>
	</div>
{else}
<table cellspacing="0" cellpadding="2" border="0" width="100%">
	{foreach from=$l.Answer item=a}
	<tr>
		<td class="tip">{$a.Text}</td>
		<td align="right" nowrap="nowrap" class="tip">{$a.Width} %</td>
		<td width="50"><div style="width:{$a.Width}%;background-color:#CCCCCC;border:1px solid #999999"></div></td>
	</tr>
	{/foreach}
	<tr class="tip">
		<td class="tip"><b>Всего голосов</b></td>
		<td align="right" class="tip"><b>{$l.Votes}</b></td>
		<td>&nbsp;</td>
	</tr>
</table>
{/if}
	
	</td>
</tr>
{/foreach}
{/if}
<tr>
	<td class="tip" style="padding-bottom:4px;"><br />
		<a href="/community/{$res.obj_id}/poll/last.php">Все голосования</a>
{if $res.can_add=== true}
		&nbsp;&nbsp;
		<a href="/community/{$res.obj_id}/poll/edit.php">Добавить</a>
{/if}
	</td>
</tr>
</table>


{/if}