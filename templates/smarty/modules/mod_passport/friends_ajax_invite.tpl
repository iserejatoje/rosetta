<form style="margin:0px" method="POST">
<table width="400" border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td class="nyroModalTitle bg_color1">
			<div style="float:right">
				<img class="nyroModalClose" style="cursor:pointer;cursor:hand;padding-top:2px;" src="/_img/modules/passport/im/close.gif " />
			</div>
			<div align="left">Добавить друга</div>
		</td>
	</tr>
	<tr bgcolor="#E0F3F3" class="bg_color2">
		<td align="center" width="100%" id="friends_container">
			<div style="float:left;background: url('{$res.UserInfo->Profile.general.AvatarUrl}') no-repeat top center;width:110px;"><img src="/_img/x.gif" width="110" height="100"/></div>
			<div align="left">
				<br>
				<a target="_blank" href="{$res.UserInfo->Profile.general.InfoUrl}"><b>{$res.UserInfo->Profile.general.ShowName}</b></a>
				
				<div id='addMsg' class="tip" style='display:none;'>
					<a href="#" onclick="$('#addMsgBox').show();$('#addMsg').hide();mod_passport_friends_loader.rendered();return false;">[ Добавить личное сообщение ]</a><br/>
				</div>
				<br><br><br><br>
				<div id='addMsgBox' style='margin-left: 10px;'>
					<div style="margin-bottom: 4px;" class="tip">Личное сообщение: <a style="font-size:9px" href="#" onclick="$('#addMsgBox').hide();$('#addMsg').show();mod_passport_friends_loader.rendered();return false;">Скрыть</a><br />
						<textarea id="friend_form_text" name="friend_form_text" rows="6" style="width: 100%;">Приглашаю Вас стать моим другом!</textarea>
				   </div>
				</div>
				
				<br/><br/>
				<div align="center">
					<input type="button" id="imSendButton" class="nyroModalSend" value="Отправить" />
					<input type="button" class="nyroModalClose" value="Закрыть" />
				</div><br/>
			</div>
		</td>
	</tr>
</table>
</form>