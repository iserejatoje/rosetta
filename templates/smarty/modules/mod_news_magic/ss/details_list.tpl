<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				{if $CURRENT_ENV.section=="journal"}
				<tr align="left" valign="bottom">
					<td colspan="3">
							<font class="descr">Наши авторы - это один россиянин и люди, которые Россию покинули, но пристально следят за всем происходящим. Загляни с их помощью в &laquo;Зеркало Мира&raquo;, быть может, станет понятнее, что происходит вокруг тебя!</font><br/><br/>
					</td>
				</tr>
				{/if}
				<tr align="left" valign="bottom">
					<td>
						<table align=left cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td class="title2_news">
									{if $res.TitleType==2 }
										{$res.TitleArr.name},<br/><font style="font-size:14px;font-weight:normal;">
										{$res.TitleArr.position}:<br/> <b>{$res.TitleArr.text}</b></font>
									{else}
										{$res.Title}
									{/if}
								</td>
							</tr>
						</table>
					</td>
					<td width="10"><img src="/_img/x.gif" width="10" height="1" border="0" alt="" /></td>
					<td width="120" align="right" class="title" style="font-size:12px;">
						{$res.Date|date_format:"%e"} {$res.Date|month_to_string:2} {$res.Date|date_format:"%Y"}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td>
	</tr>
	<tr>
		<td align="justify">
		<!-- Text article -->
			{if !$res.hideLinks}
				{$res.Text}
			{else}
				{$res.Text|screen_href|mailto_crypt}
			{/if}
		<!-- Text article: end -->
		</td>
	</tr>
	{if $res.AuthorName }
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td align="right">
			<b>{if $res.AuthorEmail}{$res.AuthorName} ({$res.AuthorEmail|mailto_crypt}){else}{$res.AuthorName}{/if}, <i>специально для {$CURRENT_ENV.site.domain|ucfirst}</i></b>{if $res.isAdvert} <img src="/_img/design/common/rr.gif" width="11" height="11" alt="На правах рекламы" title="На правах рекламы" border="0" />{/if}
		</td>
	</tr>
	{/if}
	{if $res.PhotographerName}
	<tr>
		<td align="right">{$res.PhotographerName}</td>
	</tr>
	{/if}
	<tr>
		<td height="10px"></td>
	</tr>
	{if $ENV.section_page != 'print'}
	<tr>
		<td class="tip">
		<div style="float:right; width: auto; margin-left: 20px;"><a href="/{$ENV.section}/{$res.NewsID}-print.html" class="descr" target="print" onclick="window.open('about:blank', 'print','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a></div>
		<div style="float:right; width: auto; margin-left: 20px;">Просмотров: {$res.Views|number_format:0:" "}</div>
		</td>
	</tr>
	{/if}
</table>