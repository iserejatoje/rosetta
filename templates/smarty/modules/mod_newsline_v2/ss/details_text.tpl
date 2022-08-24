<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="8"></td></tr>
<tr><td>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr align="left" valign="bottom">
      <td>
				<table align=left cellpadding=0 cellspacing=0 border=0>
				<tr><td class="zag4">
				{if $res.type==2 }
					{$res.name_arr.name},<br/><font style="font-size:13px;font-weight:normal;">
					{$res.name_arr.position}:<br/> <b>{$res.name_arr.text}</b></font>
				{else}
					{$res.name}
				{/if}
				</td></tr>
				{*<tr><td height=4 bgcolor=#333333><img src="/_img/x.gif" width=1 height=4 border=0></td></tr>*}
				</table>
			</td>
      <td width="10"><img src="/_img/x.gif" width="10" height="1" border="0" alt="" /></td>
      <td width="150" align="right">{$res.date|date_format:"%e"} {$res.date|month_to_string:2} {$res.date|date_format:"%Y"} {$res.date|date_format:"%H:%S"}</td>
    </tr>
    </table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="justify">
<!-- Text article -->
{$res.text}
<!-- Text article: end -->
</td></tr>
{if $res.author_name }
	<tr><td height="10px"></td></tr>
	<tr><td align="right">
	<b>{if $res.author_email }<a href="mailto:{$res.author_email}">{$res.author_name}</a>{else}{$res.author_name}{/if}, <i>специально для Chelyabinsk.ru</i></b>
	</td></tr>
{/if}
{if $res.photographer_name}<tr><td align="right">{$res.photographer_name}</td></tr>{/if}
<tr><td align="right"><a class="descr" href="/{$SITE_SECTION}/{$res.id}.html">постоянный адрес новости</a></td></tr>
{if !empty($res.link)}<tr><td align="right"><a href="{$res.link}" class="ssyl" target="_blank">обсудить новость на форуме</a></td></tr>{/if}
<tr><td height="25px"></td></tr>
</table>