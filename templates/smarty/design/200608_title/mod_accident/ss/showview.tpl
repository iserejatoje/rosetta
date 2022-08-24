<br/><br/>
	<table cellpadding=0 align=center cellspacing=0 border=0>
		<tr>
			<td>
				<font class=\"rem\"><b>катастрофа:</b></font>&#160;
			</td>
			{if $page.prev}
			<td>&#160;<a href="/{$SITE_SECTION}/show/{$page.prev}.html">предыдущая</a>&#160;|</td>{/if}
			{if $page.next}
			<td>&#160;<a href="/{$SITE_SECTION}/show/{$page.next}.html">следующая</a>&#160;</td><td>&#160;|</td>
			{/if}
			<td>&#160;<a href="/{$SITE_SECTION}/">все</a>&#160;</td></td>
		</tr>
	</table><br/>
	
			{"%e %B %Y"|strftime:$page.acc.date} г.<br><font class=zag1><b>{$page.acc.name}</b></font><br><br>
			<img style="border: #e0f3f3 solid 2px" src="{$page.images_url}{$page.acc.big}" alt="{$page.acc.name}"><br><br>
			{if $page.acc.text}<b>Информация:</b><br>{$page.acc.text}<br><br>{/if}
	<table cellpadding=0 cellspacing=0 border=0>
		<tr>{if $page.acc.isuser}
			<td><img src="/img/design/puser.gif" title="добавлены пользователем" alt="добавлены пользователем"></td>
			{/if}
			<td class="t5gb">
				&#160;<b>Другие фотографии с места катастрофы:</b>
			</td>
		</tr>
	</table>
	
	{if sizeof($page.acc.imglist)}
	
	<table cellpadding="8" cellspacing="2" border="0">
		<tr>
		{foreach from=$page.acc.imglist item=img key=_k name=imglist }
			<td width="120">
				<a href="/{$SITE_SECTION}/show/{$img.st_id}/{$img.id}.html"><img style="border: #e0f3f3 solid 2px" src="{$page.images_url}{$img.small}" alt="открыть"></a>
			</td>
			{if !$smarty.foreach.imglist.last && ($_k+1) % 5 == 0}<tr></tr>{/if}
		{/foreach}
		</tr>
	</table>
	
	{/if}
	
			<br><table cellpadding=0 align=center cellspacing=0 border=0>
		<tr>
			<td>
				<font class=\"rem\"><b>катастрофа:</b></font>&#160;
			</td>
			{if $page.prev}
			<td>&#160;<a href="/{$SITE_SECTION}/show/{$page.prev}.html">предыдущая</a>&#160;|</td>{/if}
			{if $page.next}
			<td>&#160;<a href="/{$SITE_SECTION}/show/{$page.next}.html">следующая</a>&#160;</td>
			<td>&#160;|</td>
			{/if}
			<td>&#160;<a href="/{$SITE_SECTION}/">все</a>&#160;</td>
		</tr>
	</table><br>