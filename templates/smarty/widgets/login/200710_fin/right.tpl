{if $USER->IsAuth()}
<div>
	<table cellspacing="0" cellpadding="0" border="0" width="100%"> 
	    <tr>
	        <td valign="top">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tr>
						<td width="13" valign="top" background="/_img/design/200710_fin/zag2.gif">
							<img height="5" width="1" src="/_img/x.gif"/>
						</td>
						<td bgcolor="#85a0b2" rowspan="2" height="23px">
							<font class="menu4">&nbsp;&nbsp;Здравствуйте, {$res.showname}</font>
						</td>
						<td bgcolor="#85a0b2" align="right" width="10" valign="bottom" rowspan="2" style="background-image: url(/_img/design/200710_fin/zag2ugol.gif);background-position:bottom;background-repeat:no-repeat;">
							<img height="1" width="10" src="/_img/x.gif"/>
						</td>
					</tr>
					<tr>
						<td background="/_img/design/200710_fin/zag2back.gif"><img height="5" width="1" src="/_img/x.gif"/></td>
					</tr>
				</table>
			</td>
	    </tr>
	</table>

	
	<img width="1" height="5" src="/_img/x.gif"/>
	<div>
		<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><a href="{$res.url_messages}" class='zag2'>у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count==1}новое{else}новых{/if} сообщени{if $res.newmessages_count==1}е{else}я{/if*}</a>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
	</div>
</div>
{else}
<div>
	<form method="POST" action="{$res.url_login}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$res.url_current|escape:"quotes"}" />
		<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
		     <tr>
		        <td width="13" valign="top"><img src="/_img/design/200710_fin/zag2.gif" width="13" height="23"></td>
		        <td bgcolor="#B3C9D7"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
		            <tr bgcolor="#85A0B2">
		              <td align="left"><font class=menu4>Вход в паспорт</font></td>
		              <td width="10" align="right" valign="bottom"><img src="/_img/design/200710_fin/zag2ugol.gif" width="10" height="23"></td>
		            </tr>
		        </table></td>
		      </tr>
		</table>  						
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" bgcolor="#E3ECF2">
		<table cellpadding="3" cellspacing="0" align="center">
			<tr>
				<td>E-Mail:</td>
				<td colspan="2"><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
			</tr>
			<tr>
				<td>Пароль:</td>
				<td colspan="2"><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr align="center">
						<td width="10px"></td>
						<td align="right"><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
						<td align="left">&nbsp;<label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label></td>
						<td align="left"><input tabindex="1003" type="submit" value="Войти" class="button" /></td>
						<td width="20px"></td>
					</tr>
					</table>
				</td>
			</tr>
		</table></td></tr>
		</table>
		<div align="center" style="background-color: #E3ECF2"><nobr>
		<a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
		<a href="{$res.url_forgot}">Забыли пароль?</a>
		</nobr><br/><br/></div>
</form>
</div>
{/if}