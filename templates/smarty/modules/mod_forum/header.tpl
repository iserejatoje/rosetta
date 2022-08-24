<div align="right" style="padding-left:4px;padding-right:4px;"><nobr>
	{*<a href="active.html" class="fmainmenu_link_red"><font color="red">Активные дискуссии</font></a>&nbsp;&nbsp;|&nbsp;
	<a href="rulez.html" class="fmainmenu_link">Правила</a>&nbsp;&nbsp;|&nbsp;
	{if !$USER->IsAuth()}
		<a href="register.html" class="fmainmenu_link">Регистрация</a>
	{else}
		<a href="subscribe.html" class="fmainmenu_link">Подписки</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="settings.html" class="fmainmenu_link">Профиль</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.html" class="fmainmenu_link">Выход</a>
	{/if}*}
</nobr></div>
<table border="0" width="100%" cellpadding="2" cellspacing="0" class="fheader_table">
<tr>
	<td width="1"><img src="/_img/x.gif" height="40" width="1"></td>
	<td>
		<table width="100%">
			<tr><td class="fheader_spath">{if !empty($RPATH) || $RFLINK}<a href="/{$SITE_SECTION}/">{/if}форумы{if !empty($RPATH) || $RFLINK}</a>{/if}
{foreach from=$RPATH item=l}
 / {if $l.data.type=='section'}<a href="view.html?id={$l.id}">{elseif $l.data.type=='theme'}<a href="theme.html?id={$l.id}">{/if}{$l.data.title}{if $l.data.type=='section' || $l.data.type=='theme'}</a>{/if}
{/foreach}
			</td></tr>
			<tr><td class="fheader_stitle">
				{$RTITLE}
				{if $theme.moderate==1}<div style="color:red;font-size:10px;">Тема на предмодерации</div>{/if}
			</td></tr>
		</table>
	</td>
	<td width="350" valign="top">
{if $GLOBAL.region==74}
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<form name="frm_search" enctype="application/x-www-form-urlencoded" target="_blank" method="get" action="http://www.74.ru/search/search.php" onsubmit="return _search_submit(this);">
		<input type="hidden" name="action" value="search" />
		<input type="hidden" name="a_c" value="01" />
		<tr valign="middle" align="left">
		<td>
			&nbsp;&nbsp;
			Поиск:
			<input type="text" name="text" value="" style="width:200px; font-size:10px;" />
			&nbsp;
			<input type="submit" value="Искать" />
		</td>
		</tr>
		</form>
		</table>
{/if}
	{*{if !$USER->IsAuth()}
		<form method="POST" action="_login.html" style="margin:0px";>
		<table width="150">
			{if $IsBlocked}
			<tr><td nowrap>Вы заблокированы и не можете авторизироваться<br>и добавлять сообщения{if $IsBlockedEternal===false} до <span class="fheader_blockstill">{$BlockStill|date_format:"%d.%m.%Y"}{/if}</span></td></tr>
			{else}
			<tr><td><input type="text" name="login" value="Логин" onfocus="if(this.value=='Логин')this.value=''" class="fheader_input"></td>
			<td><input type="password" name="password" value="Пароль" onfocus="if(this.value=='Пароль')this.value=''" class="fheader_input"></td>
			<td><input type="submit" value="вход" class="fheader_button"></td></tr>
			<tr><td colspan="2" align="right"><nobr><a href="remember.html" class="fheader_link">Забыли пароль?</a></nobr></td>
				<td class="fheader_link"><input type="checkbox" id="remember" name="remember" value="1"><label for="remember">запомнить</label></td>
			</tr>
			{/if}
		</table>
		</form>
	{else}
		<table width="150" valign="top">
			<tr><td nowrap align="right">Пользователь <span class="fheader_username">{$USER->Login}</span><br>
				{if $IsBlocked}<br>Вы не можете добавлять сообщения{if $IsBlockedEternal===false} до <span class="fheader_blockstill">{$BlockStill|date_format:"%d.%m.%Y"}{/if}</span>{/if}</td></tr>
		</table>
	{/if}*}
	</td>
</tr>
</table><br>