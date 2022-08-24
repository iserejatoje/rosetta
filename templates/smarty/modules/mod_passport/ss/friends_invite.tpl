<div class="title" style="padding: 5px;">Добавить друга</div><br/><br/>
<form method="POST">
<input type="hidden" name="action" value="friends_invite"/>
<input type="hidden" name="id" value="{$page.UserInfo->ID}"/>
<center><div style="width:550px;">
	{if $UERROR->IsError()}
	<div class="error"><span>
		{$UERROR->GetErrorsText()}</span>
	</div><br/><br/>
	{/if}

	<div style="float:left;background: url('{$page.UserInfo->Profile.general.AvatarUrl}') no-repeat top center;width:100px;"><img src="/_img/design/200608_title/x.gif" width="100" height="100"/></div>
	<div align="center">
		Вы хотите, чтобы <a target="_blank" href="{$page.UserInfo->Profile.general.InfoUrl}">{$page.UserInfo->Profile.general.ShowName}</a>
		был в списке Ваших друзей?<br/><br/>
		Мы оповестим его об этом, и он должен будет подтвердить, что вы друзья.<br/><br/>
			
		<div>
			<div style="margin-bottom: 4px;" class="tip">Личное сообщение</div>
				<textarea name="text" rows="6" style="width: 220px;">{$page.text}</textarea>
		   </div>
		</div>
		
		<br/><br/>
		<div style="padding-left:100px">
			<input type="submit" value="Добавить" />
		<div>
	
	</div>
</div></center>
</div>