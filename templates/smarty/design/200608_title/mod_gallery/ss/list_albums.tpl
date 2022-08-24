
{if $page.errors.global}
<br/><br/><div align="center"><font color="red"><b>{$page.errors.global}</b></font><br/><br/>
<a href="/{$ENV.section}/">На главную</a> | <a href="javascript:void(0)" onclick="window.history.go(-1)">Назад</a></div><br/><br/>
{else}


{capture name=pageslink}
{if sizeof($page.pageslink.btn)}
<table border="0" cellpadding="3" cellspacing="0">
<tr>
	<td class="fheader_spath">Страницы:&#160;</td>
	{if $page.pageslink.back!="" }<td><a href="{$page.pageslink.back}" alt="Назад" title="Назад"><img src="/img/design/back.gif" alt="" border="0" height="10" width="10"></a></td>{/if}
	<td class="fheader_spath">
	{foreach from=$page.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}" class="fmainmenu_link">{$l.text}</a>&nbsp;
		{else}
			<span class="fheader_spath">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	</td>
	{if $page.pageslink.next!="" }<td><a href="{$page.pageslink.next}" alt="Вперед" title="Вперед"><img src="/img/design/next.gif" alt="" border="0" height="10" width="10"></a></td>{/if}
</tr>
</table>
{/if}
{/capture}


<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
	</tr>
	<tr>
		<td width="100%" align="right"  class="t7">
			Показать:&nbsp;&nbsp;
			{if !$page.lock}
			все | <a href="/{$ENV.section}/list/albums/{if $page.uid}u{$page.uid}{else}c{$page.cid}{/if}_{$page.sort}_1_{$page.page}.html">только открытые</a>
			{else}
			<a href="/{$ENV.section}/list/albums/{if $page.uid}u{$page.uid}{else}c{$page.cid}{/if}_{$page.sort}_0_{$page.page}.html">все</a> | только открытые
			{/if}
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td width="100%">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td>
{$smarty.capture.pageslink}
				</td>
				<td align="right"  class="t7">
					Сотировать по:&nbsp;&nbsp;
					{if $page.sort == 'date'}
						дате
					{else}
						<a href="/{$ENV.section}/list/albums/{if $page.uid}u{$page.uid}{else}c{$page.cid}{/if}_date_{$page.lock|intval}_{$page.page}.html">дате</a>
					{/if} | 
					{if $page.sort == 'review'}
						по пулярности
					{else}
						<a href="/{$ENV.section}/list/albums/{if $page.uid}u{$page.uid}{else}c{$page.cid}{/if}_review_{$page.lock|intval}_{$page.page}.html">популярности</a>
					{/if} | 
					{if $page.sort == 'rate'}
						рейтингу
					{else}
						<a href="/{$ENV.section}/list/albums/{if $page.uid}u{$page.uid}{else}c{$page.cid}{/if}_rate_{$page.lock|intval}_{$page.page}.html">рейтингу</a>
					{/if}
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" width="100%">
		<table align="left" cellpadding="4" cellspacing="2" border="0" width="100%" class="table2">
		<tr align="center">
			<th width="60%" align="center" class="ftable_header" colspan="2">Альбом</th>
{if $page.uid}
			<th width="15%" align="center" class="ftable_header">Категория</th>
{else}
			<th width="15%" align="center" class="ftable_header">Автор</th>
{/if}
			<th width="10%" align="center" class="ftable_header">Кол-во фото</th>
			<th width="15%" align="center" class="ftable_header">Дата изменения</th>
		</tr>
			{foreach from=$page.albums item=album key=_k}
		<tr class="{if ($_k+1) % 2} {else} bg_color4{/if}">
			<td align="center" width="25%"><a
				href="/{$ENV.section}/list/photos/{$album.aid}.html"
				title="Смотреть альбом &laquo;{$album.album}&raquo;">
				{if $album.access == 2}
					<img src="/img/design/lock.jpg" style="border: #005A52 solid 1px" alt="Вход по паролю" title="Для входа в альбом &laquo;{$album.album}&raquo; необходимо ввести пароль" />
				{elseif !empty($album.image)}
					<img src="{$album.image}" {$album.image_size} style="border: #005A52 solid 1px" alt="Последнее добавленное фото альбома"  title="Смотреть альбом &laquo;{$album.album}&raquo;" />				
				{else}
					<img src="/_img/design/200608_title/none.jpg" style="border: #005A52 solid 1px" alt="Нет фото"  title="В альбоме &laquo;{$album.album}&raquo; нет фото" />				
				{/if}
			</a><br /></td>
			<td align="center" width="25%">
				<a href="/{$ENV.section}/list/photos/{$album.aid}.html" title="Смотреть альбом &laquo;{$album.album}&raquo; Популярность: {$album.review} Рейтинг: {$album.rate_mean|number_format:4:".":" "}"><b>{$album.album}</b></a>
				{if $album.descr}
					<br/><span class="fdescription">{$album.descr|truncate:150:"...":false}</span>
				{/if}
				{if $album.uid == $user->id}
					<br/><a href="/{$ENV.section}/album/edit/{$album.aid}.html" class="fmainmenu_link">изменить</a> | <a href="/{$ENV.section}/album/del/{$album.aid}.html" class="fmainmenu_link">удалить</a>
				{/if}
				
				{if $album.comment && $album.comment.name}<br/><br/><font class="zag3">{$album.comment.name|truncate:30:"...":false},&nbsp;{"d.m"|date:$album.comment.date}:</font> 
					<font class="otzyv"><a class="otzyv" href="/{$ENV.section}/view/photo/{$album.comment.st_id}.html#{$album.comment.id}" title="последний комментарий">{$album.comment.otziv|truncate:35:"...":false}</a></font>
				{/if}
			</td>
			{if $page.is_category}
				<td align="center"><a href="/{$ENV.section}/list/albums/c{$album.cid}.html"><b>{$album.name}</b></a></td>
			{else}
				<td align="center"><a href="/{$ENV.section}/list/albums/u{$album.uid}.html"><b>{$album.user}</b></a></td>
			{/if}
			<td align="center" class="t7">{$album.img_count}</td>
			<td align="center" class="t7">{"d.m.Y H:i:s"|date:$album.date_update}</td>
			</tr>
			{/foreach}
		</table>
		</td>
	</tr>
{if $smarty.capture.pageslink}
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	<tr>
		<td>
		{$smarty.capture.pageslink}
		</td>
	</tr>
{/if}
	<tr>
		<td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td>
	</tr>
</table>
{/if}