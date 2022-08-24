{if $USER->IsAuth()}

		<div class="user"><div class="back"></div>
			<div class="logged">
				<div class="hello_title">Здравствуйте,</div>
				<div class="name">{$res.showname}</div>
				<div class="cleaner"></div>
				{if $res.newmessages_count > 0}
				<div class="messages">
						У вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
						{*if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if*}
				</div>
				<div class="next_btn"><a href="{$res.url_messages}"><img src="/_img/design/200901_social/next_btn_small.gif" border="0" height="17" width="17" /></a></div>
				{/if}
				<div class="actions"><a href="{$res.url_logout}">Выход</a></div>
				<div class="cleaner"></div>
			</div>
		</div>
{else}

		<div class="user"><div class="back"></div>
			<div class="not_logged">
				<div class="state_2">
					<form method="POST" action="{$res.url_login}" style="margin:0px">
					<input type="hidden" value="login" name="action" />
					<input type="hidden" name="url" value="{$res.url|escape:"quotes"}" />
						<div class="field">
							<label>Email</label>
						</div>
						<div class="field">
							<label>Пароль</label>
						</div>
						<div class="field">
							<label>&nbsp;</label>
						</div>
						<div class="cleaner"></div>
						<div class="field">
							<input class="input" type="text" value="" name="email" tabindex="9"/>
						</div>
						<div class="field">
							<input class="input" type="password" value="" maxlength="32" name="password" tabindex="10"/>
						</div>
						<div class="field">
							<button tabindex="12" type="submit">Войти</button>
						</div>
						<div class="cleaner"></div>
						<div class="field">
							<input class="checkbox" id="widget_remember" type="checkbox" name="remember" tabindex="11" checked="checked"/><label for="widget_remember">запомнить</label>
						</div>
						<div class="field">
							<a href="{$res.url_forgot}">Забыли пароль?</a>
						</div>
						<div class="cleaner"></div>
					</form>
				</div>
				<div class="state_1">
					<span class="reg"><a href="{$res.url_register}">Регистрация</a></span><span class="login"><a href="javascript:void(0);" onclick="$('.not_logged .state_1').animate({literal}{left:'-300px'}{/literal}, 400);">Вход</a></span>
				</div>
			</div>
		</div>

{/if}

