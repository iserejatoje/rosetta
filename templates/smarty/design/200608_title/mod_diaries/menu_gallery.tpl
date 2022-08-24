<table cellpadding=2 cellspacing=0 border=0>
<tr><td colspan="6"><img src="/_img/x.gif" height=1 width="1"></td></tr>
<tr>
<td>{include  file="`$TEMPLATE.title_diery`"}</td>
{if $USER->isAuth() && $USER->ID==$smarty.get.id}
<td>&nbsp;&nbsp;</td>
{if $CURRENT_ENV.params!=$CONFIG.files.get.gallery_folder_add.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td><td class="text11"><a href="{$CONFIG.files.get.gallery_folder_add.string}?id={$smarty.get.id}&parentid={$smarty.get.parentid}"><b>Создать папку</b></a></td>
{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td><td class="text11"><b>Создать папку</b></td>
{/if}
<td>&nbsp;&nbsp;</td>
{if $CURRENT_ENV.params!=$CONFIG.files.get.gallery_img_add.string}
	<td><img src="/_img/design/200608_title/b1.gif"></td><td class="text11"><a href="{$CONFIG.files.get.gallery_img_add.string}?id={$smarty.get.id}&parentid={$smarty.get.parentid}"><b>Добавить фото</b></a></td>
{else}
	<td><img src="/_img/design/200608_title/b2.gif"></td><td class="text11"><b>Добавить фото</b></td>
{/if}
{/if}
</tr>
</table>