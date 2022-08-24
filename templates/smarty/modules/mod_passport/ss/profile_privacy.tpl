<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="profile_privacy" />
<div class="title">Конфиденциальность</div>        
<br /><br />
<table border="0" cellpadding="3" cellspacing="2" width="550">
{if $UERROR->GetErrorByIndex('question') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('question')}</span></td>
	</tr>
{/if}
	<tr valign="top">
		<td align="right" width="150" class="bg_color2">Выберите вопрос <font color="red">*</font>:</td>
		<td class="bg_color4">
			<select name="question" id="question" style="width:100%" onchange="mod_passport.changeQuestion();">
			<option value="0">-- выберите вопрос --</option>
			{foreach from=$page.form.question_arr item=l key=k}
			<option value="{$k}"{if $k==$page.form.question} selected{/if}>{$l|escape:'html'}</option>
			{/foreach}
			<option value="100"{if 100==$page.form.question} selected{/if}>-- или укажите свой --</option>
			</select>
			<div id="q_text_block" {if $page.form.question!=100}style="display: none;"{/if}>
				Свой вопрос:<br/>
				<input type="text" name="question_text" id="question_text" style="width:100%;" value="{$page.form.question_text}" />
			</div>
		</td>
	</tr>
{if $UERROR->GetErrorByIndex('answer') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('answer')}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right">Ответ</td>
		<td class="bg_color4"><input type="text" name="answer" value="{$page.form.answer}" style="width:100%" /></td>
	</tr>
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4">
			<input type="checkbox" name="showemail" id="showemail" value="1"{if $page.form.showemail} checked="checked"{/if} />
			<label for="showemail">Показывать почтовый ящик</label>
		</td>
	</tr>
	<tr>
		<td class="bg_color2">&nbsp;</td>
		<td class="bg_color4">
			<input type="checkbox" name="showfriends" id="showfriends" value="0"{if !$page.form.showfriends} checked="checked"{/if} />
			<label for="showfriends">Никому не показывать моих друзей.</label>
		</td>
	</tr>
	{if $page.form.login_cross_domains}
	<tr>
		<td class="bg_color2" align="right"></td>
		<td class="bg_color4">
			<input type="checkbox" name="autologincross" id="autologincross" value="1"{if $page.form.autologincross} checked="checked"{/if} />
			<label for="autologincross">Автоматически входить на сайты:</label><br/>
			<br/><small>{
			foreach from=$page.form.login_cross_domains item=domain name=domain
				}{$domain}{if !$smarty.foreach.domain.last},&#160; {/if}{
			/foreach}</small>
		</td>
	</tr>
	{/if}
	{if $UERROR->GetErrorByIndex('password') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->GetErrorByIndex('password')}</span></td>
	</tr>
	{/if}
	<tr>
		<td class="bg_color2" align="right">Пароль</td>
		<td class="bg_color4" ><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br><input type="submit" value="Сохранить изменения" /></td>
	</tr>
</table>
</form>