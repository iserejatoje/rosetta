{$page.header}<br>

{if $page.message == 'invalidphoto'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ваше сообщение размещено, но иллюстрация слишком большая или имеет неизвестный формат.<br/>
		Максимально допустимый размер иллюстрации {$CONFIG.image_size.max_width}x{$CONFIG.image_size.max_height}. Допустимые типы: jpg, gif, png.
		{if is_numeric($page.get.theme) && $page.get.theme > 0}<br><br><a href="/{$ENV.section}/{$CONFIG.files.get.theme.string}?act=last&id={$page.get.theme}">Вернуться к теме</a>{/if}
	</td>
</tr>
</table>

{elseif $page.message == 'cantvote'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Вы не можете участвовать в голосовании.<br>
	</td>
</tr>
</table>

{elseif $page.message == 'canteditmessage' || $page.message == 'cantedit'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Вы не можете редактировать данное сообщение.<br>
	</td>
</tr>
</table>
{*<div align="center">Вы не можете редактировать данное сообщение.</div>*}

{elseif $page.message == 'cantedittheme'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Вы не можете редактировать данную тему.<br>
	</td>
</tr>
</table>
{*<div align="center">Вы не можете редактировать данную тему.</div>*}

{elseif $page.message == 'cantcreatemessage'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Вы не можете добавить сообщение.<br>
	</td>
</tr>
</table>
{*<div align="center">Вы не можете добавить сообщение.</div>*}

{elseif $page.message == 'cantcreatetheme'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Создавать темы на форуме могут только зарегистрированные пользователи.<br>
	</td>
</tr>
{if !$USER->IsAuth()}
<tr>
	<td>
		Вам нужно <a href="/passport/login.php{if $page.get.url}?url={$page.get.url}{/if}">войти</a> или <a href="/passport/register.php{if $page.get.url}?url={$page.get.url}{/if}">зарегистрироваться</a>.
	</td>
</tr>
{/if}
</table>
{*<div align="center">Вы не можете добавить тему.</div>*}

{elseif $page.message == 'sectionnotfound'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Раздел не найден.<br>
	</td>
</tr>
</table>
{*<div align="center">Раздел не найден.</div>*}

{elseif $page.message == 'themenotfound'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Тема не найдена.<br>
	</td>
</tr>
</table>
{*<div align="center">Тема не найдена.</div>*}

{elseif $page.message == 'notmoderator'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Вы не являетесь модератором.<br>
	</td>
</tr>
</table>
{*<div align="center">Вы не являетесь модератором.</div>*}

{elseif $page.message == 'blocked'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ваш аккаунт заблокирован в связи с действующими наказаниями.<br>
	</td>
</tr>
</table>
{*<div align="center">Ваш аккаунт заблокирован в связи с действующими наказаниями.</div>*}

{elseif $page.message == 'accessdenied'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Доступ закрыт.<br>
	</td>
</tr>
</table>
{*<div align="center">Доступ закрыт.</div>*}

{elseif $page.message == 'technics'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ведутся технические работы до 18:00 по московскому времени<br>
	</td>
</tr>
</table>
{*<div align="center">Доступ закрыт.</div>*}

{elseif $page.message == 'madded'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ваше сообщение будет размещено на сайте, если оно соответствует<br>
<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
{if is_numeric($page.get.theme) && $page.get.theme > 0}<br><br><a href="/{$ENV.section}/{$CONFIG.files.get.theme.string}?act=last&id={$page.get.theme}">Вернуться к теме</a>{/if}
<br>
	</td>
</tr>
</table>
{*<div align="center">
Ваше сообщение будет размещено на сайте, если оно соответствует<br>
<a onclick="window.open('about:blank', 'rules','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();" target="rules" href="http://rugion.ru/rules.html">правилам модерирования</a>
{if is_numeric($page.get.theme) && $page.get.theme > 0}<br><br><a href="/{$ENV.section}/{$CONFIG.files.get.theme.string}?act=last&id={$page.get.theme}">Вернуться к теме</a>{/if}
</div>*}
{/if}<br/><br/><br/><br/>