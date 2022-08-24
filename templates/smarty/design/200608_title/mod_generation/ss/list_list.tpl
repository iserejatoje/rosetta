{capture name=pages}
{if count($res.pages.btn) > 0}
	Страницы:&#160;
	{if !empty($res.pages.back)}<a href="{$res.pages.back}" title="Предыдущая страница">&lt;&lt;&lt;</a>{/if}{
	foreach from=$res.pages.btn item=l}
		{if !$l.active
			}<a href="{$l.link}">[{$l.text}]</a>&nbsp;{
		else
			}[{$l.text}]&nbsp;{
		/if}{
	/foreach}{
	if !empty($res.pages.next)}<a href="{$res.pages.next}" title="Следующая страница">&gt;&gt;&gt;</a>{/if}
{/if}
{/capture}

<p><font class=title>Члены клуба</font></p>
<table class="table" align="center" width="98%" CELLPADDING="0" CELLSPACING="0" border="0">
	<tr>
		<td align="left" style="padding-left:15px;">
			Сортровать по:
			{if $res.current_order == 'n'}
				<b>&nbsp;имени&nbsp;</b>&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.list.string}?p={$res.page}&o=c">активности</a>&nbsp;
			{else}
				&nbsp;<a href="/{$ENV.section}/{$CONFIG.files.get.list.string}?p={$res.page}&o=n">имени</a>&nbsp;<b>&nbsp;активности&nbsp;</b>
			{/if}
		</td>
	</tr>
	<tr>
		<td height="5px"></td>
	</tr>
	<tr>
		<td align="left" style="padding-left:15px;">
			{if $res.users_count > 0}
				Всего членов клуба: {$res.users_count}. Показано  {$res.users_count_view}, начиная с {$res.users_count_start+1}
			{/if}
		</td>
	</tr> 
	<tr>
		<td height="8px"></td>
	</tr>
	<tr>
		<td class="text11" style="padding-left:15px;">
			{$smarty.capture.pages}
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="0" height="5" border="0"></td>
	</tr>
	<tr>
		<td align=center>
			<table align="center" width="100%" cellpadding="3" cellspacing="2" border="0">
			{if is_array($res.userslist) && sizeof($res.userslist)}
				{foreach from=$res.userslist item=user}
				<tr valign="top" align="left">
					<td style="padding-left:15px;">
						<a name="u{$user.ID}"/>
						<a href="/passport/info.php?id={$user.ID}">{if isset($user.Photo.Url) && $user.Photo.Url != ''}<img src="{$user.Photo.Url}" align="left" style="margin-right:5px" width="{$user.Photo.Width}" height="{$user.Photo.Height}" border="0" alt=""/>{/if}<b>{$user.FirstName} {$user.LastName}</b></a>
						<br /><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /><br />
						{$user.Position}{if $user.WorkPlace && $user.Position},{/if}
						{$user.WorkPlace}
						<br /><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /><br />
						<font class="anons">Количество отзывов: {$user.MessageCount|number_format:0:",":" "}</font>
					</td>
				</tr>
				{/foreach}
			{else}
				<tr>
					<td bgcolor="#e9efef" align="center"><b>Список пуст.</b></td>
				</tr>
			{/if}
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="0" height="5" border="0"></td>
	</tr>
	<tr>
		<td class="text11" style="padding-left:15px;">
			{$smarty.capture.pages}
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="0" height="20" border="0"></td>
	</tr>
</table>
