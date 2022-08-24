
<center><a href="/{$SITE_SECTION}/addaccid/" title="Добавить свои фотографии и описание"><b>Разместить свои фотографии с места ДТП</b></a></center><br>

{capture name=pageslink}
	{if $content.pageslink.back!="" }<a href="{$content.pageslink.back}">&lt;&lt;</a>{/if}
	{foreach from=$content.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<b>{$l.text}</b>&nbsp;
		{/if}
	{/foreach}
	{if $content.pageslink.next!="" }<a href="{$content.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<center>{$smarty.capture.pageslink}
			<table border='0' width='100%' cellpadding='5' cellspacing='1' class='text11'>
			<tr>
			{foreach from=$content.list item=itm key=k name=list}
				
				<td class="td" align="center" width="33%" valign="top">{"%e %B %Y"|strftime:$itm.date} г.<br>
					<a href="/{$SITE_SECTION}/show/{$itm.id}/{$itm.pid}.html" class="a1">
						<img src="{$content.images_url}{$itm.small}"  style="border: #e0f3f3 solid 2px" border="0"></a><br>
						<table cellpadding=0 align=center cellspacing=0 border=0>
							<tr>{if $itm.isuser}
								<td align=right width=20>
									<img src="/img/design/puser.gif" title="добавлена пользователем" alt="добавлена пользователем" border="0">
								</td>
								{/if}
								<td width="150" align="center">&#160;
									<a href="/{$SITE_SECTION}/show/{$itm.id}/{$itm.pid}.html" class="a1">{$itm.name}</a>
								</td>
								
							</tr>
						</table>
					{if $itm.comment}
						<font class="dop3"><font class="dop2"><b>{$itm.comment.author}, {"j.m"|date:$itm.comment.date}</font>:</b>&nbsp;{$itm.comment.text}...</font>
					{/if}
				</td>
				{if !$smarty.foreach.list.last && ($k+1) % 3 == 0}<tr></tr>{/if}
			{/foreach}
			</tr>
			</table>
			<br>{$pageslink}</center>
		<hr color="#1854A6" style="height:1px">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="small">Примечание: Автокатастрофы, отмеченные знаком&#160;</td>
					<td><img src="/img/design/puser.gif"></td>
					<td class="small">,&#160;добавлены пользователями сайта.</td>
				</tr>
			</table>
