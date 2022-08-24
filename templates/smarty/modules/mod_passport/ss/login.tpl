<style>
{literal}
    .error {
        color: #ff0000;
        padding: 0 0 5px 0;
    }
{/literal}
</style>

<div class="container">
	<div class="form-group-grid clearfix">
		{if $USER->IsAuth()}
			<table class="table" align="center" width="350" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>Вы уже вошли как: {$USER->Email}. <a href="/{$ENV.section}/{$CONFIG.files.get.logout.string}">Выйти.</a></td>
				</tr>
			</table>
		{else}
			<h1 class="title">Авторизация на сайте</h1>
			<br/>
			<form method="post" name="login_form">
				<input type="hidden" name="action" value="login" />
				<input type="hidden" name="url" value="{$page.form.url}" />
                <table class="table" align="center" width="600px" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 100px; border-collapse: separate; border-spacing: 0 20px;">
    				<tr>
    					<td>Почтовый ящик:</td>
    					<td>
                            {if $UERROR->GetErrorByIndex('email') != ''}
                            <div class="error">{$UERROR->GetErrorByIndex('email')}</div>
                            {/if}
    						<input type="text" tabindex="1" name="email" class="form-control form-control-rect-simple" value="{$page.form.email}" />
    					</td>
    				</tr>


    				<tr>
    					<td>Пароль:</td>
                        <td>
                            {if $UERROR->GetErrorByIndex('password') != ''}
                                <div class="error">{$UERROR->GetErrorByIndex('password')}</div>
                            {/if}
                            <input tabindex="3" type="password" name="password" class="form-control form-control-rect-simple" />
                        </td>
    				</tr>

    				<tr>
    					<td colspan="2" align="right">
    						<input tabindex="4" type="checkbox" name="remember" id="remember" value="1"{if $page.form.remember} checked="checked"{/if} /> <label for="remember">Запомнить</label>
    					</td>
    				</tr>

    				<tr>
    					<td>
    						<!-- <span class="button"><a href="/{$ENV.section}/register.php">Регистрация</a></span><br/> -->
    					</td>
    					<td align="right">
    			            <a href="#" class="btn-white-wide pull-right" onclick="document.forms.login_form.submit()">Авторизоваться</a>
    						{*<span class="button"><a href="javascript:void(0)" onclick="document.forms.login_form.submit()">Авторизоваться</a></span><br/>*}
    					</td>
    				</tr>
    				{*
    				<tr valign="top">
    					<td align="right" colspan="2">

    						<a tabindex="6" href="/{$ENV.section}/{$CONFIG.files.get.forgot.string}" class="grey-link">Забыли пароль?</a>
    					</td>
    				</tr>
    				*}
				</table>
			</form>


		{/if}

	</div>
</div>