<table cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td><font class="t5gb">Фотоальбомы</font></td>
</tr>
<tr>
	<td bgcolor="#005A52"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
{foreach from=$categories_list item=category key=key name=categories}

		<td align="center" width="150" height="120" valign="bottom">
			{if !empty($category.image)}
				<a  href="/{$ENV.section}/list/albums/c{$category.id}.html">
					<img src="{$category.image}" {$category.image_size} style="border:#005A52 solid 1px"  
					alt="Последнее добавленное фото категории &laquo;{$category.name}&raquo;" 
					title="Смотреть альбомы категории &laquo;{$category.name}&raquo;" />
				</a>
			{else}
				<a  href="/{$ENV.section}/list/albums/c{$category.id}.html">
					<img src="/_img/design/200608_title/none.jpg" style="border:#005A52 solid 1px"  
					alt="Нет фото"  title="Смотреть альбомы категории &laquo;{$category.name}&raquo;" />
				</a>
			{/if}
			<br/><font class="t7"><a href="/{$ENV.section}/list/albums/c{$category.id}.html" 
			title="Смотреть альбомы категории &laquo;{$category.name}&raquo;" class="t5gb">{$category.name}</a></font>
			<br/><font class="lit2">Всего альбомов: <b>{$category.a_count}</b></font>
			<br/><font class="lit2">Всего фото: <b>{$category.p_count}</b></font>
		</td>

{if ($key+1)%3==0 && !$smarty.foreach.categories.last}
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="#005A52"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
{/if}
{/foreach}
	</tr>
</table>