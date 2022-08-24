<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
	<td class="bg_line" style="padding:0px"><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
{if !$USER->IsAuth()}
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/passport/login.php?url=%2F{$SITE_SECTION}%2F">войти</a></td>
</tr>
{elseif $userexists === true}
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/profile.html">мой профиль</a></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/user/{$USER->ID}.html">моя страница</a></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/edit_page.html">редактировать анкету</a></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/user/delete.html">удалить анкету</a></td>
</tr>
{else}
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/create.html">создать анкету</a></td>
</tr>
{/if}
<tr><td bgcolor="#30A89E"><img height=1 alt="" src="/_img/x.gif" width=1></td></tr>
<tr>
	<td class="bg_line" style="padding:0px"><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/top100/main.html">топ-100</a></td>
</tr>
<!--<tr>
	<td bgcolor="#f3f3f3"> <img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="love.php?cmd=birthday">наши именинники</a></td>
</tr>-->
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/search.html">поиск</a></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"> <img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/smeetings.html">стрелки</a></td>
</tr>
<tr>
	<td bgcolor="#f3f3f3"><img src="/_img/design/200608_title/bull1.gif" width="10" height="9" alt="" />
		<a href="/{$SITE_SECTION}/lovestory.html">love-story</a></td>
</tr>
<tr>
	<td style="padding:0px"><img src="/_img/x.gif" height="5" width="1" alt="" /></td>
</tr>
<tr>
	<td class="bg_line" style="padding:0px"><img src="/_img/x.gif" height="2" width="1" alt="" /></td>
</tr>
</table>