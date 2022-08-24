
{capture name=pages}
{if count($pages.btn) > 0}
{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
{foreach from=$pages.btn item=l}
{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
{/foreach}
{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
{/if}
{/capture

}
<form method="post">
{$SECTION_ID_FORM}

<table width="100%" border="1">
	<tr>
		<th>Данные</th>
		<th>Отзыв</th>
		<th>Ответы</th>
		<th>Видимость</th>
		<th>Размещен</th>
		<th>Удалить</th>
	</tr>

	{foreach from=$list item=l}
	<tr>
		<td width="150" valign="top">
			<input type="hidden" name="ids[]" value="{$l.CommentID}">
	
			<br />Дата:<br />
			{$l.Created}<br />
			
			<br />Имя:<br />
			{if !$l.UserID}
				<input type="text" name="name[{$l.CommentID}]" value="{$l.Name}" class="input_100" style="width:150px">
			{else}
				{$l.user.Name}
			{/if}<br />
			
			<br />E-Mail:<br />
			{$l.user.Email}<br />
		</td>
		<td width="100%">
			<textarea style="width:100%;height:170px;" name="comment[{$l.CommentID}]">{$l.Text}</textarea>
		</td>
		<td nowrap="nowrap" align="center">
			{if $l.ChildsCount}<a href="?{$SECTION_ID_URL}&action=comments&id={$news.NewsID}&parent={$l.CommentID}">Ответов ({$l.ChildsCount})</a>{else}-{/if}
		</td>
		<td align="center">
			<input type="checkbox" name="visible[{$l.CommentID}]" value="1" {if $l.IsVisible==1} checked="checked"{/if}>
		</td>
		<td align="center">
			<input type="checkbox" name="isnew[{$l.CommentID}]" value="0" {if $l.IsNew==0} checked="checked" disabled="disabled"{/if}>
		</td>
		<td align="center">
			<input type="checkbox" name="ids_del[]" value="{$l.CommentID}">
		</td>
	</tr>
	{/foreach}

</table><br />

	<center>{$smarty.capture.pages}</center><br />

	<center>
		<input type="hidden" name="action" value="update_comments" />
		<input type="submit" value="Сохранить изменения" />
		{if !empty($comment)}
			   <input type="button" value="Назад" onclick="window.location.href = '?{$SECTION_ID_URL}&action=comments&id={$news.NewsID}&parent={$comment.ParentID}'" />
		{/if}
	</center>
</form>