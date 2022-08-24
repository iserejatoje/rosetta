{if is_array($res.data) && sizeof($res.data)}
<div class="block_info">

		<div class="title title_lt">
			<div class="left">
				<div>Голосование</div>
			</div>
		</div>

		<div class="widget_content">

			<div class="content">
				
				<div>
				{if is_array($res.data) && sizeof($res.data)}
				{foreach from=$res.data item=l}
				<b>{$l.Title}</b><br/><br/>
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
								<div>
									<input type="{if $l.Type==1}radio{elseif $l.Type==2}checkbox{/if}" name="answer{if $l.Type==2}[]{/if}" value="{$a.PollAnswerID}" id="ans-{$a.PollAnswerID}" onClick="CountAnswers(this)"><label for="ans-{$a.PollAnswerID}"> {$a.Text}</label>
								</div>
								{/foreach}
								{if $l.Type == 2}
									<div style="padding-top:3px; padding-bottom:3px;">Вы можете выбрать от <b>{$l.MultiMin}</b> до <b>{$l.MultiMax}</b> вариантов ответов. Осталось <b id="CountAnswer">{$l.MultiMax}</b>.</div>
								{/if}
								<br />
								<input type="button" id="button" value="Проголосовать" onClick="return AddVote({$l.PollID})" disabled />	
							</form>
						</div>
					{else}
					<table cellspacing="0" cellpadding="2" border="0" style="position: relative;">
						{foreach from=$l.Answer item=a}
						<tr>
							<td width="100%">{$a.Text}</td>
							<td align="right" nowrap="nowrap">{$a.Width} %</td>
							<td><div style="width:60px;"><div style="width:{$a.Width}%;background-color:#CCCCCC;border:1px solid #999999;position: relative;font-size: 1px;margin-top:6px;"></div></div></td>
						</tr>
						{/foreach}
						<tr>
							<td><b>Всего голосов</b></td>
							<td align="right"><b>{$l.Votes}</b></td>
							<td>&nbsp;</td>
						</tr>
					</table>
					{/if}
				{/foreach}
				{/if}
			</div>
			</div>
			{if  $res.count > sizeof($res.data) || $res.can_add=== true}
			<div class="actions_panel">
				<div class="actions_rs">
					{if  $res.count > sizeof($res.data)}<a href="/community/{$res.obj_id}/poll/last.php">Все голосования</a>{/if}
					{if  $res.count > sizeof($res.data) && $res.can_add=== true}<br/>{/if}
					{if $res.can_add=== true}<a href="/community/{$res.obj_id}/poll/edit.php">Создать голосование</a>{/if}
				</div>
			</div><br clear="both"/>
			{/if}
		</div>
</div>
{/if}