{if $count > 0}
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><font class="t5gb">Комментарии к фото:</font></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td height="5px"></td>
				</tr>
				<tr>
					<td align="left"><small>Всего мнений: <b>{$count}</b></small></td>
				</tr>
				<tr>
					<td height="5px"></td>
				</tr>
				{if sizeof($pageslink.btn)}
				<tr>
					<td align="left">
						<table border="0" cellpadding="3" cellspacing="0">
							<tr>
								<td class="fheader_spath">Страницы:&#160;</td>
								{if $pageslink.back!="" }
									<td><a href="{$pageslink.back}" alt="Назад" title="Назад"><img src="/img/design/back.gif" alt="" border="0" height="10" width="10"></a></td>
								{/if}
								<td class="fheader_spath">
								{foreach from=$pageslink.btn item=l}
								{if !$l.active}
									<a href="{$l.link}" class="fmainmenu_link">{$l.text}</a>&nbsp;
								{else}
									<span class="fheader_spath">{$l.text}</span>&nbsp;
								{/if}
								{/foreach}
								</td>
								{if $pageslink.next!="" }
									<td><a href="{$pageslink.next}" alt="Вперед" title="Вперед"><img src="/img/design/next.gif" alt="" border="0" height="10" width="10"></a></td>
								{/if}
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="10px"></td>
				</tr>
				{/if}
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			{foreach from=$comments item=comment key=_k}
				<tr align="left" valign="top">
					<td colspan="2">
						<table width="100%" cellpadding="4" cellspacing="0" border="0">
							<tr align="left" bgcolor="#E3F1FB">
								<td colspan="2"><a name="{$comment.id}"></a><font color="#cc0000"><b>{$_k+1}</b></font>&nbsp;&nbsp;
								{if $comment.email}<a href="mailto:{$comment.email}">{/if}{$comment.name}{if $comment.email}</a>{/if}
								&nbsp;&nbsp;{"d.m.Y"|date:$comment.date}</td>
							</tr>
							<tr>
								<td align="left" colspan="2">{$comment.otziv}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" height="15px"></td>
				</tr>
			{/foreach}
			</table>
{/if}