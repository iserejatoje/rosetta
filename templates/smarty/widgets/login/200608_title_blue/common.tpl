{if $USER->IsAuth()}
<div class="login_form login_form_autorised" style="width:220px; margin-right:0px; padding-right:0px;text-align:left; padding-top:5px; padding-bottom:10px; padding-left:6px;">
	<div class="welcome">
		Здравствуйте, {$res.showname}!
	</div>
	{*<div style="padding-top: 2px;">
		<a href="/svoi/"><img border="0" height="11" width="92" src="/_img/design/200608_title_blue/logo_svoi/s.{$CURRENT_ENV.regid}.gif"/></a>
	</div>*}
	<div class="links" style="text-align:left;">
		<a href="{$res.url_mypage}">ваша страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{$res.url_svoi}">сообщества</a>
		<br>
		<div>
		{if $res.newmessages_count > 0}
		<a href="{$res.url_newmessages}"><font color="red">у вас {$res.newmessages_count} {if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if}</font></a> <a href="{$res.url_newmessages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>
		{else}
		<a href="{$res.url_messages}">ваши сообщения</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		<a href="{$res.url_logout}">выход</a>
		{/if}
		</div>
	</div>
</div>
{else}
<div class="login_form">
                          <table cellspacing="0" cellpadding="2" bgcolor="#d3dfee" width="210">
                            <form method="post" action="/passport/login.php"/>
                              <input type="hidden" name="action" value="login" />
								<input type="hidden" name="url" value="{$res.url}" />
                              <tbody><tr>
                                <td align="left" class="t11b"><img height="11" width="92" src="/_img/design/200608_title_blue/logo_svoi/s.{$CURRENT_ENV.regid}.gif"/></td>
                                <td align="right" class="links"><a class="t9" href="{$res.url_register}">Регистрация</a></td>
                              </tr>
                              <tr>
		<td><input class="in_email" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
		<td><input class="in_pswd" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
                              <tr>
                                <td align="left"><input type="checkbox" name="remember" value="1" checked="checked" style="margin:0px" tabindex="1002" id="remember"/>
                                    <label for="remember" title="Запомнить меня на этом компьютере" class="text11">запомнить</label></td>
                                <td align="left"><input type="submit" value="Войти" tabindex="1003" class="in_submit"/></td>
                              </tr>
                            </form>
                          </tbody></table>
                        </div>
{/if}
