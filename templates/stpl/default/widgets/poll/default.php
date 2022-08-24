<?
global $CONFIG;
?>
<br>
<center id="block_center_poll">
<form name="anketa"  action="<?=$vars['wpoll']['url'];?>" id="PollForm<?=$vars['wpoll']['PollId']?>" method="post" target="stat" onsubmit="return checkAnswers('PollForm<?=$vars['wpoll']['PollId']?>','<?=$vars['wpoll']['ManyAns']?>', '<?=$vars['wpoll']['MinAns']?>', '<?=$vars['wpoll']['MaxAns']?>');">
	<input name="action" value="votew" type="hidden"/>
	<input name="question_id" value="<?=$vars['wpoll']['PollId']?>" type="hidden"/>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
	<tr>
		<td class="text11" align="left">
			<div class="poll-block">
				<i></i>
				<div class="question"><?=$vars['wpoll']['Name']?></div>
				<!-- <img src="/resources/img/x.gif" alt="" border="0" height="5" width="1"/><br> -->
				<div class="text11">
					<? foreach($vars['wpoll']['answers'] as $key=>$ans)
					{ ?>
						<label>
						<input <?
						if($vars['wpoll']['ManyAns']==1)
						{
							?> type="checkbox" name="answer[]"<?
						} 
						else
						{
							?> type="radio" name="answer"<?
						}
						?> value="<?=$ans['AnswerId']?>" />
						<?=$ans['Name']?>
						</label>
					<?}?>
					<a href="javascript:void(0)" class="poll-btn" onclick="if (checkAnswers('PollForm<?=$vars['wpoll']['PollId']?>','<?=$vars['wpoll']['ManyAns']?>', '<?=$vars['wpoll']['MinAns']?>', '<?=$vars['wpoll']['MaxAns']?>')) document.forms.anketa.submit()" >Проголосовать</a>
					<a class="stat-link" href="<?=$vars['wpoll']['url'];?>stat/<?=$vars['wpoll']['PollId']?>.html?tw=popup" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Статистика</a>
				</div>
					<? if($vars['wpoll']['ManyAns'] == 1)
					{
					?><div class="small" style="color:#AAAAAA"><br><small>* Можно выбрать несколько вариантов ответа</small></div><?
					}
					?>
			</div>
		</td>
	</tr>
	<?if(isset($vars['wpoll']['captcha_path']))
	{
	?>
	<tr>
		<td>
			<p align="center">
				<img src="<?=$vars['wpoll']['captcha_path']?>" align="absmiddle" width="150" height="50" alt="код" vspace="3" border="0"/>
				<br/>
				<input type="hidden" name="captcha_key" value="<?=$vars['wpoll']['captcha_key']?>">
				
				Код:
				<input type="text" name="captcha_code" size="20" class="text_edit" style="width:80px;">
			</p>
		</td>
	</tr>
	
	<?
	}?>
</table>
</form>
</center>