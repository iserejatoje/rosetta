<?
global $CONFIG;
?>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
        <TR>
          <TD class="block_caption_main"><a href="<?=$vars['wpoll']['url'];?>" target="_blank">Опрос</a></TD>
        </TR>
</table>
<center id="block_center_poll">
<form name="anketa"  action="<?=$vars['wpoll']['url'];?>" id="PollForm<?=$vars['wpoll']['PollId']?>" method="post" target="stat" onsubmit="return checkAnswers('PollForm<?=$vars['wpoll']['PollId']?>','<?=$vars['wpoll']['ManyAns']?>', '<?=$vars['wpoll']['MinAns']?>', '<?=$vars['wpoll']['MaxAns']?>');">
	<input name="action" value="votew" type="hidden"/>
	<input name="question_id" value="<?=$vars['wpoll']['PollId']?>" type="hidden"/>
<table width="100%" cellpadding="1" cellspacing="0" border="0" class="t12">
	<tr><td class="t12" align="left" style="padding-top: 3px;">
	<b><?=$vars['wpoll']['Name']?></b><br>
	<img src="/_img/x.gif" alt="" border="0" height="2" width="1"/><br>
		<font class="t12">
			<? foreach($vars['wpoll']['answers'] as $key=>$ans)
			{ ?>
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
				<?=$ans['Name']?><br/>
			<?}?>
	</font>
			<? if($vars['wpoll']['ManyAns'] == 1)
			{
			?><div class="small" style="color:#AAAAAA"><br><small>* Можно выбрать несколько вариантов ответа</small></div><?
			}
			?>
		</td>
	</tr>
	<?if(isset($vars['wpoll']['captcha_path']))
	{
	?>
	<tr>
		<td>
			<p align="center" class="t11">
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
	<tr><td class="t11"><b>
	<br /><img src="/_img/x.gif" width="1" height="2" border="0" alt="" /><br />
	<input style="width: 130px;" name="submit" value="Проголосовать" type="submit">
	&nbsp;&nbsp;&nbsp;[&nbsp;<a href="<?=$vars['wpoll']['url'];?>?tw=popup" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" class="a11"><b>Статистика</b></a>&nbsp;|&nbsp;<a href="<?=$vars['wpoll']['url'];?>" class="a11"><b>Все опросы</b></a>&nbsp;]</b>
	<img src="/_img/x.gif" alt="" height="3" width="1"><br />
	</td></tr>
</table>
</form>
</center>