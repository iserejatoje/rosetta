<br/>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="block_left">
<tr align="right"><th><span>{$BLOCK.title}</span></th></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

{if !$BLOCK.uid}
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
</tr> 
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/user/registration.html"><b>регистрация</b></b></a></td>
</tr>
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/user/login.html"><b>войти</b></a></td>
</tr>
{else}
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/user/profile.html"><b>мой профиль</b></a></td>
</tr>
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/list/albums/u{$BLOCK.uid}.html"><b>мои альбомы</b></a></td>
</tr>
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/user/logout.html"><b>выйти</b></a></td>
</tr>
{/if}
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="10" alt="" /></td>
</tr> 

<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/"><b>главная</b></a></td>
</tr>
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/album/add.html"><b>добавить альбом</b></a></td>
</tr>
<tr> 
	<td width="25"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
</tr> 
<tr> 
	<td width="25" align="center"><img src="/_img/design/200608_title/b3.gif" width="4" height="4" alt="" /></td>
	<td align="left"><a href="/{$BLOCK.section}/photo/add.html"><b>добавить фото</b></a></td>
</tr>

</table>