<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr align="left" valign="bottom">
	<td colspan="3">
				{if $SITE_SECTION=="journal"}
<font class="descr">Наши авторы - это один россиянин и люди, которые Россию покинули, но пристально следят за всем происходящим. Загляни с их помощью в &laquo;Зеркало Мира&raquo;, быть может, станет понятнее, что происходит вокруг тебя!</font><br/><br/>
				{/if}
	</td>
	</tr>
    <tr align="left" valign="bottom">
      <td>
				<table align=left cellpadding=0 cellspacing=0 border=0>
				<tr><td class="title2_news">
				{if $res.type==2 }
					{$res.name_arr.name},<br/><font style="font-size:14px;font-weight:normal;">
					{$res.name_arr.position}:<br/> <b>{$res.name_arr.text}</b></font>
				{else}
					{$res.name}
				{/if}
				</td></tr>
				{*<tr><td height=4 bgcolor=#333333><img src="/_img/x.gif" width=1 height=4 border=0></td></tr>*}
				</table>
			</td>
      <td width="10"><img src="/_img/x.gif" width="10" height="1" border="0" alt="" /></td>
      <td width="120" align="right" class="title" style="font-size:12px;">{$res.date|date_format:"%e"} {$res.date|month_to_string:2} {$res.date|date_format:"%Y"}</td>
    </tr>
    </table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="justify">
<!-- Text article -->
{$res.text|screen_href}
<!-- Text article: end -->
</td></tr>
{if $res.author_name }
	<tr><td height="10px"></td></tr>
	<tr><td align="right">
{assign var="user_email" value=$res.author_email}
	<b>{if $res.author_email}{$res.author_name} ({$user_email|mailto_crypt}){else}{$res.author_name}{/if}, <i>специально для {$ENV.site.domain|ucfirst}</i></b>
	</td></tr>
{/if}
{if $res.photographer_name}<tr><td align="right">{$res.photographer_name}</td></tr>{/if}
<tr><td height="1px"></td></tr>
</table>